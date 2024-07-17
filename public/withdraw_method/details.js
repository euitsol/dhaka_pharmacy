$(document).ready(function () {
    $(".view").on("click", function () {
        let id = $(this).data("id");
        let url = details["my_route"];
        let _url = url.replace("id", id);
        $.ajax({
            url: _url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.status == 2) {
                    $("#declained_reason").html(
                        `<p> <strong class = "text-danger"> Declined Reason: </strong>${data.note}</p>`
                    );
                }
                var result = `
                        <div id='declained_reason mb-2'></div>
                        <table class="table table-striped">
                            <tr>
                                <th class="text-nowrap">Account Name</th>
                                <th>:</th>
                                <td>${data.account_name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Bank Name</th>
                                <th>:</th>
                                <td>${data.bank_name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Bank Brunch Name</th>
                                <th>:</th>
                                <td>${data.bank_brunch_name}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Routing Number</th>
                                <th>:</th>
                                <td>${data.routing_number}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Type</th>
                                <th>:</th>
                                <td>${data.type}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Note</th>
                                <th>:</th>
                                <td><span class="text-danger">${
                                    data.note ?? "--"
                                }</span></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Status</th>
                                <th>:</th>
                                <td><span class="badge ${data.statusBg}">${
                    data.statusTitle
                }</span></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created At</th>
                                <th>:</th>
                                <td>${data.creating_time}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Created By</th>
                                <th>:</th>
                                <td>${data.created_by}</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated At</th>
                                <th>:</th>
                                <td>${
                                    data.creating_time != data.updating_time
                                        ? data.updating_time
                                        : ""
                                }</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Updated By</th>
                                <th>:</th>
                                <td>${data.updated_by}</td>
                            </tr>
                        </table>
                        `;
                $(".modal_data").html(result);
                $(".view_modal").modal("show");
            },
            error: function (xhr, status, error) {
                console.error("Error fetching admin data:", error);
            },
        });
    });
});
