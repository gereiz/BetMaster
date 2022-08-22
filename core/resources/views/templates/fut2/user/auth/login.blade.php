@extends($activeTemplate.'layouts.auth')

@section('content')
    @php
	    $authBackground = getContent('auth_page.content',true)->data_values;
    @endphp
    <div class="account-section bg_img" data-background="{{getImage('assets/images/frontend/auth_page/'.$authBackground->background_image,'1920x1080')}}">
        <div class="account-wrapper bg--section">
            <div class="inner">
                <div class="account-logo text-center">
                    <a href="{{route('home')}}">
                        <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
                    </a>
                </div>
                <form class="account-form" action="{{ route('user.login')}}" method="POST" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="cmn--form--group form-group">
                        <label for="username" class="cmn--label text--white w-100">@lang('Username or Email') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-user"></i>
                            </span>
                            <input type="text" class="form-control form--control" name="username" value="{{ old('username') }}" required>
                        </div>
                    </div>
                    <div class="cmn--form--group form-group">
                        <label for="password" class="cmn--label text--white w-100">@lang('Password') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-key"></i>
                            </span>
                            <input type="password" name="password" class="form-control form--control" required>
                        </div>
                    </div>

                    <div class="cmn--form--group form-group col-md-12 google-captcha">
                        @php echo loadReCaptcha() @endphp
                    </div>
                    @include($activeTemplate.'partials.custom_captcha')

                    <div class="cmn--form--group form-group">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="checkgroup text--white d-flex align-items-center">
                                <input type="checkbox" class="border-0 form--checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="m-0 pl-2">@lang('Remember Me')</label>
                            </div>
                            <a href="{{route('user.password.request')}}" class="text--base">@lang('Forget Password')?</a>
                        </div>
                    </div>

                    <div class="cmn--form--group form-group col-md-12">
                        <button type="submit" class="cmn--btn btn-block justify-content-center w-100">@lang('Login')</button>
                    </div>

                    <div class="text--white">
                        @lang('Don\'t have an account')? <a href="{{ route('user.register') }}" class="text--base">@lang('Register Now')</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
