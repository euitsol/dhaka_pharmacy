$(document).ready(function () {
    function updateRemainingTime() {
        $(".prep_time").each(function () {
            var now = moment();
            var endTime = moment($(this).data("end-time"));
            var diff = endTime.diff(now);

            if (diff > 0) {
                var duration = moment.duration(diff);
                var timeString =
                    duration.hours() +
                    "h " +
                    duration.minutes() +
                    "m " +
                    duration.seconds() +
                    "s remaining";
                $(this)
                    .text(timeString)
                    .removeClass("text-danget")
                    .addClass("text-success");
            } else {
                $(this)
                    .text("Delayed")
                    .removeClass("text-success")
                    .addClass("text-danger");
            }
        });
    }

    updateRemainingTime();
    setInterval(updateRemainingTime, 1000);
});
