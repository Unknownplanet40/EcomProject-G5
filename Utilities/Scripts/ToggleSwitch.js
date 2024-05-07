/*
    This script is temporary and it will be removed.
*/
var themeToggle = document.getElementById("light-dark");
var log_In_Out = document.getElementById("login-out");
var Cart_stat = document.getElementById("cart-status");

themeToggle.addEventListener("change", function () {
  if (themeToggle.checked) {
    document.documentElement.setAttribute("data-bs-theme", "dark");

    const imagePaths = [
      "DBTK_Light.png",
      "UND_Light.png",
      "coziesrt_Light.png",
      "Kids_Light.png",
      "RichBoys_Light.png",
    ];

    // Loop through each image element and set the src attribute
    for (let i = 1; i <= imagePaths.length; i++) {
      const imgElement = document.getElementById(`bimg-${i}`);
      imgElement.src = `../../Assets/Images/Brands_Assets/Light/${
        imagePaths[i - 1]
      }`;
    }

    document.getElementById("card-bg").classList.remove("bg-body-tertiary");
    document.getElementById("card-bg").classList.remove("bg-opacity-50");
    document.getElementById("card-bg").classList.remove("bg-blur-3");
    document.getElementById("card-bg").classList.add("bg-transparent");

    document.getElementById("light-dark-label").innerHTML =
      "Switch to Light Mode - <small class='text-muted'>*Note: This will be Included via Settings</small>";
  } else {
    document.documentElement.setAttribute("data-bs-theme", "light");

    const imagePaths = [
      "DBTK_Dark.png",
      "UND_Dark.png",
      "coziesrt_dark.png",
      "Kids_Dark.png",
      "RichBoys_Dark.png",
    ];

    // Loop through each image element and set the src attribute
    for (let i = 1; i <= imagePaths.length; i++) {
      const imgElement = document.getElementById(`bimg-${i}`);
      imgElement.src = `../../Assets/Images/Brands_Assets/Dark/${
        imagePaths[i - 1]
      }`;
    }

    document.getElementById("card-bg").classList.add("bg-body-tertiary");
    document.getElementById("card-bg").classList.add("bg-opacity-50");
    document.getElementById("card-bg").classList.add("bg-blur-3");
    document.getElementById("card-bg").classList.remove("bg-transparent");

    document.getElementById("light-dark-label").innerHTML =
      "Switch to Dark Mode - <small class='text-muted'>*Note: This will be Included via Settings</small>";
  }
});

log_In_Out.addEventListener("click", function () {
  if (log_In_Out.checked) {
    document.getElementById("login-out-label").innerHTML =
      "Switch to Logout Mode";

    document.getElementById("Log-In").classList.add("visually-hidden");
    document.getElementById("Log-Out").classList.remove("visually-hidden");

    Cart_stat.removeAttribute("disabled", "");

    document.getElementById("islogin").classList.add("visually-hidden");
    document.getElementById("viewmore").classList.remove("visually-hidden");
  } else {
    document.getElementById("login-out-label").innerHTML =
      "Switch to Login Mode";

    document.getElementById("Log-In").classList.remove("visually-hidden");
    document.getElementById("Log-Out").classList.add("visually-hidden");

    Cart_stat.setAttribute("disabled", "disabled");

    document.getElementById("islogin").classList.remove("visually-hidden");
    document.getElementById("viewmore").classList.add("visually-hidden");
  }
});

Cart_stat.addEventListener("click", function () {
  if (Cart_stat.checked) {
    document.getElementById("Cart-Empty").classList.add("visually-hidden");
    document
      .getElementById("Cart-Not-Empty")
      .classList.remove("visually-hidden");
  } else {
    document.getElementById("Cart-Empty").classList.remove("visually-hidden");
    document.getElementById("Cart-Not-Empty").classList.add("visually-hidden");
  }
});
