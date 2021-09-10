@extends($activeTemplate.'layouts.frontend')

@section('content')
@include($activeTemplate.'partials.breadcrumb')

<section class="exam-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-10 mb-30">
                <div class="faq-wrapper">
                    @foreach ($faqs as $el)
                    <div class="faq-item">
                        <h3 class="faq-title"><span class="title">{{__( $el->data_values->question)}}</span>
                            <span class="right-icon"></span></h3>
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
@include($activeTemplate.'sections.blog')
@endsection