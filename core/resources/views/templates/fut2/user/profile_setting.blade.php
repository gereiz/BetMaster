@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="profile-wrapper bg--body">
                    <div class="profile-user mb-lg-0">
                        <div class="thumb">
                            @if($user->image)
                                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. $user->image,imagePath()['profile']['user']['size']) }}" alt="user">
                            @else
                                <img src="{{ asset('assets/images/avatar.png') }}" alt="user">
                            @endif
                        </div>
                        <div class="content">
                            <h6 class="title">@lang('Name'): {{__($user->fullname)}}</h6>
                            <span class="subtitle">@lang('Username'): {{$user->username}}</span>
                        </div>
                    </div>
                    <div class="profile-form-area">
                        <form class="profile-edit-form row mb--25" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="first-name">@lang('First Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="firstname" value="{{$user->firstname}}" minlength="3" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="last-name">@lang('Last Name') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control"  name="lastname" value="{{$user->lastname}}" minlength="3" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="email">@lang('E-mail Address') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" value="{{$user->email}}" readonly>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="mobile">@lang('Mobile Number') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" value="{{$user->mobile}}" readonly>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="address">@lang('Address') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="address" value="{{@$user->address->address}}" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="state">@lang('State') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="state" value="{{@$user->address->state}}" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="zip">@lang('Zip') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="zip" value="{{@$user->address->zip}}" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="city">@lang('City') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" name="city" value="{{@$user->address->city}}" required>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="country">@lang('Country') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form--control" value="{{@$user->address->country}}" disabled>
                            </div>
                            <div class="form--group col-md-6">
                                <label class="cmn--label" for="profile-image">@lang('Profile Picture')</label>
                                <input type="file" class="form-control form--control" name="image" accept="image/*">
                            </div>
                            <div class="form--group w-100 col-md-6 mb-0 text-end">
                                <button type="submit" class="cmn--btn w-100 justify-content-center">@lang('Update Profile')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
