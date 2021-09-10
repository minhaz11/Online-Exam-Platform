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
                                    <th>@lang('Status')</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($histories as $history)
                                    <tr>
                                        <td data-label="@lang('Title')">{{$history->exam->title}}</td>
                                        <td data-label="@lang('Category')">{{$history->exam->subject->category->name}}</td>
                                        <td data-label="@lang('Subject')">{{$history->exam->subject->name}}</td>
                                        <td data-label="@lang('Subject')">
                                            @if ($history->result_status == 1)
                                                <span class="badge badge--success">@lang('PASSED')</span>
                                            @else
                                            <span class="badge badge--danger">@lang('FAILED')</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="12">@lang('No result available')</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                 {{paginateLinks($histories)}}
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
