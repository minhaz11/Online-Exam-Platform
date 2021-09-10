@php
    $content = getContent('blog.content',true)->data_values;
    $elements = getContent('blog.element',false,3,true);
@endphp

<section class="blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{__($content->heading)}}</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach ($elements as $el)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{getImage('assets/images/frontend/blog/thumb_'.$el->data_values->cover_image,'360x250')}}" alt="blog">
                        </div>
                        <div class="blog-content d-flex flex-wrap align-items-center">
                            <span class="blog-date">
                                <div class="date-icon">
                                    <i class="las la-calendar"></i>
                                </div>
                                <div class="date-content">
                                    {{showDateTime($el->created_at,'d M')}}
                                </div>
                            </span>
                            <div class="blog-content-details">
                                <h3 class="title"><a href="{{route('blog.details',[$el->id,slug($el->data_values->title)])}}">{{__(shortDescription($el->data_values->title,40))}}</a>
                                </h3>
                                <div class="blog-btn">
                                    <a href="{{route('blog.details',[$el->id,slug($el->data_values->title)])}}" class="custom-btn">@lang('Read More') <i class="las la-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
           
        </div>
    </div>
</section>