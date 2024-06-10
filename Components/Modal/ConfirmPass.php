<div class="modal" id="ConfirmPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">Please confirm your password to continue</p>
                <input type="text" class="form-control" id="ConfirmPass" placeholder="Enter your password" required aria-describedby="checkPass valfFB">
                <div id="valFB" class="invalid-feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="checkPass">Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ChangePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="oldPass" class="form-label">Old Password</label>
                    <input type="password" class="form-control form-control-sm" id="oldPass" placeholder="Enter your old password" required aria-describedby="change oldPassFB">
                    <div class="invalid-feedback" id="oldPassFB"></div>
                </div>
                <div class="mb-3">
                    <label for="newPass" class="form-label">New Password</label>
                    <input type="password" class="form-control form-control-sm" id="newPass" placeholder="Enter your new password" required aria-describedby="change newPassFB">
                    <div class="invalid-feedback" id="newPassFB"></div>
                </div>
                <div class="mb-3">
                    <label for="confirmPass" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control form-control-sm" id="confirmPass" placeholder="Confirm your new password" required aria-describedby="change confirmPassFB">
                    <div class="invalid-feedback" id="confirmPassFB"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="change">Confirm</button>
            </div>
        </div>
    </div>
</div>