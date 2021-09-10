<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('partials.seo')
    <title>{{ $general->sitename(__($page_title)) }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Josefin+Sans:400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- odometer css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/odometer.css')}}">
    <!-- lightcase css links -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <link href="{{ asset('assets/templates/basic/css/color.php') }}?color={{$general->base_color}}&color2={{$general->secondary_color}}"rel="stylesheet" />

    @stack('style-lib')

    @stack('style')
</head>
<body>
    @php echo fbcomment() @endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="preloader">
    <div class="loader book">
        <figure class="page"></figure>
        <figure class="page"></figure>
        <figure class="page"></figure>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include($activeTemplate.'partials.header')

@yield('content')
<a href="#0" class="scrollToTop"><i class="las la-angle-double-up"></i></a>
@include($activeTemplate.'partials.footer')

<!-- jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.6.0.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<!-- swipper js -->
<script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
<!-- viewport js -->
<script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>
<!-- odometer js -->
<script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
<!-- lightcase js-->
<script src="{{asset($activeTemplateTrue.'js/lightcase.js')}}"></script>
<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
<!-- main -->

<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>
@stack('script-lib')

@stack('script')

@include('partials.plugins')

@include('admin.partials.notify')



<script>
    (function ($) {
        "use strict";
        $(document).on("change", ".langSel", function() {
            window.location.href = "{{url('/')}}/change/"+$(this).val() ;
        });
    })(jQuery);
</script>

</body>
</html>
