@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="text-end mb-4">
                    <a href="{{route('ticket.open') }}" class="cmn--btn btn--sm">@lang('New Ticket')</a>
                </div>
                <div class="table-responsive">
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $key => $support)
                                <tr>
                                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold text--base"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                    <td data-label="@lang('Status')">
                                        @if($support->status == 0)
                                            <span class="badge badge--success">@lang('Open')</span>
                                        @elseif($support->status == 1)
                                            <span class="badge badge--info">@lang('Answered')</span>
                                        @elseif($support->status == 2)
                                            <span class="badge badge--primary">@lang('Customer Reply')</span>
                                        @elseif($support->status == 3)
                                            <span class="badge badge--danger">@lang('Closed')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Priority')">
                                        @if($support->priority == 1)
                                            <span class="badge badge--success">@lang('Low')</span>
                                        @elseif($support->priority == 2)
                                            <span class="badge badge--info">@lang('Medium')</span>
                                        @elseif($support->priority == 3)
                                            <span class="badge badge--danger">@lang('High')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="badge badge--success">
                                            <i class="fa fa-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="100%" class="text-center">@lang('No data found')</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <ul class="pagination justify-content-end">
                    {{$supports->links()}}
                </ul>
            </div>
        </div>
    </section>
@endsection
