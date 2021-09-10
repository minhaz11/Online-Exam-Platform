
@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content',true);
@endphp

@section('content')
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
                        <h2 class="title">@lang('Reset Password')</h2>
                    </div>
                    <form class="account-form" action="{{route('user.password.verify-code')}}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="row ml-b-20">
                            <div class="col-lg-12 form-group">
                                <label>@lang('Verification Code') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="code" required value="{{old('code')}}">
                            </div>
                           
                            <div class="col-lg-12 form-group text-center">
                                <button type="submit" class="submit-btn">@lang('Verify Code')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

