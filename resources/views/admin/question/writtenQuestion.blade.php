@extends('admin.layouts.app')

@section('panel')
<div class="container-fluid">
    
    <form action="{{route('admin.exam.written.store',$exam->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row justify-content-center">
                   
            <div class="col-md-8">
               
                <div class="card b-radius--10 p-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Question') <span class="text-danger">*</span> </label>
                            <textarea  class="form-control nicEdit" name="question" rows="6"></textarea>
                        </div>
        
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Answer')</label>
                            <textarea  class="form-control nicEdit" name="answer" rows="6"></textarea>
                        </div>
        
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Mark') <span class="text-danger">*</span> </label>
                            <input  class="form-control" name="mark" placeholder="@lang('Mark')">
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

        
    </form>
</div>
   <!-- card end -->
    
@endsection
              
                      
@push('breadcrumb-plugins')
    <a class="btn btn--primary" href="{{route('admin.exam.questions',$exam->id)}}"><i class="las la-backward"></i> @lang('Go Back')</a>
@endpush     
                    