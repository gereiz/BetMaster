@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="btn--group justify-content-center mb-4">
                    <a href="@if(request()->routeIs('user.referral.commissions.deposit')) javascript:void(0) @else {{route('user.referral.commissions.deposit')}} @endif" class="cmn--btn btn--sm @if(request()->routeIs('user.referral.commissions.deposit')) btn-disabled @endif">@lang('Commissions on Deposit')</a>

                    <a href="@if(request()->routeIs('user.referral.commissions.bet')) javascript:void(0) @else {{route('user.referral.commissions.bet')}} @endif" class="cmn--btn btn--sm @if(request()->routeIs('user.referral.commissions.bet')) btn-disabled @endif">@lang('Commissions on Bet')</a>

                    <a href="@if(request()->routeIs('user.referral.commissions.win')) javascript:void(0) @else {{route('user.referral.commissions.win')}} @endif" class="cmn--btn btn--sm @if(request()->routeIs('user.referral.commissions.win')) btn-disabled @endif">@lang('Commissions on Won Bet ')</a>

                    <a href="{{route('user.referral.users')}}" class="cmn--btn btn--sm"><i class="las la-user-circle"></i> @lang('Referred Users')</a>
                </div>
                <div class="table-responsive">
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('From')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $data)
                                <tr>
                                    <td data-label="@lang('Date')">{{showDateTime($data->created_at,'d M, Y')}}</td>
                                    <td data-label="@lang('From')"><strong>{{@$data->bywho->username}}</strong></td>
                                    <td data-label="@lang('Amount')">{{__($general->cur_sym)}}{{getAmount($data->amount)}}</td>
                                    <td data-label="@lang('Type')">{{__($data->details)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{__($emptyMessage)}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <ul class="pagination justify-content-end">
                    {{$logs->links()}}
                </ul>
            </div>
        </div>
    </section>
@endsection
