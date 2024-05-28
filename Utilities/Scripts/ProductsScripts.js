window.onload = function () {
  if (localStorage.getItem("SearchValue") != null) {
    SearchValue = localStorage.getItem("SearchValue");
    document.getElementById("SearchInput").value = SearchValue;
    document.getElementById("SearchInput").focus();
    document.getElementById("SearchBtn").click();
    localStorage.removeItem("SearchValue");
  } else {
    AllProducts("../../Utilities/api/AllProduct.php");
  }
};

document.getElementById("SearchBtn").addEventListener("click", function () {
  var SearchValue = document.getElementById("SearchInput").value;
  if (SearchValue != "") {
    AllProducts("../../Utilities/api/AllProduct.php?search=" + document.getElementById("SearchInput").value);
    document.getElementById("title").textContent = 'Results for: "' + document.getElementById("SearchInput").value + '"';
  } else {
    document.getElementById("SearchInput").classList.add("is-invalid");
    setTimeout(function () {
      document.getElementById("SearchInput").focus();
      document.getElementById("SearchInput").classList.remove("is-invalid");
    }, 1500);
  }
});

// if search is empty show all products
document.getElementById("SearchInput").addEventListener("input", function () {
  if (document.getElementById("SearchInput").value == "") {
    AllProducts("../../Utilities/api/AllProduct.php");
    document.getElementById("title").textContent = "All Products";
  }
});

document
  .getElementById("SearchInput")
  .addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
      document.getElementById("SearchBtn").click();
    }
  });

async function AllProducts(url) {
  try {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error("Network response was not ok.");
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
      return;
    } else {
      var container = document.getElementById("P_Container");
      container.innerHTML = "";
      if (data.status == "true") {
        for (let i = 0; i < data.Products.length; i++) {
          for (let j = 0; j < data.Products[i].Images.length; j++) {
            if (data.Products[i].Images[j].Img_Order == 1) {
              var Pic1 = data.Products[i].Images[j].Img_Path;
            }
          }
          var div = document.createElement("div");
          div.className = "col";
          var a = document.createElement("a");
          a.className = "text-decoration-none";
          a.setAttribute("data-bs-toggle", "modal");
          a.setAttribute("data-bs-target", "#Product");
          a.setAttribute("id", "Pmodal_" + data.Products[i].UID);

          var card = document.createElement("div");
          card.className = "card pop border-0 bg-body-tertiary";

          var img = document.createElement("img");
          img.src = Pic1;
          img.className =
            "bd-placeholder-img card-img-top object-fit-cover rounded";
          img.setAttribute("role", "img");
          img.setAttribute("preserveAspectRatio", "xMidYMid slice");
          img.setAttribute("focusable", "false");
          img.setAttribute("loading", "lazy");

          var div2 = document.createElement("div");
          div2.className = "card-body";

          var p = document.createElement("p");
          p.className = "card-title text-center";
          p.innerHTML = data.Products[i].Prod_Name;

          var div3 = document.createElement("div");
          div3.className = "text-center";

          var h5 = document.createElement("h5");
          h5.innerHTML = "₱ " + data.Products[i].Price;

          container.appendChild(div);
          div.appendChild(a);
          a.appendChild(card);
          card.appendChild(img);
          card.appendChild(div2);
          div2.appendChild(p);
          div2.appendChild(div3);
          div3.appendChild(h5);

          document
            .getElementById("Pmodal_" + data.Products[i].UID)
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

              document.getElementById("ProductID").value = data.Products[i].UID;

              // arrange images by order
              for (let j = 0; j < data.Products[i].Images.length; j++) {
                if (data.Products[i].Images[j].Img_Order == 1) {
                  document.getElementById("Pic-main").src =
                    data.Products[i].Images[j].Img_Path;
                  document.getElementById("Pic-1").src =
                    data.Products[i].Images[j].Img_Path;
                }
                if (data.Products[i].Images[j].Img_Order == 2) {
                  document.getElementById("Pic-2").src =
                    data.Products[i].Images[j].Img_Path;
                }
                if (data.Products[i].Images[j].Img_Order == 3) {
                  document.getElementById("Pic-3").src =
                    data.Products[i].Images[j].Img_Path;
                }
                if (data.Products[i].Images[j].Img_Order == 4) {
                  document.getElementById("Pic-4").src =
                    data.Products[i].Images[j].Img_Path;
                }
              }

              document.getElementById("Pname").textContent =
                data.Products[i].Prod_Name;
              document.getElementById("Pbrand").textContent =
                data.Products[i].Brand;
              document.getElementById("Pcolor").textContent =
                data.Products[i].Color;

              var Stock = 0;
              for (let j = 0; j < data.Products[i].Sizes.length; j++) {
                Stock += data.Products[i].Sizes[j].S;
                Stock += data.Products[i].Sizes[j].M;
                Stock += data.Products[i].Sizes[j].L;
                Stock += data.Products[i].Sizes[j].XL;
              }

              if (Stock > 0) {
                document.getElementById("AvailStat").textContent = "In Stock";
                document.getElementById("AvailStat").classList.add("bg-success");
              } else {
                document.getElementById("AvailStat").textContent = "Out of Stock";
                document.getElementById("AvailStat").classList.add("bg-danger");
              }

              if (data.Products[i].Sizes[0].S > 0) {
                document.getElementById("SS").hidden = false;
                document
                  .getElementById("SS")
                  .setAttribute("data-Qty", data.Products[i].Sizes[0].S);
              }

              if (data.Products[i].Sizes[0].M > 0) {
                document.getElementById("SM").hidden = false;
                document
                  .getElementById("SM")
                  .setAttribute("data-Qty", data.Products[i].Sizes[0].M);
              }

              if (data.Products[i].Sizes[0].L > 0) {
                document.getElementById("SL").hidden = false;
                document
                  .getElementById("SL")
                  .setAttribute("data-Qty", data.Products[i].Sizes[0].L);
              }

              if (data.Products[i].Sizes[0].XL > 0) {
                document.getElementById("SXL").hidden = false;
                document
                  .getElementById("SXL")
                  .setAttribute("data-Qty", data.Products[i].Sizes[0].XL);
              }

              document.getElementById("Pprice").textContent = data.Products[i].Price;
              document.getElementById("PriceItem").textContent = data.Products[i].Price;
            });
        }
      } else {
        // for loop 5 times
        for (let i = 0; i < 5; i++) {
          var div = document.createElement("div");
          div.className = "col";
          var title = document.createElement("h5");
          title.className = "text-center";
          title.innerHTML = "Loading...";
          var a = document.createElement("a");
          a.className = "text-decoration-none";
          var card = document.createElement("div");
          card.className = "card border-0 bg-body-tertiary";
          var span = document.createElement("span");
          span.className = "placeholder-glow";
          var span2 = document.createElement("span");
          span2.className =
            "placeholder bd-placeholder-img card-img-top rounded";
          span2.style.height = "128px";
          span2.setAttribute("role", "img");
          span2.setAttribute("preserveAspectRatio", "xMidYMid slice");
          span2.setAttribute("focusable", "false");

          var div2 = document.createElement("div");
          div2.className = "card-body";
          var p = document.createElement("p");
          p.className = "card-title text-center placeholder-wave";
          var span3 = document.createElement("span");
          span3.className = "placeholder col-10 rounded";
          var h5 = document.createElement("h5");
          h5.className = "card-text placeholder-wave text-center";
          var span4 = document.createElement("span");
          span4.className = "placeholder col-4 rounded";

          container.appendChild(div);
          div.appendChild(a);
          a.appendChild(card);
          card.appendChild(span);
          span.appendChild(span2);
          card.appendChild(div2);
          div2.appendChild(p);
          p.appendChild(span3);
          div2.appendChild(h5);
          h5.appendChild(span4);
        }
      }
    }
  } catch (error) {
    console.error(error);
  }
}
