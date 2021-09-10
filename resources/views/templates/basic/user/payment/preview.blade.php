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
                            <span class="title"><i class="lab la-stripe"></i></span>
                        </div>
                        <div class="deposit-item-body d-flex flex-wrap align-items-center">
                            <div class="deposit-thumb">
                                <img src="{{ $data->gateway_currency()->methodImage() }}" alt="payment">
                            </div>
                            <div class="deposit-content text-center">
                                <ul class="deposit-list">
                                   
                                    <li class="">
                                        @lang('Amount'):
                                        <strong>{{getAmount($data->amount)}} </strong> {{__($general->cur_text)}}
                                    </li>
                                    <li class="">
                                        @lang('Charge'):
                                        <strong>{{getAmount($data->charge)}}</strong> {{__($general->cur_text)}}
                                    </li>
                                    <li class="">
                                        @lang('Payable'): <strong> {{getAmount($data->amount + $data->charge)}}</strong> {{__($general->cur_text)}}
                                    </li>
                                    <li class="">
                                        @lang('Conversion Rate'): <strong>1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}</strong>
                                    </li>
                                    <li class="">
                                        @lang('In') {{$data->baseCurrency()}}:
                                        <strong>{{getAmount($data->final_amo)}}</strong>
                                    </li>
        
        
                                    @if($data->gateway->crypto==1)
                                        <li class="">
                                            @lang('Conversion with')
                                            <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="deposit-item-footer bg--success">
                            <div class="deposit-btn">

                                @if( 1000 >$data->method_code)
                                <a href="{{route('user.deposit.confirm')}}" class="btn btn--success text-white btn-block btn-icon icon-left">@lang('Confirm Payment')</a>
                                @else
                                <a href="{{route('user.deposit.manual.confirm')}}" class="btn btn--success text-white btn-block btn-icon icon-left">@lang('Confirm Payment')</a>
                                 @endif
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


