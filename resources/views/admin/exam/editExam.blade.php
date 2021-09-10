@extends('admin.layouts.app')

@section('panel')
<div class="container-fluid">
    
    <form action="{{route('admin.exam.update',$exam->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card b-radius--10 ">
            <div class="card-body">
                <div class="row p-3">
                    <div class="col-lg-6">
                       <div class="form-group">
                           <label class="font-weight-bold">@lang('Select Subject') <span class="text-danger">*</span></label>
                           <select  class="form-control" name="subject_id" required>
                               @foreach ($subjects as $subject)
                               <option value="{{$subject->id}}" {{$exam->subject_id==$subject->id?'selected':''}}>{{$subject->name}}</option>
                               @endforeach
                           </select>
                       </div>
                       <div class="form-group">
                           <label class="font-weight-bold">@lang('Title') <span class="text-danger">*</span></label>
                           <input  class="form-control" placeholder="@lang('Exam Title')" type="text" name="title" required value="{{$exam->title}}">
                       </div>

                       <div class="form-group">
                            <label class="font-weight-bold">@lang('Instruction') <span class="text-danger">*</span></label>
                            <textarea  class="form-control nicEdit" name="instruction" required>{{$exam->instruction}}</textarea>
                       </div>

                      <div class="form-group">
                        <label class="font-weight-bold">@lang('Question Type') <span class="text-danger">*</span></label>
                        <select  class="form-control" name="question_type" id="qtype" required>
                            <option value="1" {{$exam->question_type==1?'selected':''}}>@lang('MCQ')</option>
                            <option value="2" {{$exam->question_type==2?'selected':''}}>@lang('Written')</option>
                        </select>
                      </div>

                       <div class="form-group">
                           <label class="font-weight-bold">@lang('Total Mark') <span class="text-danger">*</span></label>
                           <input  class="form-control" placeholder="@lang('Exam Total Mark')" type="text" name="totalmark" required value="{{$exam->totalmark}}">
                       </div>

                       <div class="form-group">
                        <label class="font-weight-bold">@lang('Pass Mark Percentage') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input  class="form-control" placeholder="@lang('Pass Mark Percentage eg: 33%')" type="text" name="pass_percentage" required value="{{$exam->pass_percentage}}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="suffix">%</span>
                            </div>
                        </div>
                      </div>

                       <div class="form-group">
                           <label class="font-weight-bold">@lang('Time Duration (in minute)') <span class="text-danger">*</span></label>
                           <input  class="form-control" placeholder="@lang('Exam time duration in minute')" type="text" name="duration" required value="{{$exam->duration}}">
                       </div>
                       <div class="form-group">
                        <label  class="font-weight-bold">@lang('Payment Type') <span class="text-danger">*</span></label>
                        <select  class="form-control value" name="value" required>
                           
                            <option value="1" {{$exam->value==1?'selected':''}}>@lang('Paid')</option>
                            <option value="2" {{$exam->value==2?'selected':''}}>@lang('Unpaid')</option>
                          
                        </select>
                     </div>

                 
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Exam Fee') <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input  class="form-control exam_fee" placeholder="@lang('Exam Fee')" type="text" name="exam_fee" required value="{{getAmount($exam->exam_fee)}}">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="suffix">{{$general->cur_text}}</span>
                                </div>
                            </div>
                          </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Start date') <span class="text-danger">*</span></label>
                    
                            <input type="text" name="start_date" class="datepicker-here form-control" data-language='en' data-date-format="dd-mm-yyyy" data-position='top left' placeholder="@lang('Start Date')" required value="{{$exam->start_date}}">

                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('End Date') <span class="text-danger">*</span></label>
                            <input type="text" name="end_date" class="datepicker-here form-control" data-language='en' data-date-format="dd-mm-yyyy" data-position='top left' placeholder="@lang('End Date')" required value="{{$exam->end_date}}">

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage('assets/images/exam/'.$exam->image,'850x560') }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 850x560px') </small>
                                    </div>
                                </div>
                            </div>
                        </div>

            
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Negative Marking (optional)') <small class="warning text-danger"></small> </label>
                            <input type="checkbox" class="neg_status removeEl" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('ON')" data-off="@lang('OFF')" name="neg_status" @if ($exam->question_type == 2)
                                disabled
                            @endif
                            @if($exam->negative_marking==1)checked @endif>
                        </div>

                        
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Reduce Mark')</label>
                            <input class="form-control reduce" type="text" placeholder="@lang('Reduce Mark')" name="reduce_mark" @if($exam->negative_marking==0)disabled @endif value="{{$exam->reduce_mark??'0'}}" >
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Question Randomize (optional)') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('ON')" data-off="@lang('OFF')" name="randomize" @if($exam->random_question==1)checked @endif>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Question options suffle (optional)') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('ON')" data-off="@lang('OFF')" name="opt_suffle" @if($exam->option_suffle==1)checked @endif>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status" @if($exam->status==1)checked @endif>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer py-4">
                
                <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>

            </div>
        </div>
    </form>
</div>
   <!-- card end -->
    
@endsection

@push('script-lib')
<script src="{{asset('assets/admin/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/datepicker.en.js')}}"></script>
@endpush
              
@push('script')
    
    <script>
        
         (function ($) {
            'use strict'
             function options(data){
                if($(data).val()==1){
                 $('.exam_fee').removeAttr('disabled')
                } else if ($(data).val()==2){
                $('.exam_fee').attr('disabled',true)
                } else {
                 return false;
                }
              }

            $('.value').each(function() {
                options(this);
            
            })

            $('.value').on('change', function () {
                options(this);
            });

            $('.neg_status').on('change', function () {
                if($(".neg_status").is(':checked'))
                $(".reduce").removeAttr('disabled');  // checked
                else
                    $(".reduce").attr('disabled',true); 
            });

            
            $('#qtype').on('change',function () { 
                
                if($(this).val()==2){
                    $('.warning').text('Negative marking is disabled when question type is written')
                    $('.removeEl').attr('disabled',true)
                } else if ($(this).val()==1){
                    $('.warning').text('')
                    $('.removeEl').attr('disabled',false)
                } 
             })
            
         })(jQuery);



    </script>

@endpush
                      
@push('breadcrumb-plugins')
    <a class="btn btn--primary" href="{{route('admin.exam.all')}}"><i class="las la-backward"></i> @lang('Go Back')</a>
@endpush     