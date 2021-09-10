@php
    $categories = \App\Category::where('status',1)->get();

@endphp

<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{url('/')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="site-logo"></a>
                        <div class="language-select-area d-block d-lg-none ml-auto">
                            <select class="language-select langSel">
                                @foreach($language as $item)
                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                 @endforeach
                            </select>
                        </div>

                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ml-auto mr-auto">
                               
                                @foreach($pages as $k => $data)
                                 <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                                @endforeach
                               <li class="menu_has_children"><a href="javascript:void(0)">@lang('Categories')</a>
                                    <ul class="sub-menu">
                                        @foreach ($categories as $cat)
                                         <li><a href="{{route('category.subjects',$cat->slug)}}">{{$cat->name}}</a></li>
                                        @endforeach

                                    </ul>
                                </li>
                                <li><a href="{{route("subjects")}}">@lang('Subjects')</a></li>
                                <li><a href="{{route("exams")}}">@lang('Exams')</a></li>
                                <li><a href="{{route("blog")}}">@lang('Blog')</a></li>
                                <li><a href="{{route('faq')}}">@lang('Faq')</a></li>
                                @guest
                                <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                                @endguest

                                @auth
                                <li><a href="{{route('ticket')}}">@lang('Support')</a></li>
                                @endauth

                             
                            </ul>
                            <div class="language-select-area d-none d-xl-block">
                                <select class="language-select langSel">
                                    @foreach($language as $item)
                                    <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                     @endforeach
                                </select>
                            </div>
                            <div class="header-action">
                                @guest
                                    <a href="{{route('user.register')}}" class="btn--base"><span>@lang('Register')</span></a>
                                    <a href="{{route('user.login')}}" class="btn--base active"><span>@lang('Login')</span></a>
                                @endguest
                                @auth
                                    <a href="{{route('user.home')}}" class="btn--base"><span>@lang('Dashboard')</span></a>
                                    <a href="{{route('user.logout')}}" class="btn--base active"><span>@lang('Logout')</span></a>
                                @endauth
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
