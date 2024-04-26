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
  
});
