<?php
session_start();
include_once('../../Databases/DB_Configurations.php');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';
$Email = 'Undefined';
$Theme = 'light';
$haveAddress = 0;

if (isset($_SESSION['User_Data'])) {
    if ($_SESSION['User_Data']['Is_user_logged_in'] == 1) {
        $login = true;
        $Username = $_SESSION['User_Data']['First_Name'] . ' ' . $_SESSION['User_Data']['Last_Name'];
        $Last_Login = date('F j, Y', strtotime($_SESSION['User_Data']['Last_Login']));
        $UserRole = $_SESSION['User_Data']['Role'];
        $haveAddress = $_SESSION['User_Data']['HaveAddress'];
        $Theme = $_SESSION['User_Data']['User_Settings']['Theme'];
        $Email = $_SESSION['User_Data']['Email'];
        echo '<script>var Is_User_Logged_In = true;</script>';
        echo '<script>var User_ID = "' . $_SESSION['User_Data']['user_ID'] . '";</script>';
        echo '<script>var Theme = "' . $Theme . '";</script>';
    }
} else {
    echo '<script>var Is_User_Logged_In = false;</script>';
    echo '<script>var User_ID = 0;</script>';
    echo '<script>var Theme = "light";</script>';
}

if (!$login) {
    header('Location: ../../Components/Home/Homepage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo $Theme; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Utilities/Third-party/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../Utilities/Stylesheets/ProfileStyle.css">
    <script defer src="../../Utilities/Third-party/bootstrap/js/bootstrap.bundle.js"></script>
    <script defer src="../../Utilities/Third-party/sweetalert2/js/sweetalert2.all.min.js"></script>
    <script defer src="../../Utilities/Scripts/General_Setting.js"></script>
    <title>Profile Setting</title>
    <?php include "../../Assets/Icons/Icon_Assets.php"; ?>
</head>

<body>
    <div id="loader" class="d-block">
        <div class="Cmodal-backdrop Cfade Cshow"></div>
        <span class="custom-loader"></span>
    </div>
    <?php include "../../Components/Modal/ConfirmPass.php"; ?>
    <div class="container rounded mt-5 mb-5 bg-body-tertiary shadow-sm bg-opacity-25 bg-blur-10">
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="mt-5 rounded-3" style="object-fit: cover; object-position: center;" width="150" height="150" id="profile-pic" src="../../Assets/Images/Profile.gif">
                    <span class="fw-bold mt-3 mb-2" id="name_side"><?php echo $Username; ?></span>
                    <span class="fs-6" id="email_side"><?php echo $Email; ?></span>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-secondary btn-sm" type="button" id="Back">Back</button>
                    <button class="btn btn-primary btn-sm" id="changeimage" type="button"><span id="changeimage-label">ChangeImage</span></button>
                    <input type="file" class="d-none" id="ProfileImage" accept="image/png, image/jpeg image/jpg image/gif">
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-3 py-5">
                    <div class="row g-3 bg-body-secondary p-3 rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Details</h4>
                        </div>
                        <div class="col-md-6">
                            <label for="FirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="FirstName" placeholder="e.g. Juan" aria-describedby="FN_FB updetails" <?php echo ($UserRole == 'seller') ? 'disabled' : ''; ?>>
                            <div id="FN_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="LastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="LastName" placeholder="e.g. Dela Cruz" aria-describedby="LN_FB updetails">
                            <div id="LN_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="Contact" class="form-label">Contact</label>
                            <input type="text" class="form-control form-control-sm" id="Contact" placeholder="e.g. 09XX-XXX-XXXX" maxlength="11" aria-describedby="C_FB updetails">
                            <div id="C_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="Gender" class="form-label">Gender</label>
                            <input type="text" class="form-control form-control-sm" id="Gender" placeholder="e.g. Male/Femail" list="GenderList" maxlength="6" aria-describedby="G_FB updetails">
                            <div id="G_FB" class="invalid-feedback"></div>
                            <datalist id="GenderList">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </datalist>
                        </div>
                        <div class="col-md-12">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" id="Email" placeholder="e.g. JuanDelaCrus@example.com" aria-describedby="E_FB updetails">
                            <div id="E_FB" class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-12">
                            <label for="Password" class="form-label">Password</label>
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control form-control-sm" placeholder="Your Password" readonly id="Password">
                                <span class="input-group-text" id="pass-toggle">
                                    <svg id="pass-v" width="16" height="16" role="img">
                                        <use xlink:href="#Visible" />
                                    </svg>
                                </span>
                            </div>
                            <small class="text-muted mt-0">want to change password? <a class="text-primary text-decoration-none link-RP" id="CP">Click here</a></small>
                        </div>
                        <div class=" mt-1 text-end">
                            <button id="updetails" class="btn btn-success btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-title="This does not include the Password for security purposes">
                                <svg id="pass-v" width="16" height="16" role="img">
                                    <use xlink:href="#Pencil" />
                                </svg>
                                <span id="updetails-label">Save Changes</span>
                            </button>
                        </div>
                    </div>
                    <div class="row g-3 bg-body-secondary p-3 mt-3 rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-right">Address</h4>
                        </div>
                        <div class="col-md-6">
                            <label for="Province" class="form-label">Province</label>
                            <input type="text" class="form-control form-control-sm" id="Province" placeholder="e.g. Cavite">
                        </div>
                        <div class="col-md-6">
                            <label for="Municipality" class="form-label">Municipality</label>
                            <input type="text" class="form-control form-control-sm" id="Municipality" placeholder="e.g. Bacoor">
                        </div>
                        <div class="col-md-8">
                            <label for="Barangay" class="form-label">Barangay</label>
                            <input type="text" class="form-control form-control-sm" id="Barangay" placeholder="e.g. Molino 3">
                        </div>
                        <div class="col-md-4">
                            <label for="ZipCode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control form-control-sm" id="ZipCode" placeholder="e.g. 1234">
                        </div>
                        <div class="col-md-12">
                            <label for="HouseNo" class="form-label">House No. <small class="text-muted">Building,
                                    Street, etc.</small></label>
                            <input type="text" class="form-control form-control-sm" id="HouseNo" placeholder="e.g. 1234 Main St.">
                        </div>
                        <div class="col-md-12">
                            <label for="Landmark" class="form-label">Landmark <small class="text-muted">(Optional)</small></label>
                            <input type="text" class="form-control form-control-sm" id="Landmark" placeholder="e.g. Near the park">
                        </div>
                        <div class="text-end mt-3">
                            <button class="btn btn-success btn-sm" type="button" id="UpdateAddress">
                                <svg id="upaddress-icon" width="16" height="16" role="img">
                                    <use xlink:href="#Check" />
                                </svg>
                                <span id="upaddress-label"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Settings</h4>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="SwitchTheme" <?php echo ($Theme == 'dark') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="SwitchTheme">Switch Theme</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="text-muted mb-0">Current Theme: <small class="text-light" id="themeLabel">(Light
                                    Mode)</small></p>
                            <p class="text-light mb-0">Theme Preview for <span id="ThemePreviewLabel">Light Mode</span>
                            </p>
                            <img src="../../Assets/Theme/LightMode.png" class="img-thumbnail" alt="Theme Preview" id="ThemePreview" width="100%">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                            <h4 class="text-right">Payment Method</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-reverse">
                                <input class="form-check-input" type="radio" name="PaymentMethod" value="COD" id="COD">
                                <label class="form-check-label" for="COD">Cash on Delivery</label>
                            </div>
                            <div class="form-check form-check-reverse">
                                <input class="form-check-input" type="radio" name="PaymentMethod" value="GCash" id="GCash">
                                <label class="form-check-label" for="GCash">GCash</label>
                            </div>
                            <div class="form-check form-check-reverse">
                                <input class="form-check-input" type="radio" name="PaymentMethod" value="Maya" id="Maya">
                                <label class="form-check-label" for="Maya">Maya</label>
                            </div>
                            <div class="form-check form-check-reverse">
                                <input class="form-check-input" type="radio" name="PaymentMethod" value="CreditCard" id="CreditCard">
                                <label class="form-check-label" for="CreditCard">Credit Card</label>
                            </div>

                            <div class="card mt-3 d-none" id="Ewallet">
                                <div class="card-body">
                                    <h5 class="card-title" id="E_wallet_Name">GCash</h5>
                                    <div class="mb-3">
                                        <label for="EwalletMail" class="form-label">Email Address</label>
                                        <input type="email" class="form-control form-control-sm" id="EwalletMail" placeholder="e.g. juandelacruz@gmail.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="EwalletNumber" class="form-label">Account Number</label>
                                        <input type="text" class="form-control form-control-sm" id="EwalletNumber" placeholder="e.g. 09XX-XXX-XXXX" maxlength="11">
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-sm" type="button" id="UpdateEwallet">
                                            <span id="Ewallet-label">Save Changes</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3 d-none" id="CreditCardForm">
                                <div class="card-body">
                                    <h5 class="card-title">Credit Card Information</h5>
                                    <div class="mb-3">
                                        <label for="CCName" class="form-label">Card Holder's Name</label>
                                        <input type="text" class="form-control form-control-sm" id="CCName" placeholder="e.g. Juan Dela Cruz">
                                    </div>
                                    <div class="mb-3">
                                        <label for="CCNumber" class="form-label">Card Number</label>
                                        <input type="text" class="form-control form-control-sm" id="CCNumber" placeholder="e.g. 1234 5678 9012 3456" maxlength="16">
                                    </div>
                                    <div class="mb-3">
                                        <label for="CCExpiry" class="form-label">Expiry Date</label>
                                        <!-- only month and years -->
                                        <input type="text" class="form-control form-control-sm" id="CCExpiry" placeholder="e.g. 12/24" maxlength="5" pattern="(0[1-9]|1[0-2])\/\d{2}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="CCCVV" class="form-label">CVV</label>
                                        <input type="text" class="form-control form-control-sm" id="CCCVV" placeholder="e.g. 1234" maxlength="4">
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-sm" type="button" id="UpdateCreditCard">
                                            <span id="CreditCard-label">Save Changes</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6 class="text-muted text-center">More Settings Coming Soon</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>