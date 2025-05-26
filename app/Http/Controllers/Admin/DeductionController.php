<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use Exception;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    public function deductions()
    {
        $deduction = Deduction::orderBy('id', 'desc')->get();
        // return $deduction;
        return view('admin.deductions.index', compact('deduction'));
    }


    public function deductionsStore(Request $request)
    {
        $request->validate([
            'deduction_type' => 'required',
            'amount' => 'required',
            'deduction_reason' => 'required',
        ]);

        try {
            $deduction = Deduction::create([
                'deduction_type' => $request->deduction_type,
                'amount' => $request->amount,
                'deduction_reason' => $request->deduction_reason,
            ]);

            return redirect()->route('admin.deductions')->with('success', 'Deduction added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error adding deduction');
        }
    }


    public function decutionDelete($id){
        $deduction = Deduction::findOrFail($id);
        $deduction->delete();
        return redirect()->route('admin.deductions')->with('success', 'Deduction deleted successfully');
    }
}
