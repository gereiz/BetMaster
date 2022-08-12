@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="blog-section bg--section pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8"></div>
                <div class="col-lg-4"></div>
            </div>
            <div class="row justify-content-center g-4">
                @forelse($blogs as $item)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="post__item">
                            <div class="post__thumb">
                                <a href="{{route('blog.details',[$item->id,slug($item->data_values->title)])}}">
                                    <img src="{{ getImage('assets/images/frontend/blog/'.@$item->data_values->image,'600x400') }}" alt="blog">
                                </a>
                                <span class="category">
                                    {{__(@$item->data_values->tag)}}
                                </span>
                            </div>
                            <div class="post__content">
                                <h6 class="post__title">
                                    <a href="{{route('blog.details',[$item->id,slug($item->data_values->title)])}}">{{str_limit(__(@$item->data_values->title),55)}}</a>
                                </h6>
                                <div class="meta__date">
                                    <div class="meta__item">
                                        <i class="las la-calendar"></i>
                                        {{showDateTime(@$item->created_at,'d M, Y')}}
                                    </div>
                                </div>
                                <a href="{{route('blog.details',[$item->id,slug($item->data_values->title)])}}" class="post__read">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-6 col-md-6 col-sm-10">
                        <div class="post__item">
                            <div class="post__content">
                                <h6 class="post__title text-center">
                                    @lang('No data found')
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <ul class="pagination justify-content-center">
                {{$blogs->links()}}
            </ul>
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
