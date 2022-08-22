@php
   $aboutContent = getContent('about.content',true);
@endphp

<section class="about-section pt-60 pb-60 bg--section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <div class="about-content pt-60 pb-60">
                    <div class="section__header">
                        <span class="section__category">@lang('About Us')</span>
                        <h3 class="section__title">{{__(@$aboutContent->data_values->heading)}}</h3>
                        <p>
                            {{__(@$aboutContent->data_values->details)}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="about--thumb">
                    <img src="{{ getImage('assets/images/frontend/about/'.@$aboutContent->data_values->image,'655x720') }}" alt="about">
                </div>
            </div>
        </div>
    </div>
</section>
