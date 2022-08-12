@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="row g-4 justify-content-center">
                    @foreach($gatewayCurrency as $data)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="payment-card">
                                <h6 class="title">{{__($data->name)}}</h6>
                                <div class="payment-card__thumb my-3">
                                    <img src="{{$data->methodImage()}}" alt="payment">
                                </div>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#depositModal" class="btn--sm d-block cmn--btn text-center deposit" data-id="{{$data->id}}"
                                    data-name="{{$data->name}}"
                                    data-currency="{{$data->currency}}"
                                    data-method_code="{{$data->method_code}}"
                                    data-min_amount="{{showAmount($data->min_amount)}}"
                                    data-max_amount="{{showAmount($data->max_amount)}}"
                                    data-base_symbol="{{$data->baseSymbol()}}"
                                    data-fix_charge="{{showAmount($data->fixed_charge)}}"
                                    data-percent_charge="{{showAmount($data->percent_charge)}}">
                                    @lang('Deposit Now')
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade cmn--modal" id="depositModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="depositModalLabel"></strong>
                    <span  data-bs-dismiss="modal"><i class="las la-times"></i></span>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body pt-4 pb-3">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency">
                            <input type="hidden" name="method_code" class="edit-method-code">
                        </div>
                        <div class="form-group">
                            <label class="mb-2">@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form--control form-control-lg" name="amount" placeholder="@lang('Amount')" required  value="{{old('amount')}}">
                                <span class="input-group-text bg--base text--white">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <div class="prevent-double-click">
                            <button type="submit" class="btn btn--success confirm-btn">@lang('Confirm')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.deposit').on('click', function () {
                var name = $(this).data('name');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{$general->cur_text}}";
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Deposit Limit'): ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Payment By ') ${name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            });

            // $('.prevent-double-click').on('click',function(){
            //     $(this).addClass('button-none');
            //     $(this).html('<i class="fas fa-spinner fa-spin"></i> @lang('Processing')...');
            // });
        })(jQuery);
    </script>
@endpush


@push('style')
<style type="text/css">

</style>
@endpush
