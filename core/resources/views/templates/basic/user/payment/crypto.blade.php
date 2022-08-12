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
                                <img src="{{$data->img}}" alt="payment">
                            </div>
                            <div class="deposit-content justify-content-center">
                                <div>
                                    <h4 class="mt-4">@lang('PLEASE SEND EXACTLY') <span class="text--base"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                                    <h4 class="my-3">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h4><br>
                                </div>
                                <a href="javascript:void(0)" class="cmn--btn">@lang('SCAN TO SEND')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
