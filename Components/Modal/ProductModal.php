<div class="modal fade" id="Product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-body-tertiary bg-opacity-25 bg-blur-5">
            <div class=" modal-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col-lg-6">
                        <!-- Product Image -->
                        <img id="Pic-main" src="" class="rounded mx-auto d-block object-fit-cover align-self-center w-100" style="height: 300px; width: 750px;" alt="...">
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
                    <div class="col-lg-6">
                        <div id="card-bg" class="card border-0 bg-body-tertiary bg-opacity-10 bg-blur-3">
                            <div class="card-body py-5">
                                <input type="hidden" id="ProductID" value="">
                                <p class="card-title text-body-emphasis fw-bold fs-4 text-truncate" id="Pname"></p>
                                <h6 class="card-subtitle my-2 text-body-secondary" id="Pbrand"></h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Availability: <span id="AvailStat" class="badge rounded-0">In Stock</span></h6>
                                <div class="row row-cols-2 g-2 mb-2 visually-hidden">
                                    <div class="col-4 py-1">
                                        <h5 class="card-text">Color</h5>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select form-select-sm bg-transparent" aria-label="Default select example">
                                            <option selected>Choose...</option>
                                            <option value="1">Black</option>
                                            <option value="2">White</option>
                                            <option value="3">Red</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 mb-2">
                                    <div class="col-4 py-1">
                                        <h5 class="card-text">Size</h5>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select form-select-sm" id="Selectsize">
                                            <option id="SD" selected hidden>Choose Size</option>
                                            <option id="SS" hidden value="S" data-Qty="0">Small</option>
                                            <option id="SM" hidden value="M" data-Qty="0">Medium</option>
                                            <option id="SL" hidden value="L" data-Qty="0">Large</option>
                                            <option id="SXL" hidden value="XL" data-Qty="0">Extra Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 mb-3">
                                    <div class="col-4 py-1">
                                        <h5 class="card-text">Price</h5>
                                    </div>
                                    <div class="col-8 py-1">
                                        <h4 class="card-text fw-bold">₱ <span id="Pprice">0.00</span><small class="visually-hidden" id="PriceItem"></small></h4>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2">
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <button id="Qminus" class="btn btn-sm btn-primary bg-transparent text-body-emphasis" type="button">
                                                <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                    <use xlink:href="#Minus" />
                                                </svg>
                                            </button>
                                            <input id="Qinput" type="text" class="form-control form-control-sm text-center bg-transparent border-primary" value="1" min="1" max="" readonly>
                                            <button id="Qplus" class="btn btn-sm btn-outline-primary" type="button">
                                                <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                    <use xlink:href="#Plus" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-7">
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