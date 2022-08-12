@extends($activeTemplate.'layouts.frontend')
@section('content')

    @php
        $bannerElements = getContent('banner.element');
    @endphp

    <main class="all-sections">
        <div class="container-fluid">
            <div class="row g-4">
                @include($activeTemplate.'partials.leftbar')

                <article class="col main-section">
                    @if(Request::routeIs('home'))
                        <div class="banner-wrapper owl-theme owl-carousel mb-5">
                            @foreach ($bannerElements as $item)
                                <div class="banner-item">
                                    <a href="{{@$item->data_values->url}}" class="d-block">
                                        <img src="{{ getImage('assets/images/frontend/banner/'.@$item->data_values->image,'1150x650') }}" alt="banner">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="predict__wrapper">
                        <div class="predict__header">
                            <h5 class="predict__header-title">
                                @if(Request::routeIs('home'))
                                    @lang('Live Matches')
                                @else
                                    {{__($pageTitle)}}
                                @endif
                            </h5>
                        </div>
                        <div class="predict__area bg--section">
                            @forelse ($matches as $item)
                                <div class="predict__item bg--body">
                                    <div class="predict__item-header">
                                        <h6 class="predict__item-title">
                                            <a href="{{route('match.details',[slug($item->name),$item->id])}}">{{__($item->name)}}</a>
                                        </h6>

                                        @if($item->questions->count() > 1)
                                            <a href="{{route('match.details',[slug($item->name),$item->id])}}" class="view--all">@lang('More Questions')</a>
                                        @endif
                                    </div>

                                    @if($item->questions->count())
                                        <h6 class="subtitle">{{__($item->questions->first()->name)}} </h6>
                                        <ul class="predicts">
                                            @foreach ($item->questions->first()->options as $data)
                                                @auth
                                                    <li>
                                                        <a href="#predictModal" class="nav-link bet-info" data-bs-toggle="modal" data-resource="{{$data}}" data-question="{{__($item->questions->first()->name)}}" data-match="{{__($item->name)}}">
                                                            <span>{{__($data->name)}} </span>
                                                            <span>{{getAmount($data->dividend)}} : {{getAmount($data->divisor)}}</span>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="#loginModal" class="nav-link" data-bs-toggle="modal" >
                                                            <span>{{__($data->name)}} </span>
                                                            <span>{{getAmount($data->dividend)}} : {{getAmount($data->divisor)}}</span>
                                                        </a>
                                                    </li>
                                                @endauth
                                            @endforeach
                                        </ul>
                                    @else
                                    <div class="empty-div">
                                        <span><small>@lang('No question yet')</small></span>
                                    </div>
                                    @endif
                                </div>
                            @empty
                                <ul class="predicts">
                                    <li>
                                        <div class="empty-div">
                                            <span><small>@lang('No match yet')</small></span>
                                        </div>
                                    </li>
                                </ul>
                            @endforelse

                        </div>
                        <ul class="pagination justify-content-center">
                            {{$matches->links()}}
                        </ul>
                    </div>
                </article>

                @include($activeTemplate.'partials.rightbar')

            </div>
        </div>
    </main>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
