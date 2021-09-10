
@extends($activeTemplate.'layouts.master')
@section('content')



<div class="transaction-area mt-30">
    <div class="row justify-content-center mb-30-none">
        <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
            <div class="panel-table-area">
                <div class="panel-table border-0">
                    <div class="panel-card-widget-area pt-0 d-flex flex-wrap align-items-center justify-content-end">
                       
                        <form action="" method="GET">
                            <div class="panel-card-widget-right">
                                <div class="panel-widget-search-area d-flex flex-wrap align-items-center">
                                        <div class="input-group">
                                            <input type="text" name="search" placeholder="@lang('trx')" value="{{$search??''}}">
                                            <div class="input-group-append">
                                                <button type="submit" class="input-group-text" id="my-addon"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="panel-card-body table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr class="bg--primary">
                                <th scope="col">@lang('Transaction ID')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Post balance')</th>
                                <th scope="col">@lang('Details')</th>
                               
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($logs) >0)
                                @foreach($logs as $k=> $data)
                                    <tr>
                                        <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                        <td data-label="@lang('Amount')">
                                            @if($data->trx_type == '+')
                                            <span class="text-success">{{$data->trx_type}}</span>  <strong class="text-success">{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                            @else    
                                            <span class="text-danger">{{$data->trx_type}}</span> <strong class="text-danger">{{getAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                            @endif
                                           
                                        </td>
                                        
                                        <td data-label="@lang('Post balance')">
                                             {{getAmount($data->post_balance)}} {{__($general->cur_text)}}
                                        </td>
                                        <td data-label="@lang('Details')">
                                            {{$data->details}}
                                        </td>
                                       
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="100%"> @lang('No results found')!</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                        <div class="text-center">
                            {{paginateLinks($logs,'')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection