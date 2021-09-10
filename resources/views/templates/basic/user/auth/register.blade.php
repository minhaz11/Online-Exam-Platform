@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content',true);
    $elements = getContent('policy.element',false,'',true)
@endphp

@section('content')
<section class="account-section section--bg bg-overlay-white bg_img pt-50 pb-30" data-background="{{getImage('assets/images/frontend/login/'.@$bg->data_values->background_image,'1920x1080')}}">
        <div class="container">
            <div class="row account-area align-items-center justify-content-center">
                <div class="col-lg-8">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a href="{{url('/')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="account-header text-center">
                            <h2 class="title">@lang('Register Your Account Now')</h2>
                            <h3 class="sub-title"> @lang('Already Have An Account') ? <a href="{{route('user.login')}}">@lang('Login Now')</a></h3>
                        </div>
                        <form class="account-form" method="POST" action="{{route('user.register')}}" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="col-lg-6 form-group">
                                    <label>@lang('First Name')</label>
                                    <input type="text" class="form-control form--control" name="firstname" value="{{old('firstname')}}" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Last Name')</label>
                                    <input type="text" class="form-control form--control" name="lastname" value="{{old('lastname')}}" required> 
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label>@lang('Username')</label>
                                    <input type="text" class="form-control form--control" name="username" value="{{old('username')}}" required>
                                </div>
    
                                    <div class="form-group col-lg-12 country-code">
                                        <label>@lang('Mobile')</label>
                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <select name="country_code">
                                                        @include('partials.country_code')
                                                    </select>
                                                </span>
                                            </div>
                                            <input type="text" name="mobile" class="form-control form--control" required>
                                        </div>
                                    </div>
    
    
                                <div class="form-group col-lg-12">
                                    <label>@lang('Country')</label>
                                    <input type="text" name="country" class="form-control form--control" required readonly>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label>@lang('Email')</label>
                                    <input type="email" class="form-control form--control" name="email" value="{{old('email')}}" required>
                                </div>
                              
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Password')</label>
                                    <input type="password" class="form-control form--control" name="password" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>@lang('Confirm Password')</label>
                                    <input type="password" class="form-control form--control" name="password_confirmation" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <div class="checkbox-wrapper d-flex flex-wrap align-items-center">
                                        <div class="checkbox-item">
                                            <input type="checkbox" id="c1" name="terms">
                                            <label for="c1">@lang('I have read agreed with the')
                                                 @foreach ($elements as $el)
                                                    <a href="{{route('links',[slug($el->data_values->title),$el->id])}}" class="mr-2">{{__($el->data_values->title)}}</a>
                                                @endforeach 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="submit-btn">@lang('Register Now')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
<style type="text/css">
    .country-code .input-group-prepend .input-group-text{
        background-color: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .country-code select{
        border: none;
        background-color: transparent;
        color: #fff;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
</style>
@endpush
@push('script')
    <script>
      "use strict";
       @if($country_code)
        var t = $(`option[data-code={{ $country_code }}]`).attr('selected','');
       @endif
        $('select[name=country_code]').on('change',function(){
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        }).change();
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
