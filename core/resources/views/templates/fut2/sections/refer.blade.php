@php
    $referContent = getContent('refer.content',true);
    $referElements = getContent('refer.element',false,null,true);
@endphp

<section class="referral-section  bg--section pt-60 pb-60 overflow-hidden">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 col-xl-5">
                <div class="referral--content pb-60 pt-60">
                    <div class="section__header">
                        <span class="section__category">@lang('Referral')</span>
                        <h3 class="section__title">{{__(@$referContent->data_values->heading)}}</h3>
                        <p>
                            {{__(@$referContent->data_values->details)}}
                        </p>
                    </div>
                    <div class="row g-3 g-sm-4">
                        @foreach($referElements as $item)
                        <div class="col-md-12">
                            <div class="referral__item">
                                <h5 class="referral__item-thumb">
                                    <span class="d-block">{{__(@$item->data_values->percentage)}}%</span>
                                </h5>
                                <div class="referral__item-content">
                                    <h6 class="title">{{__(@$item->data_values->level_no)}}</h6>
                                    <p>
                                        {{__(@$item->data_values->details)}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="referral--thumb">
                    <img src="{{ getImage('assets/images/frontend/refer/'.@$referContent->data_values->image,'655x720') }}" alt="referral">
                </div>
            </div>
        </div>
    </div>
</section>
