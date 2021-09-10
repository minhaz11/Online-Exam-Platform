<?php

namespace App\Http\Controllers\Gateway;

use Session;
use App\Exam;
use App\User;
use App\Coupon;
use App\Result;
use App\Deposit;
use App\Transaction;
use App\GeneralSetting;
use App\WrittenPreview;
use App\GatewayCurrency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function deposit($id = null)
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $page_title = 'Deposit Methods';
    
        if(Route::current()->getName()=='user.payment'){
            $page_title = 'Payment methods';
            $exam = Exam::findOrFail($id);
            
            if($exam->question_type == 1){
                $exist = Result::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
            } else {
                $exist = WrittenPreview::where('user_id',auth()->id())->where('exam_id',$exam->id)->first();
            }

            if($exist){
                $notify[]=['error','Sorry you have already participated in this exam'];
                return back()->withNotify($notify);
            }

            Session::put('exam', $exam); 
        }

        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'page_title'));
    }
    public function depositInsert(Request $request)
    {
        if(session('newPrice')){
            $price = @session('newPrice');
        } else{
            $price = @session('exam')->exam_fee;
        }
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        if(isset($price) && $price != $request->amount){
            $notify[]=['error','Sorry amount mismatch'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please Follow payment Limit'];
            return back()->withNotify($notify);
        }

        $charge = getAmount($gate->fixed_charge + ($request->amount * $gate->percent_charge / 100));
        $payable = getAmount($request->amount + $charge);
        $final_amo = getAmount($payable * $gate->rate);

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = getAmount($final_amo);
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();
        session()->put('Track', $data['trx']);
     
        if(session('exam')){
           
            return redirect()->route('user.payment.preview');
        }
        return redirect()->route('user.deposit.preview');
    }


    public function depositPreview()
    {
        
        $track = session()->get('Track');
    
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->firstOrFail();

        if (is_null($data)) {
            $notify[] = ['error', 'Invalid payment Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($data->status != 0) {
            $notify[] = ['error', 'Invalid payment Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        $page_title = 'Payment Preview';
        return view($this->activeTemplate . 'user.payment.preview', compact('data', 'page_title'));
    }


    public function depositConfirm()
    {
        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->with('gateway')->first();
        if (is_null($deposit)) {
            $notify[] = ['error', 'Invalid payment Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($deposit->status != 0) {
            $notify[] = ['error', 'Invalid payment Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your payment request is queued for approval.'];
            return back()->withNotify($notify);
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $page_title = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'page_title', 'deposit'));
    }


    public static function userDataUpdate($trx)
    {
        $gnl = GeneralSetting::first();
        $data = Deposit::where('trx', $trx)->first();
        $exam = session('exam');
        if ($data->status == 0) {
            $data->status = 1;
            $data->save();
            
            $user = User::find($data->user_id);
            $user->balance += $data->amount;
            $user->update();

            $transaction = new Transaction();
            $transaction->user_id = $data->user_id;
            $transaction->amount = $data->amount;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = getAmount($data->charge);
            $transaction->trx_type = '+';
            $transaction->details = 'Deposit via' . $data->gateway_currency()->name;
            $transaction->trx = $data->trx;
            $transaction->save();

            if($exam){
                if(session('newPrice')){
                    $coupon = Coupon::where('coupon_code',session('coupon'))->first();
                    $coupon->use_limit -= 1;
                    $coupon->update();
                }

                $user->balance -= $data->amount;
                $user->update();

                $transaction = new Transaction();
                $transaction->user_id = $data->user_id;
                $transaction->amount = $data->amount;
                $transaction->post_balance = getAmount($user->balance);
                $transaction->charge = getAmount($data->charge);
                $transaction->trx_type = '+';
                $transaction->details = 'Payment of exam fee' . $data->gateway_currency()->name;
                $transaction->trx = $data->trx;
                $transaction->save();
            }     

            if($exam){
                notify($user, 'EXAM_FEE', [
                    'title' => $exam->title,
                    'type' => $exam->question_type == 1 ? 'MCQ':'Written',
                    'mark' => $exam->totalmark,
                    'method_name' => $data->gateway_currency()->name,
                    'method_currency' => $data->method_currency,
                    'method_amount' => getAmount($data->final_amo),
                    'amount' => getAmount($data->amount),
                    'charge' => getAmount($data->charge),
                    'currency' => $gnl->cur_text,
                    'rate' => getAmount($data->rate),
                    'trx' => $data->trx,
                    'post_balance' => getAmount($user->balance)
                ]);
                session()->put('paid','ok');
            } else {
                notify($user, 'DEPOSIT_COMPLETE', [
                    'method_name' => $data->gateway_currency()->name,
                    'method_currency' => $data->method_currency,
                    'method_amount' => getAmount($data->final_amo),
                    'amount' => getAmount($data->amount),
                    'charge' => getAmount($data->charge),
                    'currency' => $gnl->cur_text,
                    'rate' => getAmount($data->rate),
                    'trx' => $data->trx,
                    'post_balance' => getAmount($user->balance)
                ]);
            }

        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $page_title = 'Deposit Confirm';
            $method = $data->gateway_currency();
            return view($this->activeTemplate . 'user.manual_payment.manual_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }

        $params = json_decode($data->gateway_currency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }


        $this->validate($request, $rules);


        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['deposit']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }

        $exam = session('exam');
        $data->status = 2; // pending
        $exam ? $data->exam_id = $exam->id : null;
        $data->save();
        $gnl = GeneralSetting::first();
        if($exam){
            if(session('newPrice')){
                $coupon = Coupon::where('coupon_code',session('coupon'))->first();
                $coupon->use_limit -= 1;
                $coupon->update();
                
            }
            notify($data->user, 'PAYMENT_REQUEST', [
                'title' => $exam->title,
                'type' => $exam->question_type == 1 ? 'MCQ':'Written',
                'mark' => $exam->totalmark,
                'method_name' => $data->gateway_currency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => getAmount($data->final_amo),
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $gnl->cur_text,
                'rate' => getAmount($data->rate),
                'trx' => $data->trx
            ]);
        } else {

            notify($data->user, 'DEPOSIT_REQUEST', [
                'method_name' => $data->gateway_currency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => getAmount($data->final_amo),
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $gnl->cur_text,
                'rate' => getAmount($data->rate),
                'trx' => $data->trx
            ]);
        }

        $notify[] = ['success', 'Your payment request has been taken.'];
        return redirect()->route('user.deposit.history')->withNotify($notify);
    }


}
