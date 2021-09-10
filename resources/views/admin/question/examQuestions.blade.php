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
                                <th scope="col">@lang('Exam')</th>
                                <th scope="col">@lang('Type')</th>
                                <th scope="col">@lang('Ques. & Ans')</th>
                                <th scope="col">@lang('Mark')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($qstns as $qtn)
                          
                            <tr>
                                <td data-label="@lang('Exam')">
                                    <div class="user">
                                        <div class="thumb"><img src="{{getImage('assets/images/exam/'. $qtn->exam->image)}}" alt="image"></div>
                                        <span class="name">{{$qtn->exam->title}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Exam type')"><span class="badge badge-pill {{$qtn->exam->question_type==1?'bg--primary':'bg--success'}} ">{{$qtn->exam->question_type==1?'MCQ':"Written"}}</span></td>

                                @if ($exam->question_type==1)

                                <td data-label="@lang('Options')"><button type="button" class="icon-btn  btn--dark options" data-options="{{$qtn->options}}" data-qtn="{{$qtn->question}}"><i class="las la-eye"></i> @lang('see')</button></td>
                                @else
                                
                                <td data-label="@lang('Answer')"><button type="button" class="icon-btn  btn--dark ans" data-ans="{{$qtn->written_ans}}" data-qtn="{{$qtn->question}}"><i class="las la-eye"></i> @lang('see')</button></td>
                                @endif
                              
                                <td data-label="@lang('Mark')"><span class="text--small badge font-weight-normal badge--success">{{$qtn->marks}}</span></td>
                           
                                <td data-label="@lang('Action')">
                                    @if ($exam->question_type==1)
                                    <a href="{{route('admin.exam.edit.mcq',$qtn->id)}}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="edit">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                    @else
                                    <a href="{{route('admin.exam.written.edit',$qtn->id)}}" class="icon-btn edit" data-toggle="tooltip" title="" data-original-title="edit">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                    @endif

                                    <a href="javascript:void(0)" data-route="{{route('admin.question.remove',$qtn->id)}}" class="icon-btn btn--danger ml-2 delete" data-toggle="tooltip" title="" data-original-title="remove">
                                      <i class="las la-trash-alt text--shadow"></i>
                                    
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{paginateLinks($qstns)}}
                </div>
            </div><!-- card end -->
        </div>


    
    <!-- option list Modal -->
    <div class="modal fade" id="optionModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg--primary">
            <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Question and Answer')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="qtn mb-3 font-weight-bold"></div>
            <ul class="list-group">
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Answer Modal -->
    <div class="modal fade" id="ansModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg--primary">
            <h5 class="modal-title text-white" id="exampleModalLabel">@lang('Question and Answer')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <div class="qtn mb-3 font-weight-bold"></div>
           <p class="answer border p-3"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
         <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
              <form action="" method="POST">
                  @csrf
                  <div class="modal-body text-center">
                      
                      <i class="las la-exclamation-circle text-danger display-2 mb-15"></i>
                      <h4 class="text--secondary mb-15">@lang('Are You Sure Want to Delete This?')</h4>

                  </div>
              <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                <button type="submit"  class="btn btn-danger del">@lang('Delete')</button>
              </div>
              
              </form>
        </div>
      </div>
  </div>

@endsection

@push('breadcrumb-plugins')
    

   @if ($exam->question_type==1)

   <a  href="{{route('admin.exam.add.mcq',$exam->id)}}" class=" btn btn--primary mr-2 mt-2" >
    <i class="las la-plus"></i> @lang('Add Question')
   </a>
   @else
  
   <a  href="{{route('admin.exam.question.written',$exam->id)}}" class="btn btn--primary mr-2 mt-2">
      <i class="las la-plus"></i> @lang('Add Question')
   </a>
       
   @endif

    <a  href="{{route('admin.exam.all')}}" class="adM btn btn--primary mt-2">
     <i class="las la-list"></i>  @lang('Exam List')
    </a>

    
@endpush


@push('script')
    <script>
        'use strict';
        $('.options').on('click',function () { 
            var options = $(this).data('options')
            var qtn = $(this).data('qtn')
            $('#optionModal').find('.list-group').empty()
            $('#optionModal').find('.qtn').empty()
            $.each(options, function (i, val) { 
                var cls = val.correct_ans == 1 ? 'btn--success':'btn--danger'
                var ans = val.correct_ans == 1 ? 'las la-check-circle':'las la-times-circle'
              
                var el = ` <li class="list-group-item d-flex justify-content-between font-weight-bold">${val.option} <span class="icon-btn ${cls}"><i class="${ans}"></i></span></li>`

                 $('#optionModal').find('.list-group').append(el)
            });  
            $('#optionModal').find('.qtn').append($.parseHTML(qtn))
            $('#optionModal').modal('show')          
        });
        $('.ans').on('click',function () { 
            var ans = $(this).data('ans')
            var qtn = $(this).data('qtn')

            $('#ansModal').find('.qtn').html( qtn)
            $('#ansModal').find('.answer').html(ans)

            $('#ansModal').modal('show')          
        });

      $('.delete').on('click',function(){
        var route = $(this).data('route')
        var modal = $('#deleteModal');
        modal.find('form').attr('action',route)
        modal.modal('show');


      })
    

    </script>

@endpush

@push('style')
    
    <style>
      .answer{
        text-align: justify
      }
    </style>

@endpush
