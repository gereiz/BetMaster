@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Match Title')</th>
                                    <th>@lang('Category') | @lang('League')</th>
                                    <th>@lang('Start At') | @lang('End At')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($matches as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $matches->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Match Title')">{{__($item->name)}}</td>
                                        <td data-label="@lang('Category / League')">
                                            <span class="font-weight-bold">{{__($item->category->name)}}</span>
                                            <br>
                                            {{__($item->league->name)}}
                                        </td>

                                        <td data-label="@lang('Start Time')">
                                            <span class="d-block font-weight-bold">{{showDateTime($item->start_time, 'd M Y, h:i A')}}</span>
                                            <span class="font-weight-bold">{{showDateTime($item->end_time, 'd M Y, h:i A')}}</span>
                                        </td>


                                        <td data-label="@lang('Status')">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactive')</span>
                                            @endif
                                        </td>

                                        @php
                                            $item->beginning_time = showDateTime($item->end_time, 'Y-m-d h:i a');
                                            $item->finishing_time = showDateTime($item->end_time, 'Y-m-d h:i a');;
                                        @endphp

                                        <td data-label="@lang('Action')">
                                            <button type="button" class="icon-btn cuModalBtn" data-resource="{{$item}}" data-has_status="1" data-modal_title="@lang('Update Match')" title="@lang('Edit')"><i class="la la-pencil-alt"></i></button>

                                            <a href="{{ route('admin.question.index',$item->id) }}" title="{{$item->questions->count()}} @lang('Questions')" class="icon-btn btn--info"><i class="la la-question"></i></a>
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
                @if($matches->hasPages())
                    <div class="card-footer py-4">
                        {{ $matches->links('admin.partials.paginate') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Match')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.match.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Select League') <span class="text-danger">*</span></label>
                            <select name="league_id" class="form-control" required>
                                <option value="">@lang('Select One')</option>
                                @foreach ($leagues as $item)
                                    <option value="{{$item->id}}">{{__($item->name)}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Match Title') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="@lang('RM vs FCB')" name="name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Betting Starts From') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control timepicker" placeholder="@lang('Chosse start time')" name="beginning_time" autocomplete="off" required readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Betting Ends At') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control timepicker " placeholder="@lang('Chosse end time')" name="finishing_time" autocomplete="off" required readonly>
                        </div>

                        <div class="status"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end flex-gap-8">
        <button type="button" class="btn btn--primary cuModalBtn" data-modal_title="@lang('Add New Match')"><i class="las la-plus"></i>@lang('Add New')</button>

        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Match Title')" value="{{ request()->search??null }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    @endpush
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment-with-local.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
<script>

    (function ($) {
        'use strict';
        var start = new Date(),
        prevDay,
        startHours = 12;

        start.setHours(12);
        start.setMinutes(0);

        if ([6, 0].indexOf(start.getDay()) != -1) {
            start.setHours(12);
            startHours = 12
        }

        $('.timepicker').datepicker({
            timepicker: true,
            language: 'en',
            startDate: start,
            minHours: startHours,
            maxHours: 24,
            dateFormat: 'yyyy-mm-dd',

            onSelect: function (fd, d, picker) {

                if (!d) return;

                var day = d.getDay();
                if (prevDay != undefined && prevDay == day) return;
                prevDay = day;

                if (day == 6 || day == 0) {
                    picker.update({
                        minHours: 24,
                        maxHours: 24
                    })
                } else {
                    picker.update({
                        minHours: 24,
                        maxHours: 24
                    })
                }
            }
        });
    })(jQuery);

</script>
@endpush


@push('style')
<style>
    .datepicker{
        z-index: 9999;
    }
</style>
@endpush
