<?php

namespace App\Http\Controllers;

use Image;
use App\Exam;
use App\User;
use App\Coupon;
use App\Deposit;
use App\CouponUser;
use App\Transaction;
use App\GeneralSetting;
use Illuminate\Http\Request;
use App\Lib\GoogleAuthenticator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    public function home()
    {
        $page_title = 'Dashboard';
        $user = User::first();
        $totalDeposit = Deposit::where('user_id',$user->id)->sum('amount');
        $totalTrx = Transaction::where('user_id',$user->id)->count();
        $examList =  Exam::where('status',1)->where('end_date','>=',\Carbon\Carbon::now()->toDateString())->whereHas('subject',function($sub){
            $sub->where('status',1)->whereHas('category', function($cat){
                $cat->where('status',1);
            });
        })->latest()->with('subject.category')->take(8)->get();
        return view($this->activeTemplate . 'user.dashboard', compact('page_title','totalDeposit','totalTrx','examList'));
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate. 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => 'mimes:png,jpg,jpeg'
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);


        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            $size = imagePath()['profile']['user']['size'];
            $image = Image::make($image);
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
            $image->save($location);
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $logs = auth()->user()->deposits()->with(['gateway'])->where('trx','like',"%$search%")->paginate(getPaginate(15));

        } else {

            $page_title = 'Deposit History';
            $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate(15));
        }
        $empty_message = 'No history found.';
        return view($this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs','search'));
    }

    public function trxHistory(Request $request)
    {
        $search = $request->search;
        if($search){
            $page_title = "Search Result of $search";
            $logs = auth()->user()->transactions()->where('trx','like',"%$search%")->paginate(getPaginate(15));

        } else {

            $page_title = 'Transaction History';
            $logs = auth()->user()->transactions()->latest()->paginate(getPaginate(15));
        }
        $empty_message = 'No history found.';
        return view($this->activeTemplate . 'user.trxHistory', compact('page_title', 'empty_message', 'logs','search'));
    }
    

    /*
     * Withdraw Operation
     */

   

    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {

            $user->tsc = null;
            $user->ts = 0;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->with($notify);
        }
    }

    public function applyCoupon(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'coupon'=> 'required'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors());
        }
        $coupon = Coupon::where('coupon_code','=',strtoupper($request->coupon))->where('status','=',1)->first();

        if(!$coupon){
            return response()->json(['coupon'=>['Sorry! Invalid coupon']]);
        }

        if($coupon->use_limit <= 0){
            return response()->json(['coupon'=>['Sorry! Coupon limit has been reached']]);
        }
        if($coupon->start_date > Carbon::now()->toDateString()){
            return response()->json(['coupon'=>['Sorry! Coupon is not valid in this date']]);
        }
        if($coupon->end_date < Carbon::now()->toDateString()){
            return response()->json(['coupon'=>['Sorry! Coupon has been expired']]);
            $coupon->status = 0;
            $coupon->update();
        }


        $general = GeneralSetting::first();
        $exam = Exam::find($request->examid);
        if(!$exam){
            return response()->json(['coupon'=>['Sorry! Something went wrong']]);
        }
        $couponUser = CouponUser::where('user_id',auth()->id())->where('coupon_id',$coupon->id)->get();
      
        if($exam->exam_fee < $coupon->min_order_amount){
            return response()->json(['coupon'=>["Sorry! Minimum exam price is required for this coupon is ".getAmount($coupon->min_order_amount).' '.$general->cur_text]]);
        }

        if($couponUser->count() >= $coupon->usage_per_user){
            return response()->json(['coupon'=>['Sorry! Your Coupon limit has been reached']]);
        } else {
            $couponUser = new CouponUser();
            $couponUser->user_id = auth()->id();
            $couponUser->coupon_id = $coupon->id;
            $couponUser->save();
        }

        if($coupon->exam_id == 0){
            if($coupon->amount_type == 2){
                $newPrice = $exam->exam_fee - $coupon->coupon_amount;
                
            } else{
                $discount = $exam->exam_fee*($coupon->coupon_amount/100);
                $newPrice = $exam->exam_fee - $discount;
            }
            session()->put('newPrice',$newPrice);
            session()->put('coupon', $coupon->coupon_code);
            return response()->json(['yes'=>"Coupon applied! new price is $newPrice".$general->cur_text,'newPrice'=>"$newPrice".' '.$general->cur_text]);
        } else {

            if($coupon->exam_id != $exam->id){
                return response()->json(['coupon'=>['Sorry! Coupon not valid for this exam']]);

            } else {

                if($coupon->amount_type == 2){
                    $newPrice = $exam->exam_fee - $coupon->coupon_amount;
                    
                } else{
                    $discount = $exam->exam_fee*($coupon->coupon_amount/100);
                    $newPrice = $exam->exam_fee - $discount;
                }
                session()->put('newPrice',$newPrice);
                session()->put('coupon', $coupon->coupon_code);
                return response()->json(['yes'=>"Coupon applied! new price is $newPrice".$general->cur_text,'newPrice'=>"$newPrice".' '.$general->cur_text]);
            }

        }


    }


}
