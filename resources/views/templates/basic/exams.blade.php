@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.breadcrumb')

<section class="exam-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-9 mb-30">
                <div class="exam-item-area">
                    <div class="row justify-content-center mb-30-none">
                        @forelse ($exams as $exam)
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-30">
                            <div class="exam-item">
                                <div class="exam-thumb">
                                   <a href="{{route('exam.details',$exam->id)}}" class="d-block">
                                    <img src="{{getImage('assets/images/exam/thumb_'.$exam->image,'400x250')}}" alt="exam">
                                   </a>
                                </div>
                                <div class="exam-content">
                                    <h3 class="title"><a href="{{route('exam.details',$exam->id)}}">{{$exam->title}}</a></h3>
                                    <ul class="exam-list">
                                        <li>@lang('Subject') : {{$exam->subject->name}}</li>
                                        <li>@lang('Type') : {{$exam->question_type==1? trans('MCQ') :trans('Written')}}</li>
                                        <li class="">@lang('Exam fee') : {{$exam->exam_fee!=null ? getAmount($exam->exam_fee).' '.$general->cur_text:trans('Free')}}</li>
                                    </ul>
                                    <div class="exam-btn mt-10">
                                        <a href="{{route('exam.details',$exam->id)}}" class="custom-btn">@lang('Exam Details') <i class="las la-angle-double-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <h2> @lang('No Exams')</h2>
                        </div>
                        @endforelse
                    </div>
                    <nav class="d-flex justify-content-center mt-3">
                        {{paginateLinks($exams,'')}}
                    </nav>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="sidebar">
                    <div class="widget-box mb-30">
                        <h5 class="widget-title">@lang('All Categories')</h5>
                        <ul class="category-content">
                            @foreach ($categories as $item)
                             <li><a href="{{route('category.subjects',$item->slug)}}">{{$item->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget-box">
                        <h5 class="widget-title">@lang('All Subject')</h5>
                        <ul class="category-content">
                            @foreach ($subjects as $sub)
                              <li><a href="{{route('subject.exams',$sub->slug)}}">{{$sub->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
