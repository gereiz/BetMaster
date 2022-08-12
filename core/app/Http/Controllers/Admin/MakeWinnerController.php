<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\GeneralSetting;
use App\Models\Option;
use App\Models\Question;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MakeWinnerController extends Controller
{
    public function questions()
    {
        $pageTitle = 'Betted Questions';

        $questions = Question::whereHas('bets', function($q) {
            $q->where('status', 0);
        });

        if(request()->search){
            $search = request()->search;
            $questions = $questions->where(function($query) use($search){
                $query->whereHas('bets', function ($q) use ($search) {
                    $q->whereHas('match', function($match) use ($search){
                        $match->where('name', 'like',"%$search%");
                    });
                })->orWhere('name', 'like',"%$search%");
            });
        }

        $questions = $questions->latest()->with(['match','bets'])->paginate(getPaginate());

        $emptyMessage = 'No question found';

        return view('admin.make_winner.questions',compact('pageTitle', 'questions', 'emptyMessage'));
    }



    public function optionWin(Request $request)
    {
        $request->validate([
            'option_id' => 'required|integer|gt:0',
        ]);

        $option     = Option::where('id', $request->option_id)->with('question')->firstOrFail();
        $question   = $option->question;
        $general    = GeneralSetting::first();
        $winners    = Bet::where('status', 0)->where('question_id', $question->id)->where('option_id', $option->id)->get();

        foreach ($winners as $item) {
            $item->status = 1;
            $item->save();

            $item->user->balance += $item->return_amount;
            $item->user->save();

            $transaction = new Transaction();
            $transaction->user_id = $item->user->id;
            $transaction->amount = $item->return_amount;
            $transaction->post_balance = $item->user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Won a bet';
            $transaction->trx = getTrx();
            $transaction->save();

            if ($general->win_commission == 1) {
                levelCommission($item->user, $item->invest_amount, 'win', $transaction->trx, $general);
            }

        }

        $question->result = 1;
        $question->save();

        $option->winner = 1;
        $option->save();

        $notify[] = ['success', 'All bets for '.$option->name.' marked as win'];
        return back()->withNotify($notify);
    }

    public function optionAbandoned(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer|gt:0'
        ]);

        $question = Question::findOrFail($request->question_id);
        $abandonedBets = Bet::where('status', 0)->where('question_id', $question->id)->get();

        foreach ($abandonedBets as $item) {
            $item->status = 3;
            $item->save();

            $item->user->balance += $item->invest_amount;
            $item->user->save();

            $transaction = new Transaction();
            $transaction->user_id = $item->user->id;
            $transaction->amount = $item->invest_amount;
            $transaction->post_balance = $item->user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Betted amount is refunded as the match is abandoned.';
            $transaction->trx = getTrx();
            $transaction->save();
        }

        $question->result = 3;
        $question->save();

        $notify[] = ['success', 'All bets for '.$question->name.' have been marked as abandoned'];
        return back()->withNotify($notify);
    }

    public function optionLoser(Request $request)
    {
        $request->validate([
            'question_id' => 'required|integer|gt:0'
        ]);

        $question           = Question::findOrFail($request->question_id);
        Bet::where('status', 0)->where('question_id', $question->id)->update(['status' => 2]);
        $question->result   = 2;
        $question->save();

        $notify[] = ['success', 'All bets for '.$question->name.' have been marked as loser'];
        return back()->withNotify($notify);
    }
}
