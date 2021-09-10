@extends($activeTemplate.'layouts.frontend')

@section('content')

@php
    $contact = getContent('contact.content',true)->data_values
@endphp
@include($activeTemplate.'partials.breadcrumb')

<section class="contact-section pt-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-lg-6 mb-30">
                <div class="contact-info-item-area mb-40-none">
                    <div class="contact-info-header mb-30">
                        <h3 class="header-title">{{__($contact->heading)}}</h3>
                        <p>{{__($contact->short_details)}}</p>
                    </div>
                    <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                        <div class="contact-info-icon">
                            <i class="fas fa fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-info-content">
                            <h3 class="title">@lang('Address')</h3>
                            <p>{{$contact->address}}</p>
                        </div>
                    </div>
                    <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                        <div class="contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info-content">
                            <h3 class="title">@lang('Email Address')</h3>
                            <p>{{$contact->email}}</p>
                        </div>
                    </div>
                    <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                        <div class="contact-info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-info-content">
                            <h3 class="title">@lang('Phone Number')</h3>
                            <p>{{$contact->phone}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-30">
                <div class="contact-form-area">
                    <h3 class="title">@lang('Drop Us a Line')</h3>
                    <form class="contact-form"  method="post" action="">
                        @csrf  
                        <div class="row justify-content-center mb-10-none">
                            <div class="col-lg-12 form-group">
                                <input name="name" type="text" placeholder="@lang('Your Name')" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-lg-12 form-group">
                                <input name="email" type="text" placeholder="@lang('Enter E-Mail Address')" class="form-control" value="{{old('email')}}" required>
                            </div>
                            <div class="col-lg-12 form-group">
                                <input name="subject" type="text" placeholder="@lang('Write your subject')" class="form-control" value="{{old('subject')}}" required>
                            </div>
                            <div class="col-lg-12 form-group">
                                <textarea name="message" wrap="off" placeholder="@lang('Write your message')" class="form-control">{{old('message')}}</textarea>
                            </div>
                            <div class="col-lg-12 form-group">
                                <button type="submit" class="submit-btn">@lang('Send Message')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Map
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="map-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="maps"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script-lib')
<script src="http://maps.google.com/maps/api/js?key={{$contact->map_api}}"></script>
<script src="{{asset($activeTemplateTrue.'/js/map.js')}}"></script>
@endpush

@push('script')
    
<script>
    'use strict';
        var lat = '{{$contact->latitude}}';
        var long = '{{$contact->longitude}}'
        var mapOptions = {
        center: new google.maps.LatLng(lat, long),
        zoom: 12,
        styles: styleArray,
        scrollwheel: true,
        backgroundColor: 'transparent',
        mapTypeControl: true,          
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
    mapOptions);        
  var myLatlng = new google.maps.LatLng(lat, long);
  var focusplace = {lat: lat , lng: long };      
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      
  })
</script>

@endpush