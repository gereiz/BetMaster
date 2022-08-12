<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;
use App\Models\Match;

class MatchController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    protected function filterMatches($type){

        $matches = Match::latest();
        $this->pageTitle    = ucfirst($type). ' Matches';
        $this->emptyMessage = "No $type match found";

        if($type != 'all'){
            $matches = $matches->$type();
        }

        if(request()->search){
            $search             = request()->search;
            $matches            = $matches->where('name', 'like',"%$search%");
            $this->pageTitle    = "Search Result for '$search'";
        }

        return $matches->with(['category','league', 'questions'])->paginate(getPaginate());
    }

    public function index()
    {
        $segments       = request()->segments();
        $type           = end($segments);
        $matches        = $this->filterMatches(end($segments));
        $leagues        = League::latest()->get();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.match.index',compact('pageTitle', 'matches', 'emptyMessage', 'leagues'));
    }

    public function store(Request $request, $id=0)
    {
        $request->validate([
            'name'              => 'required',
            'league_id'         => 'required|integer|gt:0',
            'beginning_time'    => 'required|date_format:Y-m-d h:i a',
            'finishing_time'    => 'required|date_format:Y-m-d h:i a|after:start_time'
        ]);

        $league = League::findOrFail($request->league_id);

        if($id){
            $match = Match::findOrFail($id);
            $notification = 'Match updated successfully';
            $match->status = $request->status ? 1 : 0;
        }else{
            $match = new Match();
            $notification = 'Match added successfully';
        }

        $match->name        = $request->name;
        $match->category_id = $league->category->id;
        $match->league_id   = $league->id;
        $match->start_time  = $request->beginning_time;
        $match->end_time    = $request->finishing_time;
        $match->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
