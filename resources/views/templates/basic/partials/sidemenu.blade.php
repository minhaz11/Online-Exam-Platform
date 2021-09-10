<div class="sidebar-menu">
    <div class="sidebar-menu-inner">
        <div class="logo-env">
            <div class="logo">
                <a href="{{url('/')}}">
                    <img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" width="120" alt="logo">
                </a>
            </div>
            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon">
                    <i class="las la-bars"></i>
                </a>
            </div>
            <div class="sidebar-mobile-menu">
                <a href="#" class="with-animation">
                    <i class="las la-bars"></i>
                </a>
            </div>
        </div>
        <ul id="sidebar-main-menu" class="sidebar-main-menu">
            <li class="sidebar-single-menu nav-item {{menuActive('user.home')}}">
                <a href="{{route('user.home')}}">
                    <i class="fas fa-home"></i>
                    <span class="title">@lang('Dashboard')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.exam.list')}}">
                <a href="{{route('user.exam.list')}}">
                    <i class="las la-list"></i>
                    <span class="title">@lang('Exam List')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.exam.mcq.history')}}">
                <a href="{{route('user.exam.mcq.history')}}">
                    <i class="fas fa-tasks"></i>
                    <span class="title">@lang('MCQ Exam History')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.exam.written.history')}}">
                <a href="{{route('user.exam.written.history')}}">
                    <i class="fas fa-pen-fancy"></i>
                    <span class="title">@lang('Written Exam History')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.deposit')}}">
                <a href="{{route('user.deposit')}}">
                    <i class="las la-wallet"></i>
                    <span class="title">@lang('Deposit')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.deposit.history')}}">
                <a href="{{route('user.deposit.history')}}">
                    <i class="las la-history"></i>
                    <span class="title">@lang('Deposit History')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.trx.history')}}">
                <a href="{{route('user.trx.history')}}">
                    <i class="las la-history"></i>
                    <span class="title">@lang('Transaction History')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.profile-setting')}}">
                <a href="{{route('user.profile-setting')}}">
                    <i class="las la-user-circle"></i>
                    <span class="title">@lang('Profile Setting')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.change-password')}}">
                <a href="{{route('user.change-password')}}">
                    <i class="las la-key"></i>
                    <span class="title">@lang('Change Password')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.twofactor')}}">
                <a href="{{route('user.twofactor')}}">
                    <i class="las la-lock-open"></i>
                    <span class="title">@lang('2FA Security')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive(['ticket','ticket.open','ticket.view'])}}">
                <a href="{{route('ticket')}}">
                    <i class="fas fa-ticket-alt"></i>
                    <span class="title">@lang('Support Ticket')</span>
                </a>
            </li>
            <li class="sidebar-single-menu nav-item {{menuActive('user.logout')}}">
                <a href="{{route('user.logout')}}">
                    <i class="las la-sign-out-alt"></i>
                    <span class="title">@lang('Logout')</span>
                </a>
            </li>
        </ul>
    </div>
</div>