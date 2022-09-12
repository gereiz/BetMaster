@php
    $leagues = App\Models\League::whereHas('category', function($q) {
            $q->where('status', 1);
        })->where('status', 1)->latest()->get();
@endphp

<div class="col sidebar left-sidebar">
    <aside class="sidebar-sticky">
        <span class="close--sidebar d-xl-none">
            <i class="las la-times"></i>
        </span>
        <div class="sidebar__widget">
            <div class="sidebar__widget-header">
                <h5 class="title">@lang('Categories')</h5>
            </div>
            <div class="sidebar__widget-body bg--section">
                <ul class="nav nav-tabs nav--tabs">
                    @forelse($categories as $item)
                        <li class="nav-item">
                            <a href="#name-{{$loop->index}}" class="nav-link @if($loop->first) active @endif" data-bs-toggle="tab">{{__($item->name)}}</a>
                        </li>
                    @empty
                        <li><i class="las la-battery-empty text--base"></i> <small>@lang('No category yet')</small></li>
                    @endforelse
                </ul>
                <div class="tab-content">
                    @foreach($categories as $item)
                        <div class="tab-pane fade @if($loop->first) show active @endif" id="name-{{$loop->index}}">
                            <ul class="sidebar-menu">
                                @forelse ($item->leagues->where('status', 1) as $item)
                                    <li>
                                        <a href="{{route('league.matches',[slug($item->name),$item->id])}}">
                                            @php echo $item->icon @endphp {{__($item->name)}}
                                        </a>
                                    </li>
                                @empty
                                    <li><i class="las la-battery-empty text--base"></i> <small>@lang('No league yet')</small></li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sidebar__widget">
            <div class="sidebar__widget-header">
                <h5 class="title">@lang('League')</h5>
            </div>
            <div class="sidebar__widget-body bg--section">
                <ul class="sidebar-menu">
                    @forelse ($leagues as $item)
                        <li>
                            <a href="{{route('league.matches',[slug($item->name),$item->id])}}">
                                @php echo $item->icon @endphp {{__($item->name)}}
                            </a>
                        </li>
                    @empty
                        <li><i class="las la-battery-empty text--base"></i> <small>@lang('No league yet')</small></li>
                    @endforelse

                </ul>
            </div>
        </div>
    </aside>
</div>
