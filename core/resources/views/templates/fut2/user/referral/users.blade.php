@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="text-end mb-4">
                    @for($i = 1; $i <= $lev; $i++)
                        <a href="{{route('user.referral.users',$i)}}" class="cmn--btn btn--sm">@lang('Level '.$i)</a>
                    @endfor
                </div>
                <div class="table-responsive">
                    <table class="table cmn--table">
                        <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Fullname')</th>
                                <th scope="col">@lang('Joined At')</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{ showUserLevel(auth()->user()->id, $levelNo) }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
