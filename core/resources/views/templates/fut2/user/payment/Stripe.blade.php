@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-10">
                        <div class="card custom--card h-100">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Stripe Payment')</h5>
                            </div>
                            <div class="card-body">
                                <div class="two-factor-content">
                                    <div class="card-wrapper mb-4"></div>

                                    <form class="account-form row" role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                                        @csrf
                                        <input type="hidden" value="{{$data->track}}" name="track">

                                        <div class="cmn--form--group form-group col-md-6">
                                            <label for="username" class="cmn--label text--white w-100">@lang('Name on Card') <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="las la-user"></i>
                                                </span>
                                                <input type="text" class="form-control form--control custom-input" name="name" placeholder="@lang('Name on Card')" autocomplete="off" autofocus required>
                                            </div>
                                        </div>

                                        <div class="cmn--form--group form-group col-md-6">
                                            <label for="username" class="cmn--label text--white w-100">@lang('Card Number') <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="las la-sort-numeric-up"></i>
                                                </span>
                                                <input type="tel" class="form-control form--control custom-input" name="cardNumber" autocomplete="off" placeholder="@lang('Valid Card Number')" autofocus required>
                                            </div>
                                        </div>

                                        <div class="cmn--form--group form-group col-md-6">
                                            <label for="username" class="cmn--label text--white w-100">@lang('Expiration Date') <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="las la-calendar"></i>
                                                </span>
                                                <input type="tel" class="form-control form--control custom-input" name="cardExpiry" placeholder="@lang('MM / YYYY')" autocomplete="off" autofocus required>
                                            </div>
                                        </div>

                                        <div class="cmn--form--group form-group col-md-6">
                                            <label for="username" class="cmn--label text--white w-100">@lang('CVC Code') <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="las la-code"></i>
                                                </span>
                                                <input type="tel" class="form-control form--control custom-input" name="cardCVC" placeholder="@lang('CVC')" autocomplete="off" autofocus required>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button class="cmn--btn w-100  justify-content-center" type="submit"> @lang('Pay Now')
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@push('script')
    <script src="{{ asset('assets/global/js/card.js') }}"></script>

    <script>
        (function ($) {
            "use strict";
            var card = new Card({
                form: '#payment-form',
                container: '.card-wrapper',
                formSelectors: {
                    numberInput: 'input[name="cardNumber"]',
                    expiryInput: 'input[name="cardExpiry"]',
                    cvcInput: 'input[name="cardCVC"]',
                    nameInput: 'input[name="name"]'
                }
            });
        })(jQuery);
    </script>
@endpush
