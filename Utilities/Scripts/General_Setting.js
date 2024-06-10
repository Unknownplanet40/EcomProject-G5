/* Global variables here */
let ispassVisible = false;

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

async function postProfileImage(image) {}

async function postProfileDetails(fname, lname, contact, email) {
  try {
    const response = await fetch("../../Utilities/api/UserInfo.php", {
      method: "POST",
      body: JSON.stringify({
        firstname: fname,
        lastname: lname,
        contact: contact,
        email: email,
      }),
      headers: {
        "Content-type": "application/json; charset=UTF-8",
      },
    });

    if (!response.ok) {
      throw new Error("An error occurred while updating the profile");
    }

    const data = await response.json();
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

      if (data.data.Paymentmethod == "Cash on Delivery") {
        document.getElementById("COD").checked = true;
        document.getElementById("Ewallet").classList.add("d-none");
      }

      if (data.data.Paymentmethod == "GCash") {
        document.getElementById("GCash").checked = true;
        document.getElementById("Ewallet").classList.remove("d-none");
        document.getElementById("E_wallet_Name").innerHTML = "GCash";
      }

      if (data.data.Paymentmethod == "Maya") {
        document.getElementById("Maya").checked = true;
        document.getElementById("Ewallet").classList.remove("d-none");
        document.getElementById("E_wallet_Name").innerHTML = "Maya";
      }

      if (data.data.Paymentmethod == "Credit Card") {
        document.getElementById("CreditCard").checked = true;
        document.getElementById("Ewallet").classList.add("d-none");
      }

      document.getElementsByName("PaymentMethod").forEach((element) => {
        element.addEventListener("click", function () {
          if (element.checked) {
            if (element.value == "GCash") {
              document.getElementById("Ewallet").classList.remove("d-none");
              document.getElementById("E_wallet_Name").innerHTML = "GCash";
            } else if (element.value == "Maya") {
              document.getElementById("Ewallet").classList.remove("d-none");
              document.getElementById("E_wallet_Name").innerHTML = "Maya";
            } else {
              document.getElementById("Ewallet").classList.add("d-none");
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
      postTheme("dark");
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
});
