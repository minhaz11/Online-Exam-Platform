@php
    $content = getContent('testimonial.content',true)->data_values;
    $element = getContent('testimonial.element',false,'',true);
@endphp

<section class="client-section ptb-80 section--bg bg-overlay-white bg_img" data-background="{{getImage('assets/images/frontend/testimonial/'.@$content->background_image,'1920x1080')}}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section-header white">
                    <h2 class="section-title">{{__($content->heading)}}</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="client-slider">
                    <div class="swiper-wrapper">
                        @foreach ($element as $el)
                        <div class="swiper-slide">
                            <div class="client-item">
                                <div class="client-content text-center">
                                    <div class="client-quote-icon">
                                        <i class="las la-quote-left"></i>
                                    </div>
                                    <p>{{__($el->data_values->quote)}}</p>
                                    <div class="client-ratings">
                                        <i class="las la-star text--base"></i>
                                        <i class="las la-star text--base"></i>
                                        <i class="las la-star text--base"></i>
                                        <i class="las la-star text--base"></i>
                                        <i class="las la-star text--base"></i>
                                    </div>
                                </div>
                                <div class="client-thumb-area">
                                    <div class="client-thumb">
                                        <img src="{{getImage('assets/images/frontend/testimonial/'.$el->data_values->author_image,'70x70')}}" alt="client">
                                    </div>
                                    <div class="client-thumb-content">
                                        <h3 class="title">{{$el->data_values->author_name}}</h3>
                                        <span class="sub-title">{{__($el->data_values->author_designation)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                       
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>