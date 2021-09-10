@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="deposit-area mt-30">
        <div class="panel-card-header bg--primary text-white">
            <div class="panel-card-title d-flex justify-content-between">
                <h5 class="mt-2 text-white">@lang($page_title)</h5>
                <a href="{{route('ticket') }}" class="btn--dark border--rounded text-white p-2">
                    @lang('My Support Ticket')
                </a>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="row justify-content-center mb-30-none">   
               
                <div class="col-md-12">
                    <div class="card">
                      
                        <div class="card-body">
                            <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">@lang('Name')</label>
                                        <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control form-control-lg" placeholder="@lang('Enter Name')" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">@lang('Email address')</label>
                                        <input type="email"  name="email" value="{{@$user->email}}" class="form-control form-control-lg" placeholder="@lang('Enter your Email')" required>
                                    </div>
    
                                    <div class="form-group col-md-12">
                                        <label for="website">@lang('Subject')</label>
                                        <input type="text" name="subject" value="{{old('subject')}}" class="form-control form-control-lg" placeholder="@lang('Subject')" >
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="inputMessage">@lang('Message')</label>
                                        <textarea name="message" id="inputMessage" rows="6" class="form-control form-control-lg">{{old('message')}}</textarea>
                                    </div>
                                </div>
    
                                <div class="row form-group ">
                                    <div class="col-sm-9 file-upload">
                                        <label for="inputAttachments">@lang('Attachments')</label>
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control mb-2" />
                                        <div id="fileUploadsContainer"></div>
                                        <p class="ticket-attachments-message text-muted">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </div>
    
                                    <div class="col-sm-1">
                                        <label for="">&nbsp;</label>
                                        <button type="button" class="btn--success border--rounded text-white p-2" onclick="extraTicketAttachment()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
    
                                <div class="row form-group justify-content-center">
                                    <div class="col-md-12">
                                        <button class="btn--success border--rounded text-white p-2" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                        <button class="btn--danger border--rounded text-white p-2" type="button" onclick="formReset()">&nbsp;@lang('Cancel')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        function extraTicketAttachment() {
            $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control my-3" required />')
        }
        function formReset() {
            window.location.href = "{{url()->current()}}"
        }
    </script>
@endpush

@push('style')
    
<style>
    .form-control{
        line-height: 1.2!important
    }
</style>

@endpush