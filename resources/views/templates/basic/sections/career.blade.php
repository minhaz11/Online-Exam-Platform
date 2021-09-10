@php
    $content = getContent('career.content',true)->data_values;
    $elements = getContent('career.element',false,'',true);
@endphp

<section class="process-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 text-center">
                <div class="section-header">
                    <h2 class="section-title">@lang($content->heading)</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="process-area">
            @foreach ($elements as $el)
            <div class="process-item {{$loop->iteration % 2 == 0 ? 'right':'left'}}">
                    
                <div class="process-item-inner">
                    <div class="process-content">
                        <h3 class="title">{{__($el->data_values->title)}}</h3>
                        <p>{{__($el->data_values->short_details)}}</p>
                        
                    </div>
                </div>
            </div>
            @endforeach
           
        </div>
        <div class="process-area-inner"></div>
    </div>
</section>