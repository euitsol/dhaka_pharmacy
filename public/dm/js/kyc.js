$(document).ready(function () {
    $(document).ready(function () {
        let xhr;

        $(document).on(
            "change",
            `.fileInput ${disabled ? "disabled" : ""}`,
            function () {
                const progressBar = $(this)
                    .parent()
                    .siblings(".d-flex")
                    .find(".progressBar");
                const cancelBtn = $(this)
                    .parent()
                    .siblings(".d-flex")
                    .find(".cancelBtn");
                const fileUrl = $(this).parent().parent().find(".file_url");
                const fileTitle = $(this).parent().find(".file_title");
                const showFile = $(this).parent().siblings(".show_file");
                const isMultiple = $(this).attr("multiple");
                if (isMultiple) {
                    var count = $(this).data("count");
                    var key = $(this).attr("id");
                    count = count + 1;
                    $(this).data("count", count);
                }

                const formData = new FormData();
                formData.append("file", this.files[0]);

                xhr = $.ajax({
                    url: datas.file_upload,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    xhr: function () {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener(
                            "progress",
                            function (evt) {
                                if (evt.lengthComputable) {
                                    const percentComplete =
                                        (evt.loaded / evt.total) * 100;
                                    progressBar.css(
                                        "width",
                                        percentComplete + "%"
                                    );
                                    cancelBtn.css("display", "block");
                                }
                            },
                            false
                        );
                        return xhr;
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            alert("File uploaded successfully.");

                            let url = datas.file_delete;
                            let _url = url.replace("url", response.url);
                            if (isMultiple) {
                                var file = `<div class="form-group">
                                        <label>Uploded file - ${count}</label>
                                        <div class="input-group mb-3">
                                            <input ${
                                                disabled ? "disabled" : ""
                                            } type="text" class="form-control"   value="${set_title(
                                    fileTitle.val(),
                                    "",
                                    response.title
                                )}" disabled>
                                            <input ${
                                                disabled ? "disabled" : ""
                                            } type="text" class="form-control"  value="${set_title(
                                    fileTitle.val(),
                                    response.extension,
                                    response.title
                                )}" disabled>
                                            <input ${
                                                disabled ? "disabled" : ""
                                            } type="hidden" class="d-none" name="${key}[${count}][url]" value="${
                                    response.file_path
                                }">
                                            <input ${
                                                disabled ? "disabled" : ""
                                            } type="hidden" class="d-none" name="${key}[${count}][title]" value="${set_title(
                                    fileTitle.val(),
                                    "",
                                    response.title
                                )}">
                                            <a href="${_url}">
                                                <span class="input-group-text text-danger h-100 delete_file"><i class="tim-icons icon-trash-simple"></i></span>
                                            </a>
                                        </div>
                                    </div>`;
                                showFile.append(file);
                            } else {
                                fileUrl.val(response.file_path);
                                var file = `<div class="form-group">
                                        <label>Uploded file</label>
                                        <div class="input-group mb-3">
                                            <input ${
                                                disabled ? "disabled" : ""
                                            } type="text" class="form-control" value="${set_title(
                                    fileTitle.val(),
                                    "",
                                    response.title
                                )}" disabled>
                                            <input ${
                                                disabled ? "disabled" : ""
                                            } type="text" class="form-control" value="${set_title(
                                    fileTitle.val(),
                                    response.extension,
                                    response.title
                                )}" disabled>
                                            <a href="${_url}">
                                                <span class="input-group-text text-danger h-100 delete_file"><i class="tim-icons icon-trash-simple"></i></span>
                                            </a>
                                        </div>
                                    </div>`;
                                showFile.html(file);
                            }
                        } else {
                            alert("Failed to upload file. Please try again.");
                        }
                        progressBar.css("width", "0%");
                        cancelBtn.css("display", "none");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("Failed to upload file: " + textStatus);
                        progressBar.css("width", "0%");
                        cancelBtn.css("display", "none");
                    },
                });
            }
        );

        $(document).on("click", ".cancelBtn", function () {
            if (xhr && xhr.readyState !== 4) {
                xhr.abort();
                alert("File upload canceled.");
                $(this).siblings(".progressBar").css("width", "0%");
                $(this).siblings(".cancelBtn").css("display", "none");
            }
        });

        $(document).on("click", ".delete_file", function (e) {
            e.preventDefault();
        });
    });
});

function set_title(input_val, extension = "", prev_val = $(".title").html()) {
    if (input_val != null && input_val != "") {
        return input_val + (extension === "" ? "" : "." + extension);
    } else {
        return prev_val + (extension === "" ? "" : "." + extension);
    }
}
