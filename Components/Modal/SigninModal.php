<div class="modal fade" id="SignIN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-3">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Welcome back!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control rounded-3" id="MailAddress" placeholder="name@example.com">
                    <label for="MailAddress">Email address</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control rounded-3" id="Pword" placeholder="Password">
                    <label for="Pword">Password</label>
                </div>
                <div class="hstack gap-3 mb-3 mt-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="SPword">
                        <label class="form-check-label" for="SPword">
                            Show Password
                        </label>
                    </div>
                    <a href="#" class="link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover ms-auto">Forgot Password?</a>
                </div>
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" id="btn-Sub">Sign in</button>
                <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
                <hr class="my-4">
                <h3 class="fs-5 fw-bold mb-3">Don't have an account?</h3>
                <button class="w-100 py-2 btn btn-outline-secondary rounded-3" type="submit" onclick="window.location.href = '../../Components/Register/Signup.php'">
                    <svg class="bi" width="20" height="20">
                        <use xlink:href="#Register" />
                    </svg>
                    Create an account
                </button>
            </div>
        </div>
    </div>
</div>