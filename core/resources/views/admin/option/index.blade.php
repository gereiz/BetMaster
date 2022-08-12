@extends('admin.layouts.app')

@section('panel')
    @php
        $upcoming = upcoming($question->match);
    @endphp

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                @if ($upcoming == 1)
                    <div class="card-header">
                        <h4><span class="text--primary">@lang('Upcoming match')</span> - @lang('will start after') {{ diffForHumans($question->match->start_time) }}</h4>
                    </div>
                @endif

                @if ($question->result == 1 || $question->result == 2 || $question->result == 3)
                    <div class="card-header">
                        <h4>
                            @lang('Result is already declared')
                            @if ($question->result == 2)
                                <span class="badge badge--success">@lang('All Loser')</span>
                            @elseif($question->result == 3)
                                <span class="badge badge--danger">@lang('Refunded')</span>
                            @endif
                        </h4>
                    </div>
                @endif


                <div class="card-body px-0">
                    <h6 class="mb-3 px-3">@lang('Match Title'): {{ $question->match->name }}</h6>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Ratio')</th>
                                    <th>@lang('Bet Count')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($options as $item)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $options->firstItem() + $loop->index }}</td>

                                        <td data-label="@lang('Name')">
                                            {{__($item->name)}} @if($item->winner == 1)
                                            <br>
                                            <span class="badge badge--success">@lang('Winner')</span> @endif
                                        </td>

                                        <td data-label="@lang('Invest Rate')">
                                            {{getAmount($item->dividend)}} : {{getAmount($item->divisor)}}
                                        </td>

                                        <td data-label="@lang('Bet Count')"><span class="text--primary">
                                            {{$item->bets->where('status', 0)->count()}}</span>
                                        </td>

                                        <td data-label="@lang('Status')">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Enabled')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Disabled')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            @if ($question->result == 0 && $upcoming == 0)
                                                <a href="javascript:void(0)" class="icon-btn makewinBtn bg--success" data-name="{{$item->name}}" data-id="{{$item->id}}"><i class="las la-trophy"></i> @lang('Make Win')</a>
                                            @endif

                                            @if ($question->result == 0)
                                                <button type="button" class="icon-btn cuModalBtn" data-modal_title="@lang('Update Option')" data-resource="{{ $item}}" data-has_status="1"><i class="la la-pencil-alt"></i> @lang('Edit')</button>
                                            @else
                                                @lang('N/A')
                                            @endif
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
                @if($options->hasPages())
                    <div class="card-footer py-4">
                        {{ $options->links('admin.partials.paginate') }}
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
                    <h5 class="modal-title"> @lang('Add New Option')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.option.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Name') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Ratio') <span class="text-danger">*</span></label>

                            <div class="input-group">

                                <input type="number" step="0.01" class="form-control" name="dividend" required>

                                <span class="input-group-text font-weight-bold rounded-0">:</span>

                                <input type="number" step="0.01" class="form-control" name="divisor" required>

                            </div>
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


    {{-- Make Loser Modal --}}
    <div id="makeLoserModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation Alert')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.all.option.loser')}}" method="POST">
                    @csrf

                    <input type="hidden" name="question_id" value="{{$question->id}}">

                    <div class="modal-body">
                        <h4>@lang('Are sure to make loser all bets for ') <span class="text--warning">{{__($question->name)}}</span></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Make Abandoned Modal --}}
    <div id="makeAbandonedModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation Alert')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.all.option.abandoned')}}" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="{{$question->id}}">

                    <div class="modal-body">
                        <h4>@lang('Are sure to make abandoned all bets for') <span class="text--danger">{{__($question->name)}}</span></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Make Win Modal --}}
    <div id="makewinModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Confirmation Alert')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.all.option.win')}}" method="POST">
                    @csrf
                    <input type="hidden" class="option-id" name="option_id">
                    <div class="modal-body">
                       <h4>@lang('Are sure to make win') <span class="win-name"></span>?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('breadcrumb-plugins')

        <div class="d-flex flex-wrap justify-content-end flex-gap-8">

            <a href="{{ route('admin.question.index', $question->match->id) }}" class="btn btn--dark"><i class="las la-angle-double-left"></i> @lang('Go Back') </a>

            @if (($question->result == 0 && $upcoming == 0) && (count($options) > 0))
                <button class="btn btn--warning makeLoserBtn"><i class="las la-skull-crossbones"></i>@lang('Set Everyone as Loser')</button>
                <button class="btn btn--danger makeAbandonedBtn"><i class="las la-times-circle"></i>@lang('Refund')</button>
            @endif

            @if ($question->result == 0)
                <button class="btn btn--primary cuModalBtn" data-modal_title="@lang('Add New Option')"><i class="las la-plus"></i>@lang('Add New')</button>
            @endif
        </div>

    @endpush
@endsection


@push('script')
    <script>
        'use strict';

        (function ($) {

            $('.makeLoserBtn').on('click', function () {
                var modal = $('#makeLoserModal');
                modal.modal('show');
            });

            $('.makeAbandonedBtn').on('click', function () {
                var modal = $('#makeAbandonedModal');
                modal.modal('show');
            });

            $('.makewinBtn').on('click', function () {
                var modal = $('#makewinModal');
                var name = $(this).data('name');
                var id = $(this).data('id');

                modal.find('.win-name').text(name);
                modal.find('.option-id').val(id);
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush

