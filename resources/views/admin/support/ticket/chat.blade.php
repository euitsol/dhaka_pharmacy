@extends('admin.layouts.master', ['pageSlug' => 'ticket'])
@section('title', 'Support Ticket Chat With ' . $ticket->ticketable->name)
@push('css')
    <style>
        .support_wrap .conversation-item .author_logo img {
            min-width: 40px;
            min-height: 40px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .support_wrap .conversation-item {
            margin-bottom: 15px;
        }

        .support_wrap .conversation-item .message {
            padding: 10px 15px;
            border-radius: 20px;
            background-color: #e9ecef;
        }

        .support_wrap .conversation-item .time {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .support_wrap .conversation-item.sent .time {
            text-align: right;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-6 position-fixed" style="left: 50%; transform: translateX(-35%);">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Chat With ' . $ticket->ticketable->name) }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'st.ticket_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="card mb-0 support_wrap" style="height: calc(100vh - 300px)">
                        <div class="card-body">
                            <div class="conversation">
                                <div class="conversation-list">
                                    @foreach ($ticket->messages as $message)
                                        <div
                                            class="conversation-item d-flex align-items-start {{ $message->sender_id == $ticket->ticketable_id && $message->sender_type == $ticket->ticketable_type ? 'justify-content-start ' : 'justify-content-end sent' }}">
                                            @if ($message->sender_id == $ticket->ticketable_id && $message->sender_type == $ticket->ticketable_type)
                                                <div class="author_logo">
                                                    <img src="{{ $message->sender->image ? asset('storage/' . $message->sender->image) : asset('default_img/male.png') }}"
                                                        alt="avatar">
                                                </div>
                                            @endif
                                            <div class="sms_text w-auto">
                                                <div class="message">{{ $message->message }}</div>
                                                <div class="time">{{ $message->created_at->diffForHumans() }}</div>
                                            </div>
                                            @if ($message->sender_id != $ticket->ticketable_id && $message->sender_type != $ticket->ticketable_type)
                                                <div class="author_logo">
                                                    <img src="{{ $message->sender->image ? asset('storage/' . $message->sender->image) : asset('default_img/male.png') }}"
                                                        alt="avatar">
                                                </div>
                                            @endif

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="message" class="form-control no-ckeditor5" style="min-height: auto !important;"
                                    placeholder="Write your message"></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Send') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
