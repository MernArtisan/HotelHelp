<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\MealBreakRule;
use App\Models\NoteRule;
use App\Models\OccurrenceRule;
use App\Models\RoundingRule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HolidayController extends Controller
{




    public function holidays()
    {
        $holidays = Holiday::orderBy('id', 'desc')->get();
        $roles = Role::where('name', '!=', 'tiar4')->get();
        // return $roles;
        return view('admin.holidays.index', compact('roles', 'holidays'));
    }

    public function holidaysCreate()
    {
        $roles = Role::where('name', '!=', 'tiar4')->get();
        return view('admin.holidays.create', compact('roles'));
    }


    public function holidaysStore(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'eligibility_criteria' => 'required',
            'holiday_entitlement' => 'required',
            'shift' => 'required',
            'holiday_start_date' => 'required',
        ]);

        $shift = Carbon::parse($request->shift)->format('h:i A');
        $holiday_start_date = Carbon::parse($request->holiday_start_date)->format('h:i A');

        $holiday = Holiday::create([
            'role' => $request->role,
            'eligibility_criteria' => $request->eligibility_criteria,
            'holiday_entitlement' => $request->holiday_entitlement,
            'shift' => $shift,
            'holiday_start_date' => $holiday_start_date
        ]);

        return redirect()->route('admin.holidays')->with('success', 'Holiday Created Successfully');
    }


    public function holidaysEdit($id)
    {
        $holiday = Holiday::find($id);
        $roles = Role::where('name', '!=', 'tiar4')->get();
        return view('admin.holidays.edit', compact('holiday', 'roles'));
    }



    public function holidaysUpdate(Request $request, $id)
    {
        $request->validate([
            'role' => 'required',
            'eligibility_criteria' => 'required',
            'holiday_entitlement' => 'required',
            'shift' => 'required',
            'holiday_start_date' => 'required',
        ]);


        $shift = Holiday::find($id);
        $shift->role = $request->role;
        $shift->eligibility_criteria = $request->eligibility_criteria;
        $shift->holiday_entitlement = $request->holiday_entitlement;
        $shift->shift = Carbon::parse($request->shift)->format('h:i A');
        $shift->holiday_start_date = Carbon::parse($request->holiday_start_date)->format('h:i A');
        $shift->save();

        return redirect()->route('admin.holidays')->with('success', 'Holiday Updated Successfully');
    }

    public function occurrenceRules()
    {

        $occurenceRules = OccurrenceRule::orderBy('id', 'desc')->get();

        return view('admin.holidays.occurrence', [
            'occurenceRules' => $occurenceRules,
        ]);
    }


    public function occurrenceRulesStore(Request $request)
    {
        // return $request;
        $request->validate([
            'rule_name' => 'required',
            'description' => 'required',
            'time_of_occurrence' => 'required',
        ]);

        $time_of_occurrence = Carbon::parse($request->time_of_occurrence)->format('h:i A');
        OccurrenceRule::create([
            'rule_name' => $request->rule_name,
            'description' => $request->description,
            'time_of_occurrence' => $time_of_occurrence,
        ]);
        return redirect()->back()->with('success', 'Occurrence Rule Created Successfully');
    }

    public function deleteOccurrenceRules($id)
    {
        $occurrenceRule = OccurrenceRule::find($id);
        $occurrenceRule->delete();
        return redirect()->back()->with('success', 'Occurrence Rule Deleted Successfully');
    }



    public function noteRules(Request $request)
    {
        $noteRules = NoteRule::orderBy('id', 'desc')->get();
        return view('admin.holidays.note_rules', [
            'noteRules' => $noteRules,
        ]);
    }


    public function noteRulesAdd(Request $request)
    {
        $request->validate([
            'rule_name' => 'required',
            'rule_description' => 'required',
            'effective_start_date' => 'required',
            'effective_end_date' => 'required',
            // 'associated_department' => 'required',
            'notes' => 'required',
        ]);

        $noteRule = NoteRule::create([
            'rule_name' => $request->rule_name,
            'rule_description' => $request->rule_description,
            'effective_start_date' => Carbon::parse($request->effective_start_date)->format('Y-m-d'),
            'effective_end_date' => Carbon::parse($request->effective_end_date)->format('Y-m-d'),
            'associated_department' => $request->associated_department,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Note Rule Created Successfully');
    }





    public function noteRulesDelete($id)
    {
        $noteRule = NoteRule::find($id);
        $noteRule->delete();
        return redirect()->back()->with('success', 'Note Rule Deleted Successfully');
    }






    public function mealAndBreakRules(Request $request)
    {
        $mealAndBreakRules = MealBreakRule::orderBy('id', 'desc')->get();
        // return $mealAndBreakRules;
        return view('admin.holidays.meal_and_break_rules', [
            'mealAndBreakRules' => $mealAndBreakRules,
        ]);
    }



    public function mealAndBreakRulesStore(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'meal_break' => 'required|boolean',
            'break_duration' => 'required|integer',
            'break_frequency' => 'required|integer',
        ]);

        MealBreakRule::create($validated);

        return redirect()->back()->with('success', 'Meal and Break Rule created successfully!');
    }


    public function MealBreakRulesDelete($id)
    {
        $mealAndBreakRules = MealBreakRule::find($id);
        $mealAndBreakRules->delete();
        return redirect()->back()->with('success', 'Note Rule Deleted Successfully');
    }





    public function roundingRules(Request $request)
    {
        $rounding_rules = RoundingRule::orderBy('id', 'desc')->get();
        // return $roundingRules;
        return view('admin.holidays.rounding_rules', [
            'rounding_rules' => $rounding_rules,
        ]);
    }


    public function roundingRulesStore(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'working_hours_rounding' => 'required|integer',
            'overtime_rounding' => 'required|integer',
            'break_time_rounding' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        RoundingRule::create($validated);

        return redirect()->back()->with('success', 'Rounding Rule created successfully!');
    }
}
