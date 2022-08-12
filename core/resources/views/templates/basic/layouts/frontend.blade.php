<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{ $general->sitename(__($pageTitle)) }}</title>

    @include('partials.seo')

    <!--CSS -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/owl.min.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/main.css')}}">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php?color1='.$general->base_color)}}">

    @stack('style-lib')

    @stack('style')
</head>
<body>

    <div class="preloader">
        <div class="ball"></div>
    </div>
    <a href="javascript:void(0)" class="scrollToTop"><i class="las la-angle-up"></i></a>

    @include($activeTemplate.'partials.header')
        @yield('content')
    @include($activeTemplate.'partials.footer')

    <!-- Prediction Modal -->
    <div class="modal cmn--modal fade" id="predictModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col text-center match-name"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="final-bet-submit" action="{{route('user.bet.store')}}" method="POST">
            <div class="modal-body">
                    @csrf
                    <input type="hidden" name="option_id">
                    <div class="predict-content">
                        <h6 class="subtitle betting-details"></h6>


                        <div class="form-group text-start">
                            <div class="row">
                                <div class="form-group">
                                    <label for="amount" class="mb-2">@lang('Enter Bet Amount')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" id="invest-amount" name="invest_amount" min="{{ $general->min_limit }}" max="{{ $general->max_limit }}" class="form-control form--control" required>
                                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                                    </div>

                                    <div>
                                        @lang('Minimum Limit') : <b class="text--info">{{__($general->cur_sym)}}{{getAmount($general->min_limit)}} - {{__($general->cur_sym)}}{{getAmount($general->max_limit)}}</b>
                                    </div>

                                    <div>
                                        @lang('Maximum Limit') : <b class="text--info">{{__($general->cur_sym)}}{{getAmount($general->min_limit)}} - {{__($general->cur_sym)}}{{getAmount($general->max_limit)}}</b>
                                    </div>

                                    <h6 class="mt-2 text-center">
                                        @lang('You will get') <span class="text--success" id="return-amount">0.00 {{__($general->cur_text)}}</span> @lang('if you win')
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg bg--danger text--white border-0 fz--16" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-lg btn--success border-0 fz--16">@lang('Proceed')</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    <div class="modal cmn--modal fade" id="loginModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col text-center" >@lang('Login Required')</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="predict-content">
                    <h6 class="subtitle">
                        @lang('Placing Bet Requires Login')
                    </h6>
                    <div class="be-in-limit">
                        <span>@lang('If you are already with us then please ')</span> <span><a href="{{route('user.login')}}" class="text--base">@lang('login')</a></span> <span>@lang('otherwisw')</span> <span><a href="{{route('user.register')}}" class="text--base">@lang('register')</a></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-lg bg--danger text--white border-0 fz--16" data-bs-dismiss="modal">@lang('Close')</button>
              <a href="{{route('user.login')}}" class="btn btn-lg btn--success border-0 fz--16">@lang('Login')</a>
            </div>
          </div>
        </div>
    </div>

    @php
        $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
    @endphp

    @if(@$cookie->data_values->status && !session('cookie_accepted'))
        <div class="cookie-remove">
            <div class="cookie__wrapper bg--section">
                <div class="container">
                    <div class="flex-wrap align-items-center justify-content-between">
                        <h4 class="title">@lang('Cookie Policy')</h4>
                        <div class="txt my-2">
                            @php echo @$cookie->data_values->description @endphp
                        </div>
                        <div class="button-wrapper">
                            <button class="cmn--btn policy cookie">@lang('Accept')</button>
                            <a class="cmn--btn" href="{{ @$cookie->data_values->link }}" target="_blank" class=" mt-2">@lang('Read Policy')</a>
                            <a href="javascript:void(0)" class="btn--close cookie-close"><i class="las la-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{asset('assets/global/js/bootstrap.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/rafcounter.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/magnific-popup.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/owl.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/yscountdown.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function ($) {
            "use strict";

            $(".langSel").on("change", function() {
                window.location.href = "{{route('home')}}/change/"+$(this).val() ;
            });

            $('.cookie').on('click',function () {
                var url = "{{ route('cookie.accept') }}";

                $.get(url,function(response){

                    if(response.success){
                        notify('success',response.success);
                        $('.cookie-remove').html('');
                    }
                });
            });

            $('.cookie-close').on('click',function () {
                $('.cookie-remove').html('');
            });

            var investRate = 0;
            var returnRate = 0;
            var investAmount = 0;

            $(document).on("click", ".bet-info", function() {
                var modal = $('#predictModal');
                var resource = $(this).data('resource');
                var question = $(this).data('question');
                var matchName = $(this).data('match');
                var betDetails = `<span class="text--base">${question}</span> <br><small>@lang('You are betting for ')${resource.name}</small>`;
                modal.find("input[name='option_id']").val(resource.id);
                investRate = resource.dividend;
                returnRate = resource.divisor;
                investAmount = modal.find('#invest-amount').val();
                returnAmount(investAmount);
                modal.find('.betting-details').html(betDetails);
                modal.find('.match-name').text(matchName);
            });


            $(document).on("input", "#invest-amount", function() {
                investAmount = $(this).val();
                returnAmount(investAmount);
            });

            function returnAmount(investAmount){
                var returnAmount = (parseFloat(investAmount).toFixed(2) / parseFloat(investRate).toFixed(2)) * parseFloat(returnRate).toFixed(2);
                if (returnAmount) {
                    $(document).find('#return-amount').text(parseFloat(returnAmount).toFixed(2) + ' {{__($general->cur_text)}}');
                }else{
                    $(document).find('#return-amount').text('0.00 {{__($general->cur_text)}}');
                }
            }

        })(jQuery);
    </script>

</body>
</html>
