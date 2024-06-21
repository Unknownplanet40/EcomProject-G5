<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Third-party Stylesheet/Scripts -->
    <?php include_once '../../Utilities/Third-party/Import-ThirdParty.php';?>
    <!-- Main Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Stylesheets/SignupStyle.css">
    <script defer src="../../Utilities/Scripts/SignupScript.js"></script>
    <title>Create Account</title>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center Bg-Image" style="height: 100vh;">
        <div class="card p-0 boder-0 shadow-lg" style="width: 100%;">
            <div class="row g-0">
                <div class="col-md-8 d-flex justify-content-center align-items-center p-1">
                    <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../../Assets/Images/StockVid1-Alt.png" class="object-fit-contain rounded d-block w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="../../Assets/Products_Assets/Carousel/StockImage 1.jpg" class="rounded d-block object-fit-contain w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="../../Assets/Products_Assets/Carousel/StockImage 2.jpg" class="rounded d-block object-fit-contain w-100">
                            </div>
                            <div class="carousel-item">
                                <img src="../../Assets/Products_Assets/Carousel/StockImage 3.jpg" class="rounded d-block object-fit-contain w-100">
                            </div>
                        </div>
                    </div>
                </div>
                <audio id="backgroundMusic" autoplay loop>
                    <source src="../../Assets/Audio/BG Music.wav" type="audio/wav">
                        Your browser does not support the audio element.
                    </audio>
                <div class="col-md-4" style="height: 512px;">
                    <div id="loader" class="h-100 d-flex justify-content-center align-items-center">
                        <img class="loader-image" src="../../Assets/Images/Logo_1.png" alt="">
                    </div>
                    <div class="card-body d-none" id="FN-container">
                        <div class="text-center">
                            <img class="logobrand mb-4 mt-1" src="../../Assets/Images/Logo_1.png" alt="">
                        </div>
                        <div class="position-relative m-4">
                            <div class="progress" role="progressbar" aria-label="Progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 3px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
                            </div>
                            <button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">1</button>
                            <button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">2</button>
                            <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">3</button>
                        </div>
                        <h5 class="card-title text-center mb-3">Personal Information</h5>
                        <div class="d-flex flex-column mb-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="Fname" placeholder="First Name" aria-describedby="FN-Next FN-FB">
                                <label for="Fname">First Name</label>
                                <div id="FN-FB" class="invalid-feedback"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="Lname" placeholder="Last Name">
                                <label for="Lname">Last Name</label>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-secondary w-100" type="button" onclick="window.location.href='../../Components/Home/Homepage.php'">Back</button>
                                <button class="btn btn-primary w-100" type="button" id="FN-Next">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-none" id="EA-container">
                        <div class="text-center">
                            <img class="logobrand mb-4 mt-1" src="../../Assets/Images/Logo_1.png" alt="">
                        </div>
                        <div class="position-relative m-4">
                            <div class="progress" role="progressbar" aria-label="Progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 3px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 50%"></div>
                            </div>
                            <button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">&check;</button>
                            <button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">2</button>
                            <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">3</button>
                        </div>
                        <div class="d-none" id="EA-Inner-container">
                            <h5 class="card-title text-center mb-3">Login Information</h5>
                            <div class="d-flex flex-column mb-3">
                                <div class="form-floating mb-3 has-validation">
                                    <input type="email" class="form-control" id="Email" placeholder="Email Address" aria-describedby="EA-Next EA-FB">
                                    <label for="Email">Email Address</label>
                                    <div id="EA-FB" class="invalid-feedback"></div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-secondary w-100" type="button" id="EA-Back">Back</button>
                                    <button class="btn btn-primary w-100" type="button" id="EA-Next">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="OTP-Inner-container">
                            <h5 class="card-title text-center mb-3">Account Verification</h5>
                            <div class="d-flex flex-column mb-3">
                                <div class="vstack gap-3 mb-3">
                                    <div class="d-flex justify-content-center gap-3">
                                        <input type="text" class="form-control w-25 text-center" id="OTP1" placeholder="&#10033;" tabindex="1" maxlength="1">
                                        <input type="text" class="form-control w-25 text-center" id="OTP2" placeholder="&#10033;" tabindex="2" maxlength="1">
                                        <input type="text" class="form-control w-25 text-center" id="OTP3" placeholder="&#10033;" tabindex="3" maxlength="1">
                                        <input type="text" class="form-control w-25 text-center" id="OTP4" placeholder="&#10033;" tabindex="4" maxlength="1">
                                        <input type="text" class="form-control w-25 text-center" id="OTP5" placeholder="&#10033;" tabindex="5" maxlength="1">
                                        <input type="text" class="form-control w-25 text-center" id="OTP6" placeholder="&#10033;" tabindex="6" maxlength="1">
                                        <script>
                                            document.querySelectorAll('input').forEach(item => {
                                                item.addEventListener('keyup', function(e) {
                                                    if (e.key === 'Backspace') {
                                                        if (item.previousElementSibling) {
                                                            item.previousElementSibling.focus();
                                                        }
                                                    } else {
                                                        if (item.nextElementSibling) {
                                                            item.nextElementSibling.focus();
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="vstack gap-1">
                                        <button class="btn btn-sm btn-outline-success w-100" type="button" id="regenOTP">Resend OTP</button>
                                        <small class="text-muted">OTP will expire at <span id="OTP-Timer">00:00</span></small>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-secondary w-100" type="button" id="OTP-Back">Back</button>
                                    <button class="btn btn-primary w-100" type="button" id="OTP-Next">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-none" id="PW-container">
                        <div class="text-center">
                            <img class="logobrand mb-4 mt-1" src="../../Assets/Images/Logo_1.png" alt="">
                        </div>
                        <div class="position-relative m-4">
                            <div class="progress" role="progressbar" aria-label="Progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 3px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                            </div>
                            <button type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">&check;</button>
                            <button type="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">&check;</button>
                            <button type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">3</button>
                        </div>
                        <h5 class="card-title text-center mb-3">Password Credentials</h5>
                        <div class="d-flex flex-column mb-3">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="Password" placeholder="Password">
                                <label for="Password">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password">
                                <label for="ConfirmPassword">Confirm Password</label>
                            </div>
                            <script>
                                // if password is focused or clicked, show password
                                document.getElementById('Password').addEventListener('focus', function() {
                                    this.type = 'text';
                                });

                                document.getElementById('Password').addEventListener('blur', function() {
                                    this.type = 'password';
                                });

                                document.getElementById('ConfirmPassword').addEventListener('focus', function() {
                                    this.type = 'text';
                                });

                                document.getElementById('ConfirmPassword').addEventListener('blur', function() {
                                    this.type = 'password';
                                });
                            </script>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-secondary w-100" type="button" id="PW-Back">Back</button>
                                <button class="btn btn-primary w-100" type="button" id="PW-Next">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<!-- <div class="container text-center">
    <div class="row row-cols-1 row-cols-md-2 g-4">

        <div class="col-4">

        </div>
    </div> -->