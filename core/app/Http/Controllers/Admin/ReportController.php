<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionLog;
use App\Models\EmailLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use App\Models\Match;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function betReport()
    {
        $pageTitle = 'Betting Report';
        $emptyMessage = 'No data found';

        $matches = Match::whereHas('bets', function($q) {
            $q->where('status', '!=', 0);
        })->latest()->with(['category','league','questions','bets'])->paginate(getPaginate());

        return view('admin.reports.bet', compact('pageTitle', 'matches', 'emptyMessage'));
    }

    public function betReportSearch(Request $request)
    {
        $search = $request->search;
        $pageTitle = 'Betting Report - ' . $search;
        $emptyMessage = 'No data found';

        $matches = Match::whereHas('bets', function($q) {
            $q->where('status', '!=', 0);
        })->where('name', 'like',"%$search%")->latest()->with(['category','league','questions','bets'])->paginate(getPaginate());

        return view('admin.reports.bet', compact('pageTitle', 'matches', 'emptyMessage'));
    }

    public function transaction()
    {
        $pageTitle = 'Transaction Logs';
        $transactions = Transaction::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Transactions Search - ' . $search;
        $emptyMessage = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Login History Search - ' . $search;
            $emptyMessage = 'No search result found.';
            $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id','desc')->with('user')->paginate(getPaginate());
            return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'search', 'login_logs'));
        }
        $pageTitle = 'User Login History';
        $emptyMessage = 'No users login found.';
        $login_logs = UserLogin::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        $emptyMessage = 'No users login found.';
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs','ip'));

    }

    public function emailHistory(){
        $pageTitle = 'Email history';
        $logs = EmailLog::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.reports.email_history', compact('pageTitle', 'emptyMessage','logs'));
    }

    public function commissionsDeposit()
    {
        $pageTitle = 'Deposit Commission Log';
        $logs = CommissionLog::where('type','deposit')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No deposit commission yet';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsBet()
    {
        $pageTitle = 'Betting Commission Log';
        $logs = CommissionLog::where('type','bet')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No betting commission yet';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsWin()
    {
        $pageTitle = 'Bet winning Commission Log';
        $logs = CommissionLog::where('type','win')->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No bet winning commission yet';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage'));
    }

    public function commissionsSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Commission Log Search -'.$search;
        $logs = CommissionLog::whereHas('user', function ($user) use ($search) {
                $user->where('username', 'like',"%$search%");
            })->orWhere('trx', $search)->with(['user','bywho'])->latest()->paginate(getPaginate());
        $emptyMessage = 'No commission data found';
        return view('admin.reports.commission_log', compact('pageTitle', 'logs', 'emptyMessage','search'));
    }
}
