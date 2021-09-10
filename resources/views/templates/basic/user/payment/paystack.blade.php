@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="deposit-area mt-30">
        <div class="panel-card-header bg--primary text-white">
            <div class="panel-card-title"><i class="las la-money-bill"></i> @lang('Payment Preview')</div>
        </div>
        <div class="panel-card-body">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="deposit-preview deposit-item border--success border--rounded">
                        <div class="deposit-item-header bg--success text-white">
                            <span class="title"><i class="lab la-stripe"></i>@lang('Paystack')</span>
                        </div>
                        <div class="deposit-item-body d-flex flex-wrap align-items-center">
                            <div class="deposit-thumb">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="payment">
                            </div>
                            <div class="deposit-content text-center">
                                <ul class="deposit-list">
                             <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST">
                                    <li class="">
                                        @lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}
                                    </li>
                                    <li class="">
                                        @if (session('exam'))
                                          @lang('To Attend The Exam: '.@session('exam')->title)
                                        @else
                                          @lang('To Get') {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}
                                        @endif
                                    </li>
                                    <li class="">
                                        <button type="button" class="btn--success text-white border--rounded   icon-left btn-custom2 " id="btn-confirm" >@lang('Pay Now')</button>
                                    </li>
                                    <script
                                    src="//js.paystack.co/v1/inline.js"
                                    data-key="{{ $data->key }}"
                                    data-email="{{ $data->email }}"
                                    data-amount="{{$data->amount}}"
                                    data-currency="{{$data->currency}}"
                                    data-ref="{{ $data->ref }}"
                                    data-custom-button="btn-confirm"
                                >
                                </script>
                                    
                                </form> 
                                </ul>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


