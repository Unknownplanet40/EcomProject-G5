<div class="modal fade" id="Addressfillup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Address Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="Province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="Province" placeholder="Ex: Cavite">
                    </div>
                    <div class="col-md-6">
                        <label for="Municipality" class="form-label">Municipality - <small class="text-muted">City/Town/Municipality</small></label>
                        <input type="text" class="form-control" id="Municipality" placeholder="Ex: Bacoor">
                    </div>
                    <div class="col-md-6">
                        <label for="Barangay" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="Barangay" placeholder="Ex: Molino 3">
                    </div>
                    <div class="col-md-6">
                        <label for="HouseNo" class="form-label">House No. - <small class="text-muted">Building/Street/Block</small></label>
                        <input type="text" class="form-control" id="HouseNo" placeholder="Ex: Blk 3 Lot 5">
                    </div>
                    <div class="col-md-2">
                        <label for="ZipCode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="ZipCode" placeholder="Ex: 4102">
                    </div>
                    <div class="col-md-4">
                        <label for="Contact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="Contact" placeholder="Ex: 09123456789">
                    </div>
                    <div class="col-md-6">
                        <label for="Landmark" class="form-label">Landmark - <small class="text-muted">Optional</small></label>
                        <input type="text" class="form-control" id="Landmark" placeholder="Ex: Near 7/11">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-primary" id="SaveAddress">Continue</button>
            </div>
        </div>
    </div>
</div>

<!-- For Online Wallet -->
<div class="modal fade" id="OnlineWallet" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Online Wallet Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="OLM_Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="form-check-inline d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="WalletType" id="GCash" value="Gcash">
                            <label class="form-check-label" for="GCash"><img src="../../Assets/Images/Payments/GCash.png" alt="GCash" class="img-fluid ms-3" style="width: 32px;"> - GCash</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check-inline d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="WalletType" id="Maya" value="Maya">
                            <label class="form-check-label" for="Maya"><img src="../../Assets/Images/Payments/Maya.png" alt="Maya" class="img-fluid" style="width: 48px;"> - Maya</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="Email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="OL_Email" placeholder="Ex: Juandelacruz@gmail.com">
                    </div>
                    <div class="col-md-6">
                        <label for="AccountNo" class="form-label">Account Number <small class="text-muted">- Phone Number</small></label>
                        <input type="text" class="form-control" id="OL_Account" placeholder="Ex: 09123456789">
                        <div class="form-text">Want to use your registered phone number and email address? <a href="#" class="text-decoration-none">Click here</a></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#CreditCard">Use Credit Card</button>
                <button type="button" class="btn btn-sm btn-primary" id="SaveWallet">Procced</button>
            </div>
        </div>
    </div>
</div>

<!-- Credit Card -->
<div class="modal fade" id="Credit-Card" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Credit Card Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="CardHolder" class="form-label">Card Holder</label>
                        <input type="text" class="form-control" id="CardHolder" placeholder="Ex: Juan Dela Cruz">
                    </div>
                    <div class="col-md-6">
                        <label for="CardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="CardNumber" placeholder="Ex: 1234 5678 9012 3456">
                    </div>
                    <div class="col-md-6">
                        <label for="ExpirationDate" class="form-label">Expiration Date</label>
                        <input type="month" class="form-control" id="ExpirationDate" min="<?php echo date('Y-m'); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="CVV" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="CVV" placeholder="Ex: 123">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#OnlineWallet">Use Online Wallet</button>
                <button type="button" class="btn btn-sm btn-primary" id="SaveCard">Procced</button>
            </div>
        </div>
    </div>
</div>