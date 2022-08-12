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
                                    <th>@lang('Option Count')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($questions as $question)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                        <td data-label="@lang('Question')">{{__($question->name)}}</td>
                                        <td data-label="@lang('Options')">{{__($question->options->count())}}</td>
                                        <td data-label="@lang('Status')">
                                            @if ($question->status == 1)
                                                <span class="badge badge--success">@lang('Enabled')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Disabled')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">

                                            <button type="button" class="icon-btn cuModalBtn" data-resource="{{$question}}" data-modal_title="@lang('Update Question')" data-has_status="1">
                                                <i class="la la-pencil-alt"></i> @lang('Edit')
                                            </button>

                                            <a href="{{ route('admin.option.index',$question->id) }}" class="icon-btn btn--info">
                                                <i class="las la-stream"></i> @lang('Options')
                                            </a>

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

    {{-- Add METHOD MODAL --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Question')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.question.store')}}" method="POST">
                    @csrf

                    <input type="hidden" name="match_id" value="{{ $match->id }}">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Question') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
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
        <a href="{{ route('admin.match.index') }}" class="btn btn--dark"><i class="las la-angle-double-left"></i> @lang('Go Back') </a>
        <button type="button" class="btn btn--primary mr-3 cuModalBtn" data-modal_title="@lang('Add New Question')"><i class="las la-plus"></i>@lang('Add New')</button>
    @endpush
@endsection

