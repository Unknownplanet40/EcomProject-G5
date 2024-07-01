SelectedItem = [];

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

  // data-old attribute
  $("#Prod_Name").attr("data-old", "");
  $("#Price").attr("data-old", "");
  $("#Brand").attr("data-old", "");
  $("#Color").attr("data-old", "");
  $("#S").attr("data-old", "");
  $("#M").attr("data-old", "");
  $("#L").attr("data-old", "");
  $("#XL").attr("data-old", "");
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

function setImage(Image, setto) {
  var file = Image;
  if (file) {
    var reader = new FileReader();
    reader.onload = function () {
      var assign = "#" + setto;
      $(assign).attr("src", reader.result);
    };
    reader.readAsDataURL(file);
  }
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

      $("#Pic-1").attr("src", data.Images[0].Img_Path);
      $("#Pic-2").attr("src", data.Images[1].Img_Path);
      $("#Pic-3").attr("src", data.Images[2].Img_Path);
      $("#Pic-4").attr("src", data.Images[3].Img_Path);

      // data-old attribute
      $("#Prod_Name").attr("data-old", data.Prod_Name);
      $("#Price").attr("data-old", data.Price);
      $("#Brand").attr("data-old", data.Brand);
      $("#Color").attr("data-old", data.Color);
      $("#S").attr("data-old", data.Sizes[0].S);
      $("#M").attr("data-old", data.Sizes[0].M);
      $("#L").attr("data-old", data.Sizes[0].L);
      $("#XL").attr("data-old", data.Sizes[0].XL);
    }
  } catch (error) {
    console.error(error);
  }
}

async function RemoveProduct(UID) {
  try {
    const response = await fetch(
      "../../../Utilities/api/RemoveProduct.php?UID=" + UID
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
    }

    if (data.success) {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      })
        .fire({
          icon: "success",
          title: data.success,
        })
        .then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          } else {
            location.reload();
          }
        });
    }
  } catch (error) {
    console.error(error);
  }
}

async function AddProduct(formData) {
  try {
    const response = await fetch("../../../Utilities/api/AddProduct.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
    }

    if (data.info) {
      console.log(data.info);
    }

    if (data.success) {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      })
        .fire({
          icon: "success",
          title: data.success,
        })
        .then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          } else {
            location.reload();
          }
        });
    }
  } catch (error) {
    console.error(error);
  }
}

async function UpdateProduct(formData) {
  try {
    const response = await fetch("../../../Utilities/api/UpdateProduct.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
    }

    if (data.info) {
      console.log(data.info);
    }

    if (data.success) {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
      })
        .fire({
          icon: "success",
          title: data.success,
        })
        .then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          } else {
            location.reload();
          }
        });
    }
  } catch (error) {
    console.error(error);
  }
}

$("#SearchAdmin").on("keyup", function () {
  // pass value to dt-search-0
  $("#ProductTable").DataTable().search(this.value).draw();
});

$("#AddProduct").click(function () {
  var UID = crypto.randomUUID();
  $("#Prod_ID").val(UID);
  var modal = new bootstrap.Modal(document.getElementById("AddProdModal"));
  modal.show();
});

$("#Img_file1").change(function () {
  setImage(this.files[0], "Img-1");
});

$("#Img_file2").change(function () {
  setImage(this.files[0], "Img-2");
});

$("#Img_file3").change(function () {
  setImage(this.files[0], "Img-3");
});

$("#Img_file4").change(function () {
  setImage(this.files[0], "Img-4");
});

$("#AddBtn").click(function () {
  var Img_1 = $("#Img_file1").val();
  var Img_2 = $("#Img_file2").val();
  var Img_3 = $("#Img_file3").val();
  var Img_4 = $("#Img_file4").val();
  var Prod_ID = $("#Prod_ID").val();
  var Item_Name = $("#Item_Name").val();
  var Prod_Brand = $("#Prod_Brand").val();
  var Prod_Color = $("#Prod_Color").val();
  var Prod_Price = $("#Prod_Price").val();
  var Size_S = $("#Size_S").val();
  var Size_M = $("#Size_M").val();
  var Size_L = $("#Size_L").val();
  var Size_XL = $("#Size_XL").val();
  var validBrand = ["DBTK", "UNDRAFTED", "COZIEST", "MFCKN KIDS", "RICHBOYZ"];
  var allowedImageTypes = ["image/gif", "image/jpeg", "image/png"];
  var validSize = 1024 * 1024 * 5; // 5MB

  function validNumber(ID1, ID2, message) {
    $(ID1).addClass("is-invalid");
    $(ID2).text(message);
    setTimeout(function () {
      $(ID1).removeClass("is-invalid");
      $(ID2).text("");
    }, 1500);
  }

  function validImage(ID1, message) {
    $(ID1).addClass("img-thumbnail border border-danger");
    $("#error-mess").text(message);
    $("#error-mess").addClass("text-danger");
    setTimeout(function () {
      $(ID1).removeClass("img-thumbnail border border-danger");
      $("#error-mess").text("Click to add image");
      $("#error-mess").removeClass("text-danger");
    }, 1500);
  }

  if (Img_1 == "" && Img_2 == "" && Img_3 == "" && Img_4 == "") {
    Swal.mixin({
      toast: true,
      position: "top",
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    }).fire({
      icon: "error",
      title: "Please upload all images",
    });
    return;
  }

  if (Img_1 == "") {
    validImage("#Img-1", "Add Image");
    return;
  } else if (!allowedImageTypes.includes($("#Img_file1")[0].files[0].type)) {
    validImage("#Img-1", "Image 1 format is invalid format");
    return;
  } else if ($("#Img_file1")[0].files[0].size > validSize) {
    validImage("#Img-1", "Image 1 size should not exceed 5MB");
    return;
  }

  if (Img_2 == "") {
    validImage("#Img-2", "Add Image");
    return;
  } else if (!allowedImageTypes.includes($("#Img_file2")[0].files[0].type)) {
    validImage("#Img-2", "Image 2 format is invalid format");
    return;
  } else if ($("#Img_file2")[0].files[0].size > validSize) {
    validImage("#Img-2", "Image 2 size should not exceed 5MB");
    return;
  }

  if (Img_3 == "") {
    validImage("#Img-3", "Add Image");
    return;
  } else if (!allowedImageTypes.includes($("#Img_file3")[0].files[0].type)) {
    validImage("#Img-3", "Image 3 format is invalid format");
    return;
  } else if ($("#Img_file3")[0].files[0].size > validSize) {
    validImage("#Img-3", "Image 3 size should not exceed 5MB");
    return;
  }

  if (Img_4 == "") {
    validImage("#Img-4", "Add Image");
    return;
  } else if (!allowedImageTypes.includes($("#Img_file4")[0].files[0].type)) {
    validImage("#Img-4", "Image 4 format is invalid format");
    return;
  } else if ($("#Img_file4")[0].files[0].size > validSize) {
    validImage("#Img-4", "Image 4 size should not exceed 5MB");
    return;
  }

  if (Item_Name == "") {
    $("#Item_Name").addClass("is-invalid");
    setTimeout(function () {
      $("#Item_Name").removeClass("is-invalid");
    }, 1500);
    return;
  }

  if (Prod_Brand == "") {
    $("#Prod_Brand").addClass("is-invalid");
    setTimeout(function () {
      $("#Prod_Brand").removeClass("is-invalid");
    }, 1500);
    return;
  } else if (!validBrand.includes(Prod_Brand)) {
    $("#Prod_Brand").addClass("is-invalid");
    setTimeout(function () {
      $("#Prod_Brand").removeClass("is-invalid");
    }, 1500);
    return;
  }

  if (Prod_Color == "") {
    $("#Prod_Color").addClass("is-invalid");
    setTimeout(function () {
      $("#Prod_Color").removeClass("is-invalid");
    }, 1500);
    return;
  }

  if (Prod_Price == "") {
    validNumber("#Prod_Price", "#Price-FB", "");
    return;
  } else if (isNaN(Prod_Price)) {
    validNumber("#Prod_Price", "#Price-FB", "Please enter a valid price");
    return;
  } else if (Prod_Price < 0) {
    validNumber("#Prod_Price", "#Price-FB", "Price cannot be negative");
    return;
  }

  if (Size_S == "") {
    validNumber("#Size_S", "#Size_S_FB", "");
    return;
  } else if (isNaN(Size_S)) {
    validNumber("#Size_S", "#Size_S_FB", "Please enter a valid quantity");
    return;
  } else if (Size_S < 0) {
    validNumber("#Size_S", "#Size_S_FB", "Invalid!");
    return;
  }

  if (Size_M == "") {
    validNumber("#Size_M", "#Size_M_FB", "");
    return;
  } else if (isNaN(Size_M)) {
    validNumber("#Size_M", "#Size_M_FB", "Please enter a valid quantity");
    return;
  } else if (Size_M < 0) {
    validNumber("#Size_M", "#Size_M_FB", "Invalid!");
    return;
  }

  if (Size_L == "") {
    validNumber("#Size_L", "#Size_L_FB", "");
    return;
  } else if (isNaN(Size_L)) {
    validNumber("#Size_L", "#Size_L_FB", "Please enter a valid quantity");
    return;
  } else if (Size_L < 0) {
    validNumber("#Size_L", "#Size_L_FB", "Invalid!");
    return;
  }

  if (Size_XL == "") {
    validNumber("#Size_XL", "#Size_XL_FB", "");
    return;
  } else if (isNaN(Size_XL)) {
    validNumber("#Size_XL", "#Size_XL_FB", "Please enter a valid quantity");
    return;
  } else if (Size_XL < 0) {
    validNumber("#Size_XL", "#Size_XL_FB", "Invalid!");
    return;
  }

  var formData = new FormData();
  formData.append("Prod_ID", Prod_ID);
  formData.append("Item_Name", Item_Name);
  formData.append("Prod_Brand", Prod_Brand);
  formData.append("Prod_Color", Prod_Color);
  formData.append("Prod_Price", Prod_Price);
  formData.append("Size_S", Size_S);
  formData.append("Size_M", Size_M);
  formData.append("Size_L", Size_L);
  formData.append("Size_XL", Size_XL);
  formData.append("Img_1", $("#Img_file1")[0].files[0]);
  formData.append("Img_2", $("#Img_file2")[0].files[0]);
  formData.append("Img_3", $("#Img_file3")[0].files[0]);
  formData.append("Img_4", $("#Img_file4")[0].files[0]);

  AddProduct(formData);
});

$("#UpdateBtn").click(function () {
  var UID = $("#UID").val();
  var Prod_Name = $("#Prod_Name").val();
  var Price = $("#Price").val();
  var Brand = $("#Brand").val();
  var Color = $("#Color").val();
  var S = $("#S").val();
  var M = $("#M").val();
  var L = $("#L").val();
  var XL = $("#XL").val();

  var validBrand = ["DBTK", "UNDRAFTED", "COZIEST", "MFCKN KIDS", "RICHBOYZ"];

  function validNumber(ID1, ID2, message) {
    $(ID1).addClass("is-invalid");
    $(ID2).text(message);
    setTimeout(function () {
      $(ID1).removeClass("is-invalid");
      $(ID2).text("");
    }, 1500);
  }

  if (Prod_Name == "") {
    $("#Prod_Name").addClass("is-invalid");
    setTimeout(function () {
      $("#Prod_Name").removeClass("is-invalid");
    }, 1500);
    return;
  }

  if (Brand == "") {
    $("#Brand").addClass("is-invalid");
    setTimeout(function () {
      $("#Brand").removeClass("is-invalid");
    }, 1500);
    return;
  } else if (!validBrand.includes(Brand)) {
    $("#Brand").addClass("is-invalid");
    $("#BM_FB").text("Please select a valid brand");
    setTimeout(function () {
      $("#Brand").removeClass("is-invalid");
      $("#BM_FB").text("");
    }, 1500);
    return;
  }

  if (Price == "") {
    validNumber("#Price", "", "");
    return;
  } else if (isNaN(Price)) {
    validNumber("#Price", "#PM_FB", "Please enter a valid price");
    return;
  } else if (Price < 0) {
    validNumber("#Price", "#PM_FB", "Price cannot be negative");
    return;
  }

  if (Color == "") {
    $("#Color").addClass("is-invalid");
    setTimeout(function () {
      $("#Color").removeClass("is-invalid");
    }, 1500);
    return;
  }

  if (S == "") {
    validNumber("#S", "", "");
    return;
  } else if (isNaN(S)) {
    validNumber("#S", "", "");
    return;
  } else if (S < 0) {
    validNumber("#S", "", "");
    return;
  }

  if (M == "") {
    validNumber("#M", "", "");
    return;
  } else if (isNaN(M)) {
    validNumber("#M", "", "");
    return;
  } else if (M < 0) {
    validNumber("#M", "", "");
    return;
  }

  if (L == "") {
    validNumber("#L", "", "");
    return;
  } else if (isNaN(L)) {
    validNumber("#L", "", "");
    return;
  } else if (L < 0) {
    validNumber("#L", "", "");
    return;
  }

  if (XL == "") {
    validNumber("#XL", "", "");
    return;
  } else if (isNaN(XL)) {
    validNumber("#XL", "", "");
    return;
  } else if (XL < 0) {
    validNumber("#XL", "", "");
    return;
  }

  // compare data-old with current data
  var Prod_Name_Old = $("#Prod_Name").attr("data-old");
  var Price_Old = $("#Price").attr("data-old");
  var Brand_Old = $("#Brand").attr("data-old");
  var Color_Old = $("#Color").attr("data-old");
  var S_Old = $("#S").attr("data-old");
  var M_Old = $("#M").attr("data-old");
  var L_Old = $("#L").attr("data-old");
  var XL_Old = $("#XL").attr("data-old");

  if (
    Prod_Name == Prod_Name_Old &&
    Price == Price_Old &&
    Brand == Brand_Old &&
    Color == Color_Old &&
    S == S_Old &&
    M == M_Old &&
    L == L_Old &&
    XL == XL_Old
  ) {
    $("#uplabel").text("No changes detected");
    $("#uplabel").removeClass("d-none");
    setTimeout(function () {
      $("#uplabel").addClass("d-none");
    }, 1500);
  } else {
    var formData = new FormData();
    formData.append("UID", UID);
    formData.append("Prod_Name", Prod_Name);
    formData.append("Price", Price);
    formData.append("Brand", Brand);
    formData.append("Color", Color);
    formData.append("S", S);
    formData.append("M", M);
    formData.append("L", L);
    formData.append("XL", XL);

    UpdateProduct(formData);
  }
});

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
    initComplete: function () {},

    columnDefs: [
      {
        data: null,
        defaultContent:
          '<div class="btn-group btn-group-sm" role="group"><button type="button" id="Edit" class="btn btn-sm btn-primary me-1"><svg class="bi" width="14" height="14" fill="currentColor"><use xlink:href="#Pencil" /></svg></span></button><button type="button" id="Remove" class="btn btn-sm btn-danger"><svg class="bi" width="14" height="14" fill="currentColor"><use xlink:href="#Trash" /></svg></span></button></div>',
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
        targets: [6],
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
    if ($(this).attr("id") === "Edit") {
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
      // check row count
      if (Table.rows().count() == 1) {
        Swal.fire({
          title: "Are you sure?",
          text: "You are about to Archive the last product. This action will remove the product from the list.",
          icon: "warning",
          customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-primary",
          },
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Yes, archive it!",
        }).then((result) => {
          if (result.isConfirmed) {
            RemoveProduct(data[1]);
          }
        });
        return;
      }

      Swal.fire({
        title: "Are you sure?",
        text: "You want to archive this product?",
        icon: "warning",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-primary",
        },
        showCancelButton: false,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, archive it!",
      }).then((result) => {
        if (result.isConfirmed) {
          RemoveProduct(data[1]);
        }
      });
    }
  });

  $("#SearchProduct").on("keyup", function () {
    Table.search(this.value).draw();
  });

  $('#ArchiveProduct').on("click", async function(){
    modal("show", "ArchiveUser");

    try {
      const response = await fetch("../../../Utilities/api/GetProdArchive.php?archive=0&brand=" + Brand);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const UserInfo = await response.json();

      if (UserInfo.status == "error") {
        console.error(UserInfo.error);
      }

      if (UserInfo.status == "success") {
        $("#nodata").addClass("d-none");
        $("#ArchiveList").removeClass("d-none");
        $("#ArchiveList tbody").empty();

        var list = $("#ArchiveList");

        for (var i = 0; i < UserInfo.data.length; i++) {
          var li = $("<li>").addClass("list-group-item d-flex justify-content-between align-items-start");
          var input = $("<input>").addClass("form-check-input me-1").attr("type", "checkbox").attr("id", "CB_" + UserInfo.data[i].ID);
          var div1 = $("<div>").addClass("ms-2 me-auto");
          var div2 = $("<div>").addClass("fw-bold");
          var label = $("<label>").text(UserInfo.data[i].Prod_Name).attr("for", "CB_" + UserInfo.data[i].ID);
          var span = $("<span>").text("Color: " + UserInfo.data[i].Color + " | Price: " + UserInfo.data[i].Price + " | Popularity: " + UserInfo.data[i].Popularity);
          var span2 = $("<span>").addClass("badge text-bg-secondary rounded text-uppercase").text("Removed").attr("id", "Status_" + UserInfo.data[i].ID);

          div2.append(label);
          div1.append(div2, span);
          li.append(input, div1, span2);
          list.append(li);

          //event listener for checkbox
          $("#CB_" + UserInfo.data[i].ID).on("change", function () {
            var ID = $(this).attr("id").substring(3);
            if ($(this).is(":checked")) {
              SelectedItem.push(ID);
              $("#Status_" + ID).removeClass("text-bg-secondary").addClass("text-bg-primary").text("Selected");
            } else {
              $("#Status_" + ID).removeClass("text-bg-primary").addClass("text-bg-secondary").text("Removed");
              var index = SelectedItem.indexOf(ID);
              SelectedItem.splice(index, 1);
            }
          });
        }
      }
    } catch (error) {
      console.error(error);
    }
  });

  $("#RestoreUser").on("click", async function(){
    if (SelectedItem.length == 0) {
      $('#RestoreUser').removeClass("btn-primary").addClass("btn-secondary shack").text("No item selected").attr("disabled", true);

      setTimeout(function () {
        $('#RestoreUser').removeClass("btn-secondary shack").addClass("btn-primary").text("Restore Selected").attr("disabled", false);
      }, 1500);
      return;
    }

    try {
      const response = await fetch("../../../Utilities/api/GetProdArchive.php?delete=alluserpersonalinformations", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ data: SelectedItem }),
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (data.status == "error") {
        console.error(data.message);
      }

      if (data.status == "success") {
        modal("hide", "ArchiveUser");
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
          },
        })
          .fire({
            icon: data.status,
            title: data.message,
          })
          .then((result) => {
            SelectedItem = [];
            if (result.dismiss === Swal.DismissReason.timer) {
              location.reload();
            } else {
              location.reload();
            }
          });
      }
    } catch (error) {
      console.error(error);
    }
  });


});
