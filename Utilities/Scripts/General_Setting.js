/* Global variables here */
let ispassVisible = false;
let olddata = [];
let oldpayment = [];
let returncode = 0;
let payments = [];

// check if user is online or offline and disable input fields if offline
setInterval(function () {
  let isoffline = navigator.onLine ? false : true;
  if (isoffline) {
    var Email = document.getElementById("Email");
    Email.setAttribute("disabled", "true");
  } else {
    var Email = document.getElementById("Email");
    Email.removeAttribute("disabled");
  }
});

/* Asynchronous functions here */
async function postTheme(theme) {
  try {
    const response = await fetch(
      "../../Utilities/api/Updatetheme.php?theme=" + theme
    );

    if (!response.ok) {
      throw new Error("An error occurred while updating the theme");
    }

    const data = await response.json();

    if (data.status === "error") {
      console.error(data.message);
    }

    if (data.status === "success") {
      /* Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      }).fire({
        icon: "success",
        text: "Theme updated successfully",
      }); */
      return;
    }
  } catch (error) {
    console.error(error);
  }
}

async function postProfileImage(type, imageFile) {
  try {
    const formData = new FormData();
    formData.append("UserID", User_ID);
    formData.append("image", imageFile);

    const response = await fetch(
      `../../Utilities/api/UserInfo.php?profile=${type}`,
      {
        method: "POST",
        body: formData,
      }
    );

    if (!response.ok) {
      throw new Error("An error occurred while updating the profile image");
    }

    const data = await response.json();

    if (data.status === "error") {
      console.error(data.message);
    }

    if (data.status === "success") {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      })
        .fire({
          icon: data.status,
          text: data.message,
        })
        .then(() => {
          getProfileDetails();
        });
      return;
    }
  } catch (error) {
    console.error(error);
  }
}

async function postProfileDetails(fname, lname, contact, email, Gender) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?update=info",
      {
        method: "POST",
        body: JSON.stringify({
          UserID: User_ID,
          firstname: fname,
          lastname: lname,
          contact: contact,
          email: email,
          gender: Gender,
        }),
        headers: {
          "Content-type": "application/json; charset=UTF-8",
        },
      }
    );

    if (!response.ok) {
      throw new Error("An error occurred while updating the profile");
    }

    const data = await response.json();

    if (data.status === "error") {
      console.error(data.message);
    }

    if (data.status === "success") {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      }).fire({
        icon: data.status,
        text: data.message,
      });
      getProfileDetails();
      return;
    } else if (data.status === "info") {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      }).fire({
        icon: data.status,
        text: data.message,
      });
      return;
    }
  } catch (error) {
    console.error(error);
  }
}

async function getPayoutDetails(UserID, type) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?payout=" + type + "&UserID=" + UserID
    );

    if (!response.ok) {
      throw new Error("An error occurred while fetching the payout details");
    }

    const data = await response.json();

    if (data.status === "error") {
      if (type == "GCash" || type == "Maya") {
        document.getElementById("EwalletMail").value = "";
        document.getElementById("EwalletNumber").value = "";
      } else if (type == "CreditCard") {
        document.getElementById("CCName").value = "";
        document.getElementById("CCNumber").value = "";
        document.getElementById("CCExpiry").value = "";
        document.getElementById("CCCVV").value = "";
      }
    }

    if (data.status === "success") {
      if (type == "GCash" || type == "Maya") {
        oldpayment = [];
        oldpayment = [data.email, data.number];
        if (!payments.includes(type)) {
          payments.push(type);
        }

        document.getElementById("EwalletMail").value = data.email;
        document.getElementById("EwalletNumber").value = data.number;
      } else if (type == "CreditCard") {
        oldpayment = [];
        oldpayment = [data.cardholder, data.cardnumber, data.expdate, data.cvv];
        if (!payments.includes(type)) {
          payments.push(type);
        }
        document.getElementById("CCName").value = data.cardholder;
        document.getElementById("CCNumber").value = data.cardnumber;
        document.getElementById("CCExpiry").value = data.expdate;
        document.getElementById("CCCVV").value = data.cvv;
      } else {
        return;
      }
    }
  } catch (error) {
    console.error(error);
  }
}

async function getProfileDetails() {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?get=profile"
    );

    if (!response.ok) {
      throw new Error("An error occurred while fetching the profile details");
    }

    const data = await response.json();

    if (data.status === "error") {
      console.error(data.message);
    }

    if (data.status === "success") {
      document.getElementById("FirstName").value = data.data.First_Name;
      document.getElementById("LastName").value = data.data.Last_Name;
      document.getElementById("Contact").value = data.data.ContactInfo;
      document.getElementById("Email").value = data.data.Email_Address;
      document.getElementById("Gender").value = data.data.Gender;
      document.getElementById("Password").value = "PLACEHOLDER";

      if (data.data.Have_Profile) {
        document.getElementById("profile-pic").src = data.data.Profile;
      } else {
        document.getElementById("profile-pic").src =
          "../../Assets/Images/Profile.gif";
      }

      document.getElementById("name_side").innerHTML =
        data.data.First_Name + " " + data.data.Last_Name;
      document.getElementById("email_side").innerHTML = data.data.Email_Address;

      if (data.data.Have_Address) {
        document.getElementById("upaddress-icon").innerHTML =
          "<use xlink:href='#Pencil' />";
        document.getElementById("upaddress-label").innerHTML = "Save Changes";

        document.getElementById("Province").value = data.data.Address.Province;
        document.getElementById("Municipality").value =
          data.data.Address.Municipality;
        document.getElementById("Barangay").value = data.data.Address.Barangay;
        document.getElementById("ZipCode").value = data.data.Address.Zipcode;
        document.getElementById("HouseNo").value = data.data.Address.HouseNo;
        document.getElementById("Landmark").value = data.data.Address.Landmark;
      } else {
        document.getElementById("upaddress-icon").innerHTML =
          "<use xlink:href='#Plus' />";
        document.getElementById("upaddress-label").innerHTML = "Add Address";
      }

      olddata = [
        data.data.First_Name,
        data.data.Last_Name,
        data.data.ContactInfo,
        data.data.Email_Address,
        data.data.Gender,
      ];

      if (data.data.Paymentmethod == "Cash on Delivery") {
        document.getElementById("COD").checked = true;
        document.getElementById("Ewallet").classList.add("d-none");
      }

      if (data.data.Paymentmethod == "GCash") {
        document.getElementById("GCash").checked = true;
        document.getElementById("Ewallet").classList.remove("d-none");
        document.getElementById("E_wallet_Name").innerHTML = "GCash";
        getPayoutDetails(User_ID, "GCash");
      }

      if (data.data.Paymentmethod == "Maya") {
        document.getElementById("Maya").checked = true;
        document.getElementById("Ewallet").classList.remove("d-none");
        getPayoutDetails(User_ID, "Maya");
      }

      if (data.data.Paymentmethod == "Credit Card") {
        document.getElementById("CreditCard").checked = true;
        document.getElementById("CreditCardForm").classList.remove("d-none");
        getPayoutDetails(User_ID, "CreditCard");
      }

      document.getElementsByName("PaymentMethod").forEach((element) => {
        element.addEventListener("click", function () {
          if (element.checked) {
            if (element.value == "GCash") {
              document.getElementById("Ewallet").classList.remove("d-none");
              document.getElementById("CreditCardForm").classList.add("d-none");
              document.getElementById("E_wallet_Name").innerHTML = "GCash";
              getPayoutDetails(User_ID, "GCash");
            } else if (element.value == "Maya") {
              document.getElementById("Ewallet").classList.remove("d-none");
              document.getElementById("CreditCardForm").classList.add("d-none");
              document.getElementById("E_wallet_Name").innerHTML = "Maya";
              getPayoutDetails(User_ID, "Maya");
            } else if (element.value == "CreditCard") {
              document.getElementById("Ewallet").classList.add("d-none");
              document
                .getElementById("CreditCardForm")
                .classList.remove("d-none");
              getPayoutDetails(User_ID, "CreditCard");
            } else {
              document.getElementById("Ewallet").classList.add("d-none");
              document.getElementById("CreditCardForm").classList.add("d-none");
            }
          }
        });
      });
      return;
    }
  } catch (error) {
    console.error(error);
  }
}

async function chkPassword(pass) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?password=" + encodeURIComponent(pass)
    );

    if (!response.ok) {
      throw new Error("An error occurred while checking the password");
    }

    const data = await response.json();

    if (data.status === "error") {
      return false;
    }

    if (data.status === "valid") {
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.error(error);
    return false;
  }
}

async function postPassword(pass, newpass) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?password=" +
        encodeURIComponent(pass) +
        "&newpassword=" +
        encodeURIComponent(newpass)
    );

    if (!response.ok) {
      throw new Error("An error occurred while checking the password");
    }

    const data = await response.json();

    if (data.status === "error") {
      return false;
    }

    if (data.status === "valid") {
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.error(error);
    return false;
  }
}

async function verifyEmail(email, code, name) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?email=" +
        encodeURIComponent(email) +
        "&code=" +
        encodeURIComponent(code) +
        "&name=" +
        encodeURIComponent(name)
    );

    if (!response.ok) {
      throw new Error("An error occurred while verifying the email");
    }

    const data = await response.json();

    if (data.status === "error") {
      returncode = 0;
    }

    if (data.status === "valid") {
      returncode = data.code;
    } else {
      returncode = 0;
    }
  } catch (error) {
    console.error(error);
    returncode = 0;
  }
}

async function postAddress(
  type,
  province,
  municipality,
  barangay,
  zipcode,
  houseno,
  landmark
) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?address=" + type,
      {
        method: "POST",
        body: JSON.stringify({
          UserID: User_ID,
          province: province,
          municipality: municipality,
          barangay: barangay,
          zipcode: zipcode,
          houseno: houseno,
          landmark: landmark,
        }),
        headers: {
          "Content-type": "application/json; charset=UTF-8",
        },
      }
    );

    if (!response.ok) {
      throw new Error("An error occurred while updating the address");
    }

    const data = await response.json();

    if (data.status === "error") {
      console.error(data.message);
    }

    if (data.status === "success") {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      })
        .fire({
          icon: data.status,
          text: data.message,
        })
        .then(() => {
          getProfileDetails();
        });
      return;
    }
  } catch (error) {
    console.error(error);
  }
}

async function postEwallet(payment, email, number) {
  try {
    const response = await fetch(
      "../../Utilities/api/UserInfo.php?ewallet=update",
      {
        method: "POST",
        body: JSON.stringify({
          UserID: User_ID,
          payment: payment,
          email: email,
          number: number,
        }),
        headers: {
          "Content-type": "application/json; charset=UTF-8",
        },
      }
    );

    if (!response.ok) {
      throw new Error("An error occurred while updating the e-wallet");
    }

    const data = await response.json();

    if (data.status === "error") {
      console.error(data.message);
    }

    if (data.status === "success") {
      Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
      })
        .fire({
          icon: data.status,
          text: data.message,
        })
        .then(() => {
          getProfileDetails();
        });
      return;
    }
  } catch (error) {
    console.error(error);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("loader").classList.remove("d-block");
  document.getElementById("loader").classList.add("d-none");
  getProfileDetails();

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

  if (Theme == "dark") {
    document.getElementById("SwitchTheme").checked = true;
    document.getElementById("ThemePreview").src =
      "../../Assets/Theme/LightMode.png";
    document.getElementById("themeLabel").innerText = "(Dark Mode)";
  } else {
    document.getElementById("SwitchTheme").checked = false;
    document.getElementById("ThemePreview").src =
      "../../Assets/Theme/DarkMode.png";
    document.getElementById("themeLabel").innerText = "(Light Mode)";
  }

  document.getElementById("SwitchTheme").addEventListener("click", function () {
    var theme = document.getElementById("SwitchTheme");
    if (theme.checked) {
      document.getElementById("ThemePreview").src =
        "../../Assets/Theme/LightMode.png";
      document.getElementById("themeLabel").innerText = "(Dark Mode)";
      document.getElementById("ThemePreviewLabel").innerText = "Light Mode";
      document.body.setAttribute("data-bs-theme", "dark");
      postTheme("dark");
      theme.disabled = true;
      setTimeout(function () {
        theme.disabled = false;
      }, 2000);
    } else {
      document.getElementById("ThemePreview").src =
        "../../Assets/Theme/DarkMode.png";
      document.getElementById("themeLabel").innerText = "(Light Mode)";
      document.getElementById("ThemePreviewLabel").innerText = "Dark Mode";
      document.body.setAttribute("data-bs-theme", "light");
      postTheme("light");
      theme.disabled = true;
      setTimeout(function () {
        theme.disabled = false;
      }, 2000);
    }
  });

  document.getElementById("Back").addEventListener("click", function () {
    window.location.href = "../../Components/Home/Homepage.php";
  });

  document.getElementById("changeimage").addEventListener("click", function () {
    document.getElementById("ProfileImage").click();
  });

  document
    .getElementById("ProfileImage")
    .addEventListener("change", function () {
      var profile = document.getElementById("profile-pic");
      var file = document.getElementById("ProfileImage").files[0];
      var validImageTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/gif",
      ];
      var validSize = 5000000; // 5MB

      if (file == null) {
        return;
      }

      if (file.size > validSize) {
        Swal.mixin({
          toast: true,
          position: "top-start",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "info",
          text: "File size is too large",
        });
        return;
      }

      if (!validImageTypes.includes(file.type)) {
        Swal.mixin({
          toast: true,
          position: "top-start",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "info",
          text: "Invalid file type",
        });
        return;
      }

      var reader = new FileReader();
      reader.onload = function (e) {
        profile.src = e.target.result;
      };
      reader.readAsDataURL(file);

      document.getElementById("changeimage-label").innerHTML = "Uploading...";
      document.getElementById("changeimage").disabled = true;

      setTimeout(function () {
        document.getElementById("changeimage-label").innerHTML =
          "Change Profile";
        document.getElementById("changeimage").disabled = false;
        postProfileImage("upload", file);
      }, 1000);
    });

  document.getElementById("pass-toggle").addEventListener("click", function () {
    var pass = document.getElementById("Password");
    var passIcon = document.getElementById("pass-v");
    if (ispassVisible) {
      document.getElementById("Password").type = "password";
      passIcon.innerHTML = '<use xlink:href="#Visible" />';
      pass.value = "PLACEHOLDER";
      ispassVisible = false;
    } else {
      const pwordmodal = new bootstrap.Modal("#ConfirmPassword", {
        keyboard: false,
      });
      pwordmodal.show();
    }
  });

  document
    .getElementById("checkPass")
    .addEventListener("click", async function () {
      var pass = document.getElementById("Password");
      var passIcon = document.getElementById("pass-v");
      var modalConfirmPass = document.getElementById("ConfirmPass");
      var Feedback = document.getElementById("valFB");

      if (modalConfirmPass.value == "") {
        modalConfirmPass.classList.add("is-invalid");
        Feedback.innerHTML = "Please enter your password";

        setTimeout(function () {
          modalConfirmPass.classList.remove("is-invalid");
          Feedback.innerHTML = "";
        }, 2000);
        return;
      }

      if (await chkPassword(modalConfirmPass.value)) {
        pass.type = "text";
        pass.value = modalConfirmPass.value;
        modalConfirmPass.value = "";
        passIcon.innerHTML = '<use xlink:href="#Visible-off" />';
        ispassVisible = true;
        const pwordmodal = bootstrap.Modal.getInstance(
          document.getElementById("ConfirmPassword")
        );
        pwordmodal.hide();
      } else {
        modalConfirmPass.classList.add("is-invalid");
        Feedback.innerHTML = "Incorrect password";

        setTimeout(function () {
          modalConfirmPass.classList.remove("is-invalid");
          Feedback.innerHTML = "";
        }, 2000);
      }
    });

  document
    .getElementById("change")
    .addEventListener("click", async function () {
      var oldPass = document.getElementById("oldPass");
      var newPass = document.getElementById("newPass");
      var confirmPass = document.getElementById("confirmPass");
      var oldPassFB = document.getElementById("oldPassFB");
      var newPassFB = document.getElementById("newPassFB");
      var confirmPassFB = document.getElementById("confirmPassFB");
      var validRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

      if (oldPass.value == "") {
        oldPass.classList.add("is-invalid");
        oldPassFB.innerHTML = "Please enter your password";

        setTimeout(function () {
          oldPass.classList.remove("is-invalid");
          oldPassFB.innerHTML = "";
        }, 2000);
        return;
      }

      if (newPass.value == "") {
        newPass.classList.add("is-invalid");
        newPassFB.innerHTML = "Please enter your new password";

        setTimeout(function () {
          newPass.classList.remove("is-invalid");
          newPassFB.innerHTML = "";
        }, 2000);
        return;
      }

      if (confirmPass.value == "") {
        confirmPass.classList.add("is-invalid");
        confirmPassFB.innerHTML = "Please confirm your password";

        setTimeout(function () {
          confirmPass.classList.remove("is-invalid");
          confirmPassFB.innerHTML = "";
        }, 2000);
        return;
      }

      if (newPass.value != confirmPass.value) {
        confirmPass.classList.add("is-invalid");
        confirmPassFB.innerHTML = "Passwords do not match";

        setTimeout(function () {
          confirmPass.classList.remove("is-invalid");
          confirmPassFB.innerHTML = "";
        }, 2000);
        return;
      }

      if (!newPass.value.match(validRegex)) {
        newPass.classList.add("is-invalid");
        newPassFB.innerHTML =
          "Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, and 1 number";

        setTimeout(function () {
          newPass.classList.remove("is-invalid");
          newPassFB.innerHTML = "";
        }, 2000);
        return;
      }

      if (oldPass.value == newPass.value) {
        newPass.classList.add("is-invalid");
        newPassFB.innerHTML =
          "New password must be different from the old password";

        setTimeout(function () {
          newPass.classList.remove("is-invalid");
          newPassFB.innerHTML = "";
        }, 2000);
        return;
      }

      if (await postPassword(oldPass.value, newPass.value)) {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        })
          .fire({
            icon: "success",
            text: "Your password has been changed successfully",
          })
          .then(() => {
            oldPass.value = "";
            newPass.value = "";
            confirmPass.value = "";
            window.location.href = "../../Components/Signout/Logout.php";
          });

        const changeModal = bootstrap.Modal.getInstance(
          document.getElementById("ChangePassword")
        );
        changeModal.hide();
        return;
      } else {
        oldPass.classList.add("is-invalid");
        oldPassFB.innerHTML = "Incorrect password";

        setTimeout(function () {
          oldPass.classList.remove("is-invalid");
          oldPassFB.innerHTML = "";
        }, 2000);
      }
    });

  document.getElementById("CP").addEventListener("click", function () {
    const changeModal = new bootstrap.Modal("#ChangePassword", {
      keyboard: false,
    });
    changeModal.show();

    if (ispassVisible) {
      document.getElementById("Password").type = "password";
      document.getElementById("pass-v").innerHTML =
        '<use xlink:href="#Visible" />';
      document.getElementById("Password").value = "PLACEHOLDER";
      ispassVisible = false;
    }
  });

  document.getElementById("oldPass").addEventListener("click", function () {
    togglePasswordVisibility("oldPass", ["newPass", "confirmPass"]);
  });

  document.getElementById("newPass").addEventListener("click", function () {
    togglePasswordVisibility("newPass", ["oldPass", "confirmPass"]);
  });

  document.getElementById("confirmPass").addEventListener("click", function () {
    togglePasswordVisibility("confirmPass", ["oldPass", "newPass"]);
  });

  function togglePasswordVisibility(showId, hideIds) {
    document.getElementById(showId).type = "text";
    hideIds.forEach((id) => {
      document.getElementById(id).type = "password";
    });
  }

  document.getElementById("updetails").addEventListener("click", function () {
    var FirstName = document.getElementById("FirstName");
    var LastName = document.getElementById("LastName");
    var Contact = document.getElementById("Contact");
    var Email = document.getElementById("Email");
    var Gender = document.getElementById("Gender");

    var FN_FB = document.getElementById("FN_FB");
    var LN_FB = document.getElementById("LN_FB");
    var C_FB = document.getElementById("C_FB");
    var E_FB = document.getElementById("E_FB");
    var G_FB = document.getElementById("G_FB");

    if (FirstName.value == "") {
      FirstName.classList.add("is-invalid");
      FN_FB.innerHTML = "Please enter your first name";

      setTimeout(function () {
        FirstName.classList.remove("is-invalid");
        FN_FB.innerHTML = "";
      }, 2000);
      return;
    }

    if (LastName.value == "") {
      LastName.classList.add("is-invalid");
      LN_FB.innerHTML = "Please enter your last name";

      setTimeout(function () {
        LastName.classList.remove("is-invalid");
        LN_FB.innerHTML = "";
      }, 2000);
      return;
    }

    if (Contact.value == "") {
      Contact.classList.add("is-invalid");
      C_FB.innerHTML = "Please enter your contact number";

      setTimeout(function () {
        Contact.classList.remove("is-invalid");
        C_FB.innerHTML = "";
      }, 2000);
      return;
    } else if (Contact.value.length != 11) {
      Contact.classList.add("is-invalid");
      C_FB.innerHTML = "Invalid contact number";

      setTimeout(function () {
        Contact.classList.remove("is-invalid");
        C_FB.innerHTML = "";
      }, 2000);
      return;
    } else if (Contact.value.substring(0, 2) != "09") {
      Contact.classList.add("is-invalid");
      C_FB.innerHTML = "Please enter a valid contact number";

      setTimeout(function () {
        Contact.classList.remove("is-invalid");
        C_FB.innerHTML = "";
      }, 2000);
      return;
    } else if (isNaN(Contact.value)) {
      Contact.classList.add("is-invalid");
      C_FB.innerHTML = "Please remove special or any characters";

      setTimeout(function () {
        Contact.classList.remove("is-invalid");
        C_FB.innerHTML = "";
      }, 2000);
      return;
    }

    var validGender = ["Male", "Female"];
    if (Gender.value == "") {
      Gender.classList.add("is-invalid");
      G_FB.innerHTML = "Please select Male or Femail";

      setTimeout(function () {
        Gender.classList.remove("is-invalid");
        G_FB.innerHTML = "";
      }, 2000);
      return;
    } else if (!validGender.includes(Gender.value)) {
      Gender.classList.add("is-invalid");
      G_FB.innerHTML = "Please choice Male or Femail";

      setTimeout(function () {
        Gender.classList.remove("is-invalid");
        G_FB.innerHTML = "";
      }, 2000);
      return;
    }

    var validRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (Email.value == "") {
      Email.classList.add("is-invalid");
      E_FB.innerHTML = "Please enter your email address";

      setTimeout(function () {
        Email.classList.remove("is-invalid");
        E_FB.innerHTML = "";
      }, 2000);
      return;
    } else if (!Email.value.match(validRegex)) {
      Email.classList.add("is-invalid");
      E_FB.innerHTML = "Invalid email address";

      setTimeout(function () {
        Email.classList.remove("is-invalid");
        E_FB.innerHTML = "";
      }, 2000);
      return;
    }

    if (Email.value != olddata[3]) {
      // open EmailVeridication modal
      const emailmodal = new bootstrap.Modal("#EmailVeridication", {
        keyboard: false,
      });
      emailmodal.show();
      var codes = Math.floor(100000 + Math.random() * 900000);
      codes = verifyEmail(Email.value, codes, FirstName.value);
      return;
    }

    // if not data changed
    if (
      FirstName.value == olddata[0] &&
      LastName.value == olddata[1] &&
      Contact.value == olddata[2] &&
      Email.value == olddata[3] &&
      Gender.value == olddata[4]
    ) {
      document.getElementById("updetails").disabled = true;
      setTimeout(function () {
        document.getElementById("updetails").disabled = false;
      }, 2000);
      return;
    }

    document.getElementById("updetails").disabled = true;
    document.getElementById("updetails-label").innerHTML = "Please wait...";
    setTimeout(function () {
      document.getElementById("updetails").disabled = false;
      document.getElementById("updetails-label").innerHTML = "Save Changes";
      postProfileDetails(
        FirstName.value,
        LastName.value,
        Contact.value,
        Email.value,
        Gender.value
      );
    }, 1000);
  });

  document
    .getElementById("verifycode")
    .addEventListener("click", async function () {
      const verifycode = returncode;
      var email = document.getElementById("Email").value;
      var code1 = document.getElementById("code1").value;
      var code2 = document.getElementById("code2").value;
      var code3 = document.getElementById("code3").value;
      var code4 = document.getElementById("code4").value;
      var code5 = document.getElementById("code5").value;
      var code6 = document.getElementById("code6").value;

      var usercode = code1 + code2 + code3 + code4 + code5 + code6;

      if (verifycode == 0) {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "error",
          text: "An error occurred while verifying the email",
        });
        return;
      }

      if (usercode == verifycode) {
        const emailmodal = bootstrap.Modal.getInstance(
          document.getElementById("EmailVeridication")
        );
        emailmodal.hide();
        postProfileDetails(
          document.getElementById("FirstName").value,
          document.getElementById("LastName").value,
          document.getElementById("Contact").value,
          email,
          document.getElementById("Gender").value
        );
      } else {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "error",
          text: "Invalid verification code",
        });
      }
    });

  document
    .getElementById("UpdateAddress")
    .addEventListener("click", function () {
      var province = document.getElementById("Province");
      var Municipality = document.getElementById("Municipality");
      var Barangay = document.getElementById("Barangay");
      var ZipCodev = document.getElementById("ZipCode");
      var HouseNo = document.getElementById("HouseNo");
      var Landmark = document.getElementById("Landmark");

      if (province.value == "") {
        province.classList.add("is-invalid");
        setTimeout(function () {
          province.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (Municipality.value == "") {
        Municipality.classList.add("is-invalid");
        setTimeout(function () {
          Municipality.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (Barangay.value == "") {
        Barangay.classList.add("is-invalid");
        setTimeout(function () {
          Barangay.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (ZipCodev.value == "") {
        ZipCodev.classList.add("is-invalid");
        setTimeout(function () {
          ZipCodev.classList.remove("is-invalid");
        }, 2000);
        return;
      } else if (ZipCodev.value.length != 4) {
        ZipCodev.classList.add("is-invalid");
        setTimeout(function () {
          ZipCodev.classList.remove("is-invalid");
        }, 2000);
        return;
      } else if (isNaN(ZipCodev.value)) {
        ZipCodev.classList.add("is-invalid");
        setTimeout(function () {
          ZipCodev.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (HouseNo.value == "") {
        HouseNo.classList.add("is-invalid");
        setTimeout(function () {
          HouseNo.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (
        document.getElementById("upaddress-label").innerHTML == "Save Changes"
      ) {
        document.getElementById("UpdateAddress").disabled = true;
        document.getElementById("upaddress-label").innerHTML = "Please wait...";

        setTimeout(function () {
          document.getElementById("UpdateAddress").disabled = false;
          document.getElementById("upaddress-label").innerHTML = "Save Changes";

          postAddress(
            "update",
            province.value,
            Municipality.value,
            Barangay.value,
            ZipCodev.value,
            HouseNo.value,
            Landmark.value
          );
        }, 1000);
        return;
      }

      document.getElementById("UpdateAddress").disabled = true;
      document.getElementById("upaddress-label").innerHTML =
        "Adding Address...";

      setTimeout(function () {
        document.getElementById("UpdateAddress").disabled = false;
        document.getElementById("upaddress-label").innerHTML = "Save Changes";

        postAddress(
          "add",
          province.value,
          Municipality.value,
          Barangay.value,
          ZipCodev.value,
          HouseNo.value,
          Landmark.value
        );
      }, 1500);
    });

  document
    .getElementById("UpdateEwallet")
    .addEventListener("click", function () {
      var payment = document.getElementsByName("PaymentMethod");
      var EwalletMail = document.getElementById("EwalletMail");
      var EwalletNumber = document.getElementById("EwalletNumber");
      var selected = "";
      var validPayment = ["GCash", "Maya"];
      var validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

      payment.forEach((element) => {
        if (element.checked) {
          selected = element.value;
        }
      });

      if (selected == "") {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "info",
          text: "Please select a payment method",
        });
        return;
      }

      if (validPayment.includes(selected)) {
        if (EwalletMail.value == "") {
          EwalletMail.classList.add("is-invalid");
          setTimeout(function () {
            EwalletMail.classList.remove("is-invalid");
          }, 2000);
          return;
        }
      }

      if (EwalletNumber.value == "") {
        EwalletNumber.classList.add("is-invalid");
        setTimeout(function () {
          EwalletNumber.classList.remove("is-invalid");
        }, 2000);
        return;
      } else if (isNaN(EwalletNumber.value)) {
        EwalletNumber.classList.add("is-invalid");
        setTimeout(function () {
          EwalletNumber.classList.remove("is-invalid");
        }, 2000);
        return;
      } else if (EwalletNumber.value.length != 11) {
        EwalletNumber.classList.add("is-invalid");
        setTimeout(function () {
          EwalletNumber.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (EwalletMail == "") {
        EwalletMail.classList.add("is-invalid");
        setTimeout(function () {
          EwalletMail.classList.remove("is-invalid");
        }, 2000);
        return;
      } else if (!EwalletMail.value.match(validEmail)) {
        EwalletMail.classList.add("is-invalid");
        setTimeout(function () {
          EwalletMail.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (
        EwalletMail.value == oldpayment[0] &&
        EwalletNumber.value == oldpayment[1]
      ) {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "info",
          text: "No changes made",
        });
        return;
      }

      document.getElementById("UpdateEwallet").disabled = true;
      document.getElementById("Ewallet-label").innerHTML = "Please wait...";

      setTimeout(function () {
        document.getElementById("UpdateEwallet").disabled = false;
        document.getElementById("Ewallet-label").innerHTML = "Save Changes";
        postEwallet(selected, EwalletMail.value, EwalletNumber.value);
      }, 1000);
    });

  document
    .getElementById("UpdateCreditCard")
    .addEventListener("click", function () {
      var CCName = document.getElementById("CCName");
      var CCNumber = document.getElementById("CCNumber");
      var CCExpiry = document.getElementById("CCExpiry");
      var CCCVV = document.getElementById("CCCVV");
      var validCC = /^[\w\s]+$/;
      var validCCNumber = /^[\d]{16}$/;
      var validCCExpiry = /^[\d]{2}\/[\d]{2}$/;


      if (CCName.value == "" || !CCName.value.match(validCC)) {
        CCName.classList.add("is-invalid");
        setTimeout(function () {
          CCName.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (CCNumber.value == "" || !CCNumber.value.match(validCCNumber)) {
        CCNumber.classList.add("is-invalid");
        setTimeout(function () {
          CCNumber.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (CCExpiry.value == "" || !CCExpiry.value.match(validCCExpiry)) {
        CCExpiry.classList.add("is-invalid");
        setTimeout(function () {
          CCExpiry.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (CCCVV.value == "" || isNaN(CCCVV.value)) {
        CCCVV.classList.add("is-invalid");
        setTimeout(function () {
          CCCVV.classList.remove("is-invalid");
        }, 2000);
        return;
      }

      if (
        CCName.value == oldpayment[0] &&
        CCNumber.value == oldpayment[1] &&
        CCExpiry.value == oldpayment[2] &&
        CCCVV.value == oldpayment[3]
      ) {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        }).fire({
          icon: "info",
          text: "No changes made",
        });
        return;
      }

      document.getElementById("UpdateCreditCard").disabled = true;
      document.getElementById("CreditCard-label").innerHTML = "Please wait...";

      setTimeout(function () {
        document.getElementById("UpdateCreditCard").disabled = false;
        document.getElementById("CreditCard-label").innerHTML = "Save Changes";
        console.log("Update Credit Card");
      }, 1000);
    });
});
