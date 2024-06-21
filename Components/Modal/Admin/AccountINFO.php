<div class="modal fade" id="UserInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">User Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs d-flex justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                            data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="address-tab" data-bs-toggle="tab"
                            data-bs-target="#address-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                            aria-selected="false">Address</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel"
                        aria-labelledby="home-tab" tabindex="0">
                        <input type="hidden" id="User_ID" value="0">
                        <div class="my-3 row">
                            <label for="UserName" class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="First_Name" value="First Name"
                                    data-fname="">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="Last_Name" value="Last Name" data-lname="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="Email_Address" value="Email Address"
                                    data-email="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" placeholder="Account Password" disabled
                                        id="Password">
                                    <span class="input-group-text visually-hidden" style="cursor: pointer;">
                                        <svg class="bi pe-none text-muted" width="16" height="16">
                                            <use xlink:href="#Visible" />
                                        </svg>
                                    </span>
                                </div>
                                <small class="text-muted">Do you want to change the password?<span class="text-primary"
                                        style="cursor: pointer;" id="resetPass"> Click here</span></small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-2">
                                <label for="Gemder" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="Gender" list="GenderList"
                                    placeholder="Choose Male or Femail" data-gender="" pattern="Male|Female">
                                <datalist id="GenderList">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </datalist>
                            </div>
                            <div class="col-sm-2">
                                <label for="Role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="Role" list="RoleList" data-role=""
                                    placeholder="Choose Account Role" pattern="admin|seller|user">
                                <datalist id="RoleList">
                                    <option value="admin">Administator</option>
                                    <option value="seller">Brand Seller</option>
                                    <option value="user">Customer</option>
                                </datalist>
                            </div>
                            <div class="col-sm-4">
                                <label for="Contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="Contact" placeholder="09XX-XXX-XXXX"
                                    maxlength="11" data-contact="">
                            </div>
                            <div class="col-sm-4">
                                <label for="Status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="Status" list="StatusList"
                                    placeholder="Choose Account Status" data-status=""
                                    pattern="Active|Inactive|Suspended">
                                <datalist id="StatusList">
                                    <option value="Active">Active Account</option>
                                    <option value="Inactive">Inactive Account</option>
                                    <option value="Suspended">Suspend Account</option>
                                </datalist>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="address-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="Province" class="form-label">Province</label>
                                <input type="text" class="form-control" id="Province" placeholder="Province"
                                    data-province="">
                            </div>
                            <div class="col-md-6">
                                <label for="Municipality" class="form-label">Municipality <small
                                        class="text-muted">(City/Town/Municipality)</small></label>
                                <input type="text" class="form-control" id="Municipality" placeholder="Municipality"
                                    data-municipality="">
                            </div>
                            <div class="col-12">
                                <label for="HouseNo" class="form-label">House No. <small class="text-muted">(House No.,
                                        Bldg. Name, Street Name, Village/Subdivision)</small></label>
                                <input type="text" class="form-control" id="HouseNo" placeholder="1234 Main St"
                                    data-house="">
                            </div>
                            <div class="col-md-2">
                                <label for="Zipcode" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="Zipcode" placeholder="Zip Code"
                                    maxlength="4" data-zip="">
                            </div>
                            <div class="col-md-5">
                                <label for="Barangay" class="form-label">Barangay</label>
                                <input type="text" class="form-control" id="Barangay" placeholder="Barangay"
                                    data-barangay="">
                            </div>
                            <div class="col-md-5">
                                <label for="Landmark" class="form-label">Landmark - (Optional)</label>
                                <input type="text" class="form-control" id="Landmark" placeholder="ex. Near the School"
                                    data-landmark="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-primary" id="SaveUser" data-stat1="false">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Password Reset -->
<div class="modal fade" id="PasswordReset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Password Reset</h1>
                <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#UserInfo"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="Password" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Account Password" id="NewPassword">
                            <span class="input-group-text" style="cursor: pointer;" id="ShowPassword">
                                <svg class="bi pe-none text-muted" width="16" height="16" id="SP-label">
                                    <use xlink:href="#Visible" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="ConfirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Confirm Password"
                                id="ConfirmPassword">
                            <span class="input-group-text" style="cursor: pointer;" id="ShowConfirm">
                                <svg class="bi pe-none text-muted" width="16" height="16" id="SC-label">
                                    <use xlink:href="#Visible" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-primary" id="SavePassword">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddAdminModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">New Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="New_FirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="New_FirstName" placeholder="ex. Juan">
                    </div>
                    <div class="col-md-6">
                        <label for="New_LastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="New_LastName" placeholder="ex. Dela Cruz">
                    </div>
                    <div class="col-md-6">
                        <label for="New_Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="New_Email"
                            placeholder="ex. juandelacrus@example.com" aria-describedby="NE_FB AddnewUser" required>
                        <div class="invalid-feedback" id="NE_FB"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="New_Password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="New_Password" placeholder="Account Password">
                            <span class="input-group-text" id="RandomPassword" style="cursor: pointer;"
                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover focus"
                                data-bs-title="Generate Random Password">
                                <svg class="bi pe-none text-muted" width="16" height="16">
                                    <use xlink:href="#Randomize" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="New_Contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="New_Contact" placeholder="09XX-XXX-XXXX"
                            maxlength="11" maxlength="11">
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-4">
                        <label for="New_Role" class="form-label">Role</label>
                        <Select class="form-select" id="New_Role">
                            <option selected hidden>Choose Account Role</option>
                            <option value="admin" <?php echo ($UserRole == 'admin') ? 'selected' : ''; ?>>Administator
                            </option>
                            <option value="seller" <?php echo ($UserRole == 'seller') ? 'selected' : ''; ?>>Brand Seller
                            </option>
                            <option value="user" <?php echo ($UserRole == 'user') ? 'selected' : ''; ?>>Customer</option>
                        </Select>
                    </div>
                    <div class="col-md-4">
                        <label for="New_Status" class="form-label">Status</label>
                        <Select class="form-select" id="New_Status">
                            <option selected hidden>Choose Account Status</option>
                            <option value="Active">Active Account</option>
                            <option value="Inactive" disabled>Inactive Account</option>
                            <option value="Suspended" disabled>Suspend Account</option>
                        </Select>
                    </div>
                    <div class="col-md-4">
                        <label for="New_Gender" class="form-label">Gender</label>
                        <Select class="form-select" id="New_Gender">
                            <option selected hidden>Choose Account Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Femail</option>
                        </Select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-primary" id="AddnewUser">Add Account</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ArchiveUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-5">Archive Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>