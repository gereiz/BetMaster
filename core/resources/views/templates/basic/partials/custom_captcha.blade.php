@php
	$captcha = loadCustomCaptcha();
@endphp

@if($captcha)
    <div class="cmn--form--group form-group col-md-12">
        @php echo $captcha @endphp
    </div>
    <div class="cmn--form--group form-group col-md-12 w-100">
        <div class="input-group">
            <span class="input-group-text">
                <i class="las la-code"></i>
            </span>
            <input type="text" class="form-control form--control" name="captcha" placeholder="@lang('Enter Code')">
        </div>
    </div>
@endif
