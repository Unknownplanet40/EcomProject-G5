function tableReady() {
  $("#loader").addClass("d-none");
  $("#ProductTable").removeClass("d-none");
}

function clearModal() {
  $("#UID").val("");
  $("#Prod_Name").val("");
  $("#Price").val("");
  $("#Brand").val("");
  $("#Color").val("");
  $("#S").val("");
  $("#M").val("");
  $("#L").val("");
  $("#XL").val("");
  $("#Pic-1").attr("src", "../../../Assets/Images/Alternative.gif");
  $("#Pic-2").attr("src", "../../../Assets/Images/Alternative.gif");
  $("#Pic-3").attr("src", "../../../Assets/Images/Alternative.gif");
  $("#Pic-4").attr("src", "../../../Assets/Images/Alternative.gif");
}

async function UpdateImage(ImageFile, UID, Order) {
  try {
    const formData = new FormData();
    formData.append("Image", ImageFile);
    formData.append("UID", UID);
    formData.append("Order", Order);

    const response = await fetch("../../../Utilities/api/UpdateImage.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
    } else {
      console.log(data);
    }
  } catch (error) {
    console.error(error);
  }
}

function ValidImage(ImageFile, ImageID, Order) {
  var file = ImageFile;
  var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
  var validSize = 1024 * 1024 * 5; // 5MB

  if (file) {
    if ($.inArray(file.type, ValidImageTypes) === -1) {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      }).fire({
        icon: "error",
        title:
          "Invalid image format. Please upload a valid image format (JPEG, PNG, GIF).",
      });
      return;
    } else if (file.size > validSize) {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      }).fire({
        icon: "error",
        title: "Image size should not exceed 5MB",
      });
      return;
    } else {
      UpdateImage(file, $("#UID").val(), Order);
      var reader = new FileReader();
      reader.onload = function () {
        var imageID = "#" + ImageID;
        $(imageID).attr("src", reader.result);
      };
      reader.readAsDataURL(file);
    }
  }
}


async function GetProductData(url) {
  try {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
    } else {
      $("#UID").val(data.UID);
      $("#Prod_Name").val(data.Prod_Name);
      $("#Price").val(data.Price);
      $("#Brand").val(data.Brand);
      $("#Color").val(data.Color);
      $("#S").val(data.Sizes[0].S);
      $("#M").val(data.Sizes[0].M);
      $("#L").val(data.Sizes[0].L);
      $("#XL").val(data.Sizes[0].XL);
      // change Pic-1 src to data.Sizes[0].Img_Path

      $("#Pic-1").attr("src", data.Images[0].Img_Path);
      $("#Pic-2").attr("src", data.Images[1].Img_Path);
      $("#Pic-3").attr("src", data.Images[2].Img_Path);
      $("#Pic-4").attr("src", data.Images[3].Img_Path);
    }
  } catch (error) {
    console.error(error);
  }
}


$(document).ready(function () {
  tableReady();
  var Table = $("#ProductTable").DataTable({
    // 2 rows per page
    pageLength: 10,
    layout: {
      topStart: {
        pageLength: {
          menu: [5, 10, 25, 50, 100],
        },
      },
      topEnd: {
        search: {
          text: "_INPUT_",
          placeholder: "Type search here",
        },
      },
    },
    initComplete: function () {},

    columnDefs: [
      {
        data: null,
        defaultContent:
          '<td class="d-flex justify-content-evenly"><button type="button" class="btn btn-sm btn-outline-success"><svg class="bi" width="16" height="16" fill="currentColor"><use xlink:href="#Pencil" /></svg><span>Edit</span></button><button type="button" class="btn btn-sm btn-danger"><svg class="bi" width="16" height="16" fill="currentColor"><use xlink:href="#Trash" /></svg><span class="visually-hidden">Delete</span></button></td>',
        targets: -1,
      },
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
        targets: [7],
        searchable: false,
      },
    ],
    ordering: false,
  });

  $("#ProductTable tbody").on("click", "button", function () {
    var data = Table.row($(this).parents("tr")).data();
    if ($(this).text() === "Edit") {
      clearModal();
      GetProductData(`../../../Utilities/api/AdminProducts.php?id=${data[1]}`);
      var modal = new bootstrap.Modal(document.getElementById("ProdModal"));
      modal.show();
      $("#Pic-1").click(function () {
        $("#Image-1").click();
      });

      $("#Pic-2").click(function () {
        $("#Image-2").click();
      });

      $("#Pic-3").click(function () {
        $("#Image-3").click();
      });

      $("#Pic-4").click(function () {
        $("#Image-4").click();
      });

      $("#Pic-5").click(function () {
        $("#Image-5").click();
      });

      $("#Image-1").change(function () {
        ValidImage(this.files[0], "Pic-1", 1);
      });

      $("#Image-2").change(function () {
        ValidImage(this.files[0], "Pic-2", 2);
      });

      $("#Image-3").change(function () {
        ValidImage(this.files[0], "Pic-3", 3);
      });

      $("#Image-4").change(function () {
        ValidImage(this.files[0], "Pic-4", 4);
      });
    } else {
      // delete the product with the id of data[1]
    }
  });
});
