<div class="body-header-area d-flex flex-wrap align-items-center justify-content-between mb-10-none">
    <div class="body-header-left">
        <h3 class="title">{{__($page_title)}}</h3>
    </div>
    <div class="body-header-right dropdown">
        <button type="button" class="" data-toggle="dropdown" data-display="static" aria-haspopup="true"
            aria-expanded="false">
            <div class="header-user-area d-flex flex-wrap align-items-center justify-content-between">
                <div class="header-user-content mr-4">
                    <span>@lang('Balance : '){{getAmount(auth()->user()->balance)}} {{$general->cur_text}}</span>
                </div>

                <div class="header-user-thumb">
                    <a href="#0"><img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}" alt="user"></a>
                </div>

                <div class="header-user-content">
                    <span>{{auth()->user()->username}}</span>
                </div>
                <span class="header-user-icon"><i class="las la-chevron-circle-down"></i></span>
            </div>
        </button>
        <div class="dropdown-menu dropdown-menu--sm p-0 border-0 dropdown-menu-right">
            <a href="{{route('user.change-password')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-key"></i>
                <span class="dropdown-menu__caption">@lang('Change Password')</span>
            </a>
            <a href="{{route('user.profile-setting')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-user-circle"></i>
                <span class="dropdown-menu__caption">@lang('Profile Settings')</span>
            </a>
            <a href="{{route('user.logout')}}" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                <span class="dropdown-menu__caption">@lang('Logout')</span>
            </a>
        </div>
    </div>
</div>
