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
                            <form action="{{$data->url}}" method="{{$data->method}}">
                                    <li class="">
                                        @lang('Please Pay') {{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}
                                    </li>
                                    <li class="mb-2">
                                        @if (session('exam'))
                                          @lang('To Attend The Exam: '.@session('exam')->title)
                                        @else
                                          @lang('To Get') {{getAmount($deposit->amount)}}  {{__($general->cur_text)}}
                                        @endif
                                    </li>
                                   
                                <li>
                                    <script
                                        src="{{$data->src}}"
                                        class="stripe-button"
                                        @foreach($data->val as $key=> $value)
                                        data-{{$key}}="{{$value}}"
                                        @endforeach
                                    >
                                    </script>
                                </li>
                                    
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
@push('style')
    
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .card button {
            padding-left: 0px !important;
        }

        .stripe-button-el{
            background: #28c76f !important;
        }
        .stripe-button-el span{
            background: #28c76f !important;
        }
    </style>
@endpush

@push('script')
<script src="https://js.stripe.com/v3/"></script>
    <script>
        "use strict";
        $(document).ready(function () {
            $('button[type="submit"]').addClass("btn-round text-center btn-lg");
        })
    </script>
@endpush
