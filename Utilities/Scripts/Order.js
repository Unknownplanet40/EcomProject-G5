function tableReady() {
    $("#loader").addClass("d-none");
    $("#ProductTable").removeClass("d-none");
}

SelectedID = [];
SelectedName = [];
OutofStock = [];
OrderStatus = "";

var Filename = localStorage.getItem("FileName");

function modal(status, modalname) {
    const Name = "#" + modalname;
    const modalStatus = status;

    if (modalStatus == "show") {
        const UniModal = new bootstrap.Modal(Name, {
            keyboard: false,
            dispose: true,
        });
        UniModal.show();
    } else if (modalStatus == "hide") {
        $(Name).modal("hide");
    }
}

$("#SearchProduct").on("keyup", function () {
    // pass value to dt-search-0
    $("#ProductTable").DataTable().search(this.value).draw();
});

$(document).ready(function () {
    // Initialize Bootstrap Tooltip and Popover
    const tooltipTriggerList = document.querySelectorAll(
        '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
        (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );

    // check if table is ready
    tableReady();
    // Table Initialization
    var Table = $("#ProductTable").DataTable({
        pageLength: 10,
        responsive: true,
        layout: {
            topStart: {
                pageLength: {
                    menu: [5, 10],
                },
            },
            topEnd: {},
        },
        initComplete: function () { },

        columnDefs: [
            {
                targets: [0],
                searchable: false,
            },
            {
                targets: [1],
                visible: false,
                searchable: false,
            },
            {
                targets: [6],
                visible: false,
                searchable: false,
            },
        ],
        ordering: false,
    });

    $("#ProductTable tbody").on("click", "tr", function () {

        if ($("td", this).hasClass("dt-empty")) return;

        var data = Table.row(this).data();

        $(this).removeClass("table-danger");
        if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
            if (data[45] > data[6]) {
                $(this).addClass("table-danger");
                OutofStock.pop(data[1]);
            } else {
                SelectedID.pop(data[1]);
                SelectedName.pop(data[2]);
            }

        } else {
            Table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
            if (data[6] > data[6]) {
                $(this).addClass("table-danger");
                OutofStock.push(data[1]);
            } else {
                SelectedID.push(data[1]);
                SelectedName.push(data[2]);
            }
        }
    });

    $("#updateselected").on("click", function () {
        if (SelectedID.length == 0) {
            $("#updateselected").removeClass("bg-primary").addClass("bg-secondary shack").attr("data-bs-toggle", "tooltip").attr("data-bs-placement", "top").attr("data-bs-title", "Please select an item to update").tooltip("show").delay(1000).queue(function () {
                $(this).removeClass("bg-secondary shack").addClass("bg-primary").attr("data-bs-title", "").tooltip("hide").dequeue();
            });
            return;
        }

        if (OutofStock.length > 0) {
            $("#updateselected").removeClass("bg-primary").addClass("bg-warning shack").attr("data-bs-toggle", "tooltip").attr("data-bs-placement", "top").attr("data-bs-title", "You have selected out of stock item(s)").tooltip("show").delay(1000).queue(function () {
                $(this).removeClass("bg-warning shack").addClass("bg-primary").attr("data-bs-title", "").tooltip("hide").dequeue();
            });
            return;
        }

        if (Filename == "Prepering.php") {
            $("#PS").attr("Hidden", true);
            $("#DS").attr("disabled", true);
        }

        if (Filename == "ToShit.php") {
            $("#PS").attr("Hidden", true);
            $("#SS").attr("Hidden", true);
        }

        if (Filename == "Cancelled.php") {
            $("#PS").attr("disabled", true);
            $("#DS").attr("disabled", true);
            $("#SS").attr("disabled", true);
            $("#CS").attr("hidden", true);
            $("#EM").html("You can no longer update the status of this order");
        }

        if (Filename == "Delivered.php") {
            $("#PS").attr("disabled", true);
            $("#DS").attr("disabled", true);
            $("#SS").attr("disabled", true);
            $("#CS").attr("disabled", true);
            $("#EM").html("All orders are delivered, No Update Required");
        }

        var StatusList = $("#StatusList");
        StatusList.empty();
        SelectedName.forEach((element) => {
            StatusList.append(
                '<li class="list-group-item">' + element + "</li>"
            );
        });

        modal("show", "updatestatus");
    });

    async function updateStatus() {
        var data = {
            "SelectedID": SelectedID,
            "Status": $("#StatusSelect").val(),
        };

        try {
            const response = await fetch("../../../Utilities/api/UpdateStatus.php",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                }
            );

            if (!response.ok) {
                throw new Error("Network response was not ok");
            }

            const returnInfo = await response.json();

            if (returnInfo.status == "error") {
                console.log(returnInfo.message);
                loading("hide");
                return;
            }

            if (returnInfo.status == "success") {
                loading("hide");
                modal("hide", "updatestatus");
                Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).fire({
                    icon: returnInfo.status,
                    title: returnInfo.message,
                }).then(() => {
                    location.reload();
                });
            }
        } catch (error) {
            console.error(error);
        }
    }

    function loading(status) {
        if (status == "show") {
            Swal.mixin({
                toast: true,
                position: "top",
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            }).fire({
                icon: "info",
                title: "Plase wait while we process your request",
            });
        } else if (status == "hide") {
            Swal.close();
        }
    }

    $("#itemupstat").on("click", async function () {
        var StatusSelect = $("#StatusSelect").val();

        if (StatusSelect == "Select Status") {
            $("#itemupstat").removeClass("bg-primary").addClass("bg-danger shack").delay(1000).queue(function () {
                $(this).removeClass("bg-danger shack").addClass("bg-primary").dequeue();
            });
            return;
        }

        if (StatusSelect == "Cancelled") {
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to cancel the selected order(s)",
                icon: "warning",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes, cancel it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    loading("show");
                    updateStatus();
                    console.log(SelectedName);
                }
            });
            return;
        }

        loading("show");
        console.log(SelectedID);
        updateStatus();
    });
});