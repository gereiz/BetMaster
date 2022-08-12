@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="dashboard-section bg--section pt-120">
        <div class="container">
            <div class="pb-120">
                <div class="message__chatbox bg--body">
                    <div class="message__chatbox__header">
                        <h6 class="title">
                            @if($my_ticket->status == 0)
                                <span class="badge badge--info py-2 px-3">@lang('Open')</span>
                            @elseif($my_ticket->status == 1)
                                <span class="badge badge--success py-2 px-3">@lang('Answered')</span>
                            @elseif($my_ticket->status == 2)
                                <span class="badge badge--info py-2 px-3">@lang('Replied')</span>
                            @elseif($my_ticket->status == 3)
                                <span class="badge badge--danger py-2 px-3">@lang('Closed')</span>
                            @endif
                            [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                        </h6>

                        <a href="#0" class="cmn--btn bg-danger px-2" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i></a>
                    </div>
                    <div class="message__chatbox__body">
                        <form class="message__chatbox__form row" action="{{ route('ticket.reply', $my_ticket->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="replayTicket" value="1">
                            <div class="form--group col-sm-12">
                                <label class="cmn--label">@lang('Your Reply')</label>
                                <textarea class="form-control form--control" name="message"></textarea>
                            </div>
                            <div class="form--group col-sm-12">
                                <div class="d-flex">
                                    <div class="left-group col p-0">
                                        <label for="file2" class="cmn--label">@lang('Attachments')</label>
                                        <input type="file" class="overflow-hidden form-control form--control mb-2" name="attachments[]">

                                        <div id="fileUploadsContainer"></div>

                                        <span class="info fs--14">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</span>
                                    </div>
                                    <div class="add-area">
                                        <label class="cmn--label d-block">&nbsp;</label>
                                        <a href="javascript:void(0)" class="cmn--btn btn--sm bg--base ms-2 ms-md-4 form--control addFile" type="button"><i class="las la-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form--group col-sm-12 mb-0">
                                <button type="submit" class="cmn--btn"><i class="fa fa-reply"></i> @lang('Reply')</button>
                            </div>
                        </form>
                    </div>

                    <div class="message__chatbox bg--body">
                        <div class="message__chatbox__body">
                            <ul class="reply-message-area">
                                <li>
                                    @foreach($messages as $message)
                                        @if($message->admin_id == 0)
                                            <div class="reply-item">
                                                <div class="name-area">
                                                    <h6 class="title">{{ $message->ticket->name }}</h6>
                                                </div>
                                                <div class="content-area">
                                                    <span class="meta-date">
                                                        @lang('Posted on') <span class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                                    </span>
                                                    <p>
                                                        {{$message->message}}
                                                    </p>

                                                    @if($message->attachments()->count() > 0)
                                                        <div class="mt-2">
                                                            @foreach($message->attachments as $k=> $image)
                                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3 text--base"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                            @endforeach
                                                        </div>
                                                @endif
                                                </div>
                                            </div>
                                        @else
                                            <ul>
                                                <li>
                                                    <div class="reply-item">
                                                        <div class="name-area">
                                                            <h6 class="title">{{ $message->admin->name }}</h6>
                                                        </div>
                                                        <div class="content-area">
                                                            <span class="meta-date">
                                                                @lang('Posted on') <span class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                                            </span>
                                                            <p>
                                                                {{$message->message}}
                                                            </p>

                                                            @if($message->attachments()->count() > 0)
                                                                <div class="mt-2">
                                                                    @foreach($message->attachments as $k=> $image)
                                                                        <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3 text--base"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        @endif
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade cmn--modal" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>
                        <span data-bs-dismiss="modal"><i class="las la-times"></i></span>
                    </div>
                    <div class="modal-body">
                        <strong>@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger " data-bs-dismiss="modal"><i class="las la-times"></i>
                            @lang('Close')
                        </button>
                        <button type="submit" class="btn btn--success"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="input-group">
                        <input type="file" class="overflow-hidden form-control form--control mt-2 mb-2" name="attachments[]">
                        <div class="input-group-append support-input-group">
                            <a href="javascript:void(0)" class="input-group-text cmn--btn btn--sm bg--danger ms-2 ms-md-4 remove-btn">x</a>
                        </div>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
