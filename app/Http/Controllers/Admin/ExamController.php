<?php

namespace App\Http\Controllers\Admin;
use App\Exam;
use App\Subject;
use App\Category;
use App\Questions;
use Carbon\Carbon;
use App\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Result;

class ExamController extends Controller
{
    public function allExams(Request $request)
    {
        if($request->search){
            $search = $request->search;
            $page_title = "Search Results '$search'";
            $exams = Exam::where('title','LIKE',"%$search%")->with('subject')->paginate(15);
        } else {

            $page_title = 'All exams';
            $exams = Exam::latest()->with('subject')->paginate(15);
        }
        $empty_message = 'No exams available';

        return view('admin.exam.all',compact('page_title','exams','empty_message'));
    }

    public function addExam()
    {
        $page_title = 'Add New Exam';
        $subjects = Subject::all();
        $categories = Category::all();
        return view('admin.exam.addExam',compact('page_title','subjects','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|numeric',
            'title'     => 'required',
            'instruction'     => 'required',
            'question_type' => 'required|in:1,2',
            'totalmark'  => 'required|numeric|min:0',
            'pass_percentage' =>' required|min:0',
            'duration' => 'required|numeric|min:1',
            'value' => 'required|in:1,2',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'exam_fee' => 'required_if:value,1|numeric',
            'reduce_mark' => 'required_with:nag_status|min:0',
        ],
        [
            'reduce_mark.required_with'=>'Reduce mark is required when Negative marking is on',
            'exam_fee.required_if' => 'Exam Fee is required when Payment type is Paid'
        ]);

        $exam = new Exam();
        $exam->subject_id = $request->subject_id;
        $exam->title = $request->title;
        $exam->instruction = $request->instruction;
        $exam->question_type = $request->question_type;
        $exam->totalmark =  $request->totalmark;
        $exam->pass_percentage =  $request->pass_percentage;
        $exam->duration =  $request->duration;
        $exam->value =  $request->value;
        $exam->exam_fee =  $request->exam_fee;
        $exam->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
        $exam->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');

        if($request->image){
            $exam->image = uploadImage($request->image,'assets/images/exam/','850x560',null,'400x250');
        }

        if($request->question_type == 1){
            $exam->reduce_mark = $request->neg_status ? $request->reduce_mark:null;
            $exam-> negative_marking =$request->neg_status ? 1 : 0;
        } 

        $exam->random_question = $request->randomize ? 1:0;
        $exam->option_suffle = $request->opt_suffle ? 1:0;
        $exam->status = $request->status ? 1 : 0; 
        $exam->save();
        $notify[]=['success','Exam created successfully'];
        return back()->withNotify($notify);

    }

    public function editExam($id)
    {
        $page_title = 'Edit Exam';
        $subjects = Subject::all();
        $categories = Category::all();
        $exam = Exam::findOrFail($id);
        return view('admin.exam.editExam',compact('page_title','exam','subjects','categories'));
    }

    public function update(Request $request,$id)
    {
        
        $request->validate([
            'subject_id' => 'required|numeric',
            'title'     => 'required',
            'instruction'     => 'required',
            'question_type' => 'required|in:1,2',
            'totalmark'  => 'required|numeric|min:0',
            'pass_percentage' =>' required|min:0',
            'duration' => 'required|numeric|min:1',
            'value' => 'required|in:1,2',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'exam_fee' => 'required_if:value,1|numeric',
            'reduce_mark' => 'required_with:nag_status|min:0',
        ],
        [
            'reduce_mark.required_with'=>'Reduce mark is required when Negative marking is on',
            'exam_fee.required_if' => 'Exam Fee is required when Payment type is Paid'
        ]);

        $exam = Exam::findOrFail($id);
        $exam->subject_id = $request->subject_id;
        $exam->title = $request->title;
        $exam->instruction = $request->instruction;
        $exam->question_type = $request->question_type;
        $exam->totalmark =  $request->totalmark;
        $exam->pass_percentage =  $request->pass_percentage;
        $exam->duration =  $request->duration;
        $exam->value =  $request->value;
        $exam->exam_fee =  $request->exam_fee;
        $exam->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
        $exam->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');

        if($request->image){
            $old = $exam->image ?? null;
            $exam->image = uploadImage($request->image,'assets/images/exam/','850x560',$old,'400x250');
        }

        if($request->question_type == 1){
            $exam->reduce_mark = $request->neg_status ? $request->reduce_mark:null;
            $exam->negative_marking = $request->neg_status ? 1 : 0;
        } 

        $exam->random_question = $request->randomize ? 1:0;
        $exam->option_suffle = $request->opt_suffle ? 1:0;
        $exam->status = $request->status ? 1 : 0; 
        $exam->update();
        $notify[]=['success','Exam Updated successfully'];
        return back()->withNotify($notify);

    }

    public function examQuestions($examid)
    {
        $page_title = 'Exam Questions';
        $empty_message  = 'No data';
        $qstns = Questions::where('exam_id',$examid)->paginate(15);
        $exam = Exam::findOrFail($examid);
        return view('admin.question.examQuestions',compact('page_title','qstns','empty_message','exam'));
    }

    public function certificate()
    {
        $page_title = "Exam Certificate template";
        $certificate = Certificate::first();
        $empty_message = 'No certificate available';
        return view('admin.exam.certificate',compact('page_title','certificate','empty_message'));
    }
    public function certificateUpdate(Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);
        $certificate = Certificate::first();
        $certificate->body = $request->body;
        $certificate->update();
        $notify[]=['success','Certificate updated successfully'];
        return back()->withNotify($notify);
    }

  
}
