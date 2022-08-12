@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="table-responsive">
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Transaction ID')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $item)
                                <tr>
                                    <td data-label="@lang('Transaction ID')">{{$item->trx}}</td>

                                    <td data-label="@lang('Amount')"> @if ($item->trx_type == '+')
                                        <span class="text--base">+ {{showAmount($item->amount)}} {{__($general->cur_text)}}</td></span>
                                    @elseif ($item->trx_type == '-')
                                        <span class="text--danger">- {{showAmount($item->amount)}} {{__($general->cur_text)}}</td></span>
                                    @endif

                                    <td data-label="@lang('Charge')">{{showAmount($item->charge)}} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Post Balance')">{{showAmount($item->post_balance)}} {{__($general->cur_text)}}</td>

                                    <td data-label="@lang('Details')">{{__($item->details)}}</td>
                                </tr>
                            @empty
                                <tr><td colspan="100%" class="text-center">{{__($emptyMessage)}}</td></tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <ul class="pagination justify-content-end">
                    {{$transactions->links()}}
                </ul>
            </div>
        </div>
    </section>
@endsection

