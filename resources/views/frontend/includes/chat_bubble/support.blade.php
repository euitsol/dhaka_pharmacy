{{-- <div class="chat_bubble" id="chat_bubble">

    <div class="chat_icon w-100 h-100 d-flex justify-content-center align-items-center">
        <i class="fa-solid fa-headset"></i>
    </div>


</div> --}}
<div class="support_wrap">
    <div class="chat" id="chat">
        <div class="background"></div>
        <svg class="chat-bubble" width="100" height="100" viewBox="0 0 100 100">
            <g class="bubble">
                <path class="line line1" d="M 30.7873,85.113394 30.7873,46.556405 C 30.7873,41.101961
            36.826342,35.342 40.898074,35.342 H 59.113981 C 63.73287,35.342
            69.29995,40.103201 69.29995,46.784744" />
                <path class="line line2" d="M 13.461999,65.039335 H 58.028684 C
              63.483128,65.039335
              69.243089,59.000293 69.243089,54.928561 V 45.605853 C
              69.243089,40.986964 65.02087,35.419884 58.339327,35.419884" />
            </g>
            <circle class="circle circle1" r="1.9" cy="50.7" cx="42.5" />
            <circle class="circle circle2" cx="49.9" cy="50.7" r="1.9" />
            <circle class="circle circle3" r="1.9" cy="50.7" cx="57.3" />
        </svg>
    </div>
    <div class="default-talk-bubble tri-right border btm-right-in">
        <div class="talktext">
            <p>👋 Need any help?
                We're here to assist you! Click the chat bubble to start a conversation</p>
        </div>
    </div>

    <div class="message_box">
        <div class="head-text">
            Let's chat? - Online
        </div>
        <div class="chat-box">
            <div class="message w-100 h-100">
                <div class="chat_initial_form w-100 h-100 d-flex align-items-center justify-content-center flex-column">
                    <div class="desc-text w-100">
                        Please fill out the form below to start chatting with the next available agent.
                    </div>
                    @if (!auth()->guard('web')->check())
                        <form class="w-100" id="guestChatStartForm">
                            <div class="field">
                                <input type="text" class="p-4" placeholder="Your Name" required>
                            </div>
                            <div class="field">
                                <input type="email" class="p-4" placeholder="Your Phone" required>
                            </div>
                            <div class="field">
                                <input type="text" class="p-4" placeholder="Your Subject" required>
                            </div>
                            <div class="field">
                                <button type="submit" class="start_btn">Start Chat</button>
                            </div>
                        </form>
                    @else
                        <form class="w-100" id="authChatStartForm" action="{{ route('u.ticket.create') }}"
                            method="POST">
                            @csrf
                            <div class="field">
                                <input type="text" name="subject" class="p-4" placeholder="Your Subject" required>
                            </div>
                            <div class="field">
                                <button type="submit" class="start_btn">Start Chat</button>
                            </div>
                        </form>
                    @endif
                </div>


                {{-- ++++++++++++++++++++++++++/ --}}


                <div class="conversation d-none">
                    <div class="conversation-list">
                        <div class="conversation-item sent d-flex align-items-start justify-content-start">
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                            <div class="sms_text w-auto">
                                <div class="message">
                                    Hello, how are you?
                                </div>
                                <div class="time">
                                    10:30 AM
                                </div>
                            </div>
                        </div>
                        <div class="conversation-item d-flex align-items-start justify-content-end">
                            <div class="sms_text w-auto">
                                <div class="message">
                                    I'm good, thanks! What about you? I'm good, thanks! What about you? I'm good,
                                    thanks! What about you?
                                </div>
                                <div class="time">
                                    10:31 AM
                                </div>
                            </div>
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                        </div>
                        <div class="conversation-item d-flex align-items-start justify-content-end">
                            <div class="sms_text w-auto">
                                <div class="message">
                                    I'm good, thanks! What about you? I'm good, thanks! What about you? I'm good,
                                    thanks! What about you?
                                </div>
                                <div class="time">
                                    10:31 AM
                                </div>
                            </div>
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                        </div>
                        <div class="conversation-item d-flex align-items-start justify-content-end">
                            <div class="sms_text w-auto">
                                <div class="message">
                                    I'm good, thanks! What about you? I'm good, thanks! What about you? I'm good,
                                    thanks! What about you?
                                </div>
                                <div class="time">
                                    10:31 AM
                                </div>
                            </div>
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                        </div>
                        <div class="conversation-item d-flex align-items-start justify-content-end">
                            <div class="sms_text w-auto">
                                <div class="message">
                                    I'm good, thanks! What about you? I'm good, thanks! What about you? I'm good,
                                    thanks! What about you?
                                </div>
                                <div class="time">
                                    10:31 AM
                                </div>
                            </div>
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                        </div>
                        <div class="conversation-item d-flex align-items-start justify-content-end">
                            <div class="sms_text w-auto">
                                <div class="message">
                                    I'm good, thanks! What about you? I'm good, thanks! What about you? I'm good,
                                    thanks! What about you?
                                </div>
                                <div class="time">
                                    10:31 AM
                                </div>
                            </div>
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                        </div>
                        <div class="conversation-item d-flex align-items-start justify-content-end">
                            <div class="sms_text w-auto">
                                <div class="message">
                                    I'm good, thanks! What about you? I'm good, thanks! What about you? I'm good,
                                    thanks! What about you?
                                </div>
                                <div class="time">
                                    10:31 AM
                                </div>
                            </div>
                            <div class="author_logo">
                                <img src="{{ asset('default_img/male.png') }}" alt="avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="send_box">
                    <form action="" class="pt-2 h-100">
                        <div class="input-group h-100">
                            <textarea class="form-control message-input" rows="1" placeholder="Enter your message"></textarea>
                            <input type="submit" value="Send" class="btn send_btn">
                        </div>
                    </form>
                </div>



                {{-- ++++++++++++++++++++++++++++++++++++ --}}

            </div>
        </div>
    </div>
</div>
