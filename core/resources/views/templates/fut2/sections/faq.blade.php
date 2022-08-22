@php
    $faqContent = getContent('faq.content',true);
    $faqElements = getContent('faq.element');
@endphp

<div class="faqs-sectioin pt-120 pb-120 bg--section">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__category">@lang('FAQs')</span>
            <h3 class="section__title">{{__(@$faqContent->data_values->heading)}}</h3>
            <p>
                {{__(@$faqContent->data_values->details)}}
            </p>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="faq--thumb">
                    <img src="{{ getImage('assets/images/frontend/faq/'.@$faqContent->data_values->image,'655x720') }}" alt="faq">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq__wrapper">
                    @foreach ($faqElements as $item)
                        <div class="faq__item @if($loop->first) open active @endif">
                            <div class="faq__title">
                                <h6 class="title">
                                    {{__(@$item->data_values->question)}}
                                </h6>
                                <span class="right__icon"></span>
                            </div>
                            <div class="faq__content">
                                <p>
                                    {{__(@$item->data_values->answer)}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
