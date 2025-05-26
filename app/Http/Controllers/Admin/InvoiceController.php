<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\Hotel;
use App\Models\Inquiry;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Timecard;
use App\Models\TaskItem;
use App\Models\Task;
use App\Models\Employee;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function taskList(Request $request)
    {
        $tasks = Task::with('items.employee.user')->orderBy('id', 'desc')->paginate(10);
        // return $Invoices;
        return view('admin.task.index', compact('tasks'));
    }

    public function download($id)
    {
        $invoice = Invoice::with(['items', 'hotel'])->findOrFail($id);

        $mpdf = new Mpdf();

        $html = view('admin.invoice.pdf', compact('invoice'))->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('invoice_' . $invoice->invoice_number . '.pdf', 'D');
    }


    public function task()
    {
        $hotels = Hotel::where('status', 'active')->get();
        $prefix = 'TASK-000';
        $lastTask = Task::orderBy('id', 'desc')->first();
        $lastId = $lastTask ? $lastTask->id : 0;
        $lastTaskId = $prefix . ($lastId + 1);
        $jobs = Job::orderBy('id', 'desc')->get();

        return view('admin.task.create', compact('hotels', 'lastTaskId', 'jobs'));
    }

    public function getEmployees($hotel_id)
    {
        $employees = Employee::where('hotel_id', $hotel_id)->with('user')->get();
        return response()->json($employees);
    }


    public function TaskStore(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.employee_id' => 'required|exists:employees,id',
            'items.*.service' => 'required|string|max:255',
            'items.*.time' => 'required|numeric|min:0',
            'items.*.price_per_unit' => 'required|numeric|min:0',
            'items.*.total' => 'required|numeric|min:0',
            'items.*.start_date' => 'required|date',
            'items.*.end_date' => 'required|date',
            'items.*.platform_fee' => 'required|numeric|min:0',
        ]);

        $today = now()->format('Y-m-d');
        foreach ($request->items as $item) {
            if ($item['start_date'] < $today || $item['end_date'] < $today) {
                return redirect()->back()->with('error', 'Start or end date cannot be in the past.')->withInput();
            }
        }

        $hotel = Hotel::findOrFail($request->hotel_id);
        $email = $hotel->email;

        try {
            DB::beginTransaction();

            $prefix = 'TASK-000';
            $lastTask = Task::orderBy('id', 'desc')->first();
            $lastId = $lastTask ? $lastTask->id : 0;
            $taskNumber = $prefix . ($lastId + 1);

            $task = Task::create([
                'hotel_id' => $request->hotel_id,
                'task_number' => $taskNumber,
                'task_date' => now(),
                'due_date' => $request->due_date,
                'total_amount' => 0,
                'status' => 'unpaid',
            ]);

            $totalAmount = 0;

            foreach ($request->items as $item) {
                $overlapExists = TaskItem::where('employee_id', $item['employee_id'])
                    ->where(function ($query) use ($item) {
                        $query->whereBetween('start_date', [$item['start_date'], $item['end_date']])
                            ->orWhereBetween('end_date', [$item['start_date'], $item['end_date']])
                            ->orWhere(function ($q) use ($item) {
                                $q->where('start_date', '<=', $item['start_date'])
                                    ->where('end_date', '>=', $item['end_date']);
                            });
                    })
                    ->exists();

                if ($overlapExists) {
                    DB::rollBack();
                    Log::error('Employee already assigned a task between ' . $item['start_date'] . ' and ' . $item['end_date']);
                    return redirect()->back()->with('error', 'Employee already assigned a task between ' . $item['start_date'] . ' and ' . $item['end_date'])->withInput();
                }

                TaskItem::create([
                    'task_id' => $task->id,
                    'employee_id' => $item['employee_id'],
                    'service' => $item['service'],
                    'time' => $item['time'],
                    'price_per_unit' => $item['price_per_unit'],
                    'platform_fee' => $item['platform_fee'],
                    'total' => $item['total'],
                    'start_date' => $item['start_date'],
                    'end_date' => $item['end_date'],
                ]);

                $totalAmount += $item['total'];
            }

            $task->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->back()->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create task.');
        }
    }





    public function invoicesList(Request $request)
    {
        $Invoices = Invoice::with('items.employee.user');

        if ($request->filled('date_range')) {
            [$startDate, $endDate] = explode(' to ', $request->date_range);

            $Invoices = $Invoices->whereHas('items', function ($query) use ($startDate, $endDate) {
                $query->whereDate('start_date', '>=', $startDate)
                    ->whereDate('end_date', '<=', $endDate);
            });
        }

        $Invoices = $Invoices->orderBy('id', 'desc')->paginate(10);

        return view('admin.invoice.index', compact('Invoices'));
    }


    public function invoicesAdd()
    {
        $hotels = Hotel::where('status', 'active')->get();
        return view('admin.invoice.add', compact('hotels'));
    }

    public function getHotelEmployees(Request $request)
    {
        $hotelId = $request->hotel_id;

        // Step 1: Get all task_item IDs related to this hotel's tasks
        $taskItemIdsForHotel = TaskItem::whereHas('task', function ($q) use ($hotelId) {
            $q->where('hotel_id', $hotelId);
        })->pluck('id')->toArray();

        // Step 2: Get task_items already invoiced (unpaid invoices only)
        $alreadyInvoicedTaskItemIds = \DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->where('invoices.hotel_id', $hotelId)
            ->where('invoices.status', 'unpaid')
            ->pluck('invoice_items.task_item_id')
            ->toArray();

        // Step 3: Get only those task_items which are NOT invoiced yet
        $finalTaskItemIds = array_diff($taskItemIdsForHotel, $alreadyInvoicedTaskItemIds);

        // Step 4: If no task items, still send view with empty data
        $taskData = collect(); // default empty

        if (!empty($finalTaskItemIds)) {
            $taskData = TaskItem::with(['employee.user', 'employee.job', 'task'])
                ->whereIn('id', $finalTaskItemIds)
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'task_item_id' => $item->id,
                        'employee' => $item->employee,
                        'total_hours' => $item->time,
                        'total_amount' => $item->total,
                        'start_date' => $item->start_date,
                        'end_date' => $item->end_date,
                        'platform_fee' => $item->platform_fee,
                        'price_per_unit' => $item->employee->pay_rate ?? 0,
                        'service' => optional($item->employee->job)->name ?? '-',
                    ];
                });
        }

        $html = view('admin.invoice.partials.employee_timecards', compact('taskData'))->render();

        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }


    public function singleInvoiceStore(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'due_date' => 'required|date',
            'item.employee_id' => 'required|exists:employees,id',
            'item.service' => 'required|string|max:255',
            'item.time' => 'required|numeric|min:0',
            'item.price_per_unit' => 'nullable|numeric|min:0',
            'item.platform_fee' => 'required|numeric|min:0',
            'item.total' => 'required|numeric|min:0',
            'item.start_date' => 'required|date',
            'item.end_date' => 'required|date',
        ]);

        $hotel = Hotel::findOrFail($request->hotel_id);
        $hotelEmail = $hotel->email;

        try {
            DB::beginTransaction();

            $prefix = 'INV-000';
            $lastInvoice = Invoice::orderBy('id', 'desc')->first();
            $lastId = $lastInvoice ? (int)str_replace($prefix, '', $lastInvoice->invoice_number) : 0;
            $newInvoiceNumber = $prefix . ($lastId + 1);

            $invoice = Invoice::create([
                'hotel_id' => $request->hotel_id,
                'invoice_number' => $newInvoiceNumber,
                'invoice_date' => now(),
                'due_date' => $request->due_date,
                'total_amount' => $request->item['total'],
                'status' => 'unpaid',
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'employee_id' => $request->item['employee_id'],
                'service' => $request->item['service'],
                'quantity' => 0,
                'time' => $request->item['time'],
                'price_per_unit' => $request->item['price_per_unit'] ?? 0,
                'platform_fee' => $request->item['platform_fee'] ?? 0,
                'total' => $request->item['total'],
                'start_date' => $request->item['start_date'],
                'end_date' => $request->item['end_date'],
                'task_item_id' => $request->item['task_item_id'],
            ]);

            // ✅ Send email to hotel (with full invoice)
            Mail::to($hotelEmail)->send(new \App\Mail\HotelInvoiceMail($invoice, $hotel));

            // ✅ Send email to employee
            $employee = \App\Models\Employee::with('user')->find($request->item['employee_id']);

            if ($employee && $employee->user && filter_var($employee->user->email, FILTER_VALIDATE_EMAIL)) {
                $empData = [
                    'name' => $employee->user->first_name . ' ' . $employee->user->last_name,
                    'pay_rate' => $request->item['price_per_unit'],
                    'time' => $request->item['time'],
                    'total' => $request->item['total'],
                    'start_date' => $request->item['start_date'],
                    'end_date' => $request->item['end_date'],
                    'invoice_number' => $invoice->invoice_number,
                ];
                Mail::to($employee->user->email)->send(new \App\Mail\EmployeeInvoiceMail($empData));
            }

            DB::commit();

            return redirect()->back()->with('success', 'Single invoice created and emails sent!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to send single invoice.');
        }
    }




    public function InvoiceStore(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'due_date' => 'required|date',
            'items' => 'required|json',
        ]);

        $items = json_decode($request->items, true);

        if (!is_array($items) || count($items) === 0) {
            return back()->with('error', 'No invoice items found.');
        }

        foreach ($items as $item) {
            Validator::make($item, [
                'employee_id' => 'required|exists:employees,id',
                'service' => 'required|string|max:255',
                'time' => 'required|numeric|min:0',
                'price_per_unit' => 'nullable|numeric|min:0',
                'platform_fee' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ])->validate();
        }

        $hotel = Hotel::findOrFail($request->hotel_id);
        $hotelEmail = $hotel->email;

        try {
            DB::beginTransaction();

            $prefix = 'INV-000';
            $lastInvoice = Invoice::orderBy('id', 'desc')->first();
            $lastId = $lastInvoice ? (int)str_replace($prefix, '', $lastInvoice->invoice_number) : 0;
            $newInvoiceNumber = $prefix . ($lastId + 1);

            $invoice = Invoice::create([
                'hotel_id' => $request->hotel_id,
                'invoice_number' => $newInvoiceNumber,
                'invoice_date' => now(),
                'due_date' => $request->due_date,
                'total_amount' => 0,
                'status' => 'unpaid',
            ]);

            $totalAmount = 0;

            foreach ($items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'employee_id' => $item['employee_id'],
                    'service' => $item['service'],
                    'quantity' => 0,
                    'time' => $item['time'],
                    'price_per_unit' => $item['price_per_unit'] ?? 0,
                    'platform_fee' => $item['platform_fee'] ?? 0,
                    'total' => $item['total'],
                    'start_date' => $item['start_date'],
                    'end_date' => $item['end_date'],
                    'task_item_id' => $item['task_item_id'],
                ]);

                $totalAmount += $item['total'];
            }

            $invoice->update(['total_amount' => $totalAmount]);

            DB::commit();

            // 1. Send email to hotel (with full invoice)
            Mail::to($hotelEmail)->send(new \App\Mail\HotelInvoiceMail($invoice, $hotel));

            // 2. Send email to each employee with their own info
            foreach ($items as $item) {
                $employee = \App\Models\Employee::with('user')->find($item['employee_id']);

                if ($employee && $employee->user && filter_var($employee->user->email, FILTER_VALIDATE_EMAIL)) {
                    $empData = [
                        'name' => $employee->user->first_name . ' ' . $employee->user->last_name,
                        'pay_rate' => $item['price_per_unit'],
                        'total' => $item['total'],
                        'start_date' => $item['start_date'],
                        'time' => $item['time'],
                        'end_date' => $item['end_date'],
                        'invoice_number' => $invoice->invoice_number,
                    ];
                    Mail::to($employee->user->email)->send(new \App\Mail\EmployeeInvoiceMail($empData));
                }
            }

            return redirect()->back()->with('success', 'Bulk invoice created and emails sent!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create invoice.');
        }
    }
}
