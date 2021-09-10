@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr class="bg--primary">
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('User Mark')</th>
                                    <th>@lang('Pass Mark')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                @php
                                    $qCount = $exam->written->where('user_id',$userid)->count();
                                    $sCount = $exam->written->where('user_id',$userid)->where('status',1)->count();
                                    $passmark = $exam->passmark();
                                    $getMark = $exam->totalWrittenMark($userid);
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
                                          <span class="badge badge--warning">@lang('PENDING')</span>
                                       @else
                                           
                                        @if ($passmark < $getMark)
                                            <span class="badge badge--success">@lang('PASSED')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('FAILED')</span>
                                        @endif
                                       @endif 
                                    </td>
                                    
                                  
                                </tr>
                             
                                @empty
                                <tr>
                                    <td class="text-center" colspan="12">@lang('No results available')</td>
                                </tr>
                              @endforelse
                                
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                 {{paginateLinks($exams)}}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
<a class="btn btn--dark mr-2 mt-2" href="{{route('admin.users.detail',$userid)}}"> <i class="las la-backward"></i> @lang('Back') </a>
<form action="" method="GET" class="form-inline float-sm-right bg--white mt-2">
    <div class="input-group has_append">
        <input type="text" name="search" class="form-control" placeholder="@lang('exam title')" value="{{$search??''}}" autocomplete="off">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

@endpush
