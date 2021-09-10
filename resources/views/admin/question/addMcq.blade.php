@extends('admin.layouts.app')

@section('panel')
<div class="container-fluid">
    
    <form action="{{route('admin.exam.question.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card b-radius--10 p-4">
                    <div class="card-body">
                            <input type="hidden" name="examid" value="{{$exam->id}}">
                              <div class="form-group">
                                  <label class="font-weight-bold">@lang('Question')</label>
                                  <textarea class="form-control nicEdit"  name="question" rows="6" placeholder="@lang('Question')">{{old('question')}}</textarea>
                              </div>
                              <div class="form-group">
                                  <label class="font-weight-bold">@lang('Mark')</label>
                                  <input class="form-control" type="text" name="mark" placeholder="@lang('Mark')" value="{{old('mark')}}" required>
                              </div>
            
                            <label class="font-weight-bold" for="exampleInputnumber1">@lang('Options')</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent" id="my-addon">
                                            <div class="custom-control custom-radio form-check-primary d-flex align-items-center">
                                                <input type="radio" id="customRadio21"  name="correct" class="custom-control-input mt-1" value="1" required>
                                                <label class="custom-control-label text-secondary" for="customRadio21">@lang('Correct')</label>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control mr-1" name="option[1]" placeholder="@lang('Option')" required>
                                 </div>
            
                            </div>
                            <div class="append"></div>
                           <div class="form-group text-right">
                            <button type="button" class="btn btn--success mt-2" id="add"> <i class="las la-plus"></i> @lang('Add more options')</button>
                           </div>
                     </div>
                    <div class="card-footer py-4">
                        
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
        
                    </div>
                </div>

            </div>
        </div>

        
    </form>
</div>
   <!-- card end -->
    
@endsection
              
                      
@push('breadcrumb-plugins')
    <a class="btn btn--primary" href="{{route('admin.exam.questions',$exam->id)}}"><i class="las la-backward"></i> @lang('Go Back')</a>
@endpush     
                    
@push('script')
    
<script>
    'use strict'
        var i = 22;
        var j = 2;
        $(document).on('click', '#add', function () {
        
        var element = `
            <div class="form-group d-flex justify-content-between">
                <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent" id="my-addon">
                                <div class="custom-control custom-radio form-check-primary d-flex align-items-center">
                                    <input type="radio" id="customRadio${i}" name="correct" class="custom-control-input" value="${j}" required>
                                    <label class="custom-control-label text-secondary" for="customRadio${i}">@lang('Correct')</label>
                                  </div>
                            </span>
                        </div>
                        <input type="text" class="form-control mr-1" name="option[${j}]" placeholder="@lang('Option')"  required>
                     </div>
                <button type="button" class="icon-btn btn--danger  text-center text-nowrap remove"><i class="las la-minus-circle"></i></button>
            </div>`;
           
        $('.append').append(element);
        i++
        j++
      })

      
      $(document).on('click', '.remove', function () {
        $(this).parent('.form-group').remove()
      })

      
</script>

@endpush