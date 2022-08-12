@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="message__chatbox bg--body">
                            <div class="message__chatbox__header">
                                <h5 class="title">{{__($pageTitle)}}</h5>
                            </div>
                            <div class="message__chatbox__body">
                                <p class="text-center mt-2">@lang('You have requested') <b class="text-success">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                    <b class="text-success">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                                </p>
                                <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>

                                <div class="text-center instruction">
                                    @php echo  $data->gateway->description @endphp
                                </div>

                                <form class="message__chatbox__form row mt-4" action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    @if($method->gateway_parameter)
                                        @foreach(json_decode($method->gateway_parameter) as $k => $v)
                                            @if($v->type == "text")
                                                <div class="form--group col-sm-12">
                                                    <label for="fname" class="cmn--label">{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <input type="text" class="form-control form--control" name="{{$k}}" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == 'required') required @endif>
                                                </div>
                                            @elseif($v->type == "textarea")
                                                <div class="form--group col-sm-12">
                                                    <label for="fname" class="cmn--label">{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <textarea class="form-control form--control" name="{{$k}}" placeholder="{{__($v->field_level)}}" @if($v->validation == 'required') required @endif>{{old($k)}}</textarea>
                                                </div>
                                            @elseif($v->type == "file")
                                                <div class="form--group col-sm-12">
                                                    <label for="name" class="cmn--label">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <input type="file" class="form-control form--control" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    <div class="form--group col-sm-12 mb-0">
                                        <button type="submit" class="cmn--btn justify-content-center w-100">@lang('Pay Now')</button>
                                    </div>
                                </form>
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
        .message__chatbox__body .instruction *{
            text-align: center !important;
            color: white !important;
            font-size: 14px;
        }
    </style>
@endpush

