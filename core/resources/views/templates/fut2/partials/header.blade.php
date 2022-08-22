<div class="header-top d-none d-md-block">
    <div class="container">
        <div class="header-top-wrapper">
            <ul class="header-contact-info">
                <li>
                    <a href="Mailto:{{@$headerFooterContent->data_values->email}}"><i class="las la-envelope"></i> {{@$headerFooterContent->data_values->email}}</a>
                </li>
                <li>
                    <a href="Tel:{{@$headerFooterContent->data_values->contact_no}}"><i class="las la-phone"></i> {{__(@$headerFooterContent->data_values->contact_no)}}</a>
                </li>
            </ul>

            @auth
                <div class="right-area d-none d-md-block">
                    <a href="{{route('user.home')}}" class="cmn--btn btn--sm mr-3">@lang('Dashboard')</a>
                </div>
            @else
                <div class="right-area d-none d-md-block">
                    <a href="{{route('user.register')}}" class="cmn--btn btn--sm">@lang('Register Now')</a>
                    <a href="{{route('user.login')}}">
                        <i class="las la-user"></i>
                        <span>@lang('Login Now')</span>
                    </a>
                </div>
            @endguest
        </div>
    </div>
</div>
<div class="header-bottom bg--section">
    <div class="container">
        <div class="header__wrapper">
            <div class="logo">
                <a href="{{route('home')}}">
                    <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="header-bar ms-auto d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="menu-area align-items-center ">
                <div class="d-lg-none cross--btn">
                    <i class="las la-times"></i>
                </div>
                <div class="right-area d-md-none text-center mb-4">
                    @auth
                        <a href="{{route('user.home')}}" class="cmn--btn btn--sm mr-3">@lang('Dashboard')</a>
                    @else
                        <a href="{{route('user.register')}}" class="cmn--btn btn--sm mr-3">@lang('Register')</a>
                        <a href="{{route('user.login')}}" class="text--white">
                            <i class="las la-user"></i>
                            <span>@lang('Login Now')</span>
                        </a>
                    @endauth
                    <ul class="header-contact-info">
                        <li>
                            <a href="Mailto:{{@$headerFooterContent->data_values->email}}" class="d-block"><i class="las la-envelope"></i> {{@$headerFooterContent->data_values->email}}</a>
                        </li>
                        <li>
                            <a href="Tel:{{@$headerFooterContent->data_values->contact_no}}" class="d-block"><i class="las la-phone"></i> {{__(@$headerFooterContent->data_values->contact_no)}}</a>
                        </li>
                    </ul>
                </div>
                <ul class="menu">
                    <li><a href="{{route('home')}}">@lang('Home')</a></li>
                    <li><a href="{{route('blogs')}}">@lang('Blog')</a></li>
                    @foreach($pages as $k => $data)
                        <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                    @endforeach
                    <li><a href="{{route('contact')}}"> @lang('Contact')</a></li>

                    @auth
                        <li>
                            <a href="javascript:void(0)" class="dashboard--thumb-img">
                                @if (auth()->user()->image)
                                    <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}" alt="image">
                                @else
                                    <img src="{{ asset('assets/images/avatar.png') }}" alt="user">
                                @endif
                            </a>
                            <ul class="submenu">
                                <li><a href="{{route('user.home')}}">@lang('Dashboard')</a></li>
                                <li><a href="{{route('user.bet.index', 'all')}}">@lang('My Bets')</a></li>
                                <li><a href="{{route('user.profile.setting')}}">@lang('Profile Setting')</a></li>
                                <li><a href="{{route('user.change.password')}}">@lang('Change Password')</a></li>
                                <li><a href="{{route('user.twofactor')}}">@lang('2FA Security')</a></li>
                                <li><a href="{{route('ticket')}}">@lang('Support Ticket')</a></li>
                                <li><a href="{{route('user.deposit.history')}}">@lang('Deposit History')</a></li>
                                <li><a href="{{route('user.withdraw.history')}}">@lang('Withdrawal History')</a></li>
                                <li><a href="{{route('user.transactions')}}">@lang('Transactions')</a></li>
                                <li><a href="{{route('user.referral.commissions.deposit')}}">@lang('Referral')</a></li>
                                <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>

            <div class="open--sidebar d-xl-none ms-3">
                <i class="las la-braille"></i>
            </div>
        </div>
    </div>
</div>
