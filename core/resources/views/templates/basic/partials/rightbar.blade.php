
@php
    $upcomingMatches = App\Models\Match::where('status', 1)->whereHas('category', function($q) {
            $q->where('status', 1);
        })->whereHas('league', function($query) {
            $query->where('status', 1);
        })->where('start_time', '>=', now())->latest()->limit(10)->get();

    $recentWinners = App\Models\Bet::where('status',1)->latest()->limit(10)->with('user')->get(['user_id','return_amount']);
@endphp
<div class="col sidebar right-sidebar">
    <aside class="sidebar-sticky">
        @if($upcomingMatches->count())
        <div class="sidebar__widget">
            <div class="sidebar__widget-header">
                <h5 class="title">@lang('Upcoming Matches')</h5>
            </div>
            <div class="sidebar__widget-body bg--section">
                <ul class="upcoming__matches">
                    @foreach ($upcomingMatches as $item)
                        <li class="upcoming__item">
                            <h6 class="upcoming__item-title">{{__($item->name)}}</h6>
                            <div class="countdown" data-countdown="{{showDateTime($item->start_time,'Y-m-d')}}"></div>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="sidebar__widget">
            <div class="sidebar__widget-header">
                <h5 class="title">@lang('Recent Winners')</h5>
            </div>
            <div class="sidebar__widget-body bg--section">
                <ul class="winner-list">
                    @forelse ($recentWinners as $item)
                        <li>
                            <a href="javascript:void(0)">
                                <span class="name">{{__($item->user->fullname)}}</span>
                                <span class="amount text--base">{{getAmount($item->return_amount)}} {{__($general->cur_text)}}</span>
                            </a>
                        </li>
                    @empty
                        <li><i class="las la-battery-empty text--base"></i> <small>@lang('No winner yet')</small></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </aside>
</div>
