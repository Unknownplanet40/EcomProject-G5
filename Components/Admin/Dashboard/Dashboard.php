<?php
session_start();
include_once('../../../Databases/DB_Configurations.php');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';
$Theme = 'light';

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

// if user is not logged in, redirect to homepage
if (!$login) {
    header('Location: ../../Home/Homepage.php');
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo $Theme; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('../../../Utilities/Third-party/Import-ThirdParty_Admin.php') ?>
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/SidebarStyle.css">
    <title>Dashboard</title>
    <?php include_once('../../../Assets/Icons/Icon_Assets.php'); ?>
    <script>
        // clear specific local storage
        localStorage.removeItem('FileName');
        //get file mame and set it as the title
        var FileName = document.location.pathname.split('/').slice(-1)[0];
        // save to local storage
        localStorage.setItem('FileName', FileName);
    </script>
</head>

<body class="d-md-flex">
    <?php include_once('../sidebar/Sidebar.php') ?>
    <div class="container-fluid mt-3">
        <div class="row g-3">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <div class="col-md-3">
                        <div class="card text-bg-primary bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-title">Total Users</h5>
                                    </div>
                                    <div class="col-4">
                                        <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                            <use xlink:href="#Admin" />
                                        </svg>
                                    </div>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block">0</h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none">0</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-warning bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-title">Total Admins</h5>
                                    </div>
                                    <div class="col-4">
                                        <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                            <use xlink:href="#Admin" />
                                        </svg>
                                    </div>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block">0</h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none">0</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-bg-success bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-title">Total Sellers</h5>
                                    </div>
                                    <div class="col-4">
                                        <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                            <use xlink:href="#Admin" />
                                        </svg>
                                    </div>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block">0</h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none">0</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card text-bg-danger bg-gradient">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="card-title">Total Buyers</h5>
                                        </div>
                                        <div class="col-4">
                                            <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                                <use xlink:href="#Admin" />
                                            </svg>
                                        </div>
                                        <div class="col-8 d-flex justify-content-center align-items-center">
                                            <h1 class="card-text fw-bold display-5 d-none d-md-block">0</h1>
                                            <h1 class="card-text fw-bold display-5 d-block d-md-none">0</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Recent Products Added</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">An item</li>
                                    <li class="list-group-item">A second item</li>
                                    <li class="list-group-item">A third item</li>
                                    <li class="list-group-item">A fourth item</li>
                                    <li class="list-group-item">And a fifth one</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Recent Logins <small class="text-muted">(Last 24 hours)</small></h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">An item</li>
                                    <li class="list-group-item">A second item</li>
                                    <li class="list-group-item">A third item</li>
                                    <li class="list-group-item">A fourth item</li>
                                    <li class="list-group-item">And a fifth one</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Total Suspended Users</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <h5 class="card-title">Admins</h5>
                                        <h1 class="card-text fw-bold display-5">0</h1>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="card-title">Seller</h5>
                                        <h1 class="card-text fw-bold display-5">0</h1>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="card-title">Buyers</h5>
                                        <h1 class="card-text fw-bold display-5">0</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Total Products</h5>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>