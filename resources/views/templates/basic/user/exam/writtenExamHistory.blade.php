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
                                            <input type="text" name="search" placeholder="@lang('Exam Title')" value="{{$search??''}}">
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
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Your Mark')</th>
                                    <th>@lang('Pass Mark')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                    <th>@lang('Certificate')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                @php
                                    $qCount = $exam->written->where('user_id',auth()->id())->count();
                                    $sCount = $exam->written->where('user_id',auth()->id())->where('status',1)->count();
                                    $passmark = $exam->passmark();
                                    $getMark = $exam->totalWrittenMark(auth()->id());
                                @endphp
                                <tr>
                                    <td data-label="@lang('Title')">{{$exam->title}}</td>
                                    <td data-label="@lang('Category')">{{$exam->subject->category->name}}</td>
                                    <td data-label="@lang('Subject')">{{$exam->subject->name}}</td>
                                    <td data-label="@lang('Your mark')">
                                      @if ($qCount == $sCount)
                                        {{$getMark}}
                                       @else 
                                        N/A
                                       @endif
                                    </td>

                                    <td data-label="@lang('Pass Mark')">{{$passmark}}</td>
                                    <td data-label="@lang('Status')">
                                       @if ($qCount > $sCount)
                                          <span class="badge badge--dark text-white">@lang('PENDING')</span>
                                       @else
                                           
                                        @if ($passmark < $getMark)
                                            <span class="badge badge--success text-white">@lang('PASSED')</span>
                                        @else
                                            <span class="badge badge--danger text-white">@lang('FAILED')</span>
                                        @endif
                                       @endif 
                                    </td>
                                    
                                    @if ($qCount > $sCount)
                                         <td>@lang('N/A')</td>
                                    @else
                                          <td data-label="@lang('Details')"><a class="icon-btn btn--dark" href="{{route('user.exam.written.details',$exam->id)}}">@lang('More info.')</a></td>
                                   
                                    @endif
                                   
                                    <td data-label="@lang('Certificate')">
                                        @if ($passmark < $getMark)
                                        <a target="_blank" href="{{route('user.exam.written.certificate',$exam->id)}}" class="btn--primary border--rounded text-white p-2">@lang('view')</a>
                                        @else
                                            @lang('N/A')
                                        @endif
                                    </td>
                                </tr>
                             
                                @empty
                                <tr>
                                    <td class="text-center" colspan="12">@lang('No result available')</td>
                                </tr>
                              @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{paginateLinks($exams,'')}}
                    </div>
          
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
