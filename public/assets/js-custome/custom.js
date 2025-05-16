function alertToastr(message) {
    var toast = document.createElement("div");
    toast.className =
        "bs-toast toast toast-placement-ex m-2 fade bg-primary top-0 end-0 show";

    var header = document.createElement("div");
    header.className = "toast-header";
    var icon = document.createElement("i");
    icon.className = "bx bx-bell me-2";
    var title = document.createElement("div");
    title.className = "me-auto fw-semibold";
    title.textContent = "Notifikasi";
    // var closeButton = document.createElement("button");
    // closeButton.type = "button";
    // closeButton.className = "btn-close";
    // closeButton.setAttribute("data-bs-dismiss", "toast");
    // closeButton.setAttribute("aria-label", "Close");

    var body = document.createElement("div");
    body.className = "toast-body";
    body.textContent = message;

    header.appendChild(icon);
    header.appendChild(title);
    // header.appendChild(closeButton);
    toast.appendChild(header);
    toast.appendChild(body);

    document.body.appendChild(toast);

    setTimeout(function () {
        toast.classList.remove("show");
        setTimeout(function () {
            toast.remove();
        }, 1000);
    }, 5000);
}

function alertToastrError(message) {
    var toast = document.createElement("div");
    toast.className =
        "bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 end-0 show";
    var header = document.createElement("div");
    header.className = "toast-header";
    var icon = document.createElement("i");
    icon.className = "bx bx-bell me-2";
    var title = document.createElement("div");
    title.className = "me-auto fw-semibold";
    title.textContent = "Notifikasi";

    var body = document.createElement("div");
    body.className = "toast-body";
    body.textContent = message;

    header.appendChild(icon);
    header.appendChild(title);
    toast.appendChild(header);
    toast.appendChild(body);

    document.body.appendChild(toast);

    setTimeout(function () {
        toast.classList.remove("show");
        setTimeout(function () {
            toast.remove();
        }, 1000);
    }, 5000);
}

function alertToastrErr(message) {
    $.gritter.add({
        title: "Maaf!",
        text: message,
    });
    return false;
}

function alertDanger(message) {
    $("#alerts").html(
        '<div class="alert alert-danger alert-dismissible fade show ml-2 mr-2 mt-2">' +
        '<button type="button" class="close" data-dismiss="alert">' +
        "&times;</button><strong>Success! </strong>" +
        message +
        "</div>"
    );
    $(window).scrollTop(0);
    setTimeout(function () {
        $(".alert").alert("close");
    }, 5000);
}

$("#inputGroupFile01").change(function (event) {
    RecurFadeIn();
    readURL(this);
});
$("#inputGroupFile01").on("click", function (event) {
    RecurFadeIn();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var filename = $("#inputGroupFile01").val();
        filename = filename.substring(filename.lastIndexOf("\\") + 1);
        reader.onload = function (e) {
            $("#preview").attr("src", e.target.result);
            $("#preview").hide();
            $("#preview").fadeIn(500);
            $(".custom-file-label").text(filename);
        };
        reader.readAsDataURL(input.files[0]);
    }
    $("#pleasewait").removeClass("loading").hide();
}

function RecurFadeIn() {
    FadeInAlert("Wait for it...");
}

function FadeInAlert(text) {
    $("#pleasewait").show();
    $("#pleasewait").text(text).addClass("loading");
}

function DataTable(ajaxUrl, columns, columnDefs) {
    var table = $(".table").DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        pageLength: 10,
        lengthMenu: [10, 50, 100, 200, 500],
        lengthChange: true,
        autoWidth: true,
        scrollCollapse: true,
        scrollX: true,
        paging: true,
        ajax: ajaxUrl,
        columns: columns,
        columnDefs: columnDefs,
    });

    return table;
}

function createModel(createHeading) {
    $("#create").click(function () {
        $("#saveBtn").val("create");
        $("#modelHeading").html(createHeading);
        $("#ajaxModel").modal("show");
        $("#ajaxForm").trigger("reset");
        $("#hidden_id").val("");
        var hiddenIdValue = $("#hidden_id").val();
        if (hiddenIdValue) {
            $(".optionSpan").hide();
            $(".optionSmall").show();
        } else {
            $(".optionSpan").show();
            $(".optionSmall").hide();
        }
    });
}

function createModelFile(createHeading) {
    $("#create").click(function () {
        $("#saveBtn").val("create");
        $("#modelHeading").html(createHeading);
        $("#ajaxModel").modal("show");
        $("#delete").modal("show");
        $("#ajaxForm").trigger("reset");
        $("#hidden_id").val("");

        function resetImageSrc(imageSelectors, defaultSrc) {
            imageSelectors.forEach(function (selector) {
                $(selector).attr("src", defaultSrc);
            });
        }

        resetImageSrc(
            ["#Image", "#Image1", "#Image2", "#Image3", "#Image4"],
            "assets/img/widget-blank.jpg"
        );
    });
}


function editModel(editUrl, editHeading, field, urlGetDesa) {
    $("body").on("click", ".edit", function () {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var editId = $(this).data("id");
        $.get(editUrl + "/" + editId + "/edit", function (data) {
            $("#saveBtn").val("edit");
            $("#ajaxModel").modal("show");
            $("#ajaxForm").trigger("reset");
            $("#hidden_id").val(data.id);
            $("#modelHeading").html(editHeading);
            $.each(field, function (index, value) {
                $("#" + value).val(data[value]);
            });
            var idKec = data.kecamatan_id;
            var idDesa = data.desa_id;
            if (idKec) {
                $.ajax({
                    url: urlGetDesa,
                    type: "POST",
                    data: {
                        kecamatan_id: idKec,
                        _token: csrfToken,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result == "") {
                            $("#desa_id").html(
                                '<option value="">::Data Kelurahan/Desa tidak tersedia::</option>'
                            );
                        } else {
                            $("#desa_id").html(
                                '<option value="">::Pilih Kelurahan/Desa::</option>'
                            );
                        }
                        $.each(result, function (key, value) {
                            $("#desa_id").append(
                                '<option value="' +
                                value.id +
                                '">' +
                                value.name +
                                "</option>"
                            );
                            if (value.id == idDesa) {
                                $(
                                    "#desa_id option[value=" + value.id + "]"
                                ).prop("selected", true);
                            }
                        });
                    },
                });
            }
            var hiddenIdValue = $("#hidden_id").val();
            if (hiddenIdValue) {
                $(".optionSpan").hide();
                $(".optionSmall").show();
            } else {
                $(".optionSpan").show();
                $(".optionSmall").hide();
            }
        });
    });
}

function editModelImg(editUrl, editHeading, path, field) {
    $("body").on("click", ".edit", function () {
        var editId = $(this).data("id");

        $.get(editUrl + "/" + editId + "/edit", function (data) {
            $("#saveBtn").val("edit");
            $("#ajaxModel").modal("show");
            $("#ajaxForm").trigger("reset");
            $("#hidden_id").val(data.id);
            $("#modelHeading").html(editHeading);

            $.each(field, function (index, value) {
                $("#" + value).val(data[value]);
            });

            var images = {
                "Image": data.foto,
                "Image1": data.logo_provinsi,
                "Image2": data.logo_kabupaten,
                "Image3": data.logo_login,
                "Image4": data.favicon_app
            };

            function setImageSrc(imageId, imageName) {
                var defaultSrc = "/assets/img/widget-blank.jpg";
                var imageUrl = imageName ? path + "/" + imageName : defaultSrc;
                $("#" + imageId).attr("src", imageUrl);
            }

            $.each(images, function (imageId, imageName) {
                setImageSrc(imageId, imageName);
            });
        });
    });
}

function editModelSuara(editUrl, editHeading, field) {
    $("body").on("click", ".edit", function () {
        var editId = $(this).data("id");
        $.get(editUrl + "/" + editId + "/edit", function (data) {
            $("#saveBtn").val("edit");
            $("#ajaxModel").modal("show");
            $("#ajaxForm").trigger("reset");
            $("#hidden_id").val(data.suara.id);
            $("#modelHeading").html(editHeading);
            $.each(field, function (index, value) {
                $("#" + value).val(data.suara[value]);
            });
            var detailSuara = data.detail_suara;
            $.each(detailSuara, function (index, item) {
                var inputSah = $(
                    "input[name='sah[" + item.paslon_id + "]']"
                );
                inputSah.val(item.sah);
            });
        });
    });
}

function saveBtn(urlStore, table) {
    $("#saveBtn").click(function (e) {
        e.preventDefault();
        $(this)
            .html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>"
            )
            .attr("disabled", "disabled");
        $.ajax({
            data: $("#ajaxForm").serialize(),
            url: urlStore,
            type: "POST",
            dataType: "json",
            success: function (data) {
                if (data.errors) {
                    $(".alert-danger").html("");
                    $.each(data.errors, function (key, value) {
                        $(".alert-danger").show();
                        $(".alert-danger").append(
                            "<strong><li>" + value + "</li></strong>"
                        );
                        $(".alert-danger").fadeOut(5000);
                        $("#saveBtn").html("Simpan").removeAttr("disabled");
                    });
                } else if (data.message) {
                    $(".alert-danger").html("");
                    $(".alert-danger").show();
                    $(".alert-danger").append(
                        "<strong>" + data.message + "</strong>"
                    );
                    $(".alert-danger").fadeOut(5000);
                    $("#saveBtn").html("Simpan").removeAttr("disabled");
                } else {
                    $("#saveBtn").html("Simpan").removeAttr("disabled");
                    alertToastr(data.success);
                    $("#ajaxModel").modal("hide");
                    if (table) {
                        table.draw();
                    } else {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                }
            },
        });
    });
}

function saveImage(urlStore, table) {
    $("#saveBtn").click(function (e) {
        e.preventDefault();
        $(this)
            .html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>"
            )
            .attr("disabled", "disabled");
        var form = $("#ajaxForm")[0];
        var data = new FormData(form);
        $.ajax({
            data: data,
            url: urlStore,
            type: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    $(".alert-danger").html("");
                    $.each(data.errors, function (key, value) {
                        $(".alert-danger").show();
                        $(".alert-danger").append(
                            "<strong><li>" + value + "</li></strong>"
                        );
                        $(".alert-danger").fadeOut(5000);
                        $("#saveBtn").html("Simpan").removeAttr("disabled");
                    });
                } else {
                    alertToastr(data.success);
                    $("#saveBtn").html("Simpan").removeAttr("disabled");
                    $("#ajaxModel").modal("hide");
                    if (table) {
                        table.draw();
                    } else {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                }
            },
        });
    });
}

function importModel(importHeading) {
    $("#import").click(function () {
        $("#importHeading").html(importHeading);
        $("#modal-import").modal("show");
        $("#FormImport").trigger("reset");
    });
}

function saveImport(urlStore, table, urlDownload) {
    $("#importFile").click(function (e) {
        e.preventDefault();
        $(this).html(
            "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
        ).attr("disabled", "disabled");

        var form = $("#FormImport")[0];
        var data = new FormData(form);

        $.ajax({
            data: data,
            url: urlStore,
            type: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    $("#info").html("");
                    $.each(data.errors, function (key, value) {
                        $("#info").show();
                        $("#info").append(
                            "<strong><li>" + value + "</li></strong>"
                        );
                        $("#info").fadeOut(5000);
                        $("#importFile").html("Import").removeAttr("disabled");
                    });
                } else {
                    alertToastr(data.success);

                    window.location.href = data.download_url;

                    $("#importFile").html("Import").removeAttr("disabled");
                    $("#modal-import").modal("hide");
                    table.draw();
                }
            },
        });
    });
};

function saveFile(urlStore, table) {
    $("#saveFile").click(function (e) {
        e.preventDefault();
        $(this).html(
            "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
        );

        var form = $("#importForm")[0];
        var data = new FormData(form);

        $.ajax({
            data: data,
            url: urlStore,
            type: "POST",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    $(".alert-danger").html("");
                    $.each(data.errors, function (key, value) {
                        $(".alert-danger").show();
                        $(".alert-danger").append(
                            "<strong><li>" + value + "</li></strong>"
                        );
                        $(".alert-danger").fadeOut(5000);
                        $("#saveFile").html("Simpan");
                    });
                } else {
                    table.draw();
                    alertToastr(data.success);
                    $("#saveFile").html("Simpan");
                    $("#importModel").modal("hide");
                }
            },
        });
    });
}

function Delete(fitur, editUrl, deleteUrl, table) {
    $("body").on("click", ".delete", function () {
        var deleteId = $(this).data("id");
        $("#modelHeadingHps").html("Hapus");
        $("#fitur").html(fitur);

        $("#ajaxModelHps").data('id', deleteId).modal("show");

        $.get(editUrl + "/" + deleteId + "/edit", function (data) {
            if (data.name) {
                $("#field").html(data.name);
            } else if (data.short_name) {
                $("#field").html(data.short_name);

            }
        });
    });

    $("#ajaxModelHps").on('hidden.bs.modal', function () {
        $(this).removeData('id');
        $("#hapusBtn").html("Hapus").removeAttr("disabled");
    });

    $("#hapusBtn").click(function (e) {
        e.preventDefault();

        var deleteId = $("#ajaxModelHps").data('id');
        if (!deleteId) {
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $(this)
            .html("<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>")
            .attr("disabled", "disabled");

        $.ajax({
            type: "DELETE",
            url: deleteUrl + "/" + deleteId,
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (data.errors) {
                    alertToastrError(data.error, "error");
                } else {
                    if (table) {
                        table.draw();
                    }
                    alertToastr(data.success);
                    $("#ajaxModelHps").modal("hide");
                }
                $("#hapusBtn").html("Hapus").removeAttr("disabled");
            },
            error: function (xhr, status, error) {
                alertToastrError("Terjadi kesalahan saat menghapus data.", "error");
                $("#hapusBtn").html("Hapus").removeAttr("disabled");
            }
        });
    });
}

function resetLogin(fiturUser, editUrl, resetUrl, table) {
    $("body").on("click", ".resetLogin", function () {
        var resetId = $(this).data("id");
        $("#modelHeadingReset").html("Reset Aktivitas Login");
        $("#fitur-reset").html(fiturUser);

        $("#ajaxModelReset").data('id', resetId).modal("show");

        $.get(editUrl + "/" + resetId + "/edit", function (data) {
            $("#field-name").html(data.name);
        });
    });

    $("#ajaxModelReset").on('hidden.bs.modal', function () {
        $(this).removeData('id');
        $("#resetBtn").html("Reset").removeAttr("disabled");
    });

    $("#resetBtn").click(function (e) {
        e.preventDefault();

        var resetId = $("#ajaxModelReset").data('id');
        if (!resetId) {
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $(this)
            .html("<span class='spinner-border spinner-border-sm'></span>")
            .attr("disabled", "disabled");

        var url = resetUrl.replace(':id', resetId);

        $.ajax({
            type: "DELETE",
            url: url,
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (table) {
                    table.draw();
                }
                alertToastr(data.success, "success");
                $("#ajaxModelReset").modal("hide");
                $("#resetBtn").html("Reset").removeAttr("disabled");
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alertToastrError(xhr.responseJSON.error, "error");
                } else {
                    alertToastrError("Terjadi kesalahan saat menghapus data.", "error");
                }
                $("#resetBtn").html("Reset").removeAttr("disabled");
            }

        });
    });
}

function DeleteSuara(fitur, editUrl, deleteUrl, table) {
    $("body").on("click", ".delete", function () {
        var deleteId = $(this).data("id");
        $("#modelHeadingHps").html("Hapus");
        $("#fitur").html(fitur);
        $("#ajaxModelHps").data('id', deleteId).modal("show");

        $.get(editUrl + "/" + deleteId, function (response) {
            var data = response.tps;
            if (data) {
                $("#field").html('TPS ' + data.no_tps);
            }
        });
    });

    $("#ajaxModelHps").on('hidden.bs.modal', function () {
        $(this).removeData('id');
        $("#hapusBtn").html("Hapus").removeAttr("disabled");
    });

    $("#hapusBtn").click(function (e) {
        e.preventDefault();

        var deleteId = $("#ajaxModelHps").data('id');
        if (!deleteId) {
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $(this)
            .html("<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>")
            .attr("disabled", "disabled");

        $.ajax({
            type: "DELETE",
            url: deleteUrl + "/" + deleteId,
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (data.errors) {
                    $("#hapusBtn").html("Hapus").removeAttr("disabled");
                } else {
                    if (table) {
                        table.draw();
                    }
                    alertToastr(data.success);
                    $("#hapusBtn").html("Hapus").removeAttr("disabled");
                    $("#ajaxModelHps").modal("hide");
                }
            },
        });
    });
}

function DeletePaslon(fitur, editUrl, deleteUrl, table) {
    $("body").on("click", ".delete", function () {
        var deleteId = $(this).data("id");
        var jenisId = $(this).data("jenis");

        $("#modelHeadingHps").html("Hapus");
        if (jenisId === 1) {
            $("#fitur").html("Paslon Gubernur");
        } else if (jenisId === 2) {
            $("#fitur").html("Paslon Bupati");
        } else {
            $("#fitur").html(fitur);
        }

        $("#ajaxModelHps").data('id', deleteId).modal("show");

        $.get(editUrl + "/" + deleteId + "/edit", function (data) {
            $("#field").html('Nomor Urut ' + data.nomor);
        });
    });

    $("#ajaxModelHps").on('hidden.bs.modal', function () {
        $(this).removeData('id');
        $("#hapusBtn").html("Hapus").removeAttr("disabled");
    });

    $("#hapusBtn").click(function (e) {
        e.preventDefault();

        var deleteId = $("#ajaxModelHps").data('id');
        if (!deleteId) {
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $(this)
            .html("<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>")
            .attr("disabled", "disabled");

        $.ajax({
            type: "DELETE",
            url: deleteUrl + "/" + deleteId,
            data: {
                _token: csrfToken,
            },
            success: function (data) {
                if (data.errors) {
                    $("#hapusBtn").html("Hapus").removeAttr("disabled");
                } else {
                    if (table) {
                        table.draw();
                    }
                    alertToastr(data.success);
                    $("#hapusBtn").html("Hapus").removeAttr("disabled");
                    $("#ajaxModelHps").modal("hide");
                }
            },
        });
    });
}

function Nonaktif(fitur, table) {
    $("body").on("click", ".nonaktif", function () {
        var userid = $(this).data("id");
        var nama = $(this).data("name");
        $("#modelHeadingNon").html("Nonaktif");
        $("#ajaxModelNon").find("#fitur").html(fitur);
        $("#ajaxModelNon").find("#field").text(nama);
        $("#ajaxModelNon").modal("show");
        $("#nonaktifBtn").click(function (e) {
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $(this)
                .html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>"
                )
                .attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "user" + "/" + userid + "/nonaktif",
                data: {
                    _token: csrfToken,
                },
                success: function (data) {
                    if (data.errors) {
                        $("#nonaktifBtn")
                            .html("Nonaktifkan")
                            .removeAttr("disabled");
                    } else {
                        if (table) {
                            table.draw();
                        }
                        alertToastr(data.success);
                        $("#nonaktifBtn")
                            .html("Nonaktifkan")
                            .removeAttr("disabled");
                        $("#ajaxModelNon").modal("hide");
                    }
                },
            });
        });
    });
}

function Aktif(fitur, table) {
    $("body").on("click", ".aktif", function () {
        var userId = $(this).data("id");
        var nama = $(this).data("name");
        $("#modelHeadingAktif").html("Nonaktif");
        $("#ajaxModelAktif").find("#fitur").html(fitur);
        $("#ajaxModelAktif").find("#field").text(nama);
        $("#ajaxModelAktif").modal("show");
        $("#aktifBtn").click(function (e) {
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $(this)
                .html(
                    "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>"
                )
                .attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: "user" + "/" + userId + "/aktif",
                data: {
                    _token: csrfToken,
                },
                success: function (data) {
                    if (data.errors) {
                        $("#aktifBtn").html("Aktifkan").removeAttr("disabled");
                    } else {
                        if (table) {
                            table.draw();
                        }
                        alertToastr(data.success);
                        $("#aktifBtn").html("Aktifkan").removeAttr("disabled");
                        $("#ajaxModelAktif").modal("hide");
                    }
                },
            });
        });
    });
}

function Review(dokumenUrl, dokumenPath) {
    $("body").on("click", ".review", function () {
        var skId = $(this).data("id");
        $.get(dokumenUrl + "/" + skId, function (data) {
            $("#dokumen").empty();
            $.each(data, function (index, value) {
                $("#reviewModal").modal("show");
                $("#header").html("Surat Keterangan");
                $("#dokumen").append(
                    '<div class="form-group">' +
                    '<iframe src="' +
                    dokumenPath +
                    "/" +
                    value.sk +
                    '" style="width:100%; height:600px;"></iframe>' +
                    "</div>"
                );
            });
        });
    });
}

function DetailSuara(url, path, heading, detailPemilihan) {
    $("body").on("click", ".detail", function () {
        var suaraId = $(this).data("id");
        var noTps = $(this).data("notps");
        $("#modelHeadingDetail").html(
            heading + " TPS " + noTps
        );
        $("#ajaxModelDetail").modal("show");
        $.ajax({
            url: url + "/" + suaraId,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $("#detail").empty();
                var detailSuara = response.detail_suara;
                var tidak_sah = response.tidak_sah;
                var jlh_suara = response.jlh_suara;
                var tdk_memilih = response.tdk_memilih;
                if (detailSuara && detailSuara.length > 0) {
                    detailSuara.forEach(function (detail) {
                        var paslon = detail.paslon;
                        var imageSrc =
                            paslon && paslon.foto
                                ? path + "/" + paslon.foto
                                : "assets/img/paslon.jpg";

                        var sah = detail.sah;

                        if (paslon) {
                            $("#detail").append(
                                "<div class='col-md-12'>" +
                                "<div class='row'>" +
                                "<div class='col-md-4 mb-4'>" +
                                "<div class='cardhg'>" +
                                "<img class='card-img card border border-primary' src='" +
                                imageSrc +
                                "' alt='Foto Paslon' />" +
                                "</div>" +
                                "</div>" +
                                "<div class='col-md-8 mb-2'>" +
                                "<h5 class='card-title'>Nomor Urut " +
                                paslon.nomor +
                                "</h5>" +
                                "<hr>" +
                                "<h6 class='card-title'>Calon " + detailPemilihan + " : " +
                                paslon.nama_ketua +
                                "</h6>" +
                                "<h6 class='card-title mb-3'>Calon Wakil " + detailPemilihan + " : " +
                                paslon.nama_wakil +
                                "</h6>" +
                                "<span class='badge bg-success me-2'>Suara Sah : " +
                                sah +
                                "</span>" +
                                "<hr>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "<hr>"
                            );
                        }
                    });
                    $("#detail").append("<span class='badge bg-danger me-2'>Jumlah Suara Tidak Sah : " +
                        tidak_sah + "</span>" +
                        "<span class='badge bg-primary me-2'>Jumlah Suara Masuk : " +
                        jlh_suara + "</span>" +
                        "<span class='badge bg-warning me-2'>Tidak Memilih : " +
                        tdk_memilih + "</span>");
                } else {
                    $("#detail").append("<p>Tidak ada data detail suara.</p>");
                }
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    });
}

function statusChange(url) {
    $("body").on('click', '.status-toggle', function () {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: csrfToken,
                id: id,
                status: status
            },
            success: function (response) {
                alertToastr(response.success);
            },
            error: function (response) {
                console.log('Error:', response);
            }
        });
    });
}

function konfirmasiSuara(url, table) {
    $("body").on('click', '.konfirmasi', function () {
        var id = $(this).data('id');
        $("#modal-konfirmasi").data('id', id).modal("show");
    });

    $("#modal-konfirmasi").on('hidden.bs.modal', function () {
        $(this).removeData('id');
        $("#konfirmasiBtn").html("Konfirmasi").removeAttr("disabled");
    });

    $("#konfirmasiBtn").click(function (e) {
        e.preventDefault();

        var id = $("#modal-konfirmasi").data('id');
        if (!id) {
            return;
        }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $(this)
            .html("<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'></span>")
            .attr("disabled", "disabled");

        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: csrfToken,
                id: id,
            },
            success: function (data) {
                if (data.errors) {
                    $("#konfirmasiBtn")
                        .html("Konfirmasi")
                        .removeAttr("disabled");
                } else {
                    if (table) {
                        table.draw();
                    }
                    alertToastr(data.success);
                    $("#konfirmasiBtn")
                        .html("Konfirmasi")
                        .removeAttr("disabled");
                    $("#modal-konfirmasi").modal("hide");
                }
            },
        });
    });
}

function AktifAll(url, Aktifheading, table) {
    $("body").on("click", "#aktifBtn", function () {
        var userId = [];
        var count = 0;
        $('input[name="userID[]"]:checked').each(function () {
            userId.push($(this).val());
            count++;
        });
        $("#ajaxAktif").modal("show");
        $("#modal-heading-aktif").html(Aktifheading);
        $('#ajaxAktif').data('count', count);
        $("#ajaxAktif").find("#aktifCount").text(count);
        $("#AktifBtn").click(function (e) {
            e.preventDefault();
            $(this).html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> Mohon tunggu...</i></span>"
            ).attr('disabled', 'disabled');
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    userId: userId
                },
                success: function (data) {
                    $('#selectAll').prop('checked', false);
                    $('#aktifBtn').prop('disabled', true);
                    $('#aktifBtn').prop('disabled', true);
                    if (data.errors) {
                        $("#AktifBtn").html(
                            "<i class='fa fa-ban'></i> Ya, Aktifkan"
                        ).removeAttr('disabled');
                    } else {
                        alertToastr(data.success);
                        table.draw();
                        $("#AktifBtn").html(
                            "<i class='fa fa-ban'></i> Ya, Aktifkan")
                            .removeAttr(
                                'disabled');
                        $('#ajaxAktif').modal('hide');
                    }
                },
            });
        });
    });
}

function NonaktifAll(url, heading, table) {
    $("body").on("click", "#nonaktifBtn", function () {
        var userId = [];
        var count = 0;
        $('input[name="userID[]"]:checked').each(function () {
            userId.push($(this).val());
            count++;
        });
        $("#ajaxNonaktif").modal("show");
        $("#modal-heading-nonaktif").html(heading);
        $('#ajaxNonaktif').data('count', count);
        $("#ajaxNonaktif").find("#nonaktifCount").text(count);
        $("#NonaktifBtn").click(function (e) {
            e.preventDefault();
            $(this).html(
                "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> Mohon tunggu...</i></span>"
            ).attr('disabled', 'disabled');
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    userId: userId
                },
                success: function (data) {
                    $('#selectAll').prop('checked', false);
                    $('#aktifBtn').prop('disabled', true);
                    $('#nonaktifBtn').prop('disabled', true);
                    if (data.errors) {
                        $("#NonaktifBtn").html(
                            "<i class='fa fa-ban'></i> Ya, Nonaktifkan"
                        ).removeAttr('disabled');
                    } else {
                        alertToastr(data.success);
                        table.draw();
                        $("#NonaktifBtn").html(
                            "<i class='fa fa-ban'></i> Ya, Nonaktifkan")
                            .removeAttr(
                                'disabled');
                        $('#ajaxNonaktif').modal('hide');
                    }
                },
            });
        });
    });
}

// Fungsi Jam
document.addEventListener("DOMContentLoaded", function () {
    jam();
});

function jam() {
    var e = document.getElementById("jam"),
        d = new Date(),
        h,
        m,
        s;
    h = d.getHours();
    m = set(d.getMinutes());
    s = set(d.getSeconds());

    if (e) {
        e.innerHTML = h + ":" + m + ":" + s;
    }

    setTimeout(jam, 1000);
}

function set(e) {
    return e < 10 ? "0" + e : e;
}
