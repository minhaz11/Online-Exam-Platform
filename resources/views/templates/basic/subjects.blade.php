@extends($activeTemplate.'layouts.frontend')
@php
    $content = getContent('popular.content',true);
@endphp
@section('content')
@include($activeTemplate.'partials.breadcrumb')

<section class="subject-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            @forelse ($subjects as $sub)
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
            @empty
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                <div class="subject-item section--bg text-white">
                    @lang('No Subjects')
                </div>
            </div>
            @endforelse

        </div>
        <div class="mt-5">
            {{paginateLinks($subjects,'')}}
        </div>
    </div>
</section>
@include($activeTemplate.'sections.upcomming')
@include($activeTemplate.'sections.faq')
@endsection
