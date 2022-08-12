@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="table-responsive">
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Match')</th>
                                <th>@lang('Question')</th>
                                <th>@lang('Option')</th>
                                <th>@lang('Betted')</th>
                                <th>@lang('Reward if Won')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('More')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bets as $item)
                                <tr>
                                    <td data-label="@lang('Match')">{{__($item->match->name)}}</td>
                                    <td data-label="@lang('Question')">{{__($item->question->name)}}</td>
                                    <td data-label="@lang('Option')">{{__($item->option->name)}}</td>
                                    <td data-label="@lang('Invest')">{{getAmount($item->invest_amount)}} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Return')">{{getAmount($item->return_amount)}} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Status')">
                                        @php echo $item->statusBadge @endphp
                                    </td>
                                    <td data-label="@lang('More')">
                                        <a href="javascript:void(0)" class="badge badge--success detailBtn"
                                        data-match="{{__($item->match->name)}}"
                                        data-question="{{__($item->question->name)}}"
                                        data-choice="{{$item->option->name}}"
                                        data-invest_amount="{{$item->invest_amount}}"
                                        data-return_amount="{{$item->return_amount}}"
                                        data-status_badge='@php echo $item->statusBadge @endphp'>
                                        <i class="la la-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="100%" class="text-center">{{__($emptyMessage)}}</td></tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <ul class="pagination justify-content-end">
                    {{$bets->links()}}
                </ul>
            </div>
        </div>
    </section>

    <div class="modal cmn--modal fade" id="detailsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col text-center match-name" id="exampleModalLabel">@lang('Login Required')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="predict-content">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent d-flex flex-wrap justify-content-between">
                                @lang('Question') <span class="subtitle question"></span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex flex-wrap justify-content-between">
                                <span>@lang('My Choice Was ')</span> <span class="choice text--base"></span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex flex-wrap justify-content-between">
                                <span><b>@lang('Invested Amount ')</b></span> <span class="invest text--base"></span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex flex-wrap justify-content-between">
                                <span><b>@lang('Return Amount ')</b></span> <span class="return text--base"></span>
                            </li>

                            <li class="list-group-item bg-transparent d-flex flex-wrap justify-content-between">
                                <span><b>@lang('Result')</b></span> <span class="status text--base"></span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.detailBtn').on('click', function() {
                var modal       = $('#detailsModal');
                var match       = $(this).data('match');
                var question    = $(this).data('question');
                var choice      = $(this).data('choice');
                var investAmount= $(this).data('invest_amount');
                var returnAmount= $(this).data('return_amount');
                var statusBadge = $(this).data('status_badge');

                modal.find('.match-name').text(match);
                modal.find('.question').text(question);
                modal.find('.choice').text(choice);
                modal.find('.invest').html(`${parseFloat(investAmount).toFixed(2)} {{__($general->cur_text)}}`);
                modal.find('.return').html(`${parseFloat(returnAmount).toFixed(2)} {{__($general->cur_text)}}`);
                modal.find('.status').html(statusBadge);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
