@extends($activeTemplate.'layouts.frontend')

@section('content')

    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="deposit-preview bg--body">
                            <div class="deposit-thumb">
                                <img src="{{$deposit->gatewayCurrency()->methodImage()}}" alt="payment">
                            </div>
                            <div class="deposit-content justify-content-center">
                                <div>
                                    <h4 class="mt-4">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h4>
                                    <h4 class="my-3">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h4><br>
                                </div>
                                <form action="{{$data->url}}" method="{{$data->method}}">
                                    <script src="{{$data->src}}"
                                        class="stripe-button"
                                        @foreach($data->val as $key=> $value)
                                        data-{{$key}}="{{$value}}"
                                        @endforeach
                                    >
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass(" btn-success btn-round custom-success text-center btn-lg");
        })(jQuery);
    </script>
@endpush
