<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exam;
use App\Page;
use App\Subject;
use App\Frontend;
use App\Language;
use Carbon\Carbon;
use App\Subscriber;
use App\SupportTicket;
use App\SupportMessage;
use App\SupportAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }
        
        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }
    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($this->activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $data['page_title'] = "Contact Us";
        return view($this->activeTemplate . 'contact', $data);
    }

    public function subscribe(Request $request)
        {
         
            $validate = Validator::make($request->all(),[
                'email' => 'required|email|unique:subscribers|max:255',
            ]);
    
            if($validate->fails()){
                return response()->json($validate->errors());         
            }
    
            Subscriber::create($request->only('email'));
            $notify = ['success' => 'Subscribe Successfully!'];
            return response()->json($notify);
    
            
        }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->image = uploadImage($image, $path);
                    $attachment->save();
                    
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blog()
    {
        $page_title = "Blogs";
        $blogElements = Frontend::where('data_keys','blog.element')->latest()->paginate(9);
        return view(activeTemplate().'blog',compact('page_title','blogElements'));
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $page_title = "Blog Details";
        $recentblog = Frontend::latest()->where('data_keys','blog.element')->take(10)->get();
        return view($this->activeTemplate.'blogDetails',compact('blog','page_title','recentblog'));
    }

    public function placeholderImage($size = null){
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

  
    public function policyAndTerms($slug,$id)
    {
        $policy = Frontend::findOrFail($id);
        $page_title= $policy->data_values->title;
        return view($this->activeTemplate.'sections.policy',compact('policy','page_title'));
    }

    public function exams()
    {
        $page_title = 'All Exams';
        $exams = Exam::where('status',1)->where('end_date','>=',\Carbon\Carbon::now()->toDateString())->whereHas('subject',function($sub){
            $sub->where('status',1)->whereHas('category', function($cat){
                $cat->where('status',1);
            });
        })->latest()->with('subject.category')->paginate(6);
        return view($this->activeTemplate.'exams',compact('page_title','exams'));
    }

    public function examDetails($id)
    {
        $exam = Exam::find($id);
        if(!$exam){
            $notify[]=['error','Sorry exam couldn\'t found'];
            return back()->withNotify($notify);
        }
        $page_title = "Exam Details";
        return view($this->activeTemplate.'examDetails',compact('page_title','exam'));
    }

    public function faq()
    {
        $page_title = 'Frequently asked questions';
        $faqs = Frontend::where('data_keys','faq.element')->get();
        return view($this->activeTemplate.'faq',compact('page_title','faqs'));

    }

    public function subjectExams($slug)
    {
        $sub = Subject::where('slug',$slug)->first();
        if(!$sub){
            $notify[]=['error','Sorry subject not found'];
            return back()->withNotify($notify);
        }
        $exams = Exam::where('status',1)->where('subject_id',$sub->id)->where('end_date','>=',\Carbon\Carbon::now()->toDateString())->with('subject')->paginate(6);
        $page_title = "Exams of $sub->name";
        return view($this->activeTemplate.'exams',compact('page_title','exams'));
    }

    public function subjects()
    {
        $page_title = "All subjects";
        $subjects = Subject::where('status',1)->whereHas('category',function($cat){
            $cat->where('status',1);
        })->latest()->paginate(9);
        return view($this->activeTemplate.'subjects',compact('page_title','subjects'));
    }

    public function categorySubject($slug)
    {
        $category = Category::where('slug',$slug)->where('status',1)->first();
        if(!$category){
            $notify[]=['error','Category currently inactive'];
            return redirect(route('home'))->withNotify($notify);
        }
        $page_title = "Subjects of $category->name";
        $subjects = Subject::where('category_id',$category->id)->with('category')->paginate(9);
        return view($this->activeTemplate.'subjects',compact('page_title','subjects'));

    }
    
}
