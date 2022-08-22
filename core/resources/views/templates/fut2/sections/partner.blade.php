@php
    $partnerElements = getContent('partner.element');
@endphp

<div class="partner-section bg--section">
    <div class="container-fluid">
        <div class="partner-slider owl-theme owl-carousel">
            @foreach ($partnerElements as $item)
                <div class="partner__item">
                    <div class="partner-thumb">
                        <img src="{{ getImage('assets/images/frontend/partner/'.@$item->data_values->image,'120x50') }}" alt="partner">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
