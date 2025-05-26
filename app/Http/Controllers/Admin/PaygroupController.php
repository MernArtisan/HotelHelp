<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayGroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaygroupController extends Controller
{
    public function index()
    {
        $payGroups = PayGroup::orderBy('id', 'desc')->get();
        // return $payGroups;
        return view('admin.paygroup.index', compact('payGroups'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'pay_frequency' => 'required|string|in:weekly,biweekly,monthly', 
                'payroll_input_method' => 'required|string|in:manual,automatic', 
                'payroll_type' => 'required|string',
                'normal_hours' => 'required', 
                'pay_day_of_week' => 'required|string|max:10', 
                // 'run_date' => 'required',
                // 'inpound_date' => 'required', 
                'period_date' => 'required', 
                'status' => 'required|string|in:active,block', 
            ]);
        
            PayGroup::create($request->all());
        
            return redirect()->back()->with('success', 'Pay Group created successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.pay-group.index')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'pay_frequency' => 'required|string|in:weekly,biweekly,monthly', 
                'payroll_input_method' => 'required|string|in:manual,automatic', 
                'payroll_type' => 'required|string',
                'normal_hours' => 'required', 
                'pay_day_of_week' => 'required|string|max:10', 
                // 'run_date' => 'required',
                // 'inpound_date' => 'required', 
                'period_date' => 'required', 
                'status' => 'required|string|in:active,block', 
            ]);
        
            $paygroups = PayGroup::find($id);
            $paygroups->update($request->all());
        
            return redirect()->back()->with('success', 'Pay Group updated successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.pay-group.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $paygroups = PayGroup::find($id);
        $paygroups->delete();
        return redirect()->back()->with('success', 'Pay Group deleted successfully.');
    }
}
