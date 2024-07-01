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

var backgroundMusic = document.getElementById("backgroundMusic");
backgroundMusic.volume = 0.1;
backgroundMusic.currentTime = localStorage.getItem("BGMusicTime");


document.addEventListener("DOMContentLoaded", function () {
  // ConsoleMessage();

  
  var keys = [];
  var konami = "38,38,40,40,37,39,37,39,66,65"; // Konami Code

  function playMusic() {
    backgroundMusic
      .play()
      .then(() => {
        setInterval(function () {
          localStorage.setItem("BGMusicTime", backgroundMusic.currentTime);
        }, 1000);
      })
      .catch((error) => {
        console.error("Failed to play the music:", error);
      });

    // Remove event listeners after playing the music
    document.removeEventListener("click", playMusic);
    document.removeEventListener("keypress", playMusic);
  }
  
  // Add event listeners for user interaction
  document.addEventListener("click", playMusic);
  document.addEventListener("keypress", playMusic);

  window.addEventListener(
    "keydown",
    function (e) {
      keys.push(e.keyCode);
      if (keys.toString().indexOf(konami) >= 0) {
        // pause/play background music
        if (backgroundMusic.paused) {
          backgroundMusic.play();
        } else {
          backgroundMusic.pause();
        }
        keys = [];
      }
    },
    true
  );

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

  async function addToCart(url) {
    try {
      const response = await fetch(url);

      if (!response.ok) {
        DToast("error", "An error occured while adding to cart.");
        return;
      }

      const data = await response.json();

      if (data.error) {
        DToast("error", data.error);
      } else {
        if (data.status == "success") {
          DToast(data.status, data.message);
          if (data.type != "update") {
            var cartCount = document.getElementById("Cart-Items").textContent;
            document.getElementById("Cart-Items").textContent =
              parseInt(cartCount) + 1;
          }
        } else {
          DToast(data.status, data.message);
        }
      }
    } catch (error) {
      console.error(error);
    }
  }

  function DToast(icon, title) {
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
        icon: icon,
        title: title,
      })
      .then((result) => {
        if (Is_User_Logged_In) {
          // after that close modal
          var modal = new bootstrap.Modal(document.getElementById("Product"));
          modal.hide();
        }
      });
  }

  // check if thier is NeedLogin in local storage
  const needLogin = localStorage.getItem("NeedLogin");
  if (needLogin == "true") {
    const prod_id = localStorage.getItem("ProdID");
    const Size = localStorage.getItem("ProdSize");
    const Qty = localStorage.getItem("ProdQty");

    addToCart(
      `../../Utilities/api/AddToCart.php?prod_id=${prod_id}&user_id=${User_ID}&size=${Size}&qty=${Qty}`
    );

    //document.getElementById("Cart-Items").textContent = parseInt(document.getElementById("Cart-Items").textContent) + 1;

    // remove the NeedLogin in local storage
    localStorage.removeItem("NeedLogin");
    localStorage.removeItem("ProdID");
    localStorage.removeItem("ProdSize");
    localStorage.removeItem("ProdQty");
  }

  // hide loader after fully load
  document.getElementById("loader").classList.remove("d-block");
  document.getElementById("loader").classList.add("d-none");
  document.getElementById("cBody").style.overflow = "auto";

  // when i press the enter key on the search bar
  document
    .getElementById("search-bar")
    .addEventListener("keyup", function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("search-btn").click();
      }
    });

  // every keyup on the search bar
  /* document.getElementById("search-bar").addEventListener("keyup", function () {
    if (document.getElementById("search-bar").value.length > 0) {
      document.getElementById("search-btn").click();
    }
  }); */

  document.getElementById("search-btn").addEventListener("click", function () {
    function dAlert(icon, title) {
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
        icon: icon,
        title: title,
      });
    }

    async function getProductImages(ProductID) {
      var MainPic = document.getElementById("Pic-main");
      var Pic1 = document.getElementById("Pic-1");
      var Pic2 = document.getElementById("Pic-2");
      var Pic3 = document.getElementById("Pic-3");
      var Pic4 = document.getElementById("Pic-4");
      var alternate = "../../Assets/Images/Alternative.gif";

      try {
        const response = await fetch(
          "../../Utilities/api/ProductImage.php?prod_id=" + ProductID
        );

        if (!response.ok) {
          MainPic.src = alternate;
          Pic1.src = alternate;
          Pic2.src = alternate;
          Pic3.src = alternate;
          Pic4.src = alternate;
        }

        const data = await response.json();

        if (data.error) {
          MainPic.src = alternate;
          Pic1.src = alternate;
          Pic2.src = alternate;
          Pic3.src = alternate;
          Pic4.src = alternate;
        }

        if (data.length > 0) {
          for (let i = 0; i < data.length; i++) {
            if (data[i].order == 1) {
              MainPic.src = data[i].Img_Path;
              Pic1.src = data[i].Img_Path;
            }

            if (data[i].order == 2) {
              Pic2.src = data[i].Img_Path;
            }

            if (data[i].order == 3) {
              Pic3.src = data[i].Img_Path;
            }

            if (data[i].order == 4) {
              Pic4.src = data[i].Img_Path;
            }
          }
        }
      } catch (error) {
        console.error(error);
      }
    }

    async function search(url) {
      try {
        const response = await fetch(url);

        if (!response.ok) {
          dAlert("error", "An error occured while fetching data.");
          return;
        }

        const data = await response.json();

        if (data.error) {
          dAlert("error", data.error);
          document.getElementById("ResultLabel").textContent =
            "No results found.";
          var Sresult = document.getElementById("SresultList");
          Sresult.innerHTML = "";
          return;
        } else if (data.info) {
          document.getElementById("ResultLabel").textContent =
            "We Couldn't Find Any Results for: \"" +
            document.getElementById("search-bar").value +
            '"';
          var Sresult = document.getElementById("SresultList");
          Sresult.innerHTML = "";
          return;
        } else {
          document.getElementById("ResultLabel").textContent =
            'Search Results for: "' +
            document.getElementById("search-bar").value +
            '"';
          // Clear the previous search result
          var Sresult = document.getElementById("SresultList");
          var limit = 0;
          var count = 0;
          Sresult.innerHTML = "";

          if (data.length <= 5) {
            limit = data.length;
          } else {
            limit = 5;
          }

          // Loop through each item in the data array
          for (let i = 0; i < limit; i++) {
            // Create a new list group item
            var li = document.createElement("li");
            li.classList.add("list-group-item", "list-group-item-action");

            // Create a new anchor element
            var a = document.createElement("a");
            a.classList.add("text-decoration-none", "text-body");
            a.setAttribute("data-bs-toggle", "modal");
            a.setAttribute("data-bs-target", "#Product");
            a.style.cursor = "pointer";
            a.id = "Prod_" + data[i].UID;

            // Create a new div element
            var div = document.createElement("div");
            div.classList.add("d-flex", "justify-content-between");

            // Create a new div element
            var div2 = document.createElement("div");
            div2.classList.add("d-flex");

            // Create a new image element
            var img = document.createElement("img");
            img.src = data[i]["Prod_Images"][0]["Img_Path"];
            img.height = 40;
            img.classList.add("me-3", "rounded-3");

            // Create a new div element
            var div3 = document.createElement("div");

            // Create a new h5 element
            var h5 = document.createElement("h5");
            h5.classList.add("mb-0");
            h5.textContent = data[i].Prod_Name + " - " + data[i].Prod_Color;

            // Create a new p element
            var p = document.createElement("p");
            p.classList.add("mb-0");
            // available sizes if value is 0 then don't display
            // create a array of sizes
            var sizes = [];

            if (data[i].Prod_Sizes[0]["S"] != 0) {
              sizes.push("S");
            }
            if (data[i].Prod_Sizes[0]["M"] != 0) {
              sizes.push("M");
            }

            if (data[i].Prod_Sizes[0]["L"] != 0) {
              sizes.push("L");
            }

            if (data[i].Prod_Sizes[0]["XL"] != 0) {
              sizes.push("XL");
            }

            var size = "";

            // loop through the sizes array and append it to the p element
            for (let j = 0; j < sizes.length; j++) {
              if (j == sizes.length - 1) {
                size += sizes[j] + " ";
              } else {
                size += sizes[j] + ", ";
              }
            }
            if (Is_User_Logged_In) {
              p.innerHTML =
                'Size: <strong class="text-primary">' +
                size +
                '</strong> <br>Price: <strong class="fw-bold">₱' +
                data[i].Prod_Price +
                ".00</strong>";
            }
            // Append the h5 and p elements to the div3 element
            div3.appendChild(h5);
            div3.appendChild(p);
            div2.appendChild(img);
            div2.appendChild(div3);
            div.appendChild(div2);
            a.appendChild(div);
            li.appendChild(a);
            Sresult.appendChild(li);

            count++;

            document
              .getElementById("Prod_" + data[i].UID)
              .addEventListener("click", function () {
                document.getElementById("ProductID").value = "";
                document.getElementById("SS").hidden = true;
                document.getElementById("SM").hidden = true;
                document.getElementById("SL").hidden = true;
                document.getElementById("SXL").hidden = true;
                document.getElementById("Selectsize").selectedIndex = 0;
                document.getElementById("Qinput").value = 1;
                document.getElementById("Qinput").setAttribute("max", 1);
                document
                  .getElementById("AvailStat")
                  .classList.remove("bg-success", "bg-danger");
                document.getElementById("AddCart").classList.add("disabled");

                getProductImages(data[i].UID);

                document.getElementById("ProductID").value = data[i].UID;
                document.getElementById("Pname").textContent =
                  data[i].Prod_Name;
                document.getElementById("Pcolor").textContent =
                  data[i].Prod_Color;
                document.getElementById("Pbrand").textContent =
                  data[i].Prod_Brand;

                if (data[i].Prod_Sizes[0]["S"] != 0) {
                  document.getElementById("SS").hidden = false;
                  document.getElementById("SS").dataset.qty =
                    data[i].Prod_Sizes[0]["S"];
                }

                if (data[i].Prod_Sizes[0]["M"] != 0) {
                  document.getElementById("SM").hidden = false;
                  document.getElementById("SM").dataset.qty =
                    data[i].Prod_Sizes[0]["M"];
                }

                if (data[i].Prod_Sizes[0]["L"] != 0) {
                  document.getElementById("SL").hidden = false;
                  document.getElementById("SL").dataset.qty =
                    data[i].Prod_Sizes[0]["L"];
                }

                if (data[i].Prod_Sizes[0]["XL"] != 0) {
                  document.getElementById("SXL").hidden = false;
                  document.getElementById("SXL").dataset.qty =
                    data[i].Prod_Sizes[0]["XL"];
                }

                var stock =
                  data[i].Prod_Sizes[0]["S"] +
                  data[i].Prod_Sizes[0]["M"] +
                  data[i].Prod_Sizes[0]["L"] +
                  data[i].Prod_Sizes[0]["XL"];

                document.getElementById("Pprice").textContent =
                  data[i].Prod_Price;
                document.getElementById("PriceItem").textContent =
                  data[i].Prod_Price;

                document.getElementById("AvailStat").textContent =
                  stock > 0 ? "In Stock" : "Out of Stock";
                document
                  .getElementById("AvailStat")
                  .classList.add(stock > 0 ? "bg-success" : "bg-danger");
              });
          }

          if (count === 5) {
            var li = document.createElement("li");
            li.classList.add(
              "list-group-item",
              "list-group-item-action",
              "text-center"
            );
            var a = document.createElement("a");
            a.id = "VA_" + document.getElementById("search-bar").value;
            a.classList.add("btn", "btn-sm", "btn-outline-primary");
            a.textContent = "View all results";
            li.appendChild(a);
            Sresult.appendChild(li);
          }

          document
            .getElementById("VA_" + document.getElementById("search-bar").value)
            .addEventListener("click", function () {
              localStorage.removeItem("SearchValue");
              localStorage.setItem(
                "SearchValue",
                document.getElementById("search-bar").value
              );
              window.location.href = "../../Components/Products/Products.php";
            });
        }
      } catch (error) {
        console.error(error);
      }
    }

    var searchTxt = document.getElementById("search-bar").value;
    if (searchTxt.length > 0) {
      document.getElementById("Sresult").classList.remove("d-none");

      search("../../Utilities/api/FetchSearchData.php?search=" + searchTxt);
    } else {
      document.getElementById("Sresult").classList.add("d-none");
      document.getElementById("search-bar").classList.add("is-invalid");
      setTimeout(function () {
        document.getElementById("search-bar").classList.remove("is-invalid");
        document.getElementById("search-bar").focus();
      }, 1500);
    }
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
    case "Products.php":
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
          imgElement.onerror = function () {
            imgElement.src = "../../Assets/Images/Alternative.gif";
          };
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
          imgElement.onerror = function () {
            imgElement.src = "../../Assets/Images/Alternative.gif";
          };
        }
      }

      var MainPic = document.getElementById("Pic-main");
      var Pic1 = document.getElementById("Pic-1");
      var Pic2 = document.getElementById("Pic-2");
      var Pic3 = document.getElementById("Pic-3");
      var Pic4 = document.getElementById("Pic-4");

      var alternate = "../../Assets/Images/Alternative.gif";

      // change main picture on click
      if (Pic1.src != alternate) {
        Pic1.addEventListener("click", function () {
          MainPic.src = Pic1.src;
        });
      }

      if (Pic2.src != alternate) {
        Pic2.addEventListener("click", function () {
          MainPic.src = Pic2.src;
        });
      }

      if (Pic3.src != alternate) {
        Pic3.addEventListener("click", function () {
          MainPic.src = Pic3.src;
        });
      }

      if (Pic4.src != alternate) {
        Pic4.addEventListener("click", function () {
          MainPic.src = Pic4.src;
        });
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
            document.getElementById("reminder").textContent =
              "Please choose a size first.";
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
        var prod_id = document.getElementById("ProductID").value;
        var Size =
          document.getElementById("Selectsize").options[
            document.getElementById("Selectsize").selectedIndex
          ].value;
        var Qty = document.getElementById("Qinput").value;
        var InStock = document.getElementById("AvailStat").textContent;

        if (Is_User_Logged_In) {
          if (InStock == "In Stock" || Size != "Choose Size") {
            addToCart(
              `../../Utilities/api/AddToCart.php?prod_id=${prod_id}&user_id=${User_ID}&size=${Size}&qty=${Qty}`
            );
          } else {
            DToast("info", "Sorry, this item is out of stock.");
          }
        } else {
          DToast("info", "Sorry, you need to login first.");
          setTimeout(function () {
            const signModal = new bootstrap.Modal("#SignIN");
            var prodModal = bootstrap.Modal.getInstance(
              document.getElementById("Product")
            );
            prodModal.hide();
            signModal.show();
          }, 1500);

          // save the product info to local storage
          localStorage.setItem("ProdID", prod_id);
          localStorage.setItem("ProdSize", Size);
          localStorage.setItem("ProdQty", Qty);
          localStorage.setItem("NeedLogin", "true");
        }
      });

      document
        .getElementById("tocheckout")
        .addEventListener("click", function () {
          if (User_ID != 0) {
            localStorage.setItem("TempUserID", User_ID);
            window.location.href = "../../Components/Checkout/Checkout.php";
          }
        });

      if (Is_User_Logged_In) {
        document
          .getElementById("cart-btn")
          .addEventListener("click", function () {
            function CartToast(icon, title) {
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
              });
            }

            async function fetchCart(url) {
              try {
                const response = await fetch(url);

                if (!response.ok) {
                  throw new Error("An error occured while fetching data.");
                }

                const data = await response.json();

                if (data.error) {
                  CartToast("error", data.error);
                  return;
                } else if (data.info) {
                  CartToast("info", data.info);
                  return;
                } else {
                  if (data.status == "success") {
                    var CartTotal = data.cart_items.length;

                    function updateCartCount(type) {
                      if (type == "add") {
                        document.getElementById("Cart-Items").textContent =
                          parseInt(
                            document.getElementById("Cart-Items").textContent
                          ) + 1;
                        document.getElementById("Ccount").textContent =
                          parseInt(
                            document.getElementById("Ccount").textContent
                          ) + 1;
                      } else if (type == "remove") {
                        document.getElementById("Cart-Items").textContent =
                          parseInt(
                            document.getElementById("Cart-Items").textContent
                          ) - 1;
                        document.getElementById("Ccount").textContent =
                          parseInt(
                            document.getElementById("Ccount").textContent
                          ) - 1;
                      } else {
                        document.getElementById("Cart-Items").textContent =
                          CartTotal;
                        document.getElementById("Ccount").textContent =
                          CartTotal;
                      }
                    }

                    if (CartTotal > 0) {
                      var UserCart = document.getElementById("UserCart");
                      UserCart.innerHTML = "";
                      document
                        .getElementById("tocheckout")
                        .removeAttribute("disabled");

                      for (let i = 0; i < CartTotal; i++) {
                        updateCartCount();

                        var li = document.createElement("li");
                        li.classList.add(
                          "list-group-item",
                          "bg-transparent",
                          "border-0"
                        );
                        li.id = "Item-list_" + i;

                        var div1 = document.createElement("div");
                        div1.classList.add(
                          "list-group-item",
                          "bg-transparent",
                          "border-0"
                        );

                        var div2 = document.createElement("div");
                        div2.classList.add("row");

                        var div3 = document.createElement("div");
                        div3.classList.add("col-3");

                        var img = document.createElement("img");
                        img.src = data.cart_items[i].prod_Img.Image;
                        img.classList.add("img-thumbnail");
                        img.alt = data.cart_items[i].prod_Details.Prod_Name;

                        var div4 = document.createElement("div");
                        div4.classList.add("col-9");

                        var div5 = document.createElement("div");
                        div5.classList.add(
                          "d-flex",
                          "w-100",
                          "justify-content-between"
                        );

                        var h5 = document.createElement("h5");
                        h5.classList.add("mb-1");
                        h5.textContent =
                          data.cart_items[i].prod_Details.Prod_Name;

                        var small = document.createElement("small");

                        var a = document.createElement("a");
                        a.style.cursor = "pointer";
                        a.id = "Remove_" + i;
                        a.setAttribute("pid", data.cart_items[i].Unique_ID);
                        a.classList.add("text-danger");
                        a.title = "Remove from cart";
                        a.innerHTML = `<svg class="bi" width="16" height="16" role="img" aria-label="Remove from cart"><use xlink:href="#Trash" /></svg>`;

                        var div6 = document.createElement("div");
                        div6.classList.add(
                          "d-flex",
                          "w-100",
                          "justify-content-between"
                        );

                        var p1 = document.createElement("p");
                        p1.classList.add("mb-1");
                        p1.textContent =
                          "Size: " + data.cart_items[i].Item_size;

                        var p2 = document.createElement("p");
                        p2.classList.add("mb-1");
                        p2.textContent = "Qty: " + data.cart_items[i].Item_Qty;

                        var div7 = document.createElement("div");
                        div7.classList.add(
                          "d-flex",
                          "w-100",
                          "justify-content-between"
                        );

                        var p3 = document.createElement("p");
                        p3.classList.add("mb-1");
                        p3.textContent =
                          "Price: ₱ " +
                          data.cart_items[i].prod_Details.Prod_Price;

                        var p4 = document.createElement("p");
                        p4.classList.add("mb-1");
                        p4.textContent =
                          "Subtotal: ₱ " +
                          data.cart_items[i].prod_Details.Prod_Price *
                            data.cart_items[i].Item_Qty;

                        // Append in the correct order
                        small.appendChild(a);
                        div5.appendChild(h5);
                        div5.appendChild(small);

                        div6.appendChild(p1);
                        div6.appendChild(p2);

                        div7.appendChild(p3);
                        div7.appendChild(p4);

                        div4.appendChild(div5);
                        div4.appendChild(div6);
                        div4.appendChild(div7);

                        div3.appendChild(img);
                        div2.appendChild(div3);
                        div2.appendChild(div4);
                        div1.appendChild(div2);
                        li.appendChild(div1);

                        UserCart.appendChild(li);

                        document
                          .getElementById("Remove_" + i)
                          .addEventListener("click", function () {
                            function RToast(icon, title) {
                              Swal.mixin({
                                toast: true,
                                position: "top",
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                  toast.addEventListener(
                                    "mouseenter",
                                    Swal.stopTimer
                                  );
                                  toast.addEventListener(
                                    "mouseleave",
                                    Swal.resumeTimer
                                  );
                                },
                              }).fire({
                                icon: icon,
                                title: title,
                              });
                            }

                            async function removeItem(url) {
                              try {
                                const response = await fetch(url);

                                if (!response.ok) {
                                  throw new Error(
                                    "An error occured while removing item."
                                  );
                                }

                                const data = await response.json();

                                if (data.error) {
                                  RToast("error", data.error);
                                } else {
                                  if (data.status == "success") {
                                    console.log(data.message);
                                  } else {
                                    RToast("error", data.message);
                                  }
                                }
                              } catch (error) {
                                console.error(error);
                              }
                            }

                            var pid = this.getAttribute("pid");

                            removeItem(
                              "../../Utilities/api/RemoveItem.php?uuid=" + pid
                            );

                            UserCart.removeChild(
                              document.getElementById("Item-list_" + i)
                            );

                            updateCartCount("remove");

                            // if thiere is no item in the cart
                            if (UserCart.childElementCount === 0) {
                              var li = document.createElement("li");
                              li.classList.add(
                                "list-group-item",
                                "bg-transparent",
                                "border-0"
                              );
                              li.innerHTML = `<a class="list-group-item list-group-item-action bg-transparent border-0 text-body-emphasis" aria-current="true">
                        <div class="d-flex w-100 justify-content-center">
                            <h5 class=" text-body-emphasis text-center">Your cart is empty</h5>
                        </div>
                      </a>`;
                              UserCart.appendChild(li);
                              document
                                .getElementById("tocheckout")
                                .setAttribute("disabled", "true");
                            }
                          });
                      }
                    }
                  }
                }
              } catch (error) {
                console.error(error);
              }
            }

            if (Is_User_Logged_In) {
              fetchCart(`../../Utilities/api/FetchCart.php?user_id=${User_ID}`);
            }
          });
      }
      break;
    case "Checkout.php":
      document.getElementById("cart-btn").classList.add("visually-hidden");
      break;
    default:
      console.log("No script to run.");
      break;
  }
});

