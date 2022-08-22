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
                <h5 class="text-center">@lang('Reset Password')</h5>

                <form class="account-form" action="{{ route('user.password.email') }}" method="POST">
                    @csrf

                    <div class="cmn--form--group form-group">
                        <label for="username" class="cmn--label text--white w-100">@lang('Select One')</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-user"></i>
                            </span>
                            <select class="form-control form--control" name="type">
                                <option value="email">@lang('E-Mail Address')</option>
                                <option value="username">@lang('Username')</option>
                            </select>
                        </div>
                    </div>

                    <div class="cmn--form--group form-group">
                        <label for="username" class="cmn--label text--white w-100 my_value"></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="las la-user"></i>
                            </span>
                            <input type="text" class="form-control form--control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required autofocus="off">

                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="cmn--form--group form-group">
                        <button type="submit" class="cmn--btn w-100 justify-content-center">@lang('Send Password Code')</button>
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

            myVal();
            $('select[name=type]').on('change',function(){
                myVal();
            });
            function myVal(){
                $('.my_value').text($('select[name=type] :selected').text());
            }
        })(jQuery)
    </script>
@endpush
