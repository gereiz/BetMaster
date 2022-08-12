@php
   $counterElements = getContent('counter.element');
@endphp

<section class="counter-section pt-120 pb-120">
    <div class="container">
        <div class="row g-3 g-sm-3 g-md-4 justify-content-center">
            @foreach($counterElements as $item)
                <div class="col-sm-6 col-xl-3">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <div class="icon">
                                @php
                                    echo @$item->data_values->counter_icon;
                                @endphp
                            </div>
                        </div>
                        <div class="counter-content">
                            <div class="d-flex align-items-center">
                                <h3 class="rafcounter title text--base" data-counter-end="{{@$item->data_values->counter_digit}}">0</h3>
                            </div>
                            <div class="info">{{__(@$item->data_values->sub_title)}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
