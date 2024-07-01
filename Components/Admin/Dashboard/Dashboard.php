<?php
session_start();
include_once('../../../Databases/DB_Configurations.php');
date_default_timezone_set('Asia/Manila');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';
$Theme = 'light';
$CurrentPath = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);

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
                                        <h5 class="card-title">Total Accounts</h5>
                                    </div>
                                    <div class="col-4">
                                        <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                            <use xlink:href="#Admin" />
                                        </svg>
                                    </div>
                                    <?php
                                    $stmt = $conn->prepare("SELECT COUNT(*) FROM account");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $Total_Accounts = $row['COUNT(*)'];
                                    $stmt->close();
                                    ?>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_Accounts; ?></h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_Accounts; ?></h1>
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
                                    <?php
                                    $stmt = $conn->prepare("SELECT COUNT(*) FROM user_informations WHERE Role = 'admin'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $Total_Admins = $row['COUNT(*)'];
                                    $stmt->close();
                                    ?>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_Admins; ?></h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_Admins; ?></h1>
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
                                    <?php
                                    $stmt = $conn->prepare("SELECT COUNT(*) FROM user_informations WHERE Role = 'seller'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $Total_Seller = $row['COUNT(*)'];
                                    $stmt->close();
                                    ?>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_Seller; ?></h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_Seller; ?></h1>
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
                                            <h5 class="card-title">Total Customers</h5>
                                        </div>
                                        <div class="col-4">
                                            <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                                <use xlink:href="#Admin" />
                                            </svg>
                                        </div>
                                        <?php
                                        $stmt = $conn->prepare("SELECT COUNT(*) FROM user_informations WHERE Role = 'user'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $Total_User = $row['COUNT(*)'];
                                        $stmt->close();
                                        ?>
                                        <div class="col-8 d-flex justify-content-center align-items-center">
                                            <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_User; ?></h1>
                                            <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_User; ?></h1>
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
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title">Recent Products Added</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM product WHERE Created >= DATE_SUB(NOW(), INTERVAL 1 DAY) LIMIT 5");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <li class="list-group-item"><?php echo $row['Prod_Name']; ?> <small class="text-muted">(<?php echo $row['Brand']; ?>)</small></li>
                                    <?php }
                                        $stmt->close();
                                    } else {
                                        echo '<li class="list-group-item">No recent products added</li>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title">Recent Logins <small class="text-muted">(Last 24 hours)</small></h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM user_informations WHERE Last_Login >= DATE_SUB(NOW(), INTERVAL 1 DAY) LIMIT 5");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <li class="list-group-item"><?php echo $row['First_Name'] . ' ' . $row['Last_Name']; ?> <span> - <?php echo $row['Role'] ?> </span><small class="text-muted">(<?php echo date('h:i A', strtotime($row['Last_Login'])); ?>)</small></li>
                                    <?php }
                                        $stmt->close();
                                    } else {
                                        echo '<li class="list-group-item">No recent logins</li>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4">
                    <div class="col-md-6">
                        <div class="card text-bg-secondary bg-gradient h-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-title">Commission</h5>
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM user_Orders WHERE Status = 'Delivered'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $Total_Sales = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $stmt2 = $conn->prepare("SELECT * FROM user_itemsorder WHERE Order_ID = ?");
                                            $stmt2->bind_param('s', $row['Order_ID']);
                                            $stmt2->execute();
                                            $result2 = $stmt2->get_result();
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $Total_Sales += $row2['Total_Price'];
                                            }
                                            $stmt2->close();
                                        }
                                        $stmt->close();
                                        $Commission = $Total_Sales * 0.15;
                                        $Final_Sales = $Total_Sales - $Commission;
                                        ?>
                                        <div class="col-8 d-flex justify-content-center align-items-center mt-3">
                                            <h2 class="card-text fw-bold display-5 d-none d-md-block">&#8369; <?php echo number_format($Commission, 2); ?></h2>
                                            <h2 class="card-text fw-bold display-5 d-block d-md-none">&#8369; <?php echo number_format($Commission, 2); ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Total Suspended Users</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <h5 class="card-title">Admins</h5>
                                        <?php
                                        $stmt = $conn->prepare("SELECT COUNT(*) FROM `user_informations` JOIN `account` ON `user_informations`.`User_ID` = `account`.`User_ID` WHERE `account`.`Status` = 'Suspended' AND `user_informations`.`Role` = 'admin'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $Suspension_Admin = $row['COUNT(*)'];
                                        $stmt->close();
                                        ?>
                                        <h1 class="card-text fw-bold display-5">
                                            <?php echo $Suspension_Admin; ?>
                                        </h1>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="card-title">Seller</h5>
                                        <?php
                                        $stmt = $conn->prepare("SELECT COUNT(*) FROM `user_informations` JOIN `account` ON `user_informations`.`User_ID` = `account`.`User_ID` WHERE `account`.`Status` = 'Suspended' AND `user_informations`.`Role` = 'seller'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $Suspension_seller = $row['COUNT(*)'];
                                        $stmt->close();
                                        ?>
                                        <h1 class="card-text fw-bold display-5">
                                            <?php echo $Suspension_seller; ?>
                                        </h1>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="card-title">Customers</h5>
                                        <?php
                                        $stmt = $conn->prepare("SELECT COUNT(*) FROM `user_informations` JOIN `account` ON `user_informations`.`User_ID` = `account`.`User_ID` WHERE `account`.`Status` = 'Suspended' AND `user_informations`.`Role` = 'user'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        $Suspension_user = $row['COUNT(*)'];
                                        $stmt->close();
                                        ?>
                                        <h1 class="card-text fw-bold display-5">
                                            <?php echo $Suspension_user; ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>