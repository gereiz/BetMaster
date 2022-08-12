@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <!-- Dashboard -->
            <div class="pb-120">
                <div class="row justify-content-center g-4">
                    <div class="form--group">
                        <label class="form-label">@lang('Referral Link')</label>
                        <div class="input-group">
                            <input type="text" name="key" value="{{route('user.refer.register',[Auth::user()->username])}}" class="form-control bg--section h--50px form--control" id="referralURL" readonly>
                            <span class="input-group-text bg--base form--control h--50px cursor-pointer copytext" id="copyBoard">
                                <i class="lar la-copy"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.transactions')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-wallet"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{__($general->cur_sym)}} {{showAmount($user->balance)}}</h4>
                                    <span class="text--base">@lang('Balance')</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.transactions')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-exchange-alt"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalTransaction']}}</h4>
                                    <span class="text--base">@lang('Transactions')</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('ticket')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-ticket-alt"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalTicket']}}</h4>
                                    <span class="text--base">@lang('Support Tickets')</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.bet.index','all')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-gamepad"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalBet']}}</h4>
                                    <span class="subtitle text-white">@lang('Total')</span> <span class="text--base">@lang('Bets')</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.bet.index','pending')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-spinner"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalPending']}}</h4>
                                    <span class="subtitle text-white">@lang('Pending')</span> <span class="text--base">@lang('Bets')</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.bet.index','won')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-trophy"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalWin']}}</h4>
                                    <span class="subtitle text-white">@lang('Won')</span> <span class="text--base">@lang('Bets')</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.bet.index','lose')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-frown"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalLose']}}</h4>
                                    <span class="subtitle text-white">@lang('Lose')</span> <span class="text--base">@lang('Bets')</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <a href="{{route('user.bet.index','refunded')}}" class="d-block">
                            <div class="dashboard__item">
                                <div class="dashboard__thumb">
                                    <i class="las la-hand-holding-usd"></i>
                                </div>
                                <div class="dashboard__content">
                                    <h4 class="dashboard__title">{{$widget['totalRefund']}}</h4>
                                    <span class="subtitle text-white">@lang('Refunded')</span> <span class="text--base">@lang('Bets')</span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-section bg--section">
        <div class="container">
            <div class="pb-120">
                <h4 class="title mb-3">@lang('My Latest Bets')</h4>
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
                                    <td data-label="@lang('Betted')">{{getAmount($item->invest_amount)}} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('Reward')">{{getAmount($item->return_amount)}} {{__($general->cur_text)}}</td>
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
                                <tr><td colspan="100%" class="text-center">@lang('No bet yet')</td></tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

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
@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });

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

