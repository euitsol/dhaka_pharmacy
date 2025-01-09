function chatMessage(message) {
    let conversation = $(".conversation");
    let result = "";
    result += `
    <div class="conversation-item d-flex align-items-start ${
        message.sender_id == message.ticket.ticketable_id &&
        message.sender_type == message.ticket.ticketable_type
            ? "justify-content-start "
            : "justify-content-end sent"
    }">`;
    if (
        message.sender_id == message.ticket.ticketable_id &&
        message.sender_type == message.ticket.ticketable_type
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
        message.sender_id != message.ticket.ticketable_id ||
        message.sender_type != message.ticket.ticketable_type
    ) {
        result += `<div class="author_logo">
            <img src="${message.author_image}" alt="avatar">
        </div>`;
    }
    result += `</div>`;

    conversation.find(".conversation-list").append(result);

    conversation.scrollTop(
        conversation[0].scrollHeight - conversation.height()
    );
}

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
                    // chatMessage(response.reply);
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

    $(".conversation").scrollTop(
        $(".conversation")[0].scrollHeight - $(".conversation").height()
    );
});

$(document).ready(function () {
    if (ticket_id) {
        window.Echo.channel(`ticket.${ticket_id}`).listen(
            ".ticket-chat",
            (e) => {
                console.log(e.message);
                chatMessage(e.message);
            }
        );
    }
});
