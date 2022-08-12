<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bet;
use Illuminate\Http\Request;

class BetsController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    protected function filterBets($type){
        $bets               = Bet::latest();
        $this->pageTitle    = ucfirst($type). ' Bets';
        $this->emptyMessage = "No $type bet found";

        if($type != 'all'){
            $bets = $bets->$type();
        }

        if(request()->search){
            $search  = request()->search;
            $bets    = $bets->whereHas('user', function ($user) use ($search) {
                            $user->where('username', 'like',"%$search%");
                        })->orWhereHas('question', function ($question) use ($search) {
                            $question->where('name', 'like',"%$search%");
                        })->orWhereHas('question.match', function ($question) use ($search) {
                            $question->where('name', 'like',"%$search%");
                        });

            $this->pageTitle    = "Search Result for '$search'";
        }

        return $bets->with(['user','match','question','option'])->paginate(getPaginate());
    }

    public function index()
    {
        $segments       = request()->segments();
        $type           = end($segments);
        $bets           = $this->filterBets(end($segments));
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.bet.index',compact('pageTitle', 'bets', 'emptyMessage'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $pageTitle = 'Bet Search - ' . $search;
        $emptyMessage = 'No bet found';

        $bets = Bet::whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhereHas('question', function ($question) use ($search) {
            $question->where('name', 'like',"%$search%");
        })->with(['user','match','question','option'])
        ->latest()
        ->paginate(getPaginate());

        return view('admin.bet.index',compact('pageTitle', 'bets', 'emptyMessage', 'search'));
    }

}
