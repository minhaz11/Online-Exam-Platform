@extends($activeTemplate.'layouts.master')

@php
    if(Route::current()->getName()=='user.deposit'){
        session()->forget('exam');
        session()->forget('newPrice');
    } 

    if(session('newPrice')){
        $price = @session('newPrice');
    } else{
        $price = @session('exam')->exam_fee;
    }
 

@endphp

@section('content')


    <div class="deposit-area mt-30">
  
        <div class="panel-card-body p-4">
            <div class="row justify-content-center mb-30-none">   
                @foreach($gatewayCurrency as $data)

                <div class="col-xl-3 col-md-6 col-sm-8 mb-30">
                    <div class="deposit-item border--primary border--rounded">
                        <div class="deposit-item-header bg--primary text-white">
                            <span class="title"><i class="lab la-paypal"></i> {{__($data->name)}}</span>
                        </div>
                        <div class="deposit-item-body">
                            <div class="deposit-thumb">
                                <img src="{{$data->methodImage()}}" alt="{{__($data->name)}}">
                            </div>
                        </div>
                        <div class="deposit-item-footer bg--primary">
                            <div class="deposit-btn">
                                <button data-id="{{$data->id}}" data-resource="{{$data}}"
                                    data-min_amount="{{getAmount($data->min_amount)}}"
                                    data-max_amount="{{getAmount($data->max_amount)}}"
                                    data-base_symbol="{{$data->baseSymbol()}}"
                                    data-fix_charge="{{getAmount($data->fixed_charge)}}"
                                    data-percent_charge="{{getAmount($data->percent_charge)}}" data-toggle="modal" data-name="BitCoin" data-gate="505" data-target="#depoModal"
                                    class="btn btn--primary text-white btn-block btn-icon icon-left deposit"><i
                                        class="las la-money-bill"></i>   @if (session('exam'))
                                        @lang('Pay Now')</button>
                                      @else
                                        @lang('Deposit Now')</button>
                                      @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
               
            </div>
        </div>
    </div>


<div class="modal fade" id="depoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg--primary">
                <h3 class="modal-title method-name text-white" id="ModalLabel"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.deposit.insert')}}" method="post">
                @csrf
                <div class="modal-body">
                    <p class="text-danger depositLimit"></p>
                    <p class="text-danger depositCharge"></p>
                    <div class="form-group">
                        <input type="hidden" name="currency" class="edit-currency" value="">
                        <input type="hidden" name="method_code" class="edit-method-code" value="">
                    </div>
                    <div class="form-group">
                        <label>@lang('Enter Amount'):</label>
                        <div class="input-group">
                            <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required  value="{{ $price != null ? getAmount($price) : old('amount')}}" {{$price ? 'readonly':''}}>
                            <div class="input-group-prepend">
                                <span class="input-group-text currency-addon addon-bg">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn--secondary border--rounded text-white p-2" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn--primary border--rounded text-white p-2">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop



@push('script')
    <script>
        "use strict";
        $(document).ready(function(){
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{__($general->cur_text)}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                $('.currency-addon').text(baseSymbol);


                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);
            });
        });
    </script>
@endpush
