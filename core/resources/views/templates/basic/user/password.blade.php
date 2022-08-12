@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="profile-wrapper bg--body">
                    <div class="profile-user mb-lg-0">
                        <div class="thumb">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}" alt="user">
                        </div>
                        <div class="content">
                            <h6 class="title">@lang('Name'): {{__(auth()->user()->fullname)}}</h6>
                            <span class="subtitle">@lang('Username'): {{auth()->user()->username}}</span>
                        </div>
                    </div>
                    <div class="profile-form-area">
                        <form class="profile-edit-form row mb--25" action="" method="POST">
                            @csrf
                            <div class="form--group col-md-12">
                                <label class="cmn--label" for="first-name">@lang('Current Password')</label>
                                <input type="password" class="form-control form--control" name="current_password" required>
                            </div>
                            <div class="form--group col-md-12 hover-input-popup">
                                <label class="cmn--label" for="first-name">@lang('New Password')</label>
                                <input type="password" class="form-control form--control" name="password" required>
                                @if($general->secure_password)
                                    <div class="input-popup">
                                      <p class="error lower">@lang('1 small letter minimum')</p>
                                      <p class="error capital">@lang('1 capital letter minimum')</p>
                                      <p class="error number">@lang('1 number minimum')</p>
                                      <p class="error special">@lang('1 special character minimum')</p>
                                      <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form--group col-md-12">
                                <label class="cmn--label" for="first-name">@lang('Confirm Password')</label>
                                <input type="password" class="form-control form--control" name="password_confirmation" required>
                            </div>

                            <div class="form--group w-100 col-md-6 mb-0 text-end">
                                <button type="submit" class="cmn--btn w-100 justify-content-center">@lang('Change Password')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
<style>
    .hover-input-popup {
        position: relative;
    }
    .hover-input-popup:hover .input-popup {
        opacity: 1;
        visibility: visible;
    }
    .input-popup {
        position: absolute;
        bottom: 130%;
        left: 50%;
        width: 280px;
        background-color: #1a1a1a;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .input-popup::after {
        position: absolute;
        content: '';
        bottom: -19px;
        left: 50%;
        margin-left: -5px;
        border-width: 10px 10px 10px 10px;
        border-style: solid;
        border-color: transparent transparent #1a1a1a transparent;
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .input-popup p {
        padding-left: 20px;
        position: relative;
    }
    .input-popup p::before {
        position: absolute;
        content: '';
        font-family: 'Line Awesome Free';
        font-weight: 900;
        left: 0;
        top: 4px;
        line-height: 1;
        font-size: 18px;
    }
    .input-popup p.error {
        text-decoration: line-through;
    }
    .input-popup p.error::before {
        content: "\f057";
        color: #ea5455;
    }
    .input-popup p.success::before {
        content: "\f058";
        color: #28c76f;
    }
</style>
@endpush
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
        @endif
    })(jQuery);
</script>
@endpush
