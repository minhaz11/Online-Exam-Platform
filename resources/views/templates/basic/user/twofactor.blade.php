@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="reset-area mt-30">
        <div class="panel-card-header bg--primary text-white">
           <div class="panel-card-title"><i class="las la-lock-open"></i> @lang('Two Factor')</div>
         </div>
               <div class="panel-body">
                   <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6">
                        @if(Auth::user()->ts)
                            <div class="card border--base">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mx-auto text-center">
                                        <a href="#0"  class="btn-block btn--danger border--rounded text-white p-2" data-toggle="modal" data-target="#disableModal">
                                            @lang('Disable Two Factor Authenticator')</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card border--base">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="key" value="{{$secret}}" class="form-control form-control-lg" id="referralURL" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text copytext" id="copyBoard" onclick="myFunction()"> <i class="fa fa-copy"></i> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mx-auto text-center">
                                        <img class="mx-auto" src="{{$qrCodeUrl}}">
                                    </div>
                                    <div class="form-group mx-auto text-center">
                                        <a href="#0" class="btn-block btn--primary border--rounded text-white p-2" data-toggle="modal" data-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
        
                    <div class="col-lg-6 col-md-6">
                        <div class="card border--base">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Google Authenticator')</h5>
                            </div>
                            <div class=" card-body">
                                <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                                <a class="btn--primary border--rounded border--primary text-white p-2" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                            </div>
                        </div><!-- //. single service item -->
                    </div>
                   </div>
               </div>
           </div>


    <!--Enable Modal -->
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="border--rounded text-white p-2 btn--danger" data-dismiss="modal">@lang('close')</button>
                        <button type="submit" class="border--rounded text-white p-2 btn--primary">@lang('verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp Disable')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-success">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush


@push('style')
    
<style>
    #copyBoard{
        cursor: pointer;
    }
</style>
@endpush