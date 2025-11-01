@extends('admin.panel.layout.master')
@php
    $lastDate = '';
@endphp
@section('style')
    <link rel="stylesheet" href="{{ asset('admin-assets/panel-assets/css/TicketMessages.css') }}"/>
@endsection
@section('content')
    <section class="ticket-messages-section">
        <div class="card">
            <div class="card-header ticket-messages-card-header">
                <h2 class="ticket-messages-card-header-title">{{ $ticket->title }}</h2>
                <span class="ticket-messages-card-header-id">{{ $ticket->uuid }}#</span>
            </div>
            <div class="card-body">

                @foreach($ticket->comments as $comment)
                    @if(jdate($comment->created_at)->format('Y/m/d') != $lastDate)
                        @php $lastDate = jdate($comment->created_at)->format('Y/m/d'); @endphp
                        <div class="ticket-message-divider-date">
                            <span
                                class="ticket-message-divider-date-text">{{ jdate($comment->created_at)->format('Y/m/d') }}</span>
                        </div>
                    @endif
                    @if($comment->user_type == 2)
                        <div class="mt-2">
                            <div class="ticket-message-user-box-wrapper">
                                <div class="ticket-message-text">
                                    {{ $comment->comment }}
                                </div>
                                <div class="ticket-message-footer">
                                    <div>
                                        <span class="ticket-message-footer-ip">IP: {{ $comment->ip }}</span>
                                    </div>
                                    <div>
                                        <span
                                            class="ticket-message-footer-clock">{{ jdate($comment->created_at)->format('H:i') }}</span>
                                    </div>
                                </div>
                                @if($comment->file)
                                    <div class="attachment-wrapper">
                                        <a href="{{ $comment->file->path }}" class="attachment-link">
                                            <i class="bi bi-file-earmark bi-filetype-{{ $comment->file->extension }} attachment-icon"></i>
                                            <div class="attachment-details">
                                                <p class="attachment-name">{{ $comment->file->name }}</p>
                                                <p class="attachment-size">{{$comment->file->size}} کیلوبایت</p>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif($comment->user_type == 1)
                        <div class="mt-2" style="direction: ltr;">
                            <div class="ticket-message-admin-box-wrapper">
                                <div class="ticket-message-text">
                                    {{ $comment->comment }}
                                </div>
                                <div class="ticket-message-footer">
                                    <div>
                                        <span
                                            class="ticket-message-footer-clock">{{ jdate($comment->created_at)->format('H:i') }}</span>
                                    </div>
                                    <div>
                                        <span
                                            class="ticket-message-footer-admin-name">{{ $comment->user->fname }}
                                        </span>
                                    </div>
                                </div>
                                @if($comment->file)
                                    <div class="attachment-wrapper">
                                        <a href="{{ $comment->file->path }}" class="attachment-link">
                                            <i class="bi bi-file-earmark bi-filetype-{{ $comment->file->extension }} attachment-icon"></i>
                                            <div class="attachment-details">
                                                <p class="attachment-name">{{ $comment->file->name }}</p>
                                                <p class="attachment-size">{{$comment->file->size}} کیلوبایت</p>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="card-footer">
                <form enctype="multipart/form-data"
                      action="{{ route('admin.ticket-comment.send', ['uuid' => $ticket->uuid, 'ticket_id' => $ticket->id]) }}"
                      method="post" autocomplete="off">
                    @csrf
                    <textarea style="resize: none;" rows="7" class="form-control" name="comment"
                              placeholder="پیغام خود را بنویسید..."></textarea>
                    <div class="mt-2">
                        <label for="fileAttachment" class="form-label" style="color: var(--white);">فایل پیوست:</label>
                        <input type="file" class="form-control" id="fileAttachment" name="file">
                    </div>
                    <div class="mt-2 text-center">
                        <button class="btn btn-primary rounded">
                            <svg width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"
                                 aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M3.928 10.027a.882.882 0 0 0-1.178.83v1.046c0 2.958 0 4.437.919 5.356.919.919 2.398.919 5.355.919h3.952c2.957 0 4.436 0 5.355-.92.919-.918.919-2.397.919-5.355v-1.045a.893.893 0 0 0-1.192-.841l-6.774 2.39a.917.917 0 0 1-.61 0l-6.746-2.38ZM2.95 6.923c-.136.62-.205.93-.02 1.262.183.33.54.457 1.254.709l6.129 2.163c.33.116.494.174.666.174.17 0 .336-.058.665-.174l6.17-2.178c.715-.252 1.072-.378 1.256-.71.184-.333.115-.642-.024-1.261-.133-.594-.352-1.043-.715-1.406-.919-.919-2.398-.919-5.355-.919H9.024c-2.957 0-4.436 0-5.355.92-.366.365-.586.82-.719 1.42Z"
                                      fill="#fff"></path>
                            </svg>
                            ارسال پیغام
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
