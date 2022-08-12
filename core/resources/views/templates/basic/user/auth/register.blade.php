@extends($activeTemplate.'layouts.auth')
@section('content')
    @php
        $policyElements =  getContent('policy_pages.element');
	    $authBackground = getContent('auth_page.content',true)->data_values;
    @endphp
    <div class="account-section bg_img" data-background="{{getImage('assets/images/frontend/auth_page/'.$authBackground->background_image,'1920x1080')}}">
        <div class="account-wrapper bg--section">
            <div class="inner">
                <div class="account-logo">
                    <a href="{{route('home')}}">
                        <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="logo">
                    </a>
                </div>
                <form class="account-form row" action="{{ route('user.register') }}" method="POST" onsubmit="return submitUserForm();">
                    @csrf

                    @if(session()->get('reference') != null)
                        <div class="cmn--form--group form-group col-md-12">
                            <label for="referenceBy" class="cmn--label text--white w-100">@lang('Reference By') <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="las la-user"></i>
                                </span>
                                <input type="text" class="form-control form--control" name="referBy" id="referenceBy" value="{{session()->get('reference')}}" readonly>
                            </div>
                        </div>
                    @endif
                    <div class="cmn--form--group form-group col-md-6">
                        <label for="username" class="cmn--label text--white w-100">@lang('First Name') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-user"></i>
                            </span>
                            <input type="text" class="form-control form--control" name="firstname" value="{{ old('firstname') }}" required>
                        </div>
                    </div>
                    <div class="cmn--form--group form-group col-md-6">
                        <label for="username" class="cmn--label text--white w-100">@lang('Last Name') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-user"></i>
                            </span>
                            <input type="text" class="form-control form--control" name="lastname" value="{{ old('lastname') }}" required>
                        </div>
                    </div>
                    <div class="cmn--form--group form-group col-md-6">
                        <div class="input-group">
                            <label class="cmn--label text--white w-100">@lang('Country') <span class="text-danger">*</span></label>
                            <span class="input-group-text">
                                <i class="las la-globe-americas"></i>
                            </span>
                            <select class="form-control form--control" name="country" id="country">
                                @foreach($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cmn--form--group form-group col-md-6">
                        <label for="password" class="cmn--label text--white w-100">@lang('Mobile Number') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text mobile-code">
                            </span>

                            <input type="hidden" name="mobile_code">
                            <input type="hidden" name="country_code">
                            <input type="text" class="form-control form--control checkUser" name="mobile" id="mobile" value="{{ old('mobile') }}">
                        </div>
                        <small class="text-danger mobileExist"></small>
                    </div>
                    <div class="cmn--form--group form-group col-md-6">
                        <label for="username" class="cmn--label text--white w-100">@lang('Username') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-user"></i>
                            </span>
                            <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}" required>
                        </div>
                        <small class="text-danger usernameExist"></small>
                    </div>
                    <div class="cmn--form--group form-group col-md-6">
                        <label for="username" class="cmn--label text--white w-100">@lang('E-Mail Address') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-envelope"></i>
                            </span>
                            <input type="email" class="form-control form--control checkUser" name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="cmn--form--group form-group col-md-6 hover-input-popup">
                        <label for="username" class="cmn--label text--white w-100">@lang('Password') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-key"></i>
                            </span>
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
                    </div>
                    <div class="cmn--form--group form-group col-md-6">
                        <label for="username" class="cmn--label text--white w-100">@lang('Confirm Password') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-key"></i>
                            </span>
                            <input type="password" class="form-control form--control" name="password_confirmation" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="cmn--form--group form-group col-md-12 google-captcha">
                        @php echo loadReCaptcha() @endphp
                    </div>
                    @include($activeTemplate.'partials.custom_captcha')

                    @if($general->agree)
                        <div class="text--white col-md-12 mb-4">
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="checkgroup text--white d-flex flex-wrap align-items-center">
                                    <input type="checkbox" class="border-0 form--checkbox" id="agree" name="agree" checked>
                                    <label for="agree" class="m-0 pl-2">@lang('I aggree with')&nbsp</label>

                                    @foreach ($policyElements as $item)
                                        <a href="{{route('policy.details',[slug(@$item->data_values->title),$item->id])}}" class="text--base"> {{__($item->data_values->title)}} </a> @if(!$loop->last) ,&nbsp @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="cmn--form--group form-group col-md-12">
                        <button type="submit" class="cmn--btn btn-block justify-content-center w-100">@lang('Register')</button>
                    </div>

                    <div class="text--white col-md-12">
                        <div class="d-flex flex-wrap justify-content-between">
                            <div>
                                @lang('Already have an account')? <a href="{{route('user.login')}}" class="text--base">@lang('Login Now')</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade cmn--modal" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span data-bs-dismiss="modal"><i class="las la-times"></i></span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center m-0">@lang('You already have an account please Sign in ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--primary">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
    .country-code .input-group-prepend .input-group-text{
        background: #fff !important;
    }
    .country-code select{
        border: none;
    }
    .country-code select:focus{
        border: none;
        outline: none;
    }
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
      "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        (function ($) {
            @if($mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected','');
            @endif

            $('select[name=country]').change(function(){
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+'+$('select[name=country] :selected').data('mobile_code'));
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });
            @endif

            $('.checkUser').on('focusout',function(e){
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {mobile:mobile,_token:token}
                }
                if ($(this).attr('name') == 'email') {
                    var data = {email:value,_token:token}
                }
                if ($(this).attr('name') == 'username') {
                    var data = {username:value,_token:token}
                }
                $.post(url,data,function(response) {
                  if (response['data'] && response['type'] == 'email') {
                    $('#existModalCenter').modal('show');
                  }else if(response['data'] != null){
                    $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                  }else{
                    $(`.${response['type']}Exist`).text('');
                  }
                });
            });

        })(jQuery);

    </script>
@endpush
