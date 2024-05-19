<div class="modal fade" id="Product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-body-tertiary bg-opacity-25 bg-blur-5">
            <div class=" modal-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col-lg-6">
                        <!-- Product Image -->
                        <!-- <div data-bs-toggle="modal" data-bs-target="#ImageView" style="cursor: pointer;" id="Inlarge">
                            <img id="Pic-main" src="" class="rounded mx-auto d-block object-fit-cover align-self-center w-100 h-auto" style="width: 750px;" alt="...">
                        </div> -->
                        <img id="Pic-main" src="" class="rounded mx-auto d-block object-fit-cover align-self-center w-100 h-auto" style="width: 750px;" alt="...">
                        <!-- Product Other Images -->
                        <div class="row row-cols-4 g-1 p-2 HImage" style="cursor: pointer;">
                            <div class="col HImage-col">
                                <img id="Pic-1" src="" class="rounded-1 mx-auto d-block object-fit-contain w-75" alt="...">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-2" src="" class="rounded-1 mx-auto d-block object-fit-contain w-75" alt="...">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-3" src="" class="rounded-1 mx-auto d-block object-fit-contain w-75" alt="...">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-4" src="" class="rounded-1 mx-auto d-block object-fit-contain w-75" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div id="card-bg" class="card border-0 bg-transparent">
                            <div class="card-body w-100 h-auto">
                                <input type="hidden" id="ProductID" value="">
                                <p class="card-title text-body-emphasis fw-bold fs-4 text-truncate" id="Pname"></p>
                                <div class="mb-2">
                                    <span id="AvailStat" class="badge rounded-0"></span>
                                </div>
                                <div class="row row-cols-2 g-2 mb-2">
                                    <div class="col-4">
                                        <p class="card-text">Brand Name</p>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-text" id="Pbrand"></h5>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 mb-2">
                                    <div class="col-4">
                                        <p class="card-text">Color</p>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-text" id="Pcolor">Navy Blue</h5>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 mb-2">
                                    <div class="col-4 py-1">
                                        <p class="card-text">Available Sizes</p>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select form-select-sm text-uppercase fw-bold w-auto" id="Selectsize">
                                            <option id="SD" selected hidden>Choose Size</option>
                                            <option id="SS" hidden value="S" data-Qty="0" class="text-uppercase">Small</option>
                                            <option id="SM" hidden value="M" data-Qty="0" class="text-uppercase">Medium</option>
                                            <option id="SL" hidden value="L" data-Qty="0" class="text-uppercase">Large</option>
                                            <option id="SXL" hidden value="XL" data-Qty="0" class="text-uppercase">Extra Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 mb-3">
                                    <div class="col-6 py-1">
                                        <h5 class="card-text">Price</h5>
                                    </div>
                                    <div class="col-6 py-1">
                                        <h4 class="card-text fw-bold">₱ <span id="Pprice">0.00</span><small class="visually-hidden" id="PriceItem"></small></h4>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2">
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <button id="Qminus" class="btn btn-sm btn-outline-primary rounded-start-0" type="button">
                                                <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                    <use xlink:href="#Minus" />
                                                </svg>
                                            </button>
                                            <input id="Qinput" type="text" class="form-control form-control-sm text-center bg-transparent border-primary" value="1" min="1" max="" readonly>
                                            <button id="Qplus" class="btn btn-sm btn-outline-primary rounded-end-0" type="button">
                                                <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                    <use xlink:href="#Plus" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <a id="AddCart" class="btn btn-sm btn-primary w-100 rounded-0 disabled" role="button">
                                            <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                <use xlink:href="#Cart" />
                                            </svg>
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <small class="text-muted user-select-none" id="reminder">&nbsp;</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Image -->

<div class="modal" id="ImageView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down modal-dialog-scrollable hide-scrollbar">
        <div class="modal-content bg-body-tertiary bg-opacity-25 bg-blur-5">
            <div class="modal-body">
                <img id="Pic-View" src="../../Assets/Images/testing/temp1.jpg" class="rounded mx-auto d-block object-fit-cover align-self-center w-auto h-auto" alt="...">
            </div>
        </div>
    </div>
</div>

<!-- <script>
    document.getElementById('Inlarge').addEventListener('click', function() {
        var img = document.getElementById('Pic-main').src;
        document.getElementById('Pic-View').src = img;
    });

    // if ImageView is closed, Product Modal will show
    var myModal = document.getElementById('ImageView');
    myModal.addEventListener('hidden.bs.modal', function() {
        var myModal = new bootstrap.Modal(document.getElementById('Product'));
        myModal.show();
    });
</script> -->