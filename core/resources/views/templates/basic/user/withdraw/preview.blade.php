@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    <section class="dashboard-section bg--section pt-120">

        <div class="pb-120">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="withdraw-preview bg--body">
                        <div class="w-100 preview-header">
                            <h5 class="m-0">@lang('Current Balance') <span class="text--base">{{ showAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</span></h5>
                        </div>
                        <div class="withdraw-content">
                            <ul>
                                <li>
                                    @lang('Request Amount') : <span class="text--success">{{showAmount($withdraw->amount)  }} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('Withdrawal Charge') : <span class="text--danger">{{showAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('After Charge') : <span class="text--warning">{{showAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('Conversion Rate') : <span class="text--info">1 {{__($general->cur_text)}} = {{showAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</span>
                                </li>
                                <li>
                                    @lang('You Will Get') : <span class="text--primary">{{showAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                                </li>
                            </ul>
                            <h6 class="subtitle mt-4 mb-2">@lang('Balance Will be')</h6>
                            <div class="input-group">
                                <input type="text" value="{{showAmount($withdraw->user->balance - ($withdraw->amount))}}" class="form-control h--50px form--control" placeholder="@lanng('Enter Amount')" required readonly>
                                <span class="input-group-text form--control h--50px">
                                    {{ __($general->cur_text) }}
                                </span>
                            </div>
                        </div>
                        <div class="withdraw-form-area">
                            <form class="withdraw-form" action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                @if($withdraw->method->user_data)
                                    @foreach($withdraw->method->user_data as $k => $v)
                                        @if($v->type == "text")
                                            <div class="form--group">
                                                <label for="name" class="cmn--label">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                <input type="text" class="form-control form--control h--50px" name="{{$k}}" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>

                                                @if ($errors->has($k))
                                                    <small class="text-danger">{{ __($errors->first($k)) }}</small>
                                                @endif
                                            </div>

                                            @elseif($v->type == "textarea")
                                                <div class="form--group">
                                                    <label for="name" class="cmn--label">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <textarea class="form-control form--control h--50px" name="{{$k}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>

                                                    @if ($errors->has($k))
                                                        <small class="text-danger">{{ __($errors->first($k)) }}</small>
                                                    @endif
                                                </div>
                                            @elseif($v->type == "file")
                                                <div class="form--group">
                                                    <label for="name" class="cmn--label">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <input type="file" class="form-control form--control h--50px" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>

                                                    @if ($errors->has($k))
                                                        <small class="text-danger">{{ __($errors->first($k)) }}</small>
                                                    @endif
                                                </div>
                                            @endif
                                    @endforeach
                                @endif

                                @if(auth()->user()->ts)
                                    <div class="form-group mb-4">
                                        <label class="cmn--label">@lang('Google Authenticator Code') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form--control h--50px" name="authenticator_code" required>
                                    </div>
                                @endif
                                <div class="form--group mb-0">
                                    <button type="submit" class="cmn--btn btn-block justify-content-center w-100">Pay Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

