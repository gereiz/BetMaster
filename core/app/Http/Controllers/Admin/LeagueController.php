<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Leagues';
        $leagues = League::latest();

        if(request()->search){
            $search     = request()->search;
            $leagues = $leagues->where('name', 'like',"%$search%");
        }

        $leagues = $leagues->with(['category','matches'])->paginate(getPaginate());

        $emptyMessage = 'No league found';
        $categories = Category::latest()->get();

        return view('admin.league.index', compact('pageTitle', 'leagues', 'emptyMessage', 'categories'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'category_id'   => 'required|integer|gt:0',
            'name'          => 'required',
            'icon'          => 'required'
        ]);


        $category = Category::findOrFail($request->category_id);

        if($id){
            $league         = League::findOrFail($id);
            $league->status = $request->status ? 1 : 0;
            $notification   = 'League updated successfully';
        }else{
            $league         = new League();
            $notification   = 'League added successfully';
        }

        $league->category_id    = $category->id;
        $league->name           = $request->name;
        $league->icon           = $request->icon;
        $league->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }


}
