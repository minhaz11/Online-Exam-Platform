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
                        <h2 class="title">@lang('2FA verification')</h2>
                    </div>
                    <form class="account-form" action="{{route('user.go2fa.verify')}}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <p class="text-center text-white">@lang('Current Time'):  <strong>{{\Carbon\Carbon::now()}}</strong></p>
                        </div>

                         <div class="row ml-b-20">
                            <div class="col-lg-12 form-group">
                                <label>@lang('Verification Code') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="code" required>
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
