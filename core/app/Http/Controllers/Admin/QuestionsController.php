<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Match;

class QuestionsController extends Controller
{
    public function index($id)
    {
        $match          = Match::findOrFail($id);
        $pageTitle      = 'Questions for - '.$match->name;
        $emptyMessage   = 'No question found';
        $questions      = Question::where('match_id', $match->id)->with('options')->latest()->paginate(getPaginate());

        return view('admin.question.index',compact('pageTitle', 'match', 'emptyMessage', 'questions'));
    }

    public function store(Request $request, $id = 0)
    {

        $request->validate([
            'match_id'  => 'required|exists:matches,id',
            'name'      => 'required',
        ]);

        if($id){
            $question               = Question::findOrFail($id);
            $notification           = 'New question updated successfully';
            $question->result       = 0;
            $question->status       = $request->status ? 1 : 0;
        }else{
            $question               = new Question();
            $question->match_id     = $request->match_id;
            $notification           = 'New question added successfully';
        }

        $question->name     = $request->name;
        $question->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }



}
