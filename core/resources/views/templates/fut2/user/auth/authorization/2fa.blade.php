@extends($activeTemplate .'layouts.auth')
@section('content')
    @php
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
                <h5 class="text-center">@lang('2FA Verification')</h5>
                <p class="text-center mt-2"><b>@lang('Current Time') : {{\Carbon\Carbon::now()}}</b></p>

                <form class="account-form" action="{{route('user.go2fa.verify')}}" method="POST">
                    @csrf
                    <div class="cmn--form--group form-group">
                        <label for="username" class="cmn--label text--white w-100">@lang('Verification Code')</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-code"></i>
                            </span>
                            <input type="text" class="form-control form--control" name="code" id="code">
                        </div>
                    </div>
                    <div class="cmn--form--group form-group">
                        <button type="submit" class="cmn--btn w-100 justify-content-center">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($){
            "use strict";
            $('#code').on('input change', function () {
                var xx = document.getElementById('code').value;

                $(this).val(function (index, value) {
                    value = value.substr(0,7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)
    </script>
@endpush
