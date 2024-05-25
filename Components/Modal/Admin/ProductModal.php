<div class="modal fade" id="ProdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class=" modal-content bg-body-tertiary bg-opacity-25 bg-blur-5">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col-lg-6 ">
                        <div class="row row-cols-2 g-3 p-2 HImage" style="cursor: pointer;">
                            <div class="col HImage-col">
                                <img id="Pic-1" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-1" accept="image/*">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-2" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-2" accept="image/*">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-3" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-3" accept="image/*">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-4" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-4" accept="image/*">
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small class="card-text mb-1">Click to change image</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="P-ID">UID</span>
                            <input type="text" class="form-control" id="UID" readonly value="" style="cursor: not-allowed;" disabled>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="P-Name">Product Name</span>
                            <input type="text" class="form-control" id="Prod_Name" value="">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="P-Brand">Brand</span>
                            <input type="text" class="form-control" id="Brand" value="" list="BrandList">
                        </div>
                        <datalist id="BrandList">
                            <option value="DBTK">DBTK</option>
                            <option value="UNDRAFTED">UNDRAFTED</option>
                            <option value="COZIEST">COZIEST</option>
                            <option value="MFCKN KIDS">MFCKN KIDS</option>
                            <option value="RICHBOYZ">RICHBOYZ</option>
                        </datalist>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="P-Color">Color</span>
                            <input type="text" class="form-control" id="Color" value="">
                        </div>
                        <div class="input-group input-group-sm mb-1">
                            <span class="input-group-text" id="P-Price">Price</span>
                            <input type="text" class="form-control" id="Price" value="">
                        </div>
                        <div class="text-center text-muted mb-3">
                            <small>Product Sizes</small>
                        </div>
                        <div class="row row-cols-4 g-2">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">S</span>
                                    <input type="text" class="form-control" id="S" value="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">M</span>
                                    <input type="text" class="form-control" id="M" value="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">L</span>
                                    <input type="text" class="form-control" id="L" value="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">XL</span>
                                    <input type="text" class="form-control" id="XL" value="">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-success w-50" id="SaveBtn">Save Changes</button>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <small class="text-muted">Note: The image is automatically saved once you choose a file.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>