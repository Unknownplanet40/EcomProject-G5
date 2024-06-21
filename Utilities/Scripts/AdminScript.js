function tableReady1() {
  $("#loader").addClass("d-none");
  $("#AdminTable").removeClass("d-none");
}

function tableReady2() {
  $("#loader").addClass("d-none");
  $("#UserTable").removeClass("d-none");
}

function tableReady3() {
  $("#loader").addClass("d-none");
  $("#SellerTable").removeClass("d-none");
}

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
  tableReady1(); // for Admin
  tableReady2(); // for Seller
  tableReady3(); // for User

  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );

  // Initialize DataTables for Admin, Seller, and User
  var Admin = $("#AdminTable").DataTable({
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
        visible: false,
      },
      {
        targets: [1],
        searchable: false,
        visible: false,
      },
      {
        targets: [5],
        visible: false,
      },
      {
        targets: [8],
        searchable: false,
        visible: false,
      },
      {
        data: null,
        defaultContent:
          '<div class="btn-group btn-group-sm" role="group"><button type="button" id="Edit" class="btn btn-sm btn-primary me-1"><svg class="bi" width="14" height="14" fill="currentColor"><use xlink:href="#Pencil" /></svg></span></button><button type="button" id="Remove" class="btn btn-sm btn-danger"><svg class="bi" width="14" height="14" fill="currentColor"><use xlink:href="#Trash" /></svg></span></button></div>',
        targets: -1,
      },
    ],
  });

  var Seller = $("#SellerTable").DataTable({
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

  var User = $("#UserTable").DataTable({
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

  // Search Functions for Admin, Seller, and User
  $("#SearchAdmin").on("keyup", function () {
    $("#AdminTable").DataTable().search(this.value).draw();
  });

  $("#SearchProduct").on("keyup", function () {
    // pass value to dt-search-0
    $("#ProductTable").DataTable().search(this.value).draw();
  });

  $("#AdminTable tbody").on("click", "#Edit", async function () {
    var data = Admin.row($(this).parents("tr")).data();
    console.log(data);

    try {
      const response = await fetch(
        "../../../Utilities/api/Special_UserInfo.php?ID=" +
          data[1] +
          "&Role=" +
          data[8]
      );

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const UserInfo = await response.json();

      if (UserInfo.status == "error") {
        console.log(UserInfo.message);
        return;
      }

      if (UserInfo.status == "success") {
        modal("show", "UserInfo");
        $("#UserInfo #User_ID").val(data[1]);
        if (User_ID == data[1]) {
          $("#UserInfo .modal-title").text("Your Information");
        } else {
          $("#UserInfo .modal-title").text("Account Information");
        }
        $("#UserInfo #First_Name").val(UserInfo.data.First_Name);
        $("#UserInfo #First_Name").data("fname", UserInfo.data.First_Name);
        $("#UserInfo #Last_Name").val(UserInfo.data.Last_Name);
        $("#UserInfo #Last_Name").data("lname", UserInfo.data.Last_Name);
        $("#UserInfo #Email_Address").val(data[4]);
        $("#UserInfo #Email_Address").data("email", data[4]);
        $("#UserInfo #Password").val(data[5]);
        $("#UserInfo #Gender").val(data[6]);
        $("#UserInfo #Gender").data("gender", data[6]);
        $("#UserInfo #Status").val(data[7]);
        $("#UserInfo #Status").data("status", data[7]);
        $("#UserInfo #Role").val(data[8]);
        $("#UserInfo #Role").data("role", data[8]);
        $("#UserInfo #Contact").val(UserInfo.data.ContactInfo);
        $("#UserInfo #Contact").data("contact", UserInfo.data.ContactInfo);

        if (UserInfo.data.Have_Address == "Yes") {
          $("#UserInfo #Province").val(UserInfo.data.Address.Province);
          $("#UserInfo #Province").data(
            "province",
            UserInfo.data.Address.Province
          );
          $("#UserInfo #Municipality").val(UserInfo.data.Address.Municipality);
          $("#UserInfo #Municipality").data(
            "municipality",
            UserInfo.data.Address.Municipality
          );
          $("#UserInfo #Barangay").val(UserInfo.data.Address.Barangay);
          $("#UserInfo #Barangay").data(
            "barangay",
            UserInfo.data.Address.Barangay
          );
          $("#UserInfo #HouseNo").val(UserInfo.data.Address.HouseNo);
          $("#UserInfo #HouseNo").data("house", UserInfo.data.Address.HouseNo);
          $("#UserInfo #Zipcode").val(UserInfo.data.Address.Zipcode);
          $("#UserInfo #Zipcode").data("zip", UserInfo.data.Address.Zipcode);
          $("#UserInfo #Landmark").val(UserInfo.data.Address.Landmark);
          $("#UserInfo #Landmark").data(
            "landmark",
            UserInfo.data.Address.Landmark
          );
          $("#UserInfo #SaveUser").data("stat1", "true");
        }
      }
    } catch (error) {
      console.error(error);
    }
  });

  $("#AdminTable tbody").on("click", "#Remove", function () {
    var data = Admin.row($(this).parents("tr")).data();

    if (User_ID == data[1]) {
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
        icon: "warning",
        title: "You cannot delete your own account",
      });
      return;
    }

    var rowCount = $("#AdminTable tbody tr").length;

    if (rowCount == 1) {
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
        icon: "warning",
        title: "You cannot delete the last account",
      });
      return;
    }

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
      if (result.isConfirmed) {
        try {
          const response = await fetch(
            "../../../Utilities/api/Special_UserInfo.php?delete=1&ID=" + data[1]
          );

          if (!response.ok) {
            throw new Error("Network response was not ok");
          }

          const UserInfo = await response.json();

          if (UserInfo.status == "error") {
            console.log(UserInfo.message);
            return;
          }

          if (UserInfo.status == "success") {
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
                icon: UserInfo.status,
                title: UserInfo.message,
              })
              .then(() => {
                location.reload();
              });
          }
        } catch (error) {
          console.error(error);
        }
      }
    });
  });

  $("#SaveUser").on("click", async function () {
    var NameFile = localStorage.getItem("FileName");
    var HaveAddress = $(this).data("stat1");
    var isChanged = [];
    var stats = ["Active", "Inactive", "Suspended"];
    var roles = ["admin", "seller", "user"];
    var Sex = ["Male", "Female"];
    switch (NameFile) {
      case "Account-Admin.php":
        if (
          $("#First_Name").val() == "" ||
          $("#Last_Name").val() == "" ||
          $("#Email_Address").val() == "" ||
          $("#Gender").val() == "" ||
          $("#Status").val() == "" ||
          $("#Role").val() == ""
        ) {
          const Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "warning",
            title: "Please fill up all the fields",
          });
          return;
        }

        if (HaveAddress == "true") {
          if (
            $("#Province").val() == "" ||
            $("#Municipality").val() == "" ||
            $("#Barangay").val() == "" ||
            $("#HouseNo").val() == "" ||
            $("#Zipcode").val() == ""
          ) {
            const Toast = Swal.mixin({
              toast: true,
              position: "top",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "warning",
              title: "Please fill up all the fields",
            });
            return;
          }
        }

        if ($("#Email_Address").val() != $("#Email_Address").data("email")) {
          var EmailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
          if (!EmailRegex.test($("#Email_Address").val())) {
            const Toast = Swal.mixin({
              toast: true,
              position: "top",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "warning",
              title: "Invalid Email Address",
            });

            $("#Email_Address").addClass("is-invalid");
            setTimeout(() => {
              $("#Email_Address").removeClass("is-invalid");
            }, 1500);
            return;
          }
        }

        if (isNaN($("#Contact").val())) {
          $("#Contact").addClass("is-invalid");
          setTimeout(() => {
            $("#Contact").removeClass("is-invalid");
          }, 1500);
          return;
        } else if ($("#Contact").val().length != 11) {
          $("#Contact").addClass("is-invalid");
          setTimeout(() => {
            $("#Contact").removeClass("is-invalid");
          }, 1500);
          return;
        }

        if ($("#Zipcode").val().length != 4) {
          $("#Zipcode").addClass("is-invalid");
          setTimeout(() => {
            $("#Zipcode").removeClass("is-invalid");
          }, 1500);
          return;
        } else if (isNaN($("#Zipcode").val())) {
          $("#Zipcode").addClass("is-invalid");
          setTimeout(() => {
            $("#Zipcode").removeClass("is-invalid");
          }, 1500);
          return;
        }

        if (roles.indexOf($("#Role").val()) == -1) {
          $("#Role").addClass("is-invalid");
          setTimeout(() => {
            $("#Role").removeClass("is-invalid");
          }, 1500);
          return;
        }

        if (stats.indexOf($("#Status").val()) == -1) {
          $("#Status").addClass("is-invalid");
          setTimeout(() => {
            $("#Status").removeClass("is-invalid");
          }, 1500);
          return;
        }

        if (Sex.indexOf($("#Gender").val()) == -1) {
          $("#Gender").addClass("is-invalid");
          setTimeout(() => {
            $("#Gender").removeClass("is-invalid");
          }, 1500);
          return;
        }

        if ($("#Province").val() != $("#Province").data("province")) {
          isChanged.push("Province");
        }

        if (
          $("#Municipality").val() != $("#Municipality").data("municipality")
        ) {
          isChanged.push("Municipality");
        }

        if ($("#Barangay").val() != $("#Barangay").data("barangay")) {
          isChanged.push("Barangay");
        }

        if ($("#HouseNo").val() != $("#HouseNo").data("house")) {
          isChanged.push("House No");
        }

        if ($("#Zipcode").val() != $("#Zipcode").data("zip")) {
          isChanged.push("Zipcode");
        }

        if ($("#Landmark").val() != $("#Landmark").data("landmark")) {
          isChanged.push("Landmark");
        }

        var data = {
          ID: $("#User_ID").val(),
          First_Name: $("#First_Name").val(),
          Last_Name: $("#Last_Name").val(),
          Email_Address: $("#Email_Address").val(),
          Gender: $("#Gender").val(),
          Role: $("#Role").val(),
          Contact: $("#Contact").val(),
          Status: $("#Status").val(),
          isChanged: isChanged,
          Have_Address: HaveAddress,
          Province: $("#Province").val(),
          Municipality: $("#Municipality").val(),
          Barangay: $("#Barangay").val(),
          HouseNo: $("#HouseNo").val(),
          Zipcode: $("#Zipcode").val(),
          Landmark: $("#Landmark").val(),
        };

        try {
          const response = await fetch(
            "../../../Utilities/api/Special_UserInfo.php?update=1",
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

          const UserInfo = await response.json();

          if (UserInfo.status == "error") {
            console.log(UserInfo.message);
            return;
          }

          if (UserInfo.status == "success") {
            modal("hide", "UserInfo");
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
                icon: UserInfo.status,
                title: UserInfo.message,
              })
              .then(() => {
                location.reload();
              });
          }
        } catch (error) {
          console.error(error);
        }

        break;
      case "Seller":
        break;
      case "User":
        break;
      default:
        break;
    }
  });

  $("#resetPass").on("click", function () {
    modal("hide", "UserInfo");
    modal("show", "PasswordReset");
  });

  $("#ShowPassword").on("click", function () {
    var newPasswordInput = $("#NewPassword");
    var newPasswordValue = newPasswordInput.val();

    if (newPasswordValue === "") {
      newPasswordInput.addClass("is-invalid");
      setTimeout(() => {
        newPasswordInput.removeClass("is-invalid");
      }, 1500);
      return;
    } else {
      if (newPasswordInput.prop("type") === "password") {
        $("#SP-label").html('<use xlink:href="#Visible-off" />');
        newPasswordInput.prop("type", "text");
      } else {
        $("#SP-label").html('<use xlink:href="#Visible" />');
        newPasswordInput.prop("type", "password");
      }
    }
  });

  $("#ShowConfirm").on("click", function () {
    var confirmPasswordInput = $("#ConfirmPassword");
    var confirmPasswordValue = confirmPasswordInput.val();

    if (confirmPasswordValue === "") {
      confirmPasswordInput.addClass("is-invalid");
      setTimeout(() => {
        confirmPasswordInput.removeClass("is-invalid");
      }, 1500);
      return;
    } else {
      if (confirmPasswordInput.prop("type") === "password") {
        $("#SC-label").html('<use xlink:href="#Visible-off" />');
        confirmPasswordInput.prop("type", "text");
      } else {
        $("#SC-label").html('<use xlink:href="#Visible" />');
        confirmPasswordInput.prop("type", "password");
      }
    }
  });

  $("#PasswordReset #SavePassword").on("click", async function () {
    var UserID = $("#User_ID").val();

    if ($("#PasswordReset #NewPassword").val() == "") {
      $("#PasswordReset #NewPassword").addClass("is-invalid");
      setTimeout(() => {
        $("#PasswordReset #NewPassword").removeClass("is-invalid");
      }, 1500);
      return;
    }

    if ($("#PasswordReset #ConfirmPassword").val() == "") {
      $("#PasswordReset #ConfirmPassword").addClass("is-invalid");
      setTimeout(() => {
        $("#PasswordReset #ConfirmPassword").removeClass("is-invalid");
      }, 1500);
      return;
    }

    if (
      $("#PasswordReset #NewPassword").val() !=
      $("#PasswordReset #ConfirmPassword").val()
    ) {
      $("#PasswordReset #NewPassword").addClass("is-invalid");
      $("#PasswordReset #ConfirmPassword").addClass("is-invalid");
      setTimeout(() => {
        $("#PasswordReset #NewPassword").removeClass("is-invalid");
        $("#PasswordReset #ConfirmPassword").removeClass("is-invalid");
      }, 1500);
      return;
    }

    var data = {
      ID: UserID,
      Password: $("#NewPassword").val(),
      Email_Address: $("#Email_Address").val(),
    };

    try {
      const response = await fetch(
        "../../../Utilities/api/Special_UserInfo.php?reset=1",
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

      const UserInfo = await response.json();

      if (UserInfo.status == "error") {
        console.log(UserInfo.message);
        return;
      }

      if (UserInfo.status == "success") {
        modal("hide", "PasswordReset");
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
            icon: UserInfo.status,
            title: UserInfo.message,
          })
          .then(() => {
            location.reload();
          });
      }
    } catch (error) {
      console.error(error);
    }
  });

  $("#AddAdmin").on("click", function () {
    modal("show", "AddAdminModal");
  });

  $("#RandomPassword").on("click", function () {
    var password = "";
    var upperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var lowerCase = "abcdefghijklmnopqrstuvwxyz";
    var numbers = "0123456789";
    var specialChar = "!@#$%^&*()_+";
    var allChars = upperCase + lowerCase + numbers + specialChar;

    for (var i = 0; i < 12; i++) {
      var char = Math.floor(Math.random() * allChars.length);
      password += allChars.charAt(char);
    }

    $("#New_Password").val(password);
  });

  $("#AddnewUser").on("click", async function () {
    var New_FirstName = $("#New_FirstName");
    var New_LastName = $("#New_LastName");
    var New_Email = $("#New_Email");
    var New_Password = $("#New_Password");
    var New_Contact = $("#New_Contact");
    var New_Role = $("#New_Role");
    var New_Status = $("#New_Status");
    var New_Gender = $("#New_Gender");
    var validEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var validContact = /^[0-9]{11}$/;

    if (
      New_FirstName.val() == "" ||
      New_LastName.val() == "" ||
      New_Email.val() == "" ||
      New_Password.val() == "" ||
      New_Contact.val() == "" ||
      New_Role.val() == "" ||
      New_Status.val() == "" ||
      New_Gender.val() == ""
    ) {
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
        icon: "warning",
        title: "Please fill up all the fields",
      });
      return;
    }

    if (!validEmail.test(New_Email.val())) {
      New_Email.addClass("is-invalid");
      setTimeout(() => {
        New_Email.removeClass("is-invalid");
      }, 1500);
      return;
    }

    if (!validContact.test(New_Contact.val())) {
      New_Contact.addClass("is-invalid");
      setTimeout(() => {
        New_Contact.removeClass("is-invalid");
      }, 1500);
      return;
    } else if (New_Contact.val().length != 11) {
      New_Contact.addClass("is-invalid");
      setTimeout(() => {
        New_Contact.removeClass("is-invalid");
      }, 1500);
      return;
    } else if (isNaN(New_Contact.val())) {
      New_Contact.addClass("is-invalid");
      setTimeout(() => {
        New_Contact.removeClass("is-invalid");
      }, 1500);
      return;
    }

    if (
      New_Role.val() != "admin" &&
      New_Role.val() != "seller" &&
      New_Role.val() != "user"
    ) {
      New_Role.addClass("is-invalid");
      setTimeout(() => {
        New_Role.removeClass("is-invalid");
      }, 1500);
      return;
    }

    if (
      New_Status.val() != "Active" &&
      New_Status.val() != "Inactive" &&
      New_Status.val() != "Suspended"
    ) {
      New_Status.addClass("is-invalid");
      setTimeout(() => {
        New_Status.removeClass("is-invalid");
      }, 1500);
      return;
    }

    if (New_Gender.val() != "Male" && New_Gender.val() != "Female") {
      New_Gender.addClass("is-invalid");
      setTimeout(() => {
        New_Gender.removeClass("is-invalid");
      }, 1500);
      return;
    }

    var data = {
      First_Name: New_FirstName.val(),
      Last_Name: New_LastName.val(),
      Email_Address: New_Email.val(),
      Password: New_Password.val(),
      Contact: New_Contact.val(),
      Role: New_Role.val(),
      Status: New_Status.val(),
      Gender: New_Gender.val(),
    };

    try {
      const response = await fetch(
        "../../../Utilities/api/Special_UserInfo.php?add=1",
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

      const UserInfo = await response.json();

      if (UserInfo.status == "error") {
        console.log(UserInfo.message);
        return;
      }

      if (UserInfo.status == "info") {
        New_Email.addClass("is-invalid");
        $("#NE_FB").html(UserInfo.message);
        setTimeout(() => {
          New_Email.removeClass("is-invalid");
          $("#NE_FB").html("");
        }, 2500);
        return;
      }

      if (UserInfo.status == "success") {
        modal("hide", "AddAdminModal");
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
            icon: UserInfo.status,
            title: UserInfo.message,
          })
          .then(() => {
            location.reload();
          });
      }
    } catch (error) {
      console.error(error);
    }
  });

  $("#AdminArchive").on("click", function () {
    modal("show", "ArchiveUser");
  })
});
