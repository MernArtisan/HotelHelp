<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function privacyPolicy()
    {
        $privacyPolicy = Content::find(1);
        return view('admin.privacyPolicy.index', compact('privacyPolicy'));
    }


    public function updatePrivacyPolicy(Request $request)
    {
        $privacyPolicy = Content::find(1);
        $privacyPolicy->description = $request->description;
        $privacyPolicy->save();

        return redirect()->back()->with('success', 'Privacy Policy updated successfully!');
    }


    public function termCondition()
    {
        $termCondition = Content::find(2);
        return view('admin.termcondition.index', compact('termCondition'));
    }


    public function updateTermCondition(Request $request)
    {
        $termCondition = Content::find(2);
        $termCondition->description = $request->description;
        $termCondition->save();
        return redirect()->back()->with('success', 'Term & Condition updated successfully!');
    }
}
