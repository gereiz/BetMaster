@extends($activeTemplate.'layouts.frontend')

@section('content')

    @include($activeTemplate.'partials.breadcrumb')

    <section class="about-section pt-60 pb-60 bg--section">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-12">
                    <div class="about-content pt-60 pb-60">
                        <div class="section__header">
                            <h3 class="section__title">{{__(@$policyDetails->data_values->title)}}</h3>
                            <div class="policy-content">
                                @php
                                    echo @$policyDetails->data_values->details
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .policy-content *{
            color: #FFFFFF !important;
        }
    </style>
@endpush
