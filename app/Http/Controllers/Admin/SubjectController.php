<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function allSubject(Request $request)
    {
        if($request->search){
            $search = $request->search;
            $page_title = "Search Result of '$search'";
            $subjects = Subject::where('name','LIKE',"%$search%")->paginate(15);
        } else {

            $page_title = 'All Subjects';
            $subjects = Subject::latest()->paginate(15);
        }
        $categories = Category::get(['name','id']);
        $empty_message = 'No Subject available';
        return view('admin.subject.all',compact('page_title','empty_message','categories','subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subjects',
            'category_id' => 'required|numeric',
            'short_details' => 'required'
        ]);

        $subject = new Subject();
        $subject->category_id = $request->category_id;
        $subject->name = $request->name;
        $subject->slug = Str::slug($request->name);
        $subject->short_details = $request->short_details;
        $subject->status = $request->status ? 1:0;
        $subject->is_popular = $request->is_popular ? 1:0;
        $subject->save();
        $notify[]=['success','Subject Created Successfully'];
        return back()->withNotify($notify);
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|unique:subjects,name,'.$id,
            'category_id' => 'required|numeric',
            'short_details' => 'required'
        ]);

        $subject = Subject::findOrFail($id);
        $subject->category_id = $request->category_id;
        $subject->name = $request->name;
        $subject->short_details = $request->short_details;
        $subject->status = $request->status ? 1:0;
        $subject->is_popular = $request->is_popular ? 1:0;
        $subject->save();
        $notify[]=['success','Subject Updated Successfully'];
        return back()->withNotify($notify);
    }
}
