<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\GeneralSetting;
use App\Models\Option;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();

    }

    protected function filterBets($type){
        $bets               = Bet::where('user_id', auth()->user()->id);
        $this->pageTitle    = ucfirst($type). ' Bets';
        $this->emptyMessage = "No $type bet found";

        if($type != 'all'){
            $bets = $bets->$type();
        }


        return $bets->latest()->with(['user','match','question','option'])->paginate(getPaginate());
    }

    public function index($type='all')
    {
        $segments       = request()->segments();
        $type           = end($segments);
        $bets           = $this->filterBets(end($segments));
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view($this->activeTemplate . 'user.bet', compact('pageTitle', 'emptyMessage', 'bets'));
    }

    public function betStore(Request $request)
    {
        $request->validate([
            'option_id'         => 'required|integer|gt:0',
            'invest_amount'     => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $user = auth()->user();

        $general = GeneralSetting::first();

        if ($request->invest_amount < $general->min_limit) {
            $notify[] = ['error', 'Minimum limit is '.getAmount($general->min_limit).' '.$general->cur_text];
            return back()->withNotify($notify);
        }

        if ($request->invest_amount > $general->max_limit) {
            $notify[] = ['error', 'Maximum limit is '.getAmount($general->max_limit).' '.$general->cur_text];
            return back()->withNotify($notify);
        }

        if ($user->balance < $request->invest_amount) {
            $notify[] = ['error', 'You do not have enough balance'];
            return back()->withNotify($notify);
        }

        $option = Option::where('status', 1)->whereHas('question', function ($question) {
            $question->where('status', 1)->whereHas('match', function ($match) {
                $match->where('status', 1)->where('end_time', '>=', Carbon::now())->whereHas('league', function ($league) {
                    $league->where('status', 1)->whereHas('category', function ($category) {
                        $category->where('status', 1);
                    });
                });
            });
        })->findOrFail($request->option_id);

        $returnAmount = ($request->invest_amount / $option->dividend) * $option->divisor;

        $user->balance -= $request->invest_amount;
        $user->save();

        $trx = getTrx();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $request->invest_amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = 'For a new bet';
        $transaction->trx = $trx;
        $transaction->save();

        $bet = new Bet();
        $bet->user_id       = $user->id;
        $bet->match_id      = $option->question->match->id;
        $bet->question_id   = $option->question->id;
        $bet->option_id     = $option->id;
        $bet->dividend      = $option->dividend;
        $bet->divisor       = $option->divisor;
        $bet->invest_amount = $request->invest_amount;
        $bet->return_amount = $returnAmount;
        $bet->status = 0;
        $bet->save();

        if ($general->bet_commission == 1) {
            levelCommission($user, $request->invest_amount, 'bet', $trx, $general);
        }

        notify($user, 'BET_PLACED', [
            'invest_amount' => showAmount($bet->invest_amount),
            'return_amount' => showAmount($bet->return_amount),
            'match' => $option->question->match->name,
            'option' => $option->name,
            'question' => $option->question->name,
            'currency' => $general->cur_text,
            'trx' => $transaction->trx,
            'post_balance' => showAmount($user->balance)
        ]);

        $notify[] = ['success', 'Your bet is placed successfully'];
        return redirect()->route('user.bet.index','all')->withNotify($notify);
    }
}
