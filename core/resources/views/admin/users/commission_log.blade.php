@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">

                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Type')</th>
                                <th scope="col">@lang('Transaction')</th>
                                <th scope="col">@lang('Level')</th>
                                <th scope="col">@lang('Percent')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('After balance')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $data)
                                <tr>
                                    <td data-label="@lang('Date')">{{showDateTime($data->created_at)}}</td>
                                    <td data-label="@lang('Description')">{{__($data->title)}}</td>
                                    <td data-label="@lang('Type')">
                                        @if($data->type == 'deposit')
                                            <span class="badge badge--success">@lang('Deposit')</span>
                                        @elseif($data->type == 'bet')
                                            <span class="badge badge--info">@lang('Placed Bet')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Won Bet')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Transaction')">{{__($data->trx)}}</td>
                                    <td data-label="@lang('Level')">{{__(ordinal($data->level))}}</td>
                                    <td data-label="@lang('Percent')">{{getAmount($data->percent)}} %</td>
                                    <td data-label="@lang('Amount')"><span class="font-weight-bold">{{getAmount($data->commission_amount)}} {{__($general->cur_text)}}</span></td>
                                    <td data-label="@lang('After balance')">{{__($general->cur_sym)}} {{getAmount($data->main_amo)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if($logs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($logs) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')

    <a href="@if(request()->routeIs('admin.users.commissions.deposit')) javascript:void(0) @else {{ route('admin.users.commissions.deposit',$user->id) }} @endif" class="btn btn--primary mb-2 @if(request()->routeIs('admin.users.commissions.deposit')) btn-disabled @endif">@lang('Deposit Commission')</a>

    <a href="@if(request()->routeIs('admin.users.commissions.bet')) javascript:void(0) @else {{ route('admin.users.commissions.bet',$user->id) }} @endif" class="btn btn--primary mb-2 @if(request()->routeIs('admin.users.commissions.bet')) btn-disabled @endif">@lang('Bet Commission')</a>

    <a href="@if(request()->routeIs('admin.users.commissions.win')) javascript:void(0) @else {{ route('admin.users.commissions.win',$user->id) }} @endif" class="btn btn--primary mb-2 mr-2 @if(request()->routeIs('admin.users.commissions.win')) btn-disabled @endif">@lang('Win Bet Commission')</a>

@endpush
