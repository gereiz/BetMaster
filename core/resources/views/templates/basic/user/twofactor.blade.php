@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card custom--card h-100">
                            <div class="card-header">
                                <h5 class="card-title py-2">@lang('Two Factor Authenticator')</h5>
                            </div>
                            <div class="card-body">
                                <div class="two-factor-content">
                                    @if(Auth::user()->ts)
                                        <div class="text-center">
                                            <a href="javascript:void(0)" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
                                        </div>
                                    @else
                                        <div class="input-group">
                                            <input type="text" name="key" value="{{$secret}}" class="form-control bg--section h--50px form--control" id="referralURL" readonly>
                                            <span class="input-group-text bg--base form--control h--50px cursor-pointer copytext" id="copyBoard">
                                                <i class="lar la-copy"></i>
                                            </span>
                                        </div>
                                        <div class="two-factor-scan text-center my-4">
                                            <img class="mw-100" src="{{$qrCodeUrl}}" alt="images">
                                        </div>
                                        <div class="text-center">
                                            <a href="javascript:void(0)" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card custom--card h-100">
                            <div class="card-header">
                                <h5 class="card-title py-2">@lang('Google Authenticator')</h5>
                            </div>
                            <div class="card-body">
                                <div class="two-factor-content">
                                    <h6 class="subtitle--bordered">@lang('USE GOOGLE AUTHENTICATOR TO SCAN THE QR CODE OR USE THE CODE')</h6>
                                    <p class="two__fact__text">
                                        @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                                    </p>
                                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank" class="cmn--btn">@lang('DOWNLOAD APP')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Enable Modal -->
    <div id="enableModal" class="modal fade cmn--modal" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Verify Your Otp')</h6>
                    <span data-bs-dismiss="modal"><i class="las la-times"></i></span>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade cmn--modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Verify Your Otp Disable')</h6>
                    <span data-bs-dismiss="modal"><i class="las la-times"></i></span>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Verify')</button>
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

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


