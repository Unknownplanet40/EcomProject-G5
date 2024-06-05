document.addEventListener("DOMContentLoaded", function () {
  var loader = document.getElementById("loader"); // Loader
  var step_1 = document.getElementById("FN-container"); // First Name, Last Name container
  var step_2 = document.getElementById("EA-container"); // Email Address Container
  var step_2_1 = document.getElementById("EA-Inner-container"); // Email Address Field
  var step_2_2 = document.getElementById("OTP-Inner-container"); // OTP Field
  var step_3 = document.getElementById("PW-container"); // Password Container

  // Buttons
  var FN_Next = document.getElementById("FN-Next");
  var EA_Next = document.getElementById("EA-Next");
  var EA_Back = document.getElementById("EA-Back");
  var OTP_Next = document.getElementById("OTP-Next");
  var RegenOTP = document.getElementById("regenOTP");
  var OTP_Back = document.getElementById("OTP-Back");
  var PW_Next = document.getElementById("PW-Next");
  var PW_Back = document.getElementById("PW-Back");

  OTPcode = 0;
  canReload = true;

  async function checkEmailExistence(functionname, email) {
    try {
      const url = `../../Utilities/api/AccountCreation.php?functionname=${functionname}&email=${email}`;

      const response = await fetch(url);

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const data = await response.json();

      if (data.error) {
        console.error(data.error);
        return false;
      }

      if (data.valid === true) {
        return true;
      } else {
        return false;
      }
    } catch (error) {
      console.log(error);
      return false;
    }
  }

  async function AuthenticateOTP(functionname, firstname, email, otp) {
    try {
      const url = `../../Utilities/api/AccountCreation.php?functionname=${functionname}&name=${firstname}&email=${email}&otp=${otp}`;

      const response = await fetch(url);

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const data = await response.json();

      if (data.error) {
        console.error(data.error);
        return false;
      }
      if ((data.isSent = true)) {
        return true;
      } else {
        return false;
      }
    } catch (error) {
      console.log(error);
      return false;
    }
  }

  async function CreateAccount(
    functionname,
    email,
    password,
    firstname,
    lastname
  ) {
    try {
      const url = `../../Utilities/api/AccountCreation.php?functionname=${functionname}&email=${email}&password=${password}&firstname=${firstname}&lastname=${lastname}`;

      const response = await fetch(url);

      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      const data = await response.json();

      if (data.error) {
        console.error(data.error);
        return false;
      }

      if (data.isCreated === true) {
        return true;
      } else {
        return false;
      }
    } catch (error) {
      console.log(error);
      return false;
    }
  }

  async function AuthAccount(url) {
    try {
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          email: document.getElementById("Email").value,
          password: document.getElementById("Password").value,
        }),
      });

      if (!response.ok) {
        showAlert("error", "Network response was not ok", 2000);
      }

      const data = await response.json();

      // chekc if i receive an error message or not
      if (data.error) {
        showAlert("error", data.error, 2000);
      } else {
        if (data.status == "success") {
          Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
          })
            .fire({
              icon: data.status,
              title: data.message,
            })
            .then((result) => {
              setTimeout(function () {
                location.href = "../../Utilities/api/FetchUserData.php";
              }, 500);
            });
        } else {
          showAlert(data.status, data.message, 2000);
        }
      }
    } catch (error) {
      showAlert("error", error, 2000);
    }
  }
  /* ----------------------------------------------------------- */

  // hide loader and show first name, last name container
  loader.classList.add("d-none");
  step_1.classList.remove("d-none");

  FN_Next.addEventListener("click", function () {
    var firstName = document.getElementById("Fname");
    var lastName = document.getElementById("Lname");
    var FN_FB = document.getElementById("FN-FB");

    if (firstName.value === "" && lastName.value === "") {
      firstName.classList.add("is-invalid");
      lastName.classList.add("is-invalid");
      setTimeout(function () {
        firstName.classList.remove("is-invalid");
        lastName.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (firstName.value === "") {
      firstName.classList.add("is-invalid");
      setTimeout(function () {
        firstName.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (lastName.value === "") {
      lastName.classList.add("is-invalid");
      setTimeout(function () {
        lastName.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    canReload = false;
    FN_FB.classList.add("d-none");
    step_2.classList.remove("d-none");
    step_2_1.classList.remove("d-none");
    step_1.classList.add("d-none");
  });

  EA_Next.addEventListener("click", async function () {
    var emailAddress = document.getElementById("Email");
    var fname = document.getElementById("Fname");
    var EA_FB = document.getElementById("EA-FB");
    var RegEx = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (emailAddress.value === "") {
      emailAddress.classList.add("is-invalid");
      setTimeout(function () {
        emailAddress.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (!RegEx.test(emailAddress.value)) {
      emailAddress.classList.add("is-invalid");
      setTimeout(function () {
        emailAddress.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    const isvalid = await checkEmailExistence(
      "isEmailExist",
      emailAddress.value
    );

    if (isvalid) {
      emailAddress.classList.add("is-invalid");
      EA_FB.textContent = "Sorry, this email is already taken.";
      setTimeout(function () {
        emailAddress.classList.remove("is-invalid");
        EA_FB.textContent = "";
      }, 1500);
      return;
    }
    var otp = Math.floor(1000 + Math.random() * 9000);
    OTPcode = otp;
    canReload = false;
    AuthenticateOTP("sendOTP", fname.value, emailAddress.value, otp);
    step_2_2.classList.remove("d-none");
    step_2_1.classList.add("d-none");
  });

  EA_Back.addEventListener("click", function () {
    step_2.classList.add("d-none");
    step_2_1.classList.add("d-none");
    step_1.classList.remove("d-none");
  });

  RegenOTP.addEventListener("click", function () {
    var emailAddress = document.getElementById("Email");
    var fname = document.getElementById("Fname");
    var otp = Math.floor(1000 + Math.random() * 9000);
    OTPcode = otp;
    AuthenticateOTP("sendOTP", fname.value, emailAddress.value, otp);
  });

  OTP_Next.addEventListener("click", function () {
    var OTP = OTPcode;
    var OTP1 = document.getElementById("OTP1");
    var OTP2 = document.getElementById("OTP2");
    var OTP3 = document.getElementById("OTP3");
    var OTP4 = document.getElementById("OTP4");

    var OTP_Input = OTP1.value + OTP2.value + OTP3.value + OTP4.value;

    if (OTP_Input === "" || OTP_Input != OTP) {
      OTP1.classList.add("is-invalid");
      OTP2.classList.add("is-invalid");
      OTP3.classList.add("is-invalid");
      OTP4.classList.add("is-invalid");
      setTimeout(function () {
        OTP1.classList.remove("is-invalid");
        OTP2.classList.remove("is-invalid");
        OTP3.classList.remove("is-invalid");
        OTP4.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    canReload = false;
    step_3.classList.remove("d-none");
    step_2_2.classList.add("d-none");
    step_2_1.classList.add("d-none");
    step_2.classList.add("d-none");
  });

  OTP_Back.addEventListener("click", function () {
    step_2.classList.remove("d-none");
    step_2_1.classList.remove("d-none");
    step_2_2.classList.add("d-none");
  });

  PW_Next.addEventListener("click", async function () {
    var regExp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
    var Password = document.getElementById("Password");
    var ConfirmPassword = document.getElementById("ConfirmPassword");

    if (Password.value === "" && ConfirmPassword.value === "") {
      Password.classList.add("is-invalid");
      ConfirmPassword.classList.add("is-invalid");
      setTimeout(function () {
        Password.classList.remove("is-invalid");
        ConfirmPassword.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (Password.value === "") {
      Password.classList.add("is-invalid");
      setTimeout(function () {
        Password.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (ConfirmPassword.value === "") {
      ConfirmPassword.classList.add("is-invalid");
      setTimeout(function () {
        ConfirmPassword.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (!regExp.test(Password.value)) {
      Password.classList.add("is-invalid");
      setTimeout(function () {
        Password.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    if (Password.value !== ConfirmPassword.value) {
      ConfirmPassword.classList.add("is-invalid");
      setTimeout(function () {
        ConfirmPassword.classList.remove("is-invalid");
      }, 1500);
      return;
    }

    var email = document.getElementById("Email").value;
    var password = document.getElementById("Password").value;
    var firstname = document.getElementById("Fname").value;
    var lastname = document.getElementById("Lname").value;

    const isCreated = await CreateAccount(
      "createAccount",
      email,
      password,
      firstname,
      lastname
    );

    if (isCreated) {
      Swal.fire({
        title: "Success!",
        text: "Your account has been created successfully.",
        icon: "success",
        confirmButtonText: "OK",
      }).then((result) => {
        if (result.isConfirmed) {
          canReload = true;
          loader.classList.remove("d-none");
          step_3.classList.add("d-none");
          setTimeout(function () {
            AuthAccount("../../Utilities/api/AuthAccount.php");
          }, 1500);
        }
      });
    } else {
      Swal.fire({
        title: "Error!",
        text: "An error occured while creating your account.",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });

  PW_Back.addEventListener("click", function () {
    step_3.classList.add("d-none");
    step_2.classList.remove("d-none");
    step_2_1.classList.remove("d-none");
    step_2_2.classList.add("d-none");
  });
});

// prevent reload when user already filled the form
window.addEventListener("beforeunload", function (e) {
  var canUnload = canReload;

  if (!canUnload) {
    e.preventDefault();
    e.returnValue = "";
  }
});
