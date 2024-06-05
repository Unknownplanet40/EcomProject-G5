function tableReady() {
  $("#loader").addClass("d-none");
  $("#AdminTable").removeClass("d-none");
}

$(document).ready(function () {
  tableReady();
  var table = $("#AdminTable").DataTable({
    pageLength: 10,
    responsive: true,
    layout: {
      topStart: {
        pageLength: {
          menu: [5, 10, 25, 50, 100],
        },
      },
      topEnd: {},
    },
    columnDefs: [
      {
        targets: [0],
        searchable: false,
      },
      {
        targets: [1],
        searchable: false,
        visible: false,
      },
      {
        targets: [4],
        visible: false,
      },
      {
        data: null,
        defaultContent:
          '<button type="button" id="Edit" class="btn btn-sm btn-primary me-1"><svg class="bi" width="14" height="14" fill="currentColor"><use xlink:href="#Pencil" /></svg></span></button><button type="button" id="Remove" class="btn btn-sm btn-danger"><svg class="bi" width="14" height="14" fill="currentColor"><use xlink:href="#Trash" /></svg></span></button>',
        targets: -1,
      },
    ],
  });
  
  $("#AdminTable tbody").on("click", "#Edit", function () {
    var data = table.row($(this).parents("tr")).data();

    getinfos(data[1]);
  });

  $("#AdminTable tbody").on("click", "#Remove", function () {
    var data = table.row($(this).parents("tr")).data();
  });
});
