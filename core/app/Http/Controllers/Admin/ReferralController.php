<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Referral';
        $levels = Referral::get();

        return view('admin.referral',compact('pageTitle', 'levels'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'level' => 'required|array|min:1',
            'level.*' => 'required|integer|min:1',
            'percent' => 'required|array|min:1',
            'percent.*' => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
            'commission_type' => 'required|in:deposit,bet,win',
        ],[
            'level.required' => 'Minimum one level field is required',
            'level.*.required' => 'Minimum one level value is required',
            'level.*.integer' => 'Provide integer number as level',
            'level.*.min' => 'Level should be grater than 0',
            'percent.required' => 'Minimum one percentage field is required',
            'percent.*.required' => 'Minimum one percentage value is required',
            'percent.*.integer' => 'Provide integer number as percentage',
            'percent.*.min' => 'Percentage should be grater than 0',
        ]);

        Referral::where('commission_type',$request->commission_type)->delete();

        for ($i = 0; $i < count($request->level); $i++){
            $referral = new Referral();
            $referral->level =$request->level[$i];
            $referral->percent =$request->percent[$i];
            $referral->commission_type =$request->commission_type;
            $referral->save();
        }

        $notify[] = ['success', 'Created Successfully'];
        return back()->withNotify($notify);
    }

    public function referralStatusUpdate($type)
    {
        $general_setting = GeneralSetting::first();
        if (@$general_setting->$type == 1) {
            @$general_setting->$type = 0;
        $general_setting->save();
        }elseif(@$general_setting->$type == 0){
            @$general_setting->$type = 1;
        $general_setting->save();
        }else{
            $notify[] = ['error', 'Something Wrong'];
            return back()->withNotify($notify);
        }
        $notify[] = ['success', 'Updated Successfully'];
        return back()->withNotify($notify);
    }

}
