@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content',true);
@endphp

@section('content')
<section class="account-section section--bg bg-overlay-white bg_img" data-background="{{getImage('assets/images/frontend/login/'.@$bg->data_values->background_image,'1920x1080')}}">
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
                            <h2 class="title">@lang('Login Your Account Now')</h2>
                            <h3 class="sub-title"> @lang('Don\'t Have An Account') ? <a href="{{route('user.register')}}">@lang('Register Now')</a></h3>
                        </div>
                        <form class="account-form" action="{{route('user.login')}}" method="POST" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Username') <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form--control" name="username" required value="{{old('username')}}">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>@lang('Password') <span>*</span></label>
                                    <input type="password" class="form-control form--control" name="password" required>
                                </div>

                                @include($activeTemplate.'partials.custom-captcha')
                                <div class="form-group col-lg-12">
                                  @php echo recaptcha() @endphp
                                </div>

                                <div class="col-lg-12 form-group">
                                    <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                        <div class="checkbox-item">
                                            <label><a href="{{route('user.password.request')}}"> @lang('Forgot Password') ?</a></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="submit-btn">@lang('Login Now')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
