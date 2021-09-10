@php
    $content = getContent('faq.content',true)->data_values;
    $elements = getContent('faq.element',false,5,true);
@endphp

<section class="faq-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{__($content->heading)}}</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-6 mb-30">
                <div class="faq-thumb bg-overlay-white">
                    <img src="{{getImage('assets/images/frontend/faq/'.$content->background_image,'555x324')}}" alt="faq">
                    <div class="faq-video">
                        <a class="video-icon" data-rel="lightcase:myCollection" href="{{$content->video_link}}">
                            <i class="las la-play"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-30">
                <div class="faq-wrapper">
                    @foreach ($elements as $el)
                    <div class="faq-item">
                        <h3 class="faq-title"><span class="title">{{__( $el->data_values->question)}}</span><span
                                class="right-icon"></span></h3>
                        <div class="faq-content">
                            <p>@lang($el->data_values->answer)</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>