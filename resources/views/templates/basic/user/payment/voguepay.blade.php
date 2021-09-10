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
                            <span class="title"><i class="lab la-stripe"></i>@lang('Vougue Pay')</span>
                        </div>
                        <div class="deposit-item-body d-flex flex-wrap align-items-center">
                            <div class="deposit-thumb">
                                <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="payment">
                            </div>
                            <div class="deposit-content text-center">
                                <ul class="deposit-list">
                          
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
                               
                                </ul>
                            </div>
                             
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@push('script')
    <script src="//voguepay.com/js/voguepay.js"></script>
    <script>

       closedFunction = function() {
        }
        successFunction = function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}';
        }
        failedFunction=function(transaction_id) {
            window.location.href = '{{ route(gatewayRedirectUrl()) }}' ;
        }

        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "{{ $data->v_merchant_id}}",
                total: price,
                notify_url: "{{ $data->notify_url }}",
                cur: "{{$data->cur}}",
                merchant_ref: "{{ $data->merchant_ref }}",
                memo:"{{$data->memo}}",
                recurrent: true,
                frequency: 10,
                developer_code: '5af93ca2913fd',
                store_id:"{{ $data->store_id }}",
                custom: "{{ $data->custom }}",

                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }

        (function ($) {
             $(document).on('click', '#btn-confirm', function (e) {
                e.preventDefault();
                pay('Buy', {{ $data->Buy }});
            });
        })(jQuery);
        
    </script>
@endpush
