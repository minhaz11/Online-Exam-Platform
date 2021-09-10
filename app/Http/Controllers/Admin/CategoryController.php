<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function allCategories(Request $request)
    {
        if($request->search){
            $search = $request->search;
            $page_title = "Search Result of '$search'";
            $categories = Category::where('name','LIKE',"%$search%")->paginate(15);
        } else {

            $page_title = 'All Categories';
            $categories = Category::latest()->paginate(15);
        }
        $empty_message = 'No Categories available';
        return view('admin.category.all',compact('page_title','empty_message','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status ? 1:0;
        $category->save();
        $notify[]=['success','Category Created Successfully'];
        return back()->withNotify($notify);
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status ? 1:0;
        $category->save();
        $notify[]=['success','Category Updated Successfully'];
        return back()->withNotify($notify);
    }

    
}
