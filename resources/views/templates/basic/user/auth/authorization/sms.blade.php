@extends($activeTemplate .'layouts.auth')
@section('content')

@php
    $bg = getContent('login.content',true);
@endphp

<section class="account-section section--bg bg-overlay-white bg_img" data-background="{{getImage('assets/images/frontend/login/'.$bg->data_values->background_image,'1920x1080')}}">
    <div class="container">
        <div class="row account-area align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="account-form-area">
                    <div class="account-logo-area text-center">
                        <div class="account-logo">
                            <a href="{{url('/')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo"></a>
                        </div>
                    </div>
                    <div class="account-header text-center">
                        <h2 class="title">@lang('SMS Veification')</h2>
                    </div>
                    <form class="account-form" action="{{route('user.verify_sms')}}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <p class="text-center text-white">@lang('Your Phone'):  <strong>{{auth()->user()->mobile}}</strong></p>
                        </div>

                         <div class="row ml-b-20">
                            <div class="col-lg-12 form-group">
                                <label>@lang('Verification Code') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="sms_verified_code" required>
                            </div>
                           
                            <div class="col-lg-12 form-group text-center">
                                <button type="submit" class="submit-btn">@lang('Verify Code')</button>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                    <div class="checkbox-item">
                                        <label>@lang('Didn\'t get code in your phone yet?') <a href="{{route('user.send_verify_code')}}?type=phone" class="forget-pass"> @lang('Resend code')</a></label>
                                    
                                    </div>
                                    @if ($errors->has('resend'))
                                        <small class="text-danger">{{ $errors->first('resend') }}</small>
                                    @endif
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
