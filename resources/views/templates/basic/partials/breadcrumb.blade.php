@php
    $breadcrumb = getContent('breadcrumb.content',true)->data_values;
@endphp

<section class="inner-banner-section banner-section bg-overlay-white bg_img" data-background="{{getImage('assets/images/frontend/breadcrumb/'.$breadcrumb->background_image,'1920x1280')}}">
    <div class="container">
        <div class="row align-items-center justify-content-center mb-30-none">
            <div class="col-xl-12 text-center mb-30">
                <div class="banner-content">
                    <h1 class="title text--base">{{__($page_title)}}</h1>
                    <div class="breadcrumb-area">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__($page_title)}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>