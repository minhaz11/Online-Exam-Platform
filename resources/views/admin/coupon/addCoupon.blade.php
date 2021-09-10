@extends('admin.layouts.app')

@section('panel')
<div class="container-fluid">
    
    <form action="{{route('admin.coupon.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card b-radius--10 p-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Coupon Name') <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" placeholder="@lang('Coupon Name')" name="name" required value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Short details') <span class="text-danger">*</span></label>
                            <textarea class="form-control" placeholder="@lang('Short Details')" name="details" required>{{old('details')}}</textarea>
                        </div>
           
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Select an Exam') <span class="text-danger">*</span></label>
                            <select name="exam_id" class="form-control" required id="exam_id">
                                <option value="">--@lang('Select Option')--</option>
                                <option value="0">@lang('For All Exam')</option>
                                @foreach ($exams as $exam)
                                <option value="{{$exam->id}}">{{$exam->title}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Amount Type') <span class="text-danger">*</span></label>
                            <select name="amount_type" class="form-control" required id="amount_type">
                                <option value="1">@lang('Percentage')</option>
                                <option value="2">@lang('Fixed')</option>
                            </select>
                        </div>
           
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Discount Amount') <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control" type="number" min="1" placeholder="@lang('Discount Amount')" name="coupon_amount" required value="{{old('coupon_amount')}}">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="suffix">%</span>
                                </div>
                            </div>
                        </div>

                      

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Minmum Order Amount (optional)')</label>
                            <div class="input-group">
                                <input class="form-control" type="number" min="0" placeholder="@lang('Minmum Order Amount (optional)')" name="min_order_amount" value="{{old('min_order_amount')}}">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="suffix">{{$general->cur_text}}</span>
                                </div>
                            </div>
                        </div>
           
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Coupon Code') <span class="text-danger">*</span></label>
                            <input class="form-control" type="text"  placeholder="@lang('Coupon Code')" name="coupon_code" required value="{{old('coupon_code')}}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Total Usage limit (optional)')</label>
                            <input class="form-control" type="number" min="0"  placeholder="@lang('Total Usage limit')" name="use_limit"  value="{{old('use_limit')}}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('User usage limit (optional)')</label>
                            <input class="form-control" type="number" min="0"  placeholder="@lang('User usage limit (optional)')" name="usage_per_user"  value="{{old('usage_per_user')}}">
                        </div>

                        

                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Start date') <span class="text-danger">*</span></label>
                    
                            <input type="text" name="start_date" class="datepicker-here form-control" data-language='en' data-date-format="yyyy-mm-dd" data-position='top left' placeholder="@lang('Start Date')" required value="{{old('start_date')}}">

                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('End date') <span class="text-danger">*</span></label>
                    
                            <input type="text" name="end_date" class="datepicker-here form-control" data-language='en' data-date-format="yyyy-mm-dd" data-position='top left' placeholder="@lang('End Date')" required value="{{old('end_date')}}">

                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Status') </label>
                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('active')" data-off="@lang('inactive')" name="status">
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
        
                    </div>
                </div>
            </div>

             </div>
         </div>

    </form>
</div>
   <!-- card end -->
    
@endsection
              
                      
@push('breadcrumb-plugins')
    <a class="btn btn--primary" href="{{route('admin.coupon.all')}}"><i class="las la-backward"></i> @lang('Go Back')</a>
@endpush     
                    


@push('script-lib')
<script src="{{asset('assets/admin/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/datepicker.en.js')}}"></script>
@endpush

@push('script')

<script>
    'use strict'
    $('.datepicker-here').datepicker();

    $('#amount_type').on('change',function(){
        
        var cur = "{{$general->cur_text}}"
        if($(this).val() == 1){
            $('#suffix').text('%')
        } else if($(this).val() == 2){
            $('#suffix').text(cur)
        }
    })

</script>

@endpush