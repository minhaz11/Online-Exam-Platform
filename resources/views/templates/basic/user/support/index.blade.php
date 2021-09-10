@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="transaction-area mt-30">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                <div class="panel-table-area">
                    <div class="panel-table border-0">
                        <div class="panel-card-widget-area pt-0 d-flex flex-wrap align-items-center justify-content-end">
                            <div class="panel-card-widget-right">
                                <div class="panel-widget-search-area d-flex flex-wrap align-items-center">
                                     <a href="{{route('ticket.open')}}" class="btn--primary border--rounded text-white p-2" id="my-addon"> <i class="las la-plus"></i> @lang('Create New')</a>
                                          
                                    </div>
                            </div>
                          
                        </div>
                        <div class="panel-card-body table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr class="bg--primary">
                                        <th scope="col">@lang('Subject')</th>
                                        <th scope="col">@lang('Status')</th>
                                        <th scope="col">@lang('Last Reply')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supports as $key => $support)
                                        <tr>
                                            <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [Ticket#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                            <td data-label="@lang('Status')">
                                                @if($support->status == 0)
                                                    <span class="badge badge-success py-2 px-3">@lang('Open')</span>
                                                @elseif($support->status == 1)
                                                    <span class="badge badge-primary py-2 px-3">@lang('Answered')</span>
                                                @elseif($support->status == 2)
                                                    <span class="badge badge-warning py-2 px-3">@lang('Customer Reply')</span>
                                                @elseif($support->status == 3)
                                                    <span class="badge badge-dark py-2 px-3">@lang('Closed')</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
    
                                            <td data-label="@lang('Action')">
                                                <a href="{{ route('ticket.view', $support->ticket) }}" class="icon-btn">
                                                    <i class="fa fa-desktop"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{$supports->links()}}
                        </div>
              
                    </div>
                </div>
            </div>
        </div>
    </div>
        
@endsection
