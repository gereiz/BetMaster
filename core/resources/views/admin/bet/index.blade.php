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
                                    <th>@lang('User')</th>
                                    <th>@lang('Match')</th>
                                    <th>@lang('Question')</th>
                                    <th>@lang('Option')</th>
                                    <th>@lang('Rate')</th>
                                    <th>@lang('Invest')</th>
                                    <th>@lang('Return')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($bets as $item)
                                    <tr>
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">{{__($item->user->fullname)}}</span>
                                            <br>
                                            <span class="small">
                                            <a href="{{ route('admin.users.detail', $item->user->id) }}"><span>@</span>{{$item->user->username}}</a>
                                            </span>
                                        </td>
                                        <td data-label="@lang('Match')">{{__($item->match->name)}}</td>
                                        <td data-label="@lang('Question')">{{__($item->question->name)}}</td>
                                        <td data-label="@lang('Option')"><span class="text--primary">{{__($item->option->name)}}</span></td>
                                        <td data-label="@lang('Rate')">{{getAmount($item->dividend)}} : {{getAmount($item->divisor)}}</td>
                                        <td data-label="@lang('Invest')"><span class="text--primary">{{getAmount($item->invest_amount)}} {{__($general->cur_text)}}</span></td>
                                        <td data-label="@lang('Return')"><span class="text--primary">{{getAmount($item->return_amount)}} {{__($general->cur_text)}}</span></td>
                                        <td data-label="@lang('Status')">
                                           @php echo $item->statusBadge @endphp
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($bets->hasPages())
                    <div class="card-footer py-4">
                        {{ $bets->links('admin.partials.paginate') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
        <form method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Search')..." value="{{ request()->search??null }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    @endpush
@endsection
