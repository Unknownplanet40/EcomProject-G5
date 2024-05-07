// check if browser is Chrome
var isChrome =
  /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
if (!isChrome) {
  alert("Your not using Chrome Browser, some features may not work properly");
}

document.addEventListener("DOMContentLoaded", function () {
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

  document.getElementById("Qplus").addEventListener("click", function () {
    var Qinput = document.getElementById("Qinput");
    Qinput.value = parseInt(Qinput.value) + 1;
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
      position: "top-end",
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
});
