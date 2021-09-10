@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Title')</th>
                                <th scope="col">@lang('Subject')</th>
                                <th scope="col">@lang('Exam type')</th>
                                <th scope="col">@lang('Pass Percentage')</th>
                                <th scope="col">@lang('Exam Fee')</th>
                                <th scope="col">@lang('More Info.')</th>
                                <th scope="col">@lang('Start Date')</th>
                                <th scope="col">@lang('End Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($exams as $exam)
                            <tr>
                                <td data-label="@lang('Title')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{getImage('assets/images/exam/'. $exam->image)}}" alt="image"></div>
                                        <span class="name" data-toggle="tooltip" title="{{$exam->title}}">{{shortDescription($exam->title,20)}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Subject')"><span class="text--small badge font-weight-normal badge--success">{{$exam->subject->name}}</span></td>
                                <td data-label="@lang('Exam type')"><span class="badge badge-pill {{$exam->question_type==1?'bg--primary':'bg--success'}} ">{{$exam->question_type==1?'MCQ':"Written"}}</span></td>
                                <td data-label="@lang('Pass Percentage')">{{$exam->pass_percentage}}%</td>
                                <td data-label="@lang('Exam Fee')">{{$exam->exam_fee  ?? 'Free'}} {{$exam->exam_fee? $general->cur_text:'' }}</td>
                                <td data-label="@lang('More Info.')"><button type="button" class="icon-btn btn--dark options" data-options="{{json_encode($exam)}}"><i class="las la-eye"></i> @lang('see')</button></td>
                                <td data-label="@lang('Start Date')">{{$exam->start_date}}</td>
                                <td data-label="@lang('End Date')">{{$exam->end_date}}</td>
                                <td data-label="@lang('Status')">
                                    @if($exam->status == 1)
                                        <span class="text--small badge font-weight-normal badge--success">@lang('active')</span>
                                    @else
                                       <span class="text--small badge font-weight-normal badge--warning">@lang('inactive')</span>
                                    @endif
                                </td>
                                <td data-label="Action">
                                    <a href="{{route('admin.exam.questions',$exam->id)}}" class="icon-btn btn--dark mr-2" data-toggle="tooltip" title="" data-original-title="Questions">
                                        @lang('Questions')
                                    </a>
                                    <a href="{{route('admin.exam.edit',$exam->id)}}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="edit">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
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
           <!-- option list Modal -->
    <div class="modal fade" id="optionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg--primary">
              <h5 class="modal-title text-white" id="exampleModalLabel">@lang('More Info.')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <ul class="list-group">
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
          </div>
        </div>
      </div>
@endsection
@push('breadcrumb-plugins')
    <!-- Button trigger modal -->
    <a  href="{{route('admin.exam.add')}}" class="btn btn--primary mr-2 mt-2">
       @lang('+ Add Exam')
    </a>
    <form action="{{route('admin.exam.all')}}" method="GET" class="form-inline float-sm-right bg--white mt-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Search by title')" value="" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
@push('script')
   <script>
       'use strict';
       $('.options').on('click',function () { 
            var val = $(this).data('options')
            $('#optionModal').find('.list-group').empty()
                var el = ` <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Duration')<span class="">${val.duration} @lang('minutes')
                </span></li>
                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Total Mark')<span class="">${val.totalmark}
                </span></li>
                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Attempt Count')<span class="">${val.attempt_count} @lang('times')
                </span></li>
                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Negative Marking')<span class="">${val.negative_marking==0?'No':'Yes'}
                </span></li>
                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Reduce Mark')<span class="">${val.reduce_mark??'N/A'}
                </span></li>
                `
                 $('#optionModal').find('.list-group').append(el)
            $('#optionModal').modal('show')          
        });
   </script>
@endpush