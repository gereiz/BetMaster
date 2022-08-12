@extends($activeTemplate.'layouts.frontend')
@section('content')

    <main class="all-sections">
        <div class="container-fluid">
            <div class="row g-4">
                @include($activeTemplate.'partials.leftbar')

                <article class="col main-section">
                    <div class="predict__wrapper">
                        <div class="predict__header">
                            <h5 class="predict__header-title">
                                {{__($pageTitle)}}
                            </h5>
                        </div>
                        <div class="predict__area bg--section">
                            @forelse ($questions as $item)
                                <div class="predict__item bg--body">
                                    <h6 class="subtitle">{{__($item->name)}} </h6>

                                    <ul class="predicts">
                                        @foreach ($item->options as $data)
                                            @auth
                                                <li>
                                                    <a href="#predictModal" class="nav-link bet-info" data-bs-toggle="modal" data-resource="{{$data}}" data-question="{{__($item->name)}}" data-match="{{__($item->name)}}">
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
                                </div>
                            @empty
                                <ul class="predicts">
                                    <li>
                                        <div class="empty-div">
                                            <span><small>@lang('No question yet')</small></span>
                                        </div>
                                    </li>
                                </ul>
                            @endforelse

                        </div>
                        <ul class="pagination justify-content-center">
                            {{$questions->links()}}
                        </ul>
                    </div>
                </article>

                @include($activeTemplate.'partials.rightbar')
            </div>
        </div>
    </main>
@endsection
