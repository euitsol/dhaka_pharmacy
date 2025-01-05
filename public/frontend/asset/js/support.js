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
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        handleValidationErrors(xhr.responseJSON.errors);
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
function handleValidationErrors(errors) {
    $(".invalid-feedback").remove();
    $.each(errors, function (field, messages) {
        let errorHtml = messages
            .map(
                (message) =>
                    `<span class="invalid-feedback d-block" role="alert">${message}</span>`
            )
            .join("");
        $(`[name="${field}"]`).after(errorHtml);
    });
}

// Function to render chat messages
function chatMessages(chatMessages, senderId) {
    let conversation = $(".conversation");
    let result = "";
    if (!Array.isArray(chatMessages)) {
        $(".temp_text").remove();
        result += `<div class="conversation-item d-flex align-items-start justify-content-end sent">
                            <div class="sms_text w-auto">
                                <div class="message">${chatMessages.message}</div>
                                <div class="time">${chatMessages.send_at}</div>
                            </div>
                            <div class="author_logo">
                                <img src="${chatMessages.author_image}" alt="avatar">
                            </div>
                        </div>`;

        conversation.find(".conversation-list").append(result);
    } else {
        $(".chat_initial_form").remove();
        conversation.parent().removeClass("d-none");
        if (chatMessages.length == 0) {
            result += `<span class="temp_text text-muted text-center d-block">Sent your message here.</span>`;
        } else {
            $(".temp_text").remove();
            chatMessages.forEach((message) => {
                result += `
                <div class="conversation-item d-flex align-items-start ${
                    message.sender_id == senderId
                        ? "justify-content-end sent"
                        : "justify-content-start "
                }">`;
                if (message.sender_id != senderId) {
                    result += `<div class="author_logo">
                        <img src="${message.author_image}" alt="avatar">
                    </div>`;
                }

                result += `<div class="sms_text w-auto">
                        <div class="message">${message.message}</div>
                        <div class="time">${message.send_at}</div>
                    </div>`;
                if (message.sender_id === senderId) {
                    result += `<div class="author_logo">
                        <img src="${message.author_image}" alt="avatar">
                    </div>`;
                }
                result += `</div>`;
            });
            conversation.find(".conversation-list").html(result);
        }
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
                chatMessages(response.ticket.messages, response.ticketAbleId);
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
                    chatMessages(response.reply, response.reply.sender_id);
                    $this.find("textarea[name=message]").val("");
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    handleValidationErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error("An error occurred. Please try again.");
                }
            },
        });
    });
});
