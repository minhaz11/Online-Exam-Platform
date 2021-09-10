<?php

namespace App\Http\Controllers\Admin;

use App\Exam;
use App\User;
use App\WrittenPreview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Question\Question;

class WrittenReviewController extends Controller
{
    public function allPending(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Result of $search";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status',0)->whereHas('exam',function($exam) use ($search){
                $exam->where('title','like',"%$search%");
            })->orWhereHas('user',function($user) use($search){
                $user->where('username',$search);
            })->orWhereHas('writtenQuestion',function($qtn) use($search){
                $qtn->where('question','like',"%$search%");
            })->paginate(15);
        } else {
            $page_title = "All pending written script";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status',0)->latest()->paginate(15);
        }

        $empty_message = 'No data found';

        return view('admin.written.allPending',compact('page_title','pendings','empty_message'));
    }

    public function pendingExam(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Result of $search";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status',0)->whereHas('exam',function($exam) use ($search){
                $exam->where('title','like',"%$search%");
            })->groupBy('exam_id')->paginate(15);
        } else {
            $page_title = "All pending written exam";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status',0)->groupBy('exam_id')->latest()->paginate(15);
        }

        $empty_message = 'No data found';
        return view('admin.written.pendingExam',compact('page_title','pendings','empty_message'));
    }
    
    public function pendingExamDetails(Request $request,$id)
    {
        $search = $request->search;
        if($search){
            $page_title = "Result of $search";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status',0)->where('exam_id',$id)->whereHas('user',function($user) use($search){
                $user->where('username',$search);
            })->groupBy('user_id')->paginate(15);
        } else {
            $page_title = "All pending user scripts";
            $pendings = WrittenPreview::whereNotNull('answer')->where('status',0)->where('exam_id',$id)->groupBy('user_id')->latest()->paginate(15);
        }

        $empty_message = 'No data found';

        return view('admin.written.userPendingExam',compact('page_title','pendings','empty_message'));
    }

    public function writtenDetailsUser($userid, $examid)
    {
        $page_title = 'Written Details';
        $detailQuestions = WrittenPreview::where('user_id',$userid)->where('exam_id',$examid)->with(['writtenQuestion','exam'])->get();
        $exam  = Exam::findOrFail($examid);
        $user  = User::findOrFail($userid);
        return view('admin.written.writtenDetailsUser',compact('page_title','detailQuestions','exam','user'));
    }
    
    

    public function reviewedExam(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Result of $search";
            $reviewed = WrittenPreview::where('status',1)->whereHas('exam',function($exam) use ($search){
                $exam->where('title','like',"%$search%");
            })->groupBy('exam_id')->paginate(15);
        } else {
            $page_title = "All reviewed written exam";
            $reviewed = WrittenPreview::where('status',1)->groupBy('exam_id')->latest()->paginate(15);
        }

        $empty_message = 'No data found';

        return view('admin.written.reviewedExam',compact('page_title','reviewed','empty_message'));
    }

    public function reviewedExamDetails(Request $request,$id)
    {
        $search = $request->search;
        if($search){
            $page_title = "Result of $search";
            $reviewed = WrittenPreview::where('status',1)->where('exam_id',$id)->whereHas('user',function($user) use($search){
                $user->where('username',$search);
            })->groupBy('user_id')->paginate(15);
        } else {
            $page_title = "All reviewed user scripts";
            $reviewed = WrittenPreview::where('status',1)->where('exam_id',$id)->groupBy('user_id')->latest()->paginate(15);
        }

        $empty_message = 'No data found';

        return view('admin.written.userReviewedExam',compact('page_title','reviewed','empty_message'));
    }

    public function writtenDetails($userid,$qtnid)
    {
        $page_title = 'Written Details';
        $details = WrittenPreview::where('user_id',$userid)->where('question_id',$qtnid)->with(['writtenQuestion','exam'])->first();
        return view('admin.written.writtenDetails',compact('page_title','details'));
    }
    
    public function giveMark(Request $request,$id)
    {
        $validate = Validator::make($request->all(),[
            'mark'=> 'required|numeric|min:0'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors());
        }

        $wp = WrittenPreview::find($id);
        if(!$wp){
            return response()->json(['mark'=> ['Question not found']]);
        }
        if($request->mark > $wp->writtenQuestion->marks){
            return response()->json(['mark'=> ['Given mark can not be greater than question mark']]);
        }
        $wp->given_mark = $request->mark;
        $wp->status = 1;
        $wp->update();
        return response()->json(['yes'=> 'Mark has been given']);

  }

  public function giveCorrectAns(Request $request,$id)
  {
    $validate = Validator::make($request->all(),[
        'ans'=> 'required|numeric|min:0'
    ]);
    if($validate->fails()){
        return response()->json($validate->errors());
    }

    $wp = WrittenPreview::find($id);
    if(!$wp){
        return response()->json(['mark'=> ['Question not found']]);
    }
   
    $wp->correct_ans = 1;
    $wp->update();
    return response()->json(['yes'=> 'Correct answer provided']);
  }

    
    
    
}
