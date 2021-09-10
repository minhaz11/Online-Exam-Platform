@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="blog-details-section blog-section ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-9 mb-30">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img
                                src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->cover_image,'800x800') }}"
                                alt="blog">
                        </div>
                        <div class="blog-content d-flex flex-wrap align-items-center">
                        <span class="blog-date mb-20">
                            <div class="date-icon">
                                <i class="las la-calendar"></i>
                            </div>
                            <div class="date-content">
								{{showDateTime($blog->created_at,'d M')}}
                            </div>
                        </span>
                            <div class="blog-content-details mb-20">
                                <h3 class="title">{{__($blog->data_values->title)}}</h3>
                            </div>
                            <div class="">
                                @php echo $blog->data_values->body @endphp
                            </div>
                        </div>
                    </div>
                    <div class="blog-social-area d-flex flex-wrap justify-content-between align-items-center">
                        <h3 class="title">@lang('Share This Post')</h3>
                        <ul class="blog-social">
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"
                                   target="_blank"><i class="fab fa-facebook"></i></a></li>
                            <li>

                            <li>
                                <a href="https://twitter.com/intent/tweet?text=Post and Share &amp;url={{urlencode(url()->current()) }}"
                                   target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}"
                                   target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                    <div class="fb-comments mt-3"
                         data-href="{{ route('blog.details',[$blog->id , slug($blog->data_values->title)]) }}"
                         data-numposts="5" data-width="850"></div>
                </div>
                <div class="col-xl-3 mb-30">
                    <div class="sidebar">
                        <div class="widget-box mb-30">
                            <h5 class="widget-title">@lang('Recent Posts')</h5>
                            <div class="popular-widget-box">
                                @foreach ($recentblog as $rb)
                                    @if ($rb->id != $blog->id)

                                        <div class="single-popular-item d-flex flex-wrap align-items-center">
                                            <div class="popular-item-thumb">
                                                <img
                                                    src="{{ getImage('assets/images/frontend/blog/thumb_'.$rb->data_values->cover_image,'360x250') }}"
                                                    alt="blog">
                                            </div>
                                            <div class="popular-item-content">
                                                <a href="{{ route('blog.details',[$rb->id , slug($rb->data_values->title)]) }}"
                                                   class="title">{{Str::limit($rb->data_values->title,20)}}</a>
                                                <span class="blog-date">{{showDateTime($rb->created_at,'d M Y')}}</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

