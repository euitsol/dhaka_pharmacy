// support JS

$(document).ready(function () {
    const talkBubble = $(".default-talk-bubble");
    const lastShownTime = localStorage.getItem("talkBubbleLastShown");
    const currentTime = new Date().getTime();

    // Uncomment the following condition if you want to limit showing the talk bubble every hour
    if (!lastShownTime || currentTime - lastShownTime > 3600000) {
        setTimeout(function () {
            talkBubble.addClass("show");
            setTimeout(function () {
                talkBubble.removeClass("show");
            }, 10000);
            localStorage.setItem("talkBubbleLastShown", currentTime);
        }, 2000);
    }

    $("#chat").on("click", function () {
        $(".default-talk-bubble").remove();
        $(this).toggleClass("active");
        $(".message_box").toggleClass("active");
    });

    $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
});

// Function to handle chat ticket creation
function handleChatTicketForm(formId) {
    $(document).ready(function () {
        $(formId).on("submit", function (event) {
            event.preventDefault();
            let $this = $(this);

            $.ajax({
                url: $this.attr("action"),
                method: "POST",
                data: $this.serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        let conversation = $(".conversation");
                        conversation
                            .find(".conversation-list")
                            .html(
                                '<span class="temp_text text-muted text-center d-block">Sent your message here.</span>'
                            );
                        $this.parent().remove();
                        conversation.parent().removeClass("d-none");

                        window.Echo.channel(
                            `ticket.${response.ticket_id}`
                        ).listen(".ticket-chat", (e) => {
                            chatMessages(e.message);
                        });

                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        handleValidationErrors(xhr.responseJSON.errors, formId);
                    } else {
                        toastr.error("An error occurred. Please try again.");
                    }
                },
            });
        });
    });
}
// Initialize forms for both authenticated and guest users
handleChatTicketForm("#authChatStartForm");
handleChatTicketForm("#guestChatStartForm");

// Function to handle validation errors
function handleValidationErrors(errors, formId) {
    $(".invalid-feedback").remove();
    $.each(errors, function (field, messages) {
        let errorHtml = messages
            .map(
                (message) =>
                    `<span class="invalid-feedback d-block text-start m-0" style="position: unset;" role="alert">${message}</span>`
            )
            .join("");
        $(formId).find(`[name="${field}"]`).after(errorHtml);
    });
}

// Function to render chat messages
function chatMessages(chatMessages) {
    let conversation = $(".conversation");
    let result = "";
    if (!Array.isArray(chatMessages)) {
        result += `<div class="conversation-item d-flex align-items-start ${
            chatMessages.sender_id == chatMessages.ticket.ticketable_id &&
            chatMessages.sender_type == chatMessages.ticket.ticketable_type
                ? "justify-content-end sent"
                : "justify-content-start "
        }">`;
        if (
            chatMessages.sender_id != chatMessages.ticket.ticketable_id ||
            chatMessages.sender_type != chatMessages.ticket.ticketable_type
        ) {
            result += `<div class="author_logo">
                <img src="${chatMessages.author_image}" alt="avatar">
            </div>`;
        }
        result += `<div class="sms_text w-auto">
                                <div class="message">${chatMessages.message}</div>
                                <div class="time">${chatMessages.send_at}</div>
                            </div>`;
        if (
            chatMessages.sender_id == chatMessages.ticket.ticketable_id &&
            chatMessages.sender_type == chatMessages.ticket.ticketable_type
        ) {
            result += `<div class="author_logo">
                                    <img src="${chatMessages.author_image}" alt="avatar">
                                </div>`;
        }
        result += `</div>`;
        $(".temp_text").remove();
        conversation.find(".conversation-list").append(result);
    } else {
        $(".chat_initial_form").remove();
        conversation.parent().removeClass("d-none");
        if (chatMessages.length === 0) {
            result = `<span class="temp_text text-muted text-center d-block">Sent your message here.</span>`;
        } else {
            chatMessages.forEach((message) => {
                result += `
                <div class="conversation-item d-flex align-items-start ${
                    message.sender_id == message.ticket.ticketable_id &&
                    message.sender_type == message.ticket.ticketable_type
                        ? "justify-content-end sent"
                        : "justify-content-start "
                }">`;
                if (
                    message.sender_id != message.ticket.ticketable_id ||
                    message.sender_type != message.ticket.ticketable_type
                ) {
                    result += `<div class="author_logo">
                        <img src="${message.author_image}" alt="avatar">
                    </div>`;
                }

                result += `<div class="sms_text w-auto">
                        <div class="message">${message.message}</div>
                        <div class="time">${message.send_at}</div>
                    </div>`;
                if (
                    message.sender_id == message.ticket.ticketable_id &&
                    message.sender_type == message.ticket.ticketable_type
                ) {
                    result += `<div class="author_logo">
                        <img src="${message.author_image}" alt="avatar">
                    </div>`;
                }
                result += `</div>`;
            });
        }
        conversation.find(".conversation-list").html(result);
    }
    conversation.scrollTop(
        conversation[0].scrollHeight - conversation.height()
    );
}

// Chat Refresh Function
function chatDataLoad() {
    let route = routes.getMessages;
    $.ajax({
        url: route,
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                chatMessages(response.ticket.messages);
            } else {
                toastr.error(response.message);
            }
        },
    });
}
chatDataLoad();

$(document).ready(function () {
    $("#messageSendForm").on("submit", function (event) {
        event.preventDefault();
        let $this = $(this);
        $.ajax({
            url: $this.attr("action"),
            method: "POST",
            data: $this.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    // chatMessages(response.reply);
                    $this.find("textarea[name=message]").val("");
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // toastr.error(xhr.responseJSON.message);
                    console.log(xhr.responseJSON.message);
                } else {
                    toastr.error("An error occurred. Please try again.");
                }
            },
        });
    });
});

$(document).ready(function () {
    if (TICKET_ID) {
        window.Echo.channel(`ticket.${TICKET_ID}`).listen(
            ".ticket-chat",
            (e) => {
                console.log(TICKET_ID);

                chatMessages(e.message);
            }
        );
    }
});
