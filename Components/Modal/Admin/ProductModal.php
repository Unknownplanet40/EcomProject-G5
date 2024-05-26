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
                                <img id="Pic-1" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-cover" style="width: 150px; height: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-1" accept="image/png, image/gif, image/jpeg">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-2" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-cover" style="width: 150px; height: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-2" accept="image/png, image/gif, image/jpeg">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-3" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-cover" style="width: 150px; height: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-3" accept="image/png, image/gif, image/jpeg">
                            </div>
                            <div class="col HImage-col">
                                <img id="Pic-4" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-cover" style="width: 150px; height: 150px;" alt="...">
                                <input type="file" class="form-control form-control-sm d-none" id="Image-4" accept="image/png, image/gif, image/jpeg">
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <small class="card-text mb-1">Click to change image</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3 has-validation">
                            <span class="input-group-text" id="P-ID">UID</span>
                            <input type="text" class="form-control" id="UID" readonly style="cursor: not-allowed;" disabled>
                        </div>
                        <div class="input-group input-group-sm mb-3 has-validation">
                            <span class="input-group-text" id="P-Name">Product Name</span>
                            <input type="text" class="form-control" id="Prod_Name" data-old="" aria-describedby="UpdateBtn NM_FB">
                            <div id="NM_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="input-group input-group-sm mb-3 has-validation">
                            <span class="input-group-text" id="P-Brand">Brand</span>
                            <input type="text" class="form-control" id="Brand" list="BrandList" data-old="" aria-describedby="UpdateBtn BM_FB">
                            <div id="BM_FB" class="invalid-feedback"></div>
                        </div>
                        <datalist id="BrandList">
                            <option value="DBTK">DBTK</option>
                            <option value="UNDRAFTED">UNDRAFTED</option>
                            <option value="COZIEST">COZIEST</option>
                            <option value="MFCKN KIDS">MFCKN KIDS</option>
                            <option value="RICHBOYZ">RICHBOYZ</option>
                        </datalist>
                        <div class="input-group input-group-sm mb-3 has-validation">
                            <span class="input-group-text" id="P-Color">Color</span>
                            <input type="text" class="form-control" id="Color" data-old="" aria-describedby="UpdateBtn CM_FB">
                            <div id="CM_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="input-group input-group-sm mb-1 has-validation">
                            <span class="input-group-text" id="P-Price">Price</span>
                            <input type="text" class="form-control" id="Price" min="0" data-old="" aria-describedby="UpdateBtn Price-FB">
                            <div id="PM_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="text-center text-muted mb-3">
                            <small>Product Sizes</small>
                        </div>
                        <div class="row row-cols-4 g-2">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">S</span>
                                    <input type="text" class="form-control" id="S" value="" data-old="" aria-describedby="UpdateBtn Size_FB">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">M</span>
                                    <input type="text" class="form-control" id="M" value="" data-old="" aria-describedby="UpdateBtn Size_FB">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">L</span>
                                    <input type="text" class="form-control" id="L" value="" data-old="" aria-describedby="UpdateBtn Size_FB">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">XL</span>
                                    <input type="text" class="form-control" id="XL" value="" data-old="">
                                    <div id="Size_FB" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-muted mb-3">
                            <span class="text-success d-none" id="uplabel"></span>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-success w-50" id="UpdateBtn">Save Changes</button>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <small class="text-muted">The images will be automatically saved when you change them.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddProdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class=" modal-content bg-body-tertiary bg-opacity-25 bg-blur-5">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col-lg-6 ">
                        <div class="row row-cols-2 g-3 p-2 HImage" style="cursor: pointer;">
                            <div class="col HImage-col text-center">
                                <img id="Img-1" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="..." onclick="$('#Img_file1').click();">
                                <input type="file" class="form-control form-control-sm d-none" id="Img_file1" accept="image/png, image/gif, image/jpeg">
                                <small class="text-muted">Image 1</small>
                            </div>
                            <div class="col HImage-col text-center">
                                <img id="Img-2" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="..." onclick="$('#Img_file2').click();">
                                <input type="file" class="form-control form-control-sm d-none" id="Img_file2" accept="image/png, image/gif, image/jpeg">
                                <small class="text-muted">Image 2</small>
                            </div>
                            <div class="col HImage-col text-center">
                                <img id="Img-3" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="..." onclick="$('#Img_file3').click();">
                                <input type="file" class="form-control form-control-sm d-none" id="Img_file3" accept="image/png, image/gif, image/jpeg">
                                <small class="text-muted">Image 3</small>
                            </div>
                            <div class="col HImage-col text-center">
                                <img id="Img-4" src="../../../Assets/Images/Alternative.gif" class="rounded-1 mx-auto d-block object-fit-contain" style="width: 150px;" alt="..." onclick="$('#Img_file4').click();">
                                <input type="file" class="form-control form-control-sm d-none" id="Img_file4" accept="image/png, image/gif, image/jpeg">
                                <small class="text-muted">Image 4</small>
                            </div>
                        </div>
                        <div class="col-12 text-center text-center">
                            <small class="card-text mb-1" id="error-mess">Click to add image</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group input-group-sm mb-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-title="Automatically generated UID" data-bs-delay="500">
                            <span class="input-group-text">UID</span>
                            <input type="text" class="form-control" id="Prod_ID" readonly value="" style="cursor: not-allowed;" disabled>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text">Product Name</span>
                            <input type="text" class="form-control" id="Item_Name" value="">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text">Brand</span>
                            <input type="text" class="form-control" id="Prod_Brand" value="" list="BrandList">
                        </div>
                        <datalist id="BrandList">
                            <option value="DBTK">DBTK</option>
                            <option value="UNDRAFTED">UNDRAFTED</option>
                            <option value="COZIEST">COZIEST</option>
                            <option value="MFCKN KIDS">MFCKN KIDS</option>
                            <option value="RICHBOYZ">RICHBOYZ</option>
                        </datalist>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text">Color</span>
                            <input type="text" class="form-control" id="Prod_Color" value="">
                        </div>
                        <div class="input-group input-group-sm mb-3 has-validation">
                            <span class="input-group-text">Price</span>
                            <input type="text" class="form-control" id="Prod_Price" value="" min="0" aria-describedby="AddBtn Price-FB">
                            <div id="Price-FB" class="invalid-feedback"></div>
                        </div>
                        <div class="text-center text-muted mb-1">
                            <small>Product Sizes</small>
                        </div>
                        <div class="row row-cols-4 g-2">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">S</span>
                                    <input type="text" class="form-control" id="Size_S" value="" min="0" aria-describedby="Size_S_FB">
                                    <div id="Size_S_FB" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">M</span>
                                    <input type="text" class="form-control" id="Size_M" value="" min="0" aria-describedby="Size_M_FB">
                                    <div id="Size_M_FB" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">L</span>
                                    <input type="text" class="form-control" id="Size_L" value="" min="0" aria-describedby="Size_L_FB">
                                    <div id="Size_L_FB" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">XL</span>
                                    <input type="text" class="form-control" id="Size_XL" value="" min="0" aria-describedby="Size_XL_FB">
                                    <div id="Size_XL_FB" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-success w-50" id="AddBtn">Add Product</button>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <small class="text-danger" id="error-mes">&nbsp;</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>