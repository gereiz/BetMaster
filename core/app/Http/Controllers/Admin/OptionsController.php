<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index($id)
    {
        $question       = Question::findOrFail($id);
        $options        = Option::where('question_id', $question->id)->latest()->with(['bets','question.match'])->paginate(getPaginate());
        $pageTitle      = 'Options for - '.$question->name;
        $emptyMessage   = 'No option found';
        return view('admin.option.index',compact('pageTitle', 'question', 'emptyMessage', 'options'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'       => 'required',
            'dividend'   => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
            'divisor'    => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        if($id){
            $option         = Option::findOrFail($id);
            $option->status = $request->status ? 1 : 0;
            $notification   = 'Option updated successfully';
        }else{
            $option = new Option();
            $notification   = 'Option added successfully';
        }

        $option->question_id    = $request->question_id;
        $option->name           = $request->name;

        $option->dividend       = $request->dividend;
        $option->divisor        = $request->divisor;
        $option->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

}
