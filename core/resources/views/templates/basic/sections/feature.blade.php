@php
   $featureContent = getContent('feature.content',true);
   $featureElements = getContent('feature.element');
@endphp

<section class="feature-section pt-120 pb-120">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__category">@lang('Feature')</span>
            <h3 class="section__title">{{__(@$featureContent->data_values->heading)}}</h3>
            <p>
                {{__(@$featureContent->data_values->details)}}
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($featureElements as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="feature-item">
                        <div class="feature-icon text--base">
                            @php
                                echo @$item->data_values->icon
                            @endphp
                        </div>
                        <div class="feature-content">
                            <h5 class="title">{{__(@$item->data_values->heading)}}</h5>
                            <p>
                                {{__(@$item->data_values->heading)}}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
