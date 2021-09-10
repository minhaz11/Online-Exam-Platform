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
                        <div class="deposit-item-body d-flex flex-wrap align-items-center justify-content-center">
                            <div class="deposit-content text-center">
                                <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount}}</span> {{__($data->currency)}}</h4>
                                <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                                <img src="{{$data->img}}" alt="@lang('Image')">
                                <h4 class="bold my-4">@lang('SCAN TO SEND')</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
