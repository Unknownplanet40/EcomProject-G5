<?php
session_start();
include_once('../../Databases/DB_Configurations.php');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';
$Theme = 'light';
$Item = 'all';
$Title = 'All Products';

if (isset($_SESSION['User_Data'])) {
    if ($_SESSION['User_Data']['Is_user_logged_in'] == 1) {
        $login = true;
        $Username = $_SESSION['User_Data']['First_Name'] . ' ' . $_SESSION['User_Data']['Last_Name'];
        $Last_Login = date('F j, Y', strtotime($_SESSION['User_Data']['Last_Login']));
        $UserRole = $_SESSION['User_Data']['Role'];
        $Theme = $_SESSION['User_Data']['User_Settings']['Theme'];
        echo '<script>var Is_User_Logged_In = true;</script>';
        echo '<script>var User_ID = "' . $_SESSION['User_Data']['user_ID'] . '";</script>';
    }
} else {
    echo '<script>var Is_User_Logged_In = false;</script>';
    echo '<script>var User_ID = 0;</script>';
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo $Theme; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Third-party Stylesheet/Scripts -->
    <?php include_once('../../Utilities/Third-party/Import-ThirdParty.php'); ?>
    <!-- Main Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Stylesheets/HomeStyle.css">
    <script defer src="../../Utilities/Scripts/HomeScript.js"></script>
    <!-- <script defer src="../../Utilities/Scripts/ToggleSwitch.js"></script> -->
    <script defer src="../../Utilities/Scripts/LoginScript.js"></script>
    <script defer src="../../Utilities/Scripts/ProductsScripts.js"></script>
    <title>Ecommers</title>
    <script>
        // clear specific local storage
        localStorage.removeItem('FileName');
        //get file mame and set it as the title
        var FileName = document.location.pathname.split('/').slice(-1)[0];
        // save to local storage
        localStorage.setItem('FileName', FileName);
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
    // Alert
    include_once('../SweetAlerts/Sweetalert.php');

    // Header
    include_once('../Header/Header.php');

    // Modal
    include_once('../Modal/SearchModal.php');
    include_once('../Modal/SizeGuide.php');
    include_once('../Modal/SigninModal.php');
    include_once('../Modal/ProductModal.php');
    ?>

    <div class="mt-4 bg-body-emphasis p-2 visually-hidden">
        <div class="container-lg text-center">
            <div class="row align-items-center justify-content-between g-3">
                <!-- for Loop to remove repetitive code -->
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <div class="col">
                        <a class="text-decoration-none text-body">
                            <div class="card border-0 bg-transparent">
                                <div class="card-body ratio ratio-16x9">
                                    <img id="bimg-<?php echo $i; ?>" src="../../Assets/Images/Alternative.gif" alt="Category Icon" class="img-fluid object-fit-contain" loading="lazy">
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="container-md mt-4">
        <div class="input-group mb-3 has-validation">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="SearchInput" aria-describedby="SearchBtn validationServer03Feedback">
            <button class="btn btn-outline-success d-flex align-items-center" id="SearchBtn" type="button">
                <svg class="bi me-1" width="24" height="24" fill="currentColor">
                    <use xlink:href="#Search" />
                </svg>
                <span>Search</span>
            </button>
            <div id="validationServer03Feedback" class="invalid-feedback">
                Please provide a valid search query.
            </div>
        </div>
    </div>
    <h1 class="text-center clamp m-5" id="title"><?php echo $Title; ?></h1>
    <div class="album bg-body-tertiary pt-1">
        <div class="container-lg">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-col-xxl-6 g-3" data-masonry='{"percentPosition": true }' id="P_Container">
                <!-- All Products Here -->
            </div>
        </div>
    </div>
</body>

</html>