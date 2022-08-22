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
                                <img src="{{ $data->gatewayCurrency()->methodImage() }}" alt="payment">
                            </div>
                            <div class="deposit-content">
                                <ul>
                                    <li>
                                        @lang('Amount'): <span class="text--success">{{showAmount($data->amount)}} {{__($general->cur_text)}}</span>
                                    </li>

                                    <li>
                                        @lang('Charge'): <span class="text--danger">{{showAmount($data->charge)}} USD</span>
                                    </li>

                                    <li>
                                        @lang('Payable'): <span class="text--warning">{{showAmount($data->amount + $data->charge)}} {{__($general->cur_text)}}</span>
                                    </li>

                                    <li>
                                        @lang('Conversion Rate'): <span class="text--info">1 {{__($general->cur_text)}} = {{showAmount($data->rate)}}  {{__($data->baseCurrency())}}</span>
                                    </li>

                                    <li>
                                        @lang('In') {{$data->baseCurrency()}}: <span class="text--primary">{{showAmount($data->final_amo)}}</span>
                                    </li>

                                    @if($data->gateway->crypto==1)
                                        <li>
                                            @lang('Conversion with')
                                            <span class="text--info"> {{ __($data->method_currency) }}</span> <span>@lang('and final value will Show on next step')</span>
                                        </li>
                                    @endif
                                </ul>

                                @if( 1000 >$data->method_code)
                                    <a href="{{route('user.deposit.confirm')}}" class="cmn--btn">@lang('Pay Now')</a>
                                @else
                                    <a href="{{route('user.deposit.manual.confirm')}}" class="cmn--btn">@lang('Pay Now')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


