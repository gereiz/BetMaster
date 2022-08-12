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
                                    <th>@lang('Question')</th>
                                    <th>@lang('Match')</th>
                                    <th>@lang('Bet Count')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($questions as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $questions->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Question')">{{__($item->name)}}</td>
                                        <td data-label="@lang('Match')">{{__($item->match->name)}}</td>
                                        <td data-label="@lang('Bet Count')"><span class="text--primary"> {{$item->bets->where('status', 0)->count()}}</span></td>
                                        <td data-label="@lang('Action')">
                                            <a href="{{route('admin.option.index',$item->id)}}" class="icon-btn"><i class="las la-eye"></i></a>
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
                @if($questions->hasPages())
                    <div class="card-footer py-4">
                        {{ $questions->links('admin.partials.paginate') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
        <form action="" method="GET" class="form-inline float-sm-right bg--white mt-2">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Match Title')" value="{{ request()->search }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    @endpush
@endsection
