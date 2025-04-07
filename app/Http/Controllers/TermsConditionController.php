<?php

namespace App\Http\Controllers;

use App\TermsCondition;
use Illuminate\Http\Request;

class TermsConditionController extends Controller
{
    public function view(){
        $data['title'] = 'Terms & Conditions';
        $data['value'] = \App\TermsCondition::where('id',1)->first();
        return view('admin.Terms_Condition.terms_condition')->with($data);
    }

    public function update(Request $request){
        $user = TermsCondition::where('id',1)->update(['terms_condition' => $request->terms_condition]);
        return redirect()->route('terms_condition_view');
    }

    public function terms_condition(){
        $data['title'] = 'Terms & Conditions';
        $data['value'] = \App\TermsCondition::where('id',1)->first();
        return view('terms_condition')->with($data);
    }
}
