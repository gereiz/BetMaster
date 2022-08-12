@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="blog-section bg--section pt-120 pb-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
				<div class="col-lg-8">
					<div class="post__details pb-50">
                        <div class="post__thumb">
							<img src="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'600x400') }}" alt="blog">
						</div>
						<div class="post__header">
							<h3 class="post__title">
								{{__(@$blog->data_values->title)}}
							</h3>
						</div>
                        <div class="blog-details mb-4">
                            @php
                                echo @$blog->data_values->description_nic;
                            @endphp
                        </div>

						<div class="row gy-4 justify-content-between">

							<div class="col-md-12">
								<h6 class="post__share__title">Share now</h6>
								<ul class="post__share">
                                    <li><a href="http://www.facebook.com/sharer.php?u={{urlencode(url()->current())}}&p[title]={{slug(@$blog->data_values->title)}}" target="_blank" title="@lang('Facebook')"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="http://twitter.com/share?text={{slug(@$blog->data_values->title)}}&url={{urlencode(url()->current()) }}" target="_blank" title="@lang('Twitter')" class="active"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="http://pinterest.com/pin/create/button/?url={{urlencode(url()->current()) }}&description={{slug(@$blog->data_values->title)}}" target="_blank" title="@lang('Pinterest')"><i class="lab la-pinterest-p"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url()->current()) }}&title={{slug(@$blog->data_values->title)}}" target="_blank" title="@lang('Linkedin')"><i class="lab la-linkedin-in"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<aside class="blog-sidebar bg--body">
						<div class="widget widget__post__area">
							<h4 class="widget__title">@lang('Recent Post')</h4>
							<ul>
                                @forelse ($recentPosts as $item)
                                    <li>
                                        <a href="{{route('blog.details',[$item->id,slug($item->data_values->title)])}}" class="widget__post">
                                            <div class="widget__post__thumb">
                                                <img src="{{ getImage('assets/images/frontend/blog/'.@$item->data_values->image,'600x400') }}" alt="blog">
                                            </div>
                                            <div class="widget__post__content">
                                                <h6 class="widget__post__title">
                                                    {{str_limit(__(@$item->data_values->title),40)}}
                                                </h6>
                                                <span>{{showDateTime(@$item->created_at,'d F Y')}}</span>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <div class="widget__post__content">
                                            <h6 class="widget__post__title">
                                                @lang('No data found')
                                            </h6>
                                        </div>
                                    </li>
                                @endforelse

							</ul>
						</div>
					</aside>
				</div>
			</div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .blog-details *{
            color: #FFFFFF;
        }
    </style>
@endpush

@push('shareImage')
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ __(@$blog->data_values->title) }}">
    <meta itemprop="description" content="{{ strip_tags(__(@$blog->data_values->description_nic)) }}">
    <meta itemprop="image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'600x400') }}">

    <!-- Facebook Meta Tags -->
    <meta property="og:image" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'600x400') }}"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __(@$blog->data_values->title) }}">
    <meta property="og:description" content="{{ strip_tags(__(@$blog->data_values->description_nic)) }}">
    <meta property="og:image:type" content="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->image,'600x400') }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="400" />
    <meta property="og:url" content="{{ url()->current() }}">
@endpush

