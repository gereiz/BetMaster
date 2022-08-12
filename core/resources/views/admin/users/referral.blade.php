@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Phone')</th>
                                <th scope="col">@lang('Joined At')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($referrals as $referral)
                                <tr>
                                    <td data-label="@lang('SL')">
                                        {{ $referrals->firstItem() + $loop->index }}
                                    </td>
                                    <td data-label="@lang('Username')"> <a href="{{ route('admin.users.detail', $referral->id) }}"><span>@</span>{{ $referral->username }}</a></td>
                                    <td data-label="@lang('User')">{{ __($referral->fullname) }}</td>
                                    <td data-label="@lang('Email')">{{ __($referral->email) }}</td>
                                    <td data-label="@lang('Phone')">{{ __($referral->mobile) }}</td>
                                    <td data-label="@lang('Joined At')">{{ showDateTime($referral->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('User Not Found')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if($referrals->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($referrals) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
