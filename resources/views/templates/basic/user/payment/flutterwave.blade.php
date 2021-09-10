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
                            <span class="title"><i class="lab la-stripe"></i>@lang('Flutterwave')</span>
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
                                    <li>
                                        <div class="deposit-btn">
                                            <button type="button" class="btn btn--success rounded text-white btn-icon icon-left btn-custom2 " id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                                    </div>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                       

                        
                        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                        <script>
                            var btn = document.querySelector("#btn-confirm");
                            btn.setAttribute("type", "button");
                            const API_publicKey = "{{$data->API_publicKey}}";

                            function payWithRave() {
                                var x = getpaidSetup({
                                    PBFPubKey: API_publicKey,
                                    customer_email: "{{$data->customer_email}}",
                                    amount: "{{$data->amount }}",
                                    customer_phone: "{{$data->customer_phone}}",
                                    currency: "{{$data->currency}}",
                                    txref: "{{$data->txref}}",
                                    onclose: function () {
                                    },
                                    callback: function (response) {
                                        var txref = response.tx.txRef;
                                        var status = response.tx.status;
                                        var chargeResponse = response.tx.chargeResponseCode;
                                        if (chargeResponse == "00" || chargeResponse == "0") {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        } else {
                                            window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                        }
                                            // x.close(); // use this to close the modal immediately after payment.
                                        }
                                    });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection