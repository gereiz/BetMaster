@php
    $strategyContent = getContent('strategy.content',true);
    $strategyElements = getContent('strategy.element');
@endphp

<section class="how-to-start bg--section pt-120 pb-120">
    <div class="container">
        <div class="section__header section__header__center">
            <span class="section__category">@lang('Strategy')</span>
            <h3 class="section__title">{{__(@$strategyContent->data_values->heading)}}</h3>
            <p>
                {{__(@$strategyContent->data_values->details)}}
            </p>
        </div>
        <div class="row gy-5">
            @foreach ($strategyElements as $item)
                <div class="col-lg-4">
                    <div class="how-item">
                        <div class="how-thumb">
                            @php
                                echo @$item->data_values->icon;
                            @endphp
                        </div>
                        <div class="how-content">
                            <h5 class="title">{{__(@$item->data_values->heading)}}</h5>
                            <p>
                                {{__(@$item->data_values->details)}}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
