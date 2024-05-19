<?php
session_start();
include_once('../../Databases/DB_Configurations.php');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';

if (isset($_SESSION['User_Data'])) {
    if ($_SESSION['User_Data']['Is_user_logged_in'] == 1) {
        $login = true;
        $Username = $_SESSION['User_Data']['First_Name'] . ' ' . $_SESSION['User_Data']['Last_Name'];
        // format last login date to this format "January 1, 2021"
        $Last_Login = date('F j, Y', strtotime($_SESSION['User_Data']['Last_Login']));
        $UserRole = $_SESSION['User_Data']['Role'];
        echo '<script>var Is_User_Logged_In = true;</script>';
        echo '<script>var User_ID = "' . $_SESSION['User_Data']['user_ID'] . '";</script>';
    }
} else {
    echo '<script>var Is_User_Logged_In = false;</script>';
    echo '<script>var User_ID = 0;</script>';
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Third-party Stylesheet/Scripts -->
    <?php include_once('../../Utilities/Third-party/Import-ThirdParty.php'); ?>
    <!-- Main Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Stylesheets/HomeStyle.css">
    <script defer src="../../Utilities/Scripts/HomeScript.js"></script>
    <script defer src="../../Utilities/Scripts/CheckoutScript.js"></script>
    <title>Checkout</title>
    <script>
        // This is to specify what function to run in each page
        // clear specific local storage
        localStorage.removeItem('FileName');
        // get file mame and set it as the title
        var FileName = document.location.pathname.split('/').slice(-1)[0];
        // save to local storage
        localStorage.setItem('FileName', FileName);

        // remove cartItems from local storage
        localStorage.removeItem('CartItems');
        // get json data
        let json = <?php if (file_exists('../../Temp/User_CartItems.json')) {
                        echo file_get_contents('../../Temp/User_CartItems.json');
                    } else {
                        echo '[]';
                    } ?>;
        // save to local storage
        localStorage.setItem('CartItems', JSON.stringify(json));
        // delete json file
        <?php //unlink('../../Temp/User_CartItems.json');
        ?>
    </script>
</head>

<?php include_once('../../Assets/Icons/Icon_Assets.php'); ?>

<body class="bg-body-tertiary" id="cBody" style="overflow: hidden;">
    <div id="devtool" class="visually-hidden">
        <div class="Cmodal-backdrop Cfade Cshow"></div>
        <span class="custom-devtool">
            <p class="text-center">We can't allow you to inspect the code</p>
        </span>
    </div>
    <div id="loader" class="d-block">
        <div class="Cmodal-backdrop Cfade Cshow"></div>
        <span class="custom-loader"></span>
    </div>
    <?php
    // Header
    include_once('../Header/Header.php');

    // Modal
    include_once('../Modal/SearchModal.php');
    include_once('../Modal/SizeGuide.php');
    include_once('../Modal/SigninModal.php');
    include_once('../Modal/ProductModal.php');
    include_once('../Modal/RetriveItems.php'); ?>



    <div class="container-lg mt-3">
        <main>
            <div class="row g-3 row-cols-md-1">
                <div class="col-md-8">
                    <h4 class="mb-3">My Cart
                        <button class="btn btn-sm btn-outline-danger ms-5 visually-hidden" type="button" id="ArchiveCart" data-bs-toggle="modal" data-bs-target="#RetriveItems">
                            Retrive Removed Items
                        </button>
                    </h4>
                    <div class="overflow-auto items-scroll" style="max-height: 465px;">
                        <ul class="list-group list-group-flush" id="CartList">

                        </ul>
                    </div>
                </div>
                <div class="col-md-4 order-md-last">
                    <input type="hidden" value="0" id="totalCartItem">
                    <div class="overflow-auto" style="max-height: 360px;">
                        <ul class="list-group mb-3" id="CheckoutList">
                            <li class="list-group-item d-flex justify-content-center" id="NoItem">
                                <p class="text-body-secondary text-center">
                                <div class="spinner-border spinner-border-sm text-secondary my-1 me-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div> No Selected Items</p>
                            </li>
                        </ul>
                    </div>
                    <div class="d-grid gap-2 m-3">
                        <div class="d-flex justify-content-between">
                            <span>Total Items</span>
                            <strong class="fs-5 fw-bold"><span id="CartCount">0</span></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total (PHP)</span>
                            <input type="hidden" value="0" id="totalPrice">
                            <strong class="fs-5 fw-bold">&#8369;<span id="total">0</span></strong>
                        </div>
                        <button class="btn btn-primary" type="button">CHECKOUT</button>
                    </div>
                </div>
            </div>
        </main>
</body>

</html>