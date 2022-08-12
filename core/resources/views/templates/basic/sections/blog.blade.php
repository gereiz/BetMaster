@php
    $blogContent = getContent('blog.content',true);
    $blogElements = getContent('blog.element',false,3);
@endphp

<section class="blog-section pt-120 pb-120">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__category">@lang('Blog')</span>
            <h3 class="section__title">{{__(@$blogContent->data_values->heading)}}</h3>
            <p>
                {{__(@$blogContent->data_values->details)}}
            </p>
        </div>
        <div class="row gy-5">
            @forelse($blogElements as $item)
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
    </div>
</section>
