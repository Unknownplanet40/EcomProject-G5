const SPword = document.getElementById("SPword");
const Pword = document.getElementById("Pword");
SPword.addEventListener("change", () => {
  if (SPword.checked) {
    Pword.type = "text";
  } else {
    Pword.type = "password";
  }
});

function showAlert(icon, title, timelaspe) {
  Swal.mixin({
    toast: true,
    position: "top",
    showConfirmButton: false,
    timer: timelaspe,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  }).fire({
    icon: icon,
    title: title,
  });
}

function EmailValidation(email) {
  var validRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  if (!email.match(validRegex)) {
    return false;
  } else {
    return true;
  }
}

function PasswordValidation(password) {
  // Regex for at least one digit, one lowercase letter, one uppercase letter, and a minimum length of 8
  var validRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  // Allowed special characters
  var specialCharsAllowed = "!@#$%^&*()-+";

  // First check if the password matches the regex
  if (!password.match(validRegex)) {
    return false;
  }

  // Then check if the password contains only allowed special characters
  for (var i = 0; i < password.length; i++) {
    var char = password.charAt(i);
    // If the character is a special character and not in the allowed list, return false
    if (!/[a-zA-Z0-9]/.test(char) && specialCharsAllowed.indexOf(char) === -1) {
      return false;
    }
  }
  return true;
}

document.getElementById("btn-Sub").addEventListener("click", function () {
  let email = document.getElementById("MailAddress");
  let password = document.getElementById("Pword");

  if (email.value == "" && password.value == "") {
    showAlert("info", "Please fill in all fields", 1500);
    email.classList.add("is-invalid");
    password.classList.add("is-invalid");
    setTimeout(function () {
      email.classList.remove("is-invalid");
      password.classList.remove("is-invalid");
    }, 1500);
  } else if (email.value == "") {
    showAlert("info", "Please fill in email field", 1500);
    email.classList.add("is-invalid");
    setTimeout(function () {
      email.classList.remove("is-invalid");
      email.focus();
    }, 1500);
  } else if (password.value == "") {
    showAlert("info", "Please fill in password field", 1500);
    password.classList.add("is-invalid");
    setTimeout(function () {
      password.classList.remove("is-invalid");
      password.focus();
    }, 1500);
  } else if (!EmailValidation(email.value)) {
    showAlert("info", "Invalid Email Address", 2000);
    email.classList.add("is-invalid");
    setTimeout(function () {
      email.classList.remove("is-invalid");
      email.focus();
    }, 1500);
  } else if (password.value.length < 8) {
    showAlert("info", "Password must be at least 8 characters", 2000);
    password.classList.add("is-invalid");
    setTimeout(function () {
      password.classList.remove("is-invalid");
      password.focus();
    }, 1500);
  } else if (!PasswordValidation(password.value)) {
    showAlert(
      "info",
      "Password must contain at least one uppercase letter, one lowercase letter, and one number",
      5000
    );
    password.classList.add("is-invalid");
    setTimeout(function () {
      password.classList.remove("is-invalid");
      password.focus();
    }, 1500);
  } else {
    // what is async/await?
    // async/await is a new way to write asynchronous code. Previous alternatives were callbacks and promises.
    // how does it work?
    // async makes a function return a Promise
    // await makes a function wait for a Promise

    async function AuthAccount(url) {
      try {
        const response = await fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: email.value,
            password: password.value,
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
            }).fire({
                icon: data.status,
                title: data.message,
              })
              .then((result) => {
                setTimeout(function () {
                  location.href = '../../Utilities/api/FetchUserData.php';
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

    AuthAccount("../../Utilities/api/AuthAccount.php");
  }
});
