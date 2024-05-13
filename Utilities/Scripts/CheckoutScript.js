// Retrieve JSON data from local storage
if (localStorage.getItem("CartItems") == null) {
  localStorage.setItem("CartItems", JSON.stringify([]));
} else {
  var UserCart = JSON.parse(localStorage.getItem("CartItems"));
}

// Check if UserCart is not empty
if (UserCart.length > 0) {
  try {
    UserCart.forEach((obj) => {
      var CartList = document.getElementById("CartList");
      var li = document.createElement("li");
      li.className = "list-group-item bg-transparent";
      li.id = `MainCart_${obj.id}`;
      li.innerHTML = `<div class="hstack gap-3">
            <div class="input-group-text border-0 px-0" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-trigger="hover" data-bs-title="Select item to checkout">
                <input class="btn-check px-0" type="checkbox" id="Check${
                  obj.id
                }">
                <label class="px-0 btn btn-secondary text-body-emphasis bg-transparent border-0" style="cursor: pointer;" for="Check${
                  obj.id
                }" id="CheckLabel${obj.id}">
                    <svg class="bi" width="30px" height="30px">
                    <use xlink:href="#Check" />
                                </svg>
                                </label>
                                <input type="hidden" value="${
                                  obj.id
                                }" id="ProductID${obj.id}">
                            </div>
                            <div class="card border-0 bg-transparent">
                                <div class="row g-0">
                                    <div class="col-2 d-flex align-items-center">
                                        <img src="../${
                                          obj.product_Image
                                        }" class="img-fluid object-fit-cover w-100 rounded" alt="...">
                                    </div>
                                    <div class="col-10">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                <h5 class="card-title
                                                text-truncate" id="ProductName${
                                                  obj.id
                                                }" style="width: 200px" data-bs-toggle="tooltip" data-bs-placement="top" title="${
        obj.product_Name
      }"
                                                >${obj.product_Name}</h5>
                                                <div class="text-body-secondary">
                                                    Price: 
                                                    &#8369;
                                                    <span class="text-body-secondary fs-5 fw-bold" id="ItemPrice${
                                                      obj.id
                                                    }">${obj.Price}</span>
                                                </div>
                                                </div>
                                                <div>
                                                <button class="btn btn-sm btn-outline-danger border-0" style="cursor: pointer;
                                                " id="DeleteItem${obj.id}">
                                                    <svg fill="currentColor" class="bi" width="16px" height="16px">
                                                        <use xlink:href="#Trash" />
                                                    </svg>
                                                </button>
                                                </div>
                                            </div>
                                            <div class="hstack gap-3" id="ItemDetails${
                                              obj.id
                                            }">
                                                <div class="d-flex align-items-center">
                                                    <span class="text-body-secondary me-2">Size: </span>
                                                    <select class="form-select form-select-sm w-auto" id="Size${
                                                      obj.id
                                                    }">
                                                        <option ${
                                                          obj.Size != "S" &&
                                                          obj.Size != "M" &&
                                                          obj.Size != "L" &&
                                                          obj.Size != "XL"
                                                            ? "selected"
                                                            : ""
                                                        } hidden>Choose...</option>
                                                        <option ${
                                                          obj.Size == "S"
                                                            ? "selected"
                                                            : ""
                                                        } value="S">Small</option>
                                                        <option ${
                                                          obj.Size == "M"
                                                            ? "selected"
                                                            : ""
                                                        } value="M">Medium</option>
                                                        <option ${
                                                          obj.Size == "L"
                                                            ? "selected"
                                                            : ""
                                                        } value="L">Large</option>
                                                        <option ${
                                                          obj.Size == "XL"
                                                            ? "selected"
                                                            : ""
                                                        } value="XL">Extra Large</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-body- me-2">Qty: </span>
                                                    <div class="btn-group btn-group-sm w-50" role="group">
                                                        <a class="btn btn-sm btn-outline-secondary" id="Qminus${
                                                          obj.id
                                                        }">&minus;</a>
                                                        <input type="text" class="form-control form-control-sm text-center" min="1" value="${
                                                          obj.Quantity
                                                        }" id="Q${
        obj.id
      }" readonly>
                                                        <a class="btn btn-sm btn-outline-secondary" id="Qplus${
                                                          obj.id
                                                        }">&plus;</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
      CartList.appendChild(li);

      // Quantity minus
      document
        .getElementById(`Qminus${obj.id}`)
        .addEventListener("click", function () {
          var Q = document.getElementById(`Q${obj.id}`);
          if (Q.value > 1) {
            Q.value--;
          }
        });

      // Quantity plus
      document
        .getElementById(`Qplus${obj.id}`)
        .addEventListener("click", function () {
          var Q = document.getElementById(`Q${obj.id}`);
          Q.value++;
        });

      // Checkboxes
      document
        .getElementById(`Check${obj.id}`)
        .addEventListener("click", function () {
          if (document.getElementById("totalCartItem").value == 0) {
            //remove no item in cart
            document.getElementById("NoItem").remove();
          }

          if (document.getElementById(`Check${obj.id}`).checked) {
            // Change CheckLabel to Check
            document.getElementById(`CheckLabel${obj.id}`).innerHTML =
              "<svg class='bi' width='30px' height='30px'><use xlink:href='#Close' /></svg>";

            // disable item details
            document
              .getElementById(`ItemDetails${obj.id}`)
              .classList.add("visually-hidden");

            // Increment totalCartItem
            document.getElementById("totalCartItem").value =
              parseInt(document.getElementById("totalCartItem").value) + 1;

            var SelectSize = document.getElementById(`Size${obj.id}`);
            let Size = SelectSize.options[SelectSize.selectedIndex].value;
            var ProductID = document.getElementById(`ProductID${obj.id}`).value;
            var ProductName = document.getElementById(
              `ProductName${obj.id}`
            ).textContent;
            var Quantity = document.getElementById(`Q${obj.id}`).value;
            var Price = document.getElementById(
              `ItemPrice${obj.id}`
            ).textContent;

            var data = {
              id: ProductID,
              product_Name: ProductName,
              Size: Size,
              Quantity: Quantity,
              Price: Price,
            };

            //increment totalCartItem
            document.getElementById("totalCartItem").value =
              document.getElementById("totalCartItem").value;

            let Checklist = document.getElementById("CheckoutList");
            let li = document.createElement("li");

            // Add item to checkout list
            li.className =
              "list-group-item d-flex justify-content-between lh-sm";
            li.id = `Item_${ProductID}`;
            li.style = "cursor: pointer";
            li.innerHTML = `<div>
                        <h6 class="my-0 text-truncate" style="max-width: 200px" title="${ProductName}">${ProductName}</h6>
                        <small class="text-body-secondary">Size: <span class="text-body fw-bold">${Size}</span> Qty: <span class="text-body fw-bold">${Quantity}</span></small>
                    </div>
                    <div class="hstack gap-3">
                        <span class="text-body-secondary">
                            &#8369;
                            <span class="text-body-secondary fs-5 fw-bold" id="ItemPrice${ProductID}">${
              Quantity * Price
            }</span>
                        </span>
                    </div>`;
            Checklist.appendChild(li);

            // Increment total price
            let total_Price = document.getElementById("totalPrice").value;
            let total = parseInt(total_Price) + parseInt(Quantity * Price);
            document.getElementById("totalPrice").value = total;
            document.getElementById("total").textContent = total;

            // Increment Cart Count
            document.getElementById("CartCount").textContent =
              parseInt(document.getElementById("CartCount").textContent) + 1;
          } else {
            // Change CheckLabel to Check
            document.getElementById(`CheckLabel${obj.id}`).innerHTML =
              "<svg class='bi' width='30px' height='30px'><use xlink:href='#Check' /></svg>";

            // enable item details
            document
              .getElementById(`ItemDetails${obj.id}`)
              .classList.remove("visually-hidden");

            // Remove item from checkout list
            var Item = document.getElementById(`Item_${obj.id}`);
            Item.remove();

            // Decrement totalCartItem
            document.getElementById("totalCartItem").value =
              parseInt(document.getElementById("totalCartItem").value) - 1;

            // Decrement Cart Count
            document.getElementById("CartCount").textContent =
              parseInt(document.getElementById("CartCount").textContent) - 1;

            // If totalCartItem is 0 display no items in cart
            if (document.getElementById("totalCartItem").value == 0) {
              let li = document.createElement("li");
              li.className = "list-group-item d-flex justify-content-center";
              li.id = "NoItem";
              li.innerHTML = `<p class="text-body-secondary text-center">
              <div class="spinner-border spinner-border-sm text-secondary my-1 me-3" role="status"><span class="visually-hidden">Loading...</span></div> No Selected Items</p>`;
              document.getElementById("CheckoutList").appendChild(li);
            }

            // Decrement total price
            let total_Price = document.getElementById("totalPrice").value;
            let ItemPrice =
              parseInt(
                document.getElementById(`ItemPrice${obj.id}`).textContent
              ) * parseInt(document.getElementById(`Q${obj.id}`).value);
            let total = parseInt(total_Price) - ItemPrice;
            document.getElementById("totalPrice").value = total;
            document.getElementById("total").textContent = total;
          }
        });

      // Remove item
      document
        .getElementById(`DeleteItem${obj.id}`)
        .addEventListener("click", function () {
          if (document.getElementById(`Check${obj.id}`).checked) {
            // Decrement total price
            let total_Price = document.getElementById("totalPrice").value;
            let ItemPrice =
              parseInt(
                document.getElementById(`ItemPrice${obj.id}`).textContent
              ) * parseInt(document.getElementById(`Q${obj.id}`).value);
            let total = parseInt(total_Price) - ItemPrice;
            document.getElementById("totalPrice").value = total;
            document.getElementById("total").textContent = total;

            // Decrement totalCartItem
            document.getElementById("totalCartItem").value =
              parseInt(document.getElementById("totalCartItem").value) - 1;

            // Decrement Cart Count
            document.getElementById("CartCount").textContent =
              parseInt(document.getElementById("CartCount").textContent) - 1;

            // If totalCartItem is 0 display no items in cart
            if (document.getElementById("totalCartItem").value == 0) {
              let li = document.createElement("li");
              li.className = "list-group-item d-flex justify-content-center";
              li.id = "NoItem";
              li.innerHTML = `<p class="text-body-secondary text-center">
              <div class="spinner-border spinner-border-sm text-secondary my-1 me-3" role="status"><span class="visually-hidden">Loading...</span></div> No Selected Items</p>`;
              document.getElementById("CheckoutList").appendChild(li);
            }

            // save MainCart of current id to local storage
            var savedCart = {
              id: obj.id,
              product_Name: obj.product_Name,
              product_Image: obj.product_Image,
              Size: obj.Size,
              Quantity: obj.Quantity,
              Price: obj.Price,
            };

            // if archivedCart is existing in local storage
            if (localStorage.getItem("ArchivedCart") != null) {
              // Retrieve archivedCart from local storage
              var ArchivedCart = JSON.parse(
                localStorage.getItem("ArchivedCart")
              );

              // Push savedCart to archivedCart
              ArchivedCart.push(savedCart);

              // Save archivedCart to local storage
              localStorage.setItem(
                "ArchivedCart",
                JSON.stringify(ArchivedCart)
              );
            } else {
              // Create new array
              var ArchivedCart = [];

              // Push savedCart to archivedCart
              ArchivedCart.push(savedCart);

              // Save archivedCart to local storage
              localStorage.setItem(
                "ArchivedCart",
                JSON.stringify(ArchivedCart)
              );
            }

            /*             var ArchivedItem = JSON.parse(localStorage.getItem("ArchivedCart"));
            var RetriveList = document.getElementById("RetriveList");

            RetriveList.innerHTML = "";

            ArchivedItem.forEach((Archived) => {
              var li = document.createElement("li");
              li.className =
                "list-group-item d-flex justify-content-between lh-sm";
              li.id = `Item_${Archived.id}`;
              li.style = "cursor: pointer";
              var div = document.createElement("div");
              div.innerHTML = `
                    <div class="d-flex align-items-between">
                        <div>
                            <h6 class="my-0 text-truncate" style="max-width: 200px" title="${Archived.product_Name}">${Archived.product_Name}</h6>
                            <small class="text-body-secondary">Size: <span class="text-body fw-bold">${Archived.Size}</span> Qty: <span class="text-body fw-bold">${Archived.Quantity}</span></small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger border-0" style="cursor: pointer;" id="RetrieveItem${Archived.id}">
                            &#8617;
                        </button>
                    </div>
                    </div>
                    <div class="hstack gap-3">
                        <span class="text-body-secondary">
                            &#8369;
                            <span class="text-body-secondary fs-5 fw-bold" id="ItemPrice${Archived.id}">${Archived.Price}</span>
                        </span>
                    </div>`;
              li.appendChild(div);
              RetriveList.appendChild(li);
            }); */

            document.getElementById(`MainCart_${obj.id}`).remove();
            document.getElementById(`Item_${obj.id}`).remove();

            // check if CartList does contain any child
            if (CartList.childElementCount == 0) {
              let li = document.createElement("li");
              li.className = "list-group-item d-flex justify-content-center";
              li.id = `NoItem`;
              li.innerHTML = `<p class="text-body-secondary text-center">
              <div class="spinner-grow text-secondary my-1 me-3" role="status"><span class="visually-hidden">Loading...</span></div></p>`;
              CartList.appendChild(li);
            }

            // compare ArchivedCart and UserCart if id is equal remove from UserCart
            UserCart = UserCart.filter((item) => item.id != obj.id);

            // Save UserCart to local storage
            localStorage.setItem("CartItems", JSON.stringify(UserCart));
          } else {
            document.getElementById(`MainCart_${obj.id}`).remove();
          }
        });
    });
  } catch (error) {
    Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    }).fire({
      icon: "error",
      title: "Error: " + error,
    });
  }
} else {
  var CartList = document.getElementById("CartList");
  var li = document.createElement("li");
  li.className = "list-group-item bg-transparent";
  li.id = `NoItem`;
  var div = document.createElement("div");
  div.className = "d-flex justify-content-center";
  var spinner = document.createElement("div");
  spinner.className = "spinner-grow";
  spinner.role = "status";
  var span = document.createElement("span");
  span.className = "visually-hidden";
  span.textContent = "Loading...";
  spinner.appendChild(span);
  div.appendChild(spinner);
  li.appendChild(div);
  CartList.appendChild(li);
}