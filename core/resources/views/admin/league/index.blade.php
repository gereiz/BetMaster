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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Icon')</th>
                                    <th>@lang('Match Count')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($leagues as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $leagues->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Name')">{{__($item->name) }}</td>
                                        <td data-label="@lang('Category')">{{__($item->category->name) }}</td>
                                        <td data-label="@lang('Icon')">@php echo $item->icon; @endphp</td>
                                        <td data-label="@lang('Match Count')">{{__($item->matches->count())}}</td>
                                        <td data-label="@lang('Status')">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactive')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button type="button" class="icon-btn cuModalBtn" data-resource="{{$item}}" data-has_status="1" data-modal_title="@lang('Update League')" title="@lang('Edit')"><i class="la la-pencil-alt"></i></button>
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
                @if($leagues->hasPages())
                    <div class="card-footer py-4">
                        {{ $leagues->links('admin.partials.paginate') }}
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
                    <h5 class="modal-title"> @lang('Add New League')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.league.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Select Category') <span class="text-danger">*</span></label>

                            <select name="category_id" class="form-control" required>
                                <option value="">@lang('Select One')</option>
                                @foreach ($categories as $item)
                                    <option value="{{$item->id}}">{{__($item->name)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Name') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="@lang('UEFA Champions League')" name="name" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Select Icon')</label>
                            <div class="input-group has_append">
                                <input type="text" class="form-control icon" name="icon" required>

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                </div>
                            </div>
                        </div>

                        <div class="status"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end flex-gap-8">
        <button type="button" class="btn btn--primary cuModalBtn" data-modal_title="@lang('Add League')"><i class="las la-plus"></i>@lang('Add New')</button>

        <form method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="@lang('Name')" value="{{ request()->search }}">
                <div class="input-group-append">
                    <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    @endpush
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush

@push('script')
<script>
    'use strict';

    (function ($) {

        $('#cuModal').on('shown.bs.modal', function (e) {
            $(document).off('focusin.modal');
        });

        $('.iconPicker').iconpicker().on('change', function (e) {
            $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
        });

    })(jQuery);
</script>
@endpush
