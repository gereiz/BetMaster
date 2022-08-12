@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="row g-4 justify-content-center">
                    @foreach($withdrawMethod as $data)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="payment-card">
                                <h5 class="title">{{__($data->name)}}</h5>
                                <div class="payment-card__thumb my-3">
                                    <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image,imagePath()['withdraw']['method']['size'])}}" alt="payment">
                                </div>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#withdrawModal" class="btn--sm d-block cmn--btn text-center withdraw" data-id="{{$data->id}}"
                                    data-resource="{{$data}}"
                                    data-min_amount="{{showAmount($data->min_limit)}}"
                                    data-max_amount="{{showAmount($data->max_limit)}}"
                                    data-delay="{{$data->delay}}"
                                    data-fix_charge="{{showAmount($data->fixed_charge)}}"
                                    data-percent_charge="{{showAmount($data->percent_charge)}}"
                                    data-base_symbol="{{__($general->cur_text)}}">
                                    @lang('Withdraw Now')
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title method-name" id="withdrawModalLabel">@lang('Withdraw')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('user.withdraw.money')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger withdrawLimit"></p>
                        <p class="text-danger withdrawCharge"></p>
                        <p class="text-danger delay"></p>

                        <div class="form-group">
                            <input type="hidden" name="currency"  class="edit-currency form-control">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control">
                        </div>



                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">

                                <div class="input-group-prepend">
                                    <span class="input-group-text addon-bg currency-addon">{{__($general->cur_text)}}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
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
            $('.withdraw').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');
                var delay = $(this).data('delay');

                var withdrawLimit = `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{__($general->cur_text)}}`;
                $('.withdrawLimit').text(withdrawLimit);
                var withdrawCharge = `@lang('Charge'): ${fixCharge} {{__($general->cur_text)}} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.withdrawCharge').text(withdrawCharge);
                $('.delay').text('@lang('PRocessing Time'): ' + delay);

                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });
        })(jQuery);
    </script>

@endpush

