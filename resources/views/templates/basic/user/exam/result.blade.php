@extends($activeTemplate.'layouts.master')

@section('content')
<div class="transaction-area mt-30">
    <div class="row justify-content-center mb-30-none">
        <div class="col-xl-6 col-md-6 col-sm-6 mb-30">
            <div class="panel-table-area">
                <div class="panel-table border--base">
                    <div class="panel-card-body table-responsive">
                        <table class="table  table-striped table-bordered">
                            <tr>
                                <th>@lang('Exam Name')</th>
                                <td>{{__($exam->title)}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Exam Category')</th>
                                <td>{{$exam->subject->category->name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Exam Subject')</th>
                                <td>{{$exam->subject->name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Total Question')</th>
                                <td>{{$exam->questions->count()}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Total Mark')</th>
                                <td>{{$exam->totalmark}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark')</th>
                                <td>{{($exam->totalmark*$exam->pass_percentage)/100}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark Percentage')</th>
                                <td>{{$exam->pass_percentage}}%</td>
                            </tr>
                            <tr>
                                <th>@lang('Your Mark')</th>
                                <td>{{$result->result_mark}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Total Correct Answer')</th>
                                <td>{{$result->total_correct_ans}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Total Wrong Answer')</th>
                                <td>{{$result->total_wrong_ans}}</td>
                            </tr>
                          
                            <tr>
                                <th>@lang('Status')</th>
                                @if ($result->result_status == 1)
                                <td><span class="text--success font-weight-bold">@lang('PASSED')</span></td>
                                @else
                                <td><span class="text--danger font-weight-bold">@lang('FAILED')</span></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    
    <script>
        'use strict'
        var count = 0; 
        window.onload = function () { 
            if (typeof history.pushState === "function") { 
                history.pushState("back", null, null);          
                window.onpopstate = function () { 
                    history.pushState('back', null, null);              
                    if(count == 0){
                        window.location = "{{route('user.exam.list')}}";
                    }
                 }; 
             }
         }  
        setTimeout(function(){count = 0;},200);
    </script>

@endpush