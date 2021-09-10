@php
    $content = getContent('popular.content',true);
    $subjects = \App\Subject::latest()->where('status',1)->where('is_popular',1)->with('category')->get();
@endphp

<section class="subject-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 text-center">
                <div class="section-header">
                    <h2 class="section-title">@lang($content->data_values->heading)</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach ($subjects as $sub)
                @if ($sub->category->status == 1)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="subject-item section--bg">
                            <div class="subject-content">
                                <h3 class="title">{{__($sub->name)}}</h3>
                                <p>{{shortDescription(trans($sub->short_details),80)}}</p>
                                <div class="subject-btn">
                                    <a data-toggle="tooltip" title="@lang($sub->short_details)" href="{{route('subject.exams',$sub->slug)}}" class="custom-btn">@lang('Exams') <i class="las la-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            
            @endforeach
           
        </div>
    </div>
</section>