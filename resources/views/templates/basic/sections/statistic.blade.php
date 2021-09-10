@php
    $content = getContent('statistic.content',true)->data_values;
    $elements = getContent('statistic.element',false,'',true);
@endphp
<section class="statistics-section ptb-80 bg-overlay-white bg_img" data-background="{{getImage('assets/images/frontend/statistic/'. @$content->background_image,'1920x450')}}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 text-center">
                <div class="section-header white">
                    <h2 class="section-title">{{__(@$content->heading)}}</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="statistics-area">
            <div class="row justify-content-center mb-30-none">
                @foreach ($elements as $el)
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-30">
                        <div class="statistics-item text-center">
                            <div class="statistics-icon">
                                @php
                                    echo $el->data_values->icon
                                @endphp
                            </div>
                            <div class="statistics-content">
                                <div class="odo-area">
                                    <h3 class="odo-title odometer" data-odometer-final="{{$el->data_values->count}}">0</h3>
                                    <h3 class="title">+</h3>
                                </div>
                            </div>
                            <p>{{__(@$el->data_values->title)}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>