function getBrowserName(userAgent) {
  if (userAgent.includes("Firefox")) {
    // "Mozilla/5.0 (X11; Linux i686; rv:104.0) Gecko/20100101 Firefox/104.0"
    return "Mozilla Firefox";
  } else if (userAgent.includes("SamsungBrowser")) {
    // "Mozilla/5.0 (Linux; Android 9; SAMSUNG SM-G955F Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/9.4 Chrome/67.0.3396.87 Mobile Safari/537.36"
    return "Samsung Internet";
  } else if (userAgent.includes("Opera") || userAgent.includes("OPR")) {
    // "Mozilla/5.0 (Macintosh; Intel Mac OS X 12_5_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 OPR/90.0.4480.54"
    return "Opera";
  } else if (userAgent.includes("Edge")) {
    // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299"
    return "Microsoft Edge (Legacy)";
  } else if (userAgent.includes("Edg")) {
    // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 Edg/104.0.1293.70"
    return "Microsoft Edge (Chromium)";
  } else if (userAgent.includes("Chrome")) {
    // "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36"
    return "Google Chrome or Chromium";
  } else if (userAgent.includes("Safari")) {
    // "Mozilla/5.0 (iPhone; CPU iPhone OS 15_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6 Mobile/15E148 Safari/604.1"
    return "Apple Safari";
  } else {
    return "unknown";
  }
}

function ConsoleMessage() {
  if (window.console && window.console.log) {
    const browserName = getBrowserName(navigator.userAgent);
    console.log(
      "%cPLEASE CLOSE THIS WINDOW IMMEDIATELY!",
      "color: red; font-size: 60px; font-weight: bold; text-shadow: 2px 2px 0 rgb(217,31,38), 4px 4px 0 rgb(226,91,14), 6px 6px 0 rgb(245,221,8), 8px 8px 0 rgb(5,148,68), 10px 10px 0 rgb(2,135,206), 12px 12px 0 rgb(4,77,145), 14px 14px 0 rgb(42,21,113);"
    );
    console.log(
      "%cWe are reminding you that this is a browser feature intended for developers. You can close this window now.",
      "font-size: 20px;"
    );

    if (browserName == "unknown") {
      console.log(
        "%cWe are unable to detect your browser, please use a modern browser like Google Chrome, Mozilla Firefox, Microsoft Edge, Opera or Apple Safari.",
        "font-size: 20px;"
      );
    } else if (browserName != "Google Chrome or Chromium") {
      console.log("%cYou are using: " + browserName, "font-size: 20px;");
      console.log(
        "%cWe recommend you to use Google Chrome for better performance and user experience.",
        "font-size: 16px; font-style: italic; color: #007bff;"
      );
    } else {
      console.log("%cYou are using: " + browserName, "font-size: 20px;");
    }
  }
}
document.addEventListener("DOMContentLoaded", function () {
  // ConsoleMessage();

  // --------------------------------------------------------- //

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

  // hide loader after fully load
  document.getElementById("loader").classList.remove("d-block");
  document.getElementById("loader").classList.add("d-none");
  document.getElementById("cBody").style.overflow = "auto";

  // [teporary] search bar event listener
  document.getElementById("search-btn").addEventListener("click", function () {
    document.getElementById("Sresult").classList.remove("d-none");
  });

  // [teporary] search bar event listener
  document.getElementById("search-bar").addEventListener("click", function () {
    document.getElementById("Sresult").classList.add("d-none");
    document.getElementById("search-bar").value = "";
  });

  // [teporary] search header event listener
  document.getElementById("Hsearch").addEventListener("click", function () {
    document.getElementById("Sresult").classList.add("d-none");
  });

  //Show Password checkbox
  const SPword = document.getElementById("SPword");
  const Pword = document.getElementById("Pword");
  SPword.addEventListener("change", () => {
    if (SPword.checked) {
      Pword.type = "text";
    } else {
      Pword.type = "password";
    }
  });

  // get FileName in local Storage
  const fileName = localStorage.getItem("FileName");
  switch (fileName) {
    case "Homepage.php":
      // Brands Logo [Light/Dark] Mode
      if (document.documentElement.getAttribute("data-bs-theme") == "dark") {
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
      } else {
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
      }

      var MainPic = document.getElementById("Pic-main");
      var Pic1 = document.getElementById("Pic-1");
      var Pic2 = document.getElementById("Pic-2");
      var Pic3 = document.getElementById("Pic-3");
      var Pic4 = document.getElementById("Pic-4");

      // change main picture on click
      Pic1.addEventListener("click", function () {
        MainPic.src = Pic1.src;
      });

      Pic2.addEventListener("click", function () {
        MainPic.src = Pic2.src;
      });

      Pic3.addEventListener("click", function () {
        MainPic.src = Pic3.src;
      });

      Pic4.addEventListener("click", function () {
        MainPic.src = Pic4.src;
      });

      // check if data-bs-theme in html tag is dark
      if (document.documentElement.getAttribute("data-bs-theme") == "dark") {
        document.getElementById("card-bg").classList.remove("bg-body-tertiary");
        document.getElementById("card-bg").classList.remove("bg-opacity-50");
        document.getElementById("card-bg").classList.add("bg-transparent");
      }

      document
        .getElementById("Selectsize")
        .addEventListener("change", function () {
          var Size = document.getElementById("Selectsize");
          let selectedSize = Size.options[Size.selectedIndex].dataset.qty;
          document.getElementById("Qinput").max = selectedSize;
          document.getElementById("Qinput").value = 1;
          document.getElementById("AddCart").classList.remove("disabled");
        });

      document.getElementById("Qplus").addEventListener("click", function () {
        var Qinput = document.getElementById("Qinput");
        if (Qinput.value < parseInt(document.getElementById("Qinput").max)) {
          Qinput.value = parseInt(Qinput.value) + 1;
        } else {
          // add is-invalid class to input for 1 sec then remove it
          Qinput.classList.add("is-invalid");
          setTimeout(function () {
            Qinput.classList.remove("is-invalid");
          }, 1500);

          var chooseSize = document.getElementById("Selectsize");
          if (chooseSize.value == "Choose Size") {
            chooseSize.classList.add("is-invalid");
            document.getElementById("reminder").textContent = "Please choose a size first.";
            setTimeout(function () {
              chooseSize.classList.remove("is-invalid");
              document.getElementById("reminder").innerHTML = "&nbsp;";
            }, 2000);
          }
        }
      });

      document.getElementById("Qminus").addEventListener("click", function () {
        var Qinput = document.getElementById("Qinput");
        if (Qinput.value > 1) {
          Qinput.value = parseInt(Qinput.value) - 1;
        } else {
          // add is-invalid class to input for 1 sec then remove it
          Qinput.classList.add("is-invalid");
          setTimeout(function () {
            Qinput.classList.remove("is-invalid");
          }, 1500);
        }
      });

      // dispose bootstrap modal with id Product when button with id AddCart is clicked
      document.getElementById("AddCart").addEventListener("click", function () {
        // do something

        // sweetalert 2 toast
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
            title: "Added to Cart Successfully!",
          })
          .then((result) => {
            // after that close modal
            var modal = bootstrap.Modal.getInstance(
              document.getElementById("Product")
            );
            modal.hide();
          });
      });
      break;
    case "Checkout.php":
      break;
    default:
      console.log("No script to run.");
      break;
  }
});
