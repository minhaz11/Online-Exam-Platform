<?php

namespace App\Http\Controllers;

use App\Exam;
use App\GeneralSetting;
use App\Options;
use App\Questions;
use App\Result;
use App\Transaction;
use App\WrittenPreview;
use Illuminate\Http\Request;


class UserExamController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }
    public function examList(Request $request)
    {

        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $examList  = Exam::where('status',1)->where('end_date','>=',\Carbon\Carbon::now()->toDateString())->where('title','like',"%$search%")->whereHas('subject', function($sub) use($search){
                $sub->whereHas('category', function($cat){
                    $cat->where('status',1);
                })->orWhere('status',1)->where('name','like',"%$search%");
            })->paginate(15);
           
            
        } else {
            $page_title = "Exam List";
            $examList =  Exam::where('status',1)->where('end_date','>=',\Carbon\Carbon::now()->toDateString())->whereHas('subject',function($sub){
                $sub->where('status',1)->whereHas('category', function($cat){
                    $cat->where('status',1);
                });
            })->latest()->with('subject.category')->paginate(15);
        }
        return view($this->activeTemplate.'user.exam.examList',compact('page_title','examList','search'));  
    }

    public function perticipateExam($id)
    {
           session()->forget('exam');
           $page_title = 'Participation of exam';
           $exam = Exam::find($id);
           if(!$exam){
               $notify[]=['error','Exam not found'];
               return back()->withNotify($notify);
           }
           if($exam->upcomming($exam->id)){
                $notify[]=['error','Sorry!! this is an upcoming exam'];
                return back()->withNotify($notify);
           }
           if($exam->question_type == 1){
                $exist = Result::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
                if($exist){
                    $notify[]=['error','Sorry you have already participated in this exam'];
                    return back()->withNotify($notify);
                }

               $result = new Result();
               $result->exam_id = $exam->id;
               $result->user_id = auth()->id();
               $result->result_mark = 0;
               $result->total_correct_ans = 0;
               $result->total_wrong_ans = 0;
               $result->result_status = 0;
               $result->save();
           } else {
                $exist = WrittenPreview::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
                if($exist){
                    $notify[]=['error','Sorry you have already participated in this exam'];
                    return back()->withNotify($notify);
                }

                $written = new WrittenPreview();
                $written->exam_id = $exam->id;
                $written->user_id = auth()->id();
                $written->status = 2;
                $written->save();
           }

           if($exam->random_question == 1){
               $questions = Questions::where('exam_id',$id)->inRandomOrder()->get();
           } else {
                $questions = Questions::where('exam_id',$id)->get();
           }

           return view($this->activeTemplate.'user.exam.examScript',compact('page_title','questions','exam'));
    }

    public function takeExam($id)
    {
        $exam = Exam::findOrFail($id);
        $gnl = GeneralSetting::first();
        $user = auth()->user();
        if($exam->question_type == 1){
            $exist = Result::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
        } else {
            $exist = WrittenPreview::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
        }
        if($exist){
            $notify[]=['error','Sorry you have already participated in this exam'];
            return back()->withNotify($notify);
        }

        if(session('newPrice')){
            $price = session('newPrice');
        } else {
            $price = $exam->exam_fee;
        }
        if($price > $user->balance){
            $notify[]=['error','Insufficient balance'];
            return back()->withNotify($notify);
        }
    
        $user->balance -= $price;
        $user->update();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($price);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '-';
        $transaction->details = "Payment of exam fee, $exam->title";
        $transaction->trx = getTrx();
        $transaction->save();

        notify($user, 'EXAM_FEE_FROM_BALANCE', [
            'title' => $exam->title,
            'type' => $exam->question_type == 1 ? 'MCQ':'Written',
            'mark' => $exam->totalmark,
            'amount' => getAmount($price),
            'trx' => $transaction->trx,
            'currency' => $gnl->cur_text,
            'post_balance' => getAmount($user->balance)
        ]);
        
        return redirect(route('user.exam.perticipate',$exam->id));
    }

    public function scriptSubmission(Request $request)
    {
       
        $exam = Exam::findOrFail($request->examId);

        if($exam->question_type == 1){
           
            $passMark = ($exam->totalmark*$exam->pass_percentage)/100;
            $correctAns = 0;
            $wrongAns = 0;
            $resultMark = 0;
    
           if($request->ans){
             foreach($request->ans as $k => $ans){
              
                $qtn = Questions::findOrFail($k);
                $opt = Options::findOrFail($ans);
                
                if($opt->correct_ans == 1){
                  $correctAns +=1;
                  
                } else if($opt->correct_ans == 0) {
                   $wrongAns += 1;
                }

                $resultMark = $exam->totalmark - $qtn->marks*$wrongAns;
                
              }
                if($exam->negative_marking == 1){
                    $resultMark -= $exam->reduce_mark*$wrongAns;
                }

                if($correctAns == 0){
                    $resultMark = 0;
                }
           }

            $result  = Result::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
            $result->exam_id = $exam->id;
            $result->user_id = auth()->id();
            $result->result_mark = $resultMark ?? 0;
            $result->total_correct_ans = $correctAns ?? 0;
            $result->total_wrong_ans = $wrongAns ?? 0;
            $result->result_status = $passMark > $resultMark ? 0:1 ?? 0;
            $result->save();
            return redirect(route('user.exam.result',$exam->id));

        } else {
            WrittenPreview::where('user_id',auth()->id())->where('exam_id',$exam->id)->delete();
            foreach($request->written as $k => $ans){
                $qtn = Questions::findOrFail($k);
                $written = new WrittenPreview();
                $written->exam_id = $exam->id;
                $written->question_id = $qtn->id;
                $written->user_id = auth()->id();
                $written->question = $qtn->question;
                $written->answer = $ans;
                $written->status = 0;
                $written->save();
            }
            return redirect(route('user.exam.result',$exam->id));
        }

    }

    public function result($id)
    {
        $exam = Exam::findOrFail($id);
        if($exam->question_type == 1){
            $page_title = "Exam Result";
            $result = Result::where('exam_id',$exam->id)->first();
            return view($this->activeTemplate.'user.exam.result',compact('page_title','exam','result'));
        } else {
            $page_title = "Submission";
            return view($this->activeTemplate.'user.exam.writtenPrev',compact('page_title','exam'));
        }
    }

    public function mcqExamHistory(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $histories = Result::where('user_id',auth()->id())->whereHas('exam',function($q) use($search){
                $q->where('question_type',1)->where('title','like',"%$search%");
            })->paginate(15);

        } else {

            $page_title = "Mcq Exam History";
            $histories = Result::where('user_id',auth()->id())->whereHas('exam',function($q){
                $q->where('question_type',1);
            })->paginate(15);
        }
        return view($this->activeTemplate.'user.exam.examHistory',compact('page_title','histories','search'));
    }

    public function writtenExamHistory(Request $request)
    {
            $search = $request->search;
            if($search){
                $page_title = "Search Result of $search";
                $collection = WrittenPreview::where('user_id',auth()->id())->whereHas('exam',function($q) use($search){
                    $q->where('title','like',"%$search%");
                })->get();

            } else {

                $page_title = "Written Exam History";
                $collection = WrittenPreview::where('user_id',auth()->id())->whereHas('exam')->get();
   
            }

            $histories = $collection->groupBy('exam_id');
            $examId = array_keys($histories->toArray());
            $exams = Exam::whereIn('id',$examId)->paginate(15);
            return view($this->activeTemplate.'user.exam.writtenExamHistory',compact('page_title','histories','search','exams'));
    }

    public function writtenExamDetails($examid)
    {
        $page_title = "Written Exam Result Details";
        $user  = auth()->user();
        $detailQuestions = WrittenPreview::where('user_id',$user->id)->where('exam_id',$examid)->with(['writtenQuestion','exam'])->get();
        $exam  = Exam::findOrFail($examid);
        return view($this->activeTemplate.'user.exam.writtenExamDetails',compact('page_title','detailQuestions','exam','user'));
    }

    

    public function perticipate()
    {
        $exam = session('exam');
        $paid = session('paid');
        if(!$paid){
            $notify[]=['error','Sorry Invalid Request'];
            return redirect(route('user.exam.list'))->withNotify($notify);
        }
        session()->forget('paid');
        return redirect(route('user.exam.perticipate',$exam->id));
    }

    public function mcqCertificate($id)
    {
        $result  = Result::findOrFail($id);
        $page_title = 'Certificate';
        $gnl =GeneralSetting::first();
        $cert = certificate([

            'sitename' => $gnl->sitename,
            'name' => auth()->user()->fullname,
            'score' => $result->result_mark,
            'exam_title'=> $result->exam->title,
            'date' => showDateTime($result->created_at,'d M Y')
        ]);
        $cert_name = slug($result->exam->title).'-'.slug(showDateTime($result->created_at,'d M Y'));
      return view($this->activeTemplate.'certificate',compact('cert','page_title','cert_name'));
    }

    public function writtenCertificate($examid)
    {
        $exam  = Exam::findOrFail($examid);
        $result = $exam->written->where('user_id',auth()->id())->last();
        $page_title = 'Certificate';
        $getMark = $exam->totalWrittenMark(auth()->id());
        $gnl = GeneralSetting::first();
      
        $cert = certificate([
            'sitename' => $gnl->sitename,
            'name' => auth()->user()->fullname,
            'score' => $getMark,
            'exam_title'=> $exam->title,
            'date' => showDateTime($result->updated_at,'d M Y')
        ]);
      $cert_name = slug($exam->title).'-'.slug(showDateTime($result->updated_at,'d M Y'));
      return view($this->activeTemplate.'certificate',compact('cert','page_title','cert_name'));
    }
    
    
    
    
}
