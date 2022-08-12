@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Match Title')</th>
                                    <th>@lang('Category / League')</th>
                                    <th>@lang('Question Count')</th>
                                    <th>@lang('Total Invested')</th>
                                    <th>@lang('Total Returned')</th>
                                    <th>@lang('Result')</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                                @forelse ($matches as $item)
                                    @php
                                        $totalInvested = $item->bets->where('status', '!=', 0)->sum('invest_amount');
                                        $winReturned = $item->bets->where('status', 1)->sum('return_amount');
                                        $refundReturned = $item->bets->where('status', 3)->sum('invest_amount');
                                        $result = $totalInvested - ($winReturned + $refundReturned);
                                    @endphp

                                    <tr>
                                        <td data-label="@lang('SL')">{{ $matches->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Match Title')">{{__($item->name)}}</td>
                                        <td data-label="@lang('Category / League')"><span class="font-weight-bold">{{__($item->category->name)}}</span> <br> {{__($item->league->name)}}</td>
                                        <td data-label="@lang('Question Count')">{{__($item->questions->count())}}</td>
                                        <td data-label="@lang('Total Invested')">{{showAmount($totalInvested)}} {{__($general->cur_text)}}</td>
                                        <td data-label="@lang('Total Returned')">{{showAmount($winReturned + $refundReturned)}} {{__($general->cur_text)}}</td>
                                        <td data-label="@lang('Result')">
                                            @if ($result > 0)
                                                <span class="badge badge--success"><i class="las la-arrow-alt-circle-up"></i> {{showAmount($result)}} {{__($general->cur_text)}}</span>
                                            @elseif($result < 0)
                                                <span class="badge badge--danger"><i class="las la-arrow-alt-circle-down"></i> {{showAmount(abs($result))}} {{__($general->cur_text)}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{__($emptyMessage)}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($matches->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($matches) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
        <form action="{{ route('admin.report.bet.search') }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('By match title')" value="{{ request()->search??null }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    @endpush
@endsection
