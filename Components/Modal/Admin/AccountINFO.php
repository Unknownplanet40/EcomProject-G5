<div class="modal fade" id="UserInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">User Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Address</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <input type="hidden" id="User_ID" value="0">
                        <div class="my-3 row">
                            <label for="UserName" class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="First_Name" value="First Name">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="Last_Name" value="Last Name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="Email_Address" value="Email Address">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-4">
                                <label for="Gemder" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="Gender" value="Male" list="GenderList">
                                <datalist id="GenderList">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </datalist>
                            </div>
                            <div class="col-sm-4">
                                <label for="Role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="Role" value="Admin" list="RoleList">
                                <datalist id="RoleList">
                                    <option value="Admin">Admin</option>
                                    <option value="Seller">Seller</option>
                                    <option value="User">User</option>
                                </datalist>
                            </div>
                            <div class="col-sm-4">
                                <label for="Contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="Contact" placeholder="09XX-XXX-XXXX">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="address-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="Province" class="form-label">Province</label>
                                <input type="text" class="form-control" id="Province" value="Province">
                            </div>
                            <div class="col-md-6">
                                <label for="Municipality" class="form-label">Municipality <small class="text-muted">(City/Town/Municipality)</small></label>
                                <input type="text" class="form-control" id="Municipality" value="Municipality">
                            </div>
                            <div class="col-12">
                                <label for="HouseNo" class="form-label">House No. <small class="text-muted">(House No., Bldg. Name, Street Name, Village/Subdivision)</small></label>
                                <input type="text" class="form-control" id="HouseNo" placeholder="1234 Main St">
                            </div>
                            <div class="col-md-2">
                                <label for="Zipcode" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="Zipcode">
                            </div>
                            <div class="col-md-10">
                                <label for="Landmark" class="form-label">Landmark</label>
                                <input type="text" class="form-control" id="Landmark">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>