@php
    $footer = getContent('footer.content',true)->data_values;
    $element = getContent('footer.element',false,'',true);
    $policies = getContent('policy.element',false,'',true)
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<footer class="footer-section pt-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 text-center">
                <div class="footer-widget widget-menu">
                    <div class="footer-logo mb-20">
                        <a href="{{url('/')}}" class="site-logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo"></a>
                    </div>
                    <p>{{__($footer->short_details)}}</p>
                    <div class="social-area">
                        <ul class="footer-social">
                            @foreach ($element as $el)
                              <li><a target="_blank" href="{{$el->data_values->link}}">@php
                                  echo $el->data_values->icon
                              @endphp</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="copyright-area d-flex flex-wrap align-items-center justify-content-between mb-10-none">
                        <div class="copyright mb-10">
                            <p>@lang('Copyright') © {{date('Y')}} @lang('All Rights reserved by') {{$general->sitename}}</p>
                        </div>
                        <ul class="copyright-list mb-10">
                            @foreach ($policies as $item)
                                <li><a href="{{route('links',[slug($item->data_values->title),$item->id])}}">{{__($item->data_values->title)}}</a></li>
                           
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->