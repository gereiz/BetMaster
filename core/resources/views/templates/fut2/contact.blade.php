@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    @php
        $contactContent = getContent('contact_us.content',true);
        $contactElements = getContent('contact_us.element');
    @endphp

    <section class="contact-section bg--section pt-120 pb-120 overflow-hidden">
        <div class="container">
            <div class="row justify-content-between align-items-end">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="contact--thumb rtl">
                        <img src="{{ getImage('assets/images/frontend/contact_us/'.@$contactContent->data_values->image,'655x720') }}" alt="contact">
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="section__header">
                        <span class="section__category">@lang('Contact')</span>
                        <h3 class="section__title">{{__(@$contactContent->data_values->heading)}}</h3>
                        <p>
                            {{__(@$contactContent->data_values->details)}}
                        </p>
                    </div>
                    <form class="contact-form" method="POST">
                        @csrf
                        <div class="form--group">
                            <label class="form-label">@lang('Name')</label>
                            <input type="text" name="name" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->fullname }} @else {{ old('name') }} @endif" @if(auth()->user()) readonly @else required @endif>
                        </div>
                        <div class="form--group">
                            <label for="email" class="form-label">@lang('Email')</label>
                            <input type="email" name="email" class="form-control form--control" value="@if(auth()->user()) {{ auth()->user()->email }} @else {{old('email')}} @endif" @if(auth()->user()) readonly @else required @endif>
                        </div>
                        <div class="form--group">
                            <label for="phone" class="form-label">@lang('Subject')</label>
                            <input type="text" name="subject" class="form-control form--control" value="{{old('subject')}}" required>
                        </div>
                        <div class="form--group">
                            <label for="message" class="form-label">@lang('Message')</label>
                            <textarea name="message" id="message" class="form-control form--control">{{old('message')}}</textarea>
                        </div>
                        <div class="form--group mb-0">
                            <button class="cmn--btn" type="submit">@lang('Send Message')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center g-4">
                @foreach($contactElements as $item)
                    <div class="col-sm-10 col-md-6 col-lg-4">
                        <div class="contact-item">
                            <div class="contact-thumb">
                                @php
                                    echo @$item->data_values->icon
                                @endphp
                            </div>
                            <div class="contact-content">
                                <h6 class="title">{{__(@$item->data_values->heading)}}</h6>
                                <p class="mt-2">{{__(@$item->data_values->details)}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
