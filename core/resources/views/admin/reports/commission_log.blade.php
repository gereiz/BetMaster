@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Type - Transaction')</th>
                                <th>@lang('Level - From')</th>
                                <th>@lang('Amount - Percentage')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $data)
                                <tr>
                                    <td data-label="@lang('Date')">{{showDateTime($data->created_at,'Y-m-d')}}</td>
                                    <td data-label="@lang('User')">
                                        <span class="font-weight-bold">{{ $data->user->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->user->id) }}"><span>@</span>{{ $data->user->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Type - Transaction')">
                                        @if($data->type == 'deposit')
                                            <span class="badge badge--success">@lang('Deposit')</span>
                                        @elseif($data->type == 'bet')
                                            <span class="badge badge--info">@lang('Placed Bet')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Won Bet')</span>
                                        @endif
                                        <br>
                                        {{__($data->trx)}}
                                    </td>
                                    <td data-label="@lang('Level - From')">
                                        <span class="font-weight-bold">{{__(ordinal($data->level))}}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->bywho->id) }}"><span>@</span>{{ $data->bywho->username }}</a> </span>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        {{getAmount($data->amount)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Description')">
                                        {{__($data->details)}}
                                    </td>
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

<div class="d-flex flex-wrap justify-content-end flex-gap-8">
    <a href="@if(request()->routeIs('admin.report.commissions.deposit')) javascript:void(0) @else {{ route('admin.report.commissions.deposit') }} @endif" class="btn btn--primary mb-2 @if(request()->routeIs('admin.report.commissions.deposit')) btn-disabled @endif">@lang('Deposit Commission')</a>

    <a href="@if(request()->routeIs('admin.report.commissions.bet')) javascript:void(0) @else {{ route('admin.report.commissions.bet') }} @endif" class="btn btn--primary mb-2 @if(request()->routeIs('admin.report.commissions.bet')) btn-disabled @endif">@lang('Placed Bet Commission')</a>

    <a href="@if(request()->routeIs('admin.report.commissions.win')) javascript:void(0) @else {{ route('admin.report.commissions.win') }} @endif" class="btn btn--primary mb-2 mr-2 @if(request()->routeIs('admin.report.commissions.win')) btn-disabled @endif">@lang('Win Bet Commission')</a>


    <form action="{{ route('admin.report.commissions.search') }}" method="GET">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Username')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>

</div>
    </form>
@endpush
