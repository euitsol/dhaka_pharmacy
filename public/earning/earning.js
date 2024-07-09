function getHtml(earnings) {
    var result = "";
    earnings.forEach(function (earning) {
        result += `<tr>
                        <td>${earning.creationDate}</td>
                        <td>
                            <span class="${earning.activityBg}">
                                ${earning.activityTitle}
                            </span>
                        </td>
                        <td>${earning.description}</td>
                        <td>${earning.order.order_id}</td>
                        <td>${numberFormat(earning.amount, 2)} BDT</td>
                    </tr>`;
    });
    return result;
}

$(document).ready(function () {
    function initializeDateRangePicker() {
        var startDate = moment().startOf("month");
        var endDate = moment().endOf("month");

        $("#daterange").daterangepicker(
            {
                locale: {
                    format: "YYYY-MM-DD",
                },
                startDate: startDate,
                endDate: endDate,
                autoUpdateInput: false,
            },
            function (start, end) {
                $("#daterange").val(
                    `${start.format("YYYY-MM-DD")} - ${end.format(
                        "YYYY-MM-DD"
                    )}`
                );
                $("#fromDate").val(start.format("YYYY-MM-DD"));
                $("#toDate").val(end.format("YYYY-MM-DD"));
                fetchData(start.format("YYYY-MM-DD"), end.format("YYYY-MM-DD"));
            }
        );

        $("#daterange").attr("placeholder", "Select Date Range");
    }

    function fetchData(from, to) {
        let url = myRoutes["filter"];
        let __url = url
            .replace("_from", from)
            .replace("_to", to)
            .replace(/&amp;/g, "&");
        $.ajax({
            url: __url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var result = "";
                var earnings = data.paginateEarnings.data;
                if (earnings.length === 0) {
                    result = `<tr>
                        <td colspan="5" class="text-muted text-center">No earning found</td>
                        </tr>`;
                } else {
                    result = getHtml(earnings);
                }
                $(".earning_wrap").html(result);
                $(".paginate").html(data.pagination);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    }

    initializeDateRangePicker();
});

// $(document).ready(function () {
//     function initializeReportDateRangePicker() {
//         var startDate = moment().startOf("month");
//         var endDate = moment().endOf("month");

//         $("#reportDateRange").daterangepicker(
//             {
//                 locale: {
//                     format: "YYYY-MM-DD",
//                 },
//                 startDate: startDate,
//                 endDate: endDate,
//                 autoUpdateInput: false,
//             },
//             function (start, end) {
//                 $("#reportDateRange").val(
//                     `${start.format("YYYY-MM-DD")} - ${end.format(
//                         "YYYY-MM-DD"
//                     )}`
//                 );
//                 $("#fromDate").val(start.format("YYYY-MM-DD"));
//                 $("#toDate").val(end.format("YYYY-MM-DD"));
//             }
//         );

//         $("#reportDateRange").attr("placeholder", "Select Date Range");
//     }
//     initializeReportDateRangePicker();
// });

function handleErrors(response) {
    var errors = response.errors;
    for (var field in errors) {
        toastr.error(errors[field][0]);
    }
}
$(document).ready(function () {
    $(".email_activity").on("click", function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: myRoutes["report"],
            method: "POST",
            dataType: "json",
            data: {
                from_date: $("#fromDate").val() ?? " ",
                to_date: $("#toDate").val() ?? " ",
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    handleErrors(response);
                }
            },
            error: function (XHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            },
        });
    });
});
