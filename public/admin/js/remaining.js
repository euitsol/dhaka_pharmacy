$(document).ready(function () {
    function updateRemainingTime() {
        var now = moment();
        var endTime = moment($(".prep_time").data("end-time"));
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
            $(".prep_time")
                .text(timeString)
                .removeClass("red")
                .addClass("green");
        } else {
            $(".prep_time")
                .text("Delayed")
                .removeClass("green")
                .addClass("red");
        }
    }

    updateRemainingTime();
    setInterval(updateRemainingTime, 1000);
});
