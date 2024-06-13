<div class="modal" id="ConfirmPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Please confirm your password to continue</p>
                <input type="text" class="form-control" id="ConfirmPass" placeholder="Enter your password" required
                    aria-describedby="checkPass valfFB">
                <div id="valFB" class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="checkPass">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="oldPass" class="form-label">Old Password</label>
                    <input type="password" class="form-control form-control-sm" id="oldPass"
                        placeholder="Enter your old password" required aria-describedby="change oldPassFB">
                    <div class="invalid-feedback" id="oldPassFB"></div>
                </div>
                <div class="mb-3">
                    <label for="newPass" class="form-label">New Password</label>
                    <input type="password" class="form-control form-control-sm" id="newPass"
                        placeholder="Enter your new password" required aria-describedby="change newPassFB">
                    <div class="invalid-feedback" id="newPassFB"></div>
                </div>
                <div class="mb-3">
                    <label for="confirmPass" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control form-control-sm" id="confirmPass"
                        placeholder="Confirm your new password" required aria-describedby="change confirmPassFB">
                    <div class="invalid-feedback" id="confirmPassFB"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="change">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="EmailVeridication" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title fs-5">Email Verification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Please check your email for the verification code</p>
                <div class="row">
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm text-center" placeholder="&#10033;"
                            id="code1" maxlength="1">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm text-center" placeholder="&#10033;"
                            id="code2" maxlength="1">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm text-center" placeholder="&#10033;"
                            id="code3" maxlength="1">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm text-center" placeholder="&#10033;"
                            id="code4" maxlength="1">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm text-center" placeholder="&#10033;"
                            id="code5" maxlength="1">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm text-center" placeholder="&#10033;"
                            id="code6" maxlength="1">
                    </div>
                    <script>
                        for (let i = 1; i <= 6; i++) {
                            let currentField = document.getElementById('code' + i);
                            if (currentField) {
                                currentField.addEventListener('input', function (e) {
                                    if (this.value.length >= 1) {
                                        if (i < 6) {
                                            document.getElementById('code' + (i + 1)).focus();
                                        } else {
                                            this.blur();
                                        }
                                    }
                                });
                            }
                        }
                    </script>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
                <div class="d-grid gap-2 col-12 mx-auto">
                    <button class="btn btn-primary btn-sm" type="button" id="verifycode">Verify Code</button>
                </div>
            </div>
        </div>
    </div>
</div>