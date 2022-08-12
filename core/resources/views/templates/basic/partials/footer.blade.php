@php
    $policyElements =  getContent('policy_pages.element');
    $socialIcons =  getContent('social_icon.element',false);
@endphp

<footer>
    <div class="pt-80 pb-80">
        <div class="container">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="footer__widget text--white">
                        <div class="logo">
                            <a href="{{route('home')}}" class="d-block">
                                <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" class="w-100" alt="logo">
                            </a>
                        </div>
                        <p class="mt-3">
                            {{__(@$headerFooterContent->data_values->footer_text)}}
                        </p>
                        <ul class="social__icons">
                            @foreach($socialIcons as $icon)
                                <li>
                                    <a href="{{$icon->data_values->url}}" target="_blank">
                                        @php
                                            echo $icon->data_values->social_icon;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer__widget">
                        <h5 class="widget__title text--white">@lang('Quick Links')</h5>
                        <ul class="footer__links">
                            <li><a href="{{route('home')}}">@lang('Home')</a></li>

                            @foreach($pages as $k => $data)
                                <li><a href="{{route('pages',[$data->slug])}}">{{__($data->name)}}</a></li>
                            @endforeach
                            <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer__widget">
                        <h5 class="widget__title text--white">@lang('Company Policy')</h5>
                        <ul class="footer__links">
                            @foreach ($policyElements as $item)
                                <li><a href="{{route('policy.details',[slug(@$item->data_values->title),$item->id])}}">{{__(@$item->data_values->title)}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 col-md-6">
                    <div class="footer__widget text--white">
                        <h5 class="widget__title text--white">{{__(@$headerFooterContent->data_values->subscribe_heading)}}</h5>
                        <p class="m-0 mb-3">
                            {{__(@$headerFooterContent->data_values->subscribe_details)}}
                        </p>
                        <form class="newsletter-form">
                            <div class="newsletter-form-group">
                                <input type="email" id="subscriber" class="form-control" placeholder="@lang('Your Email Address')" name="email" required>
                                <button type="button" class="cmn--btn subs">@lang('Subscribe Now')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text--white text-center">
        <div class="container">
            {{__(@$headerFooterContent->data_values->copyright)}} <a href="{{route('home')}}" class="text--base">{{$general->sitename}}</a>
        </div>
    </div>
</footer>

@push('script')
    <script>
        'use strict';

        (function ($) {
            $('.subs').on('click',function () {
                var email = $('#subscriber').val();
                var csrf = '{{csrf_token()}}'
                var url = "{{ route('subscriber.store') }}";
                var data = {email:email, _token:csrf};

                $.post(url, data,function(response){
                    if(response.success){
                        notify('success', response.success);
                        $('#subscriber').val('');
                    }else{
                        notify('error', response.error);
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
