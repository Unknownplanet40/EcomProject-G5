<div class="modal fade" id="Product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-body-tertiary bg-opacity-25 bg-blur-5">
            <div class=" modal-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col">
                        <!-- Product Image -->
                        <img id="Pic-main" src="../../Assets/Images/testing/temp1.jpg" class="rounded mx-auto d-block object-fit-contain w-100" alt="Product Image">
                        <!-- Product Other Images -->
                        <div class="row row-cols-4 g-1 p-2">
                            <div class="col">
                                <img id="Pic-1" src="../../Assets/Images/testing/temp1.jpg" class="rounded-1 mx-auto d-block object-fit-contain w-100" alt="...">
                            </div>
                            <div class="col">
                                <img id="Pic-2" src="../../Assets/Images/testing/temp2.jpg" class="rounded-1 mx-auto d-block object-fit-contain w-100" alt="...">
                            </div>
                            <div class="col">
                                <img id="Pic-3" src="../../Assets/Images/testing/temp3.jpg" class="rounded-1 mx-auto d-block object-fit-contain w-100" alt="...">
                            </div>
                            <div class="col">
                                <img id="Pic-4" src="../../Assets/Images/testing/temp4.jpg" class="rounded-1 mx-auto d-block object-fit-contain w-100" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div id="card-bg" class="card h-100 border-0 bg-body-tertiary bg-opacity-50 bg-blur-3">
                            <div class="card-body">
                                <input type="hidden" id="ProductID" value="1">
                                <h3 class="card-title text-body-emphasis">Product Name</h3>
                                <h6 class="card-subtitle my-2 text-body-secondary">Brand Name</h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Availability: <span class="badge bg-success rounded-0">In Stock</span></h6>
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
                                        <select class="form-select form-select-sm
                                        " aria-label="Default select example">
                                            <option selected hidden>Choose...</option>
                                            <option value="1">Small</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Large</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 mb-3">
                                    <div class="col-4 py-1">
                                        <h5 class="card-text">Price</h5>
                                    </div>
                                    <div class="col-8 py-1">
                                        <h4 class="card-text fw-bold">₱ 100.00 <small class="text-muted text-decoration-line-through">₱ 200.00</small></h4>
                                    </div>
                                </div>
                                <div class="row row-cols-2 g-2 disabled">
                                    <div class="col-5">
                                        <div class="input-group mb-3">
                                            <button id="Qminus" class="btn btn-sm btn-outline-primary" type="button">
                                                <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                    <use xlink:href="#Minus" />
                                                </svg>
                                            </button>
                                            <input id="Qinput" type="text" class="form-control form-control-sm text-center border-1 border-primary bg-transparent" value="1" aria-label="Quantity" aria-describedby="button-addon1" readonly>
                                            <button id="Qplus" class="btn btn-sm btn-outline-primary" type="button">
                                                <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                    <use xlink:href="#Plus" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <a id="AddCart" class="btn btn-sm btn-primary w-100 rounded-0">
                                            <svg class="bi" fill="currentColor" width="1.5em" height="1.5em">
                                                <use xlink:href="#Cart" />
                                            </svg>
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                                <small class="text-muted">Please note: A maximum of 5 items per transaction is allowed. Thank you for your cooperation.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>