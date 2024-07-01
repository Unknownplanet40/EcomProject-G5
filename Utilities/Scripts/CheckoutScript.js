let haveExistingAddress = false;
let completeAddress = "";
let paymentMethod = "none";
let retrievedItems = [];
localStorage.removeItem("SelectedItems");

async function CheckoutItems(UserID) {
  try {
    const response = await fetch(
      "../../Utilities/api/CheckoutItems.php?UserID=" + UserID
    );

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }

    const data = await response.json();

    if (data.length > 0) {
      var CheckoutList = document.getElementById("CartList");
      CheckoutList.innerHTML = "";

      data.forEach((obj) => {
        var li = document.createElement("li");
        li.classList.add("list-group-item");
        CheckoutList.appendChild(li);

        var row = document.createElement("div");
        row.classList.add("row", "g-0");

        var col1 = document.createElement("div");
        col1.classList.add(
          "col-1",
          "d-flex",
          "justify-content-end",
          "align-items-center",
          "px-0"
        );
        row.appendChild(col1);

        var input1 = document.createElement("input");
        input1.classList.add("btn-check");
        input1.type = "checkbox";
        input1.id = "Check_" + obj.UUID;

        var label1 = document.createElement("label");
        label1.classList.add(
          "px-0",
          "btn",
          "btn-secondary",
          "text-body-emphasis",
          "bg-transparent",
          "border-0"
        );
        label1.style.cursor = "pointer";
        label1.htmlFor = "Check_" + obj.UUID;
        label1.id = "CheckLabel_" + obj.UUID;
        label1.innerHTML =
          "<svg class='bi' width='30px' height='30px'><use xlink:href='#Check' /></svg>";

        col1.appendChild(input1);
        col1.appendChild(label1);

        var col2 = document.createElement("div");
        col2.classList.add(
          "col-4",
          "d-flex",
          "justify-content-center",
          "align-items-center",
          "px-1"
        );

        var img = document.createElement("img");
        img.src = obj.Images[0].Img_Path;
        img.alt = obj.Prod_Details.Prod_Name;
        img.classList.add("img-thumbnail", "object-fit-contain");
        img.style.width = "150px";
        img.style.height = "150px";

        col2.appendChild(img);

        var col3 = document.createElement("div");
        col3.classList.add("col-7");

        var div1 = document.createElement("div");
        div1.classList.add("d-flex", "justify-content-between");

        var h6 = document.createElement("h6");
        h6.classList.add("mb-0");
        h6.innerHTML = obj.Prod_Details.Prod_Name;

        var button1 = document.createElement("button");
        button1.classList.add("btn-close");
        button1.type = "button";
        button1.ariaLabel = "Close";

        div1.appendChild(h6);
        div1.appendChild(button1);

        var br = document.createElement("br");

        var small = document.createElement("small");

        var b1 = document.createElement("b");
        b1.innerHTML = obj.Prod_Details.Brand;

        var b2 = document.createElement("b");
        b2.innerHTML = obj.Prod_Details.Color;

        small.innerHTML = "Brand: ";
        small.appendChild(b1);

        small.innerHTML += " | Color: ";
        small.appendChild(b2);

        var innerdiv = document.createElement("div");
        innerdiv.classList.add("mt-3");
        var div2 = document.createElement("div");
        div2.classList.add("d-flex", "justify-content-start");

        var inputGroup1 = document.createElement("div");
        inputGroup1.classList.add("input-group", "w-50", "mx-2");

        var button2 = document.createElement("button");
        button2.classList.add("btn", "btn-sm", "btn-outline-secondary");
        button2.type = "button";
        button2.id = "Minus_" + obj.UUID;
        button2.innerHTML = "-";

        var input3 = document.createElement("input");
        input3.type = "text";
        input3.classList.add("form-control", "form-control-sm", "text-center");
        input3.value = obj.Ordered_Qty;
        input3.id = "QInput_" + obj.UUID;
        input3.min = 1;
        if (obj.Ordered_Size == "S") {
          input3.max = obj.Sizes[0].S;
        } else if (obj.Ordered_Size == "M") {
          input3.max = obj.Sizes[0].M;
        } else if (obj.Ordered_Size == "L") {
          input3.max = obj.Sizes[0].L;
        } else if (obj.Ordered_Size == "XL") {
          input3.max = obj.Sizes[0].XL;
        } else {
          input3.max = 1;
        }
        var button3 = document.createElement("button");
        button3.classList.add("btn", "btn-sm", "btn-outline-secondary");
        button3.type = "button";
        button3.id = "Plus_" + obj.UUID;
        button3.innerHTML = "+";

        inputGroup1.appendChild(button2);
        inputGroup1.appendChild(input3);
        inputGroup1.appendChild(button3);

        var inputGroup2 = document.createElement("div");
        inputGroup2.classList.add("input-group", "w-50", "mx-2");

        var select1 = document.createElement("select");
        select1.classList.add("form-select", "form-select-sm");
        select1.id = "Size_" + obj.UUID;

        // Create and configure the initial "Size" option
        var option1 = document.createElement("option");
        option1.disabled = true;
        option1.hidden = true;
        option1.innerHTML = "Size";

        // Create the size options
        var sizes = ["S", "M", "L", "XL"];
        var options = [];

        sizes.forEach(function (size) {
          var option = document.createElement("option");
          option.value = size;
          option.hidden = true; // Initially hidden
          option.innerHTML = size;
          options.push(option);
        });

        // Check availability and unhide available sizes
        if (obj.Sizes[0].S > 0) {
          options[0].hidden = false;
          options[0].setAttribute("data-Qty", obj.Sizes[0].S);
        }

        if (obj.Sizes[0].M > 0) {
          options[1].hidden = false;
          options[1].setAttribute("data-Qty", obj.Sizes[0].M);
        }

        if (obj.Sizes[0].L > 0) {
          options[2].hidden = false;
          options[2].setAttribute("data-Qty", obj.Sizes[0].L);
        }

        if (obj.Sizes[0].XL > 0) {
          options[3].hidden = false;
          options[3].setAttribute("data-Qty", obj.Sizes[0].XL);
        }

        if (obj.Ordered_Size == "S") {
          options[0].selected = true;
          if (parseInt(input3.value) > parseInt(obj.Sizes[0].S)) {
            label1.classList.add("visually-hidden");
          } else {
            label1.classList.remove("visually-hidden");
          }
        } else if (obj.Ordered_Size == "M") {
          options[1].selected = true;
          if (parseInt(input3.value) > parseInt(obj.Sizes[0].M)) {
            label1.classList.add("visually-hidden");
          } else {
            label1.classList.remove("visually-hidden");
          }
        } else if (obj.Ordered_Size == "L") {
          options[2].selected = true;
          if (parseInt(input3.value) > parseInt(obj.Sizes[0].L)) {
            label1.classList.add("visually-hidden");
          } else {
            label1.classList.remove("visually-hidden");
          }
        } else if (obj.Ordered_Size == "XL") {
          options[3].selected = true;
          if (parseInt(input3.value) > parseInt(obj.Sizes[0].XL)) {
            label1.classList.add("visually-hidden");
          } else {
            label1.classList.remove("visually-hidden");
          }
        } else {
          options[0].selected = true;
          label1.classList.add("visually-hidden");
        }

        // Append options to the select element
        select1.appendChild(option1);
        options.forEach(function (option) {
          select1.appendChild(option);
        });

        inputGroup2.appendChild(select1);

        div2.appendChild(inputGroup1);
        div2.appendChild(inputGroup2);
        innerdiv.appendChild(div2);

        var hr = document.createElement("hr");
        hr.classList.add("my-2");

        var div3 = document.createElement("div");
        div3.classList.add("d-flex", "justify-content-evenly");

        var p1 = document.createElement("p");
        p1.classList.add("text-body-secondary");
        p1.innerHTML = "Price: ";

        var b3 = document.createElement("b");
        b3.innerHTML = "&#8369; " + obj.Prod_Details.Price + ".00";
        b3.setAttribute("data-price", obj.Prod_Details.Price);

        var p2 = document.createElement("p");
        p2.classList.add("text-body-secondary");
        p2.innerHTML = "Total: ";

        var b4 = document.createElement("b");
        b4.innerHTML =
          "&#8369; " + obj.Prod_Details.Price * input3.value + ".00";
        b4.setAttribute("data-total", obj.Prod_Details.Price * input3.value);

        p1.appendChild(b3);
        p2.appendChild(b4);
        div3.appendChild(p1);
        div3.appendChild(p2);
        col3.appendChild(div1);
        col3.appendChild(small);
        col3.appendChild(innerdiv);
        col3.appendChild(hr);
        col3.appendChild(div3);
        row.appendChild(col1);
        row.appendChild(col2);
        row.appendChild(col3);
        li.appendChild(row);

        // Event listeners for the Size select element
        select1.addEventListener("change", function () {
          select1.childNodes.forEach(function (option) {
            if (option.selected) {
              var qty = option.getAttribute("data-Qty");
              input3.max = qty;
              if (parseInt(input3.value) > parseInt(qty)) {
                document
                  .getElementById("CheckLabel_" + obj.UUID)
                  .classList.add("visually-hidden");
              } else {
                document
                  .getElementById("CheckLabel_" + obj.UUID)
                  .classList.remove("visually-hidden");
              }
            }
          });
        });

        button2.addEventListener("click", function () {
          if (parseInt(input3.value) > 1) {
            input3.value = parseInt(input3.value) - 1;
            b4.innerHTML =
              "&#8369; " + obj.Prod_Details.Price * input3.value + ".00";
            b4.setAttribute(
              "data-total",
              obj.Prod_Details.Price * input3.value
            );
            if (parseInt(input3.value) > parseInt(input3.max)) {
              document
                .getElementById("CheckLabel_" + obj.UUID)
                .classList.add("visually-hidden");
            } else {
              document
                .getElementById("CheckLabel_" + obj.UUID)
                .classList.remove("visually-hidden");
            }
          }
        });

        button3.addEventListener("click", function () {
          if (parseInt(input3.value) < parseInt(input3.max)) {
            input3.value = parseInt(input3.value) + 1;
            b4.innerHTML =
              "&#8369; " + obj.Prod_Details.Price * input3.value + ".00";
            b4.setAttribute(
              "data-total",
              obj.Prod_Details.Price * input3.value
            );
            if (parseInt(input3.value) > parseInt(input3.max)) {
              document
                .getElementById("CheckLabel_" + obj.UUID)
                .classList.add("visually-hidden");
            } else {
              document
                .getElementById("CheckLabel_" + obj.UUID)
                .classList.remove("visually-hidden");
            }
          }
        });

        button1.addEventListener("click", function () {
          var ConfirmDelete = confirm(
            "Are you sure you want to remove this item from your cart?"
          );
          if (ConfirmDelete) {
            DeleteCartItem(obj.UUID, UserID);
          }
        });

        label1.addEventListener("click", function () {
          if (!input1.checked) {
            label1.innerHTML =
              "<svg class='bi' width='30px' height='30px'><use xlink:href='#Close' /></svg>";
            var CheckList = document.getElementById("CheckoutList");
            // if NoItem is present, remove it
            if (document.getElementById("NoItem") != null) {
              document.getElementById("NoItem").remove();
            }

            var CartCount = document.getElementById("CartCount");
            if (CartCount == null) {
              CartCount = 0;
            } else {
              CartCount = parseInt(CartCount.innerHTML);
            }
            CartCount += 1;
            document.getElementById("CartCount").innerHTML = CartCount;

            var li = document.createElement("li");
            li.classList.add(
              "list-group-item",
              "d-flex",
              "justify-content-between"
            );
            li.id = "ItemNo_" + obj.UUID;
            var div = document.createElement("div");
            var h6 = document.createElement("h6");
            h6.classList.add("my-0", "text-truncate");
            h6.style.maxWidth = "200px";
            h6.title = obj.Prod_Details.Prod_Name;
            h6.innerHTML = obj.Prod_Details.Prod_Name;
            var small = document.createElement("small");
            small.classList.add("text-body-secondary");
            small.innerHTML = "Size: ";
            var span1 = document.createElement("span");
            span1.classList.add("text-body", "fw-bold");
            span1.innerHTML = obj.Ordered_Size;
            small.appendChild(span1);
            small.innerHTML += " Qty: ";
            var span2 = document.createElement("span");
            span2.classList.add("text-body", "fw-bold");
            span2.innerHTML = input3.value;
            small.appendChild(span2);
            div.appendChild(h6);
            div.appendChild(small);
            var div2 = document.createElement("div");
            div2.classList.add("hstack", "gap-3");
            var span3 = document.createElement("span");
            span3.classList.add("text-body-secondary");
            span3.innerHTML = "&#8369;";
            var span4 = document.createElement("span");
            span4.classList.add("text-body-secondary", "fs-5", "fw-bold");
            span4.id = "ItemPrice" + obj.Prod_Details.Prod_ID;
            span4.innerHTML = obj.Prod_Details.Price * input3.value;
            span3.appendChild(span4);
            div2.appendChild(span3);
            li.appendChild(div);
            li.appendChild(div2);
            CheckList.appendChild(li);

            var totalprice = document.getElementById("totalPrice");
            var total = document.getElementById("total");
            var temp_price =
              parseInt(totalprice.value) +
              obj.Prod_Details.Price * input3.value;
            totalprice.value = temp_price;
            total.innerHTML = temp_price + ".00";

            button2.disabled = true;
            button3.disabled = true;
            select1.disabled = true;
            input3.disabled = true;
          } else {
            button2.disabled = false;
            button3.disabled = false;
            select1.disabled = false;
            input3.disabled = false;

            label1.innerHTML =
              "<svg class='bi' width='30px' height='30px'><use xlink:href='#Check' /></svg>";

            var ItemNo = document.getElementById("ItemNo_" + obj.UUID);
            if (ItemNo != null) {
              ItemNo.remove();

              var totalprice = document.getElementById("totalPrice");
              var total = document.getElementById("total");
              var temp_price =
                parseInt(totalprice.value) -
                obj.Prod_Details.Price * input3.value;

              totalprice.value = temp_price;
              total.innerHTML = temp_price + ".00";

              var CartCount = document.getElementById("CartCount");
              if (CartCount == null) {
                CartCount = 0;
              } else {
                CartCount = parseInt(CartCount.innerHTML);
              }
              CartCount -= 1;
              document.getElementById("CartCount").innerHTML = CartCount;
            }

            if (
              document.getElementById("CheckoutList").childElementCount == 0
            ) {
              var CheckList = document.getElementById("CheckoutList");
              var li = document.createElement("li");
              li.classList.add(
                "list-group-item",
                "d-flex",
                "justify-content-center"
              );
              li.id = "NoItem";
              li.innerHTML =
                '<p class="text-body-secondary text-center"><div class="spinner-border spinner-border-sm text-secondary my-1 me-3" role="status"><span class="visually-hidden">Loading...</span></div> No Selected Items</p>';
              CheckList.appendChild(li);
            }
          }
        });
      });
    } else {
      var CheckoutList = document.getElementById("CartList");
      CheckoutList.innerHTML = "";
      var li = document.createElement("li");
      li.classList.add(
        "list-group-item",
        "d-flex",
        "justify-content-center",
        "align-items-center",
        "bg-transparent"
      );
      li.id = "ChartNoItem";
      var p = document.createElement("p");
      p.classList.add("text-body-secondary", "text-center");
      var div = document.createElement("div");
      div.classList.add("spinner-border", "text-secondary", "me-3");
      div.role = "status";
      var span = document.createElement("span");
      span.classList.add("visually-hidden");
      span.innerHTML = "Loading...";
      div.appendChild(span);
      p.appendChild(div);
      li.appendChild(p);
      CheckoutList.appendChild(li);
    }
  } catch (error) { }
}

async function DeleteCartItem(UUID, UserID) {
  try {
    const response = await fetch(
      "../../Utilities/api/DeleteCartItem.php?UUID=" +
      UUID +
      "&UserID=" +
      UserID
    );

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }

    const data = await response.json();

    if (data.Status == "Success") {
      CheckoutItems(UserID);
    }
  } catch (error) { }
}

async function addressAndPaymentMethod(userID) {
  try {
    const response = await fetch(
      `../../Utilities/api/CheckUserStat.php?UserID=${userID}`
    );

    if (!response.ok) {
      throw new Error(`HTTP error ${response.status}`);
    }

    const responseData = await response.json();

    if (responseData.status === "error") {
      console.error(responseData.message);
      return;
    }

    if (responseData.status === "success") {
      const data = responseData.data;

      haveExistingAddress = data.isAddressExist === 1;
      completeAddress = data.address;
      switch (data.payment_method) {
        case "GCash":
          paymentMethod = "GCash";
          break;
        case "Maya":
          paymentMethod = "Maya";
          break;
        case "Credit Card":
          paymentMethod = "Credit/Debit Card";
          break;
        case "COD":
          paymentMethod = "Cash on Delivery";
          break;
        default:
          paymentMethod = "none";
      }
      const paymentMethodRadios = document.querySelectorAll(
        'input[name="PaymentMethod"]'
      );
      paymentMethodRadios.forEach((radio) => {
        if (radio.value === "0" && paymentMethod === "Cash on Delivery") {
          radio.checked = true;
        } else if (radio.value === "1" && paymentMethod === "GCash") {
          radio.checked = true;
        } else if (radio.value === "2" && paymentMethod === "Maya") {
          radio.checked = true;
        } else if (
          radio.value === "3" &&
          paymentMethod === "Credit/Debit Card"
        ) {
          radio.checked = true;
        }
      });

      console.log("haveExistingAddress: ", haveExistingAddress);
      console.log("paymentMethod: ", paymentMethod);
      console.log("completeAddress: ", completeAddress);
    }
  } catch (error) {
    console.error("Function: addressAndPaymentMethod\n", error);
  }
}

async function CheckforPaymentType(
  UsesrID,
  PaymentMethod,
  selectedItems,
  Address
) {
  try {
    const response = await fetch(
      "../../Utilities/api/PaymentInfo.php?UserID=" +
      UsesrID +
      "&PaymentMethod=" +
      PaymentMethod
    );

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }

    function loadingSwal() {
      Swal.fire({
        title: "Processing Payment",
        html: "Please wait while we process your payment.",
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
      });
    }

    function processPayment(Type, selectedItems, Address) {
      if (Type === "Cash on Delivery") {
        ProceedtoCheckout(selectedItems, Address, PaymentMethod);
      } else {
        loadingSwal();
        // Simulate payment processing delay
        setTimeout(() => {
          const isSuccess = Math.random() > 0.2; // 80% chance to succeed, 20% chance to fail
          if (isSuccess) {
            Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 1400,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
              },
            })
              .fire({
                icon: "success",
                text: "Your payment has been successfully processed.",
              })
              .then(() => {
                ProceedtoCheckout(selectedItems, Address, PaymentMethod);
              });
          } else {
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
              icon: "warning",
              text: "There was an issue processing your payment. Please try again.",
            });
          }
        }, 3000); // 3 second delay to simulate processing time
      }
    }

    const data = await response.json();

    if (data.status == "error") {
      if (data.message === "Wallet not found.") {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
          },
        })
          .fire({
            icon: "info",
            text:
              "We noticed that you don't have " +
              PaymentMethod +
              " Payment method yet.",
          })
          .then(() => {
            const walletModal = new bootstrap.Modal(
              document.getElementById("OnlineWallet"),
              {
                keyboard: false,
                backdrop: "static",
              }
            );
            walletModal.show();
          });
        return;
      } else if (data.message === "Credit card not found.") {
        Swal.mixin({
          toast: true,
          position: "top",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
          },
        })
          .fire({
            icon: "info",
            text:
              "We noticed that you don't have " +
              PaymentMethod +
              " Payment method yet.",
          })
          .then(() => {
            const cardModal = new bootstrap.Modal(
              document.getElementById("CreditCard"),
              {
                keyboard: false,
                backdrop: "static",
              }
            );
            cardModal.show();
          });
        return;
      } else {
        alert(data.message);
      }
    }

    if (data.status == "success") {
      processPayment(data.Type, selectedItems, Address);
    }
  } catch (error) {
    console.error("Function: CheckforPaymentType\n", error);
  }
}

async function ProceedtoCheckout(Items, Address, PaymentMethod) {
  try {
    var totalPrice = document.getElementById("totalPrice").value;
    const response = await fetch("../../Utilities/api/OrderItem.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        Items: Items,
        Address: Address,
        PaymentMethod: PaymentMethod,
        TotalPrice: totalPrice,
        User_ID: User_ID,
      }),
    });

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }

    const data = await response.json();

    if (data.status == "success") {
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
          text: "Order placed successfully.",
        })
        .then(() => {
          CheckoutItems(User_ID);
          location.reload();
        });
    } else {
      alert("Checkout failed!");
    }
  } catch (error) {
    console.error("Function: ProceedtoCheckout\n", error);
  }
}

async function SaveOLPaymentInfo(Type, Number, Email, UserID) {
  try {
    const response = await fetch(
      "../../Utilities/api/OnlinePayment.php?Type=" +
      Type +
      "&Number=" +
      Number +
      "&Email=" +
      Email +
      "&UserID=" +
      UserID
    );

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }

    const data = await response.json();

    if (data.status == "success") {
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
          text: "Successfully saved wallet information.",
        })
        .then(() => {
          document.getElementById("OLM_Close").click();
        });
    } else {
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
        icon: "error",
        text: "Failed to save wallet information.",
      });
    }
  } catch (error) {
    console.error("Function: SavePaymentInfo\n", error);
  }
}

async function ArchiveCart(UserID) {
  try {
    const response = await fetch(
      "../../Utilities/api/ArchiveCart.php?UserID=" + UserID
    );

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }
    const data = await response.json();

    var RetriveList = document.getElementById("RetriveList");
    RetriveList.innerHTML = "";

    if (data.status == "error") {
      var li = document.createElement("li");
      li.classList.add("list-group-item", "text-center");
      li.innerHTML = "No items to retrieve.";
      RetriveList.appendChild(li);
    } else {
      data.data.forEach((obj) => {
        var li = document.createElement("li");
        li.classList.add(
          "list-group-item",
          "d-flex",
          "justify-content-between",
          "align-items-start",
          "bg-body-tertiary",
          "bg-opacity-50"
        );

        var input = document.createElement("input");
        input.classList.add("form-check-input", "me-1");
        input.type = "checkbox";
        input.id = "Check_" + obj.UUID;

        var div1 = document.createElement("div");
        div1.classList.add("ms-2", "me-auto");

        var div2 = document.createElement("div");
        div2.classList.add("fw-bold");
        div2.innerHTML =
          '<label for="Check_' + obj.UUID + '">' + obj.Product + "</label>";

        var div3 = document.createElement("div");
        div3.classList.add("text-muted");
        div3.innerHTML = "Brand: ";

        var span1 = document.createElement("span");
        span1.classList.add("fw-bold");
        span1.innerHTML = obj.Brand;
        div3.appendChild(span1);

        div3.innerHTML += " | Size: ";
        var span2 = document.createElement("span");
        span2.classList.add("fw-bold");
        span2.innerHTML = obj.Size;
        div3.appendChild(span2);

        div3.innerHTML += " | Quantity: ";
        var span3 = document.createElement("span");
        span3.classList.add("fw-bold");
        span3.innerHTML = obj.Quantity;
        div3.appendChild(span3);

        div1.appendChild(div2);
        div1.appendChild(div3);

        var span4 = document.createElement("span");
        span4.classList.add("text-body-secondary");
        span4.innerHTML = "&#x20B1; ";

        var span5 = document.createElement("span");
        span5.classList.add("fw-bold");
        span5.innerHTML = obj.Price;
        span4.appendChild(span5);

        li.appendChild(input);
        li.appendChild(div1);
        li.appendChild(span4);

        RetriveList.appendChild(li);

        input.addEventListener("click", function () {
          if (input.checked) {
            retrievedItems.push(obj.UUID);
          } else {
            retrievedItems = retrievedItems.filter((item) => item !== obj.UUID);
          }
          // if retrievedItems is not empty, enable the "Retrieve" button
          if (retrievedItems.length > 0) {
            document.getElementById("RetBTN").disabled = false;
          } else {
            document.getElementById("RetBTN").disabled = true;
          }
        });
      });
    }
  } catch (error) {
    console.error("Function: ArchiveCart\n", error);
  }
}

if (localStorage.getItem("TempUserID") == null) {
  var TempUserID = 0;
} else {
  var TempUserID = localStorage.getItem("TempUserID");
  CheckoutItems(TempUserID);
  addressAndPaymentMethod(TempUserID);
}

document.getElementById("checkBTN").addEventListener("click", function () {
  if (TempUserID != 0) {
    var checkoutList = document.getElementById("CheckoutList");
    if (checkoutList.childElementCount > 0) {
      var cartCount = document.getElementById("CartCount");
      if (cartCount != null) {
        if (parseInt(cartCount.innerHTML) > 0) {
          var selectedItems = [];
          var items = document.querySelectorAll('input[type="checkbox"]');
          items.forEach((item) => {
            if (item.checked) {
              selectedItems.push(item.id.split("_")[1]);
            }
          });

          if (selectedItems.length > 0) {
            localStorage.setItem(
              "SelectedItems",
              JSON.stringify(selectedItems)
            );

            // Check if user has existing address
            if (haveExistingAddress) {
              const paymentMethodRadios = document.querySelectorAll(
                'input[name="PaymentMethod"]'
              );
              let selectedPaymentMethod = "";
              let selectedPaymentMethodValue = "";
              paymentMethodRadios.forEach((radio) => {
                if (radio.checked) {
                  selectedPaymentMethod = radio.value;
                  selectedPaymentMethodValue =
                    radio.nextElementSibling.innerText;
                }
              });

              if (selectedPaymentMethod === "") {
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
                  icon: "error",
                  text: "Please select a payment method.",
                });
              } else {
                CheckforPaymentType(
                  TempUserID,
                  selectedPaymentMethodValue,
                  selectedItems,
                  completeAddress
                );
              }
            } else {
              const addressModal = new bootstrap.Modal(
                document.getElementById("Addressfillup"),
                {
                  keyboard: false,
                  backdrop: "static",
                }
              );
              addressModal.show();
            }
          }
        }
      }
    }
  } else {
    console.log("No items to checkout.");
  }
});

document.getElementById("SaveWallet").addEventListener("click", function () {
  function functoast(icon, text, timer) {
    Swal.mixin({
      toast: true,
      position: "top",
      showConfirmButton: false,
      timer: timer,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    }).fire({
      icon: icon,
      text: text,
    });
  }

  const walletNumber = document.getElementById("OL_Account").value;
  const walletEmail = document.getElementById("OL_Email").value;
  const walletGcash = document.getElementById("GCash");
  const walletMaya = document.getElementById("Maya");
  const walletType = walletGcash.checked ? "GCash" : "Maya";

  if (walletNumber === "" || walletEmail === "") {
    functoast("error", "Please fill up all fields.", 3000);
    return;
  }

  if (!walletGcash.checked && !walletMaya.checked) {
    functoast("error", "Please select a wallet type.", 3000);
    return;
  }

  const walletNumberRegex = /^(09)\d{9}$/;
  if (!walletNumberRegex.test(walletNumber)) {
    functoast("error", "Please start with '09' followed by 9 digits.", 3000);
    return;
  } else if (walletNumber.length !== 11) {
    functoast("error", "Please enter 11 digits.", 3000);
    return;
  }

  const walletEmailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  if (!walletEmailRegex.test(walletEmail)) {
    functoast("error", "Please enter a valid email address.", 3000);
    return;
  }

  SaveOLPaymentInfo(walletType, walletNumber, walletEmail, TempUserID);
});

document.getElementById("ArchiveCart").addEventListener("click", function () {
  ArchiveCart(TempUserID);
});

document.getElementById("RetBTN").addEventListener("click", async function () {
  if (retrievedItems.length > 0) {
    var RetBTN = document.getElementById("RetBTN");
    RetBTN.disabled = true;
    RetBTN.innerHTML = "Retrieving...";

    var data = {
      UserID: TempUserID,
      Items: retrievedItems,
    };

    try {
      const response = await fetch("../../Utilities/api/RetrieveCart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });

      if (!response.ok) {
        throw new Error("HTTP error " + response.status);
      }

      const resData = await response.json();

      if (resData.status === "error") {
        console.error(resData.message);
        return;
      }

      if (resData.status === "success") {
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
            text: "Items retrieved successfully.",
          })
          .then(() => {
            setTimeout(() => {
              RetBTN.disabled = false;
              RetBTN.innerHTML = "Retrieve Selected Items";
              CheckoutItems(TempUserID);
              document.getElementById("RetCloseModal").click();
            }, 1000);
          });
      }
    } catch (error) {
      console.error("Function: RetrieveCart\n", error);
    }
  } else {
    var RetBTN = document.getElementById("RetBTN");
    RetBTN.disabled = true;
    RetBTN.classList.remove("btn-primary");
    RetBTN.classList.add("btn-secondary");

    setTimeout(() => {
      RetBTN.disabled = false;
      RetBTN.classList.remove("btn-secondary");
      RetBTN.classList.add("btn-primary");
    }, 1000);
  }
});

document.getElementById("SaveAddress").addEventListener("click", async function () {
  var Province = document.getElementById("Province");
  var City = document.getElementById("Municipality");
  var Barangay = document.getElementById("Barangay");
  var HouseNo = document.getElementById("HouseNo");
  var ZipCode = document.getElementById("ZipCode");
  var ContactNo = document.getElementById("Contact");
  var Landmark = document.getElementById("Landmark");

  if (
    Province.value == "" ||
    City.value == "" ||
    Barangay.value == "" ||
    HouseNo.value == "" ||
    ZipCode.value == "" ||
    ContactNo.value == ""
  ) {
    Swal.mixin({
      toast: true,
      position: "top",
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    }).fire({
      icon: "warning",
      text: "Please fill up all fields.",
    });
    return;
  }

  if (ContactNo.value.length !== 11) {
    ContactNo.classList.add("is-invalid");
    setTimeout(() => {
      ContactNo.classList.remove("is-invalid");
    }, 2000);
    return;
  } else if (isNaN(ContactNo.value)) {
    ContactNo.classList.add("is-invalid");
    setTimeout(() => {
      ContactNo.classList.remove("is-invalid");
    }, 2000);
    return;
  }

  if (ZipCode.value.length !== 4) {
    ZipCode.classList.add("is-invalid");
    setTimeout(() => {
      ZipCode.classList.remove("is-invalid");
    }, 2000);
    return;
  } else if (isNaN(ZipCode.value)) {
    ZipCode.classList.add("is-invalid");
    setTimeout(() => {
      ZipCode.classList.remove("is-invalid");
    }, 2000);
    return;
  }

  var data = {
    UserID: TempUserID,
    province: Province.value,
    municipality: City.value,
    barangay: Barangay.value,
    houseno: HouseNo.value,
    zipcode: ZipCode.value,
    contactno: ContactNo.value,
    landmark: Landmark.value,
  };

  try {
    const response = await fetch("../../Utilities/api/UserInfo.php?address=checkout", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }

    const resData = await response.json();

    if (resData.status === "error") {
      console.error(resData.message);
      return;
    };

    if (resData.status === "success") {
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
          text: "Address saved successfully.",
        })
        .then(() => {
          document.getElementById("AddModalClose").click();
          addressAndPaymentMethod(TempUserID);
        });
    }
  } catch (error) {
    console.error("Function: SaveAddress\n", error);
  }
});
