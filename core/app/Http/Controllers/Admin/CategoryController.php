<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle      = 'All Categories';
        $categories     = Category::latest();

        if(request()->search){
            $search     = request()->search;
            $categories = $categories->where('name', 'like',"%$search%");
        }

        $categories     = $categories->with('leagues')->paginate(getPaginate());
        $emptyMessage   = 'No category found';

        return view('admin.category.index', compact('pageTitle', 'categories', 'emptyMessage'));
    }

    public function store(Request $request, $id=0)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        if($id){
            $category = Category::findOrFail($id);
            $category->status = $request->status ? 1 : 0;
            $notification = 'Category updated successfully';
        }else{
            $category = new Category();
            $notification = 'Category added successfully';
        }

        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

}
