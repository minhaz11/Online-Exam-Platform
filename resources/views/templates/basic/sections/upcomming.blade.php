@php
    $content = getContent('upcomming.content',true)->data_values;
    $upcomming = \App\Exam::where('status',1)->where('start_date','>',\Carbon\Carbon::now()->toDateString())->latest()->inRandomOrder()->take(4)->get();

   
@endphp
@if($upcomming->count() > 3)
<section class="schedule-section bg--gray ptb-80">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-12">
                <div class="section-header-area d-flex flex-wrap align-items-start justify-content-between">
                    <div class="section-header left">
                        <h2 class="section-title">@lang($content->heading)</h2>
                        <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                    </div>
                    <div class="section-slider-area">
                        <div class="slider-prev">
                            <i class="las la-angle-left"></i>
                        </div>
                        <div class="slider-next">
                            <i class="las la-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="schedule-slider">
                    <div class="swiper-wrapper">
                        @foreach ($upcomming as $exam)
                        <div class="swiper-slide">
                            <div class="schedule-item d-flex flex-wrap align-items-center">
                                <div class="schedule-thumb">
                                    <img src="{{getImage('assets/images/exam/'.$exam->image,'200x150')}}" alt="schedule">
                                    <div class="schedule-badge">
                                        @if ($exam->value == 1)
                                            @lang('Paid')
                                        @else
                                            @lang('Free')
                                        @endif
                                   </div>
                                </div>
                                <div class="schedule-content">
                                    <h3 class="title"><a href="{{route('exam.details',$exam->id)}}">@lang($exam->title)</a></h3>
                                    <ul class="schedule-list">
                                        <li><i class="las la-calendar"></i>{{showDateTime($exam->start_date,'d M Y')}} - {{showDateTime($exam->end_date,'d M Y')}}</li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif