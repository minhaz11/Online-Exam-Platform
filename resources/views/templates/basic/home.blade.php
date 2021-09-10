@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
	$banner = @getContent('banner.content',true)->data_values;
@endphp
 <section class="banner-section bg-overlay-white bg_img" data-background="{{getImage('assets/images/frontend/banner/'.$banner->background_image,'1920x1080')}}">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-10 text-center mb-30">
                <div class="banner-content">
                    <h1 class="title text--base">{{__($banner->heading)}}</h1>
                    <h3 class="sub-title text-white">{{__($banner->sub_heading)}}</h3>
                    <div class="banner-btn">
                        <a href="{{url($banner->button_1_link)}}" class="btn--base">{{__($banner->button_1_text)}}</a>
                        <a href="{{url($banner->button_2_link)}}" class="btn--base active">{{__($banner->button_2_text)}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </section>
    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
