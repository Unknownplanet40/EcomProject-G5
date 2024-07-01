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

        if ($_SESSION['User_Data']['First_Name'] == 'UND') {
            $Brand = 'UNDRAFTED';
        } else {
            $Brand = $_SESSION['User_Data']['First_Name'];
        }
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
        <div class="row g-3 mb-3">
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
                                    $stmt = $conn->prepare("SELECT * FROM product WHERE Created >= DATE_SUB(NOW(), INTERVAL 1 DAY) AND Brand = ? LIMIT 5");
                                    $stmt->bind_param('s', $Brand);
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
                                <h5 class="card-title">Most Popular <?php echo $_SESSION['User_Data']['First_Name']; ?> Products</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM product WHERE Brand = ? AND Popularity >= 1000 LIMIT 5");
                                    $stmt->bind_param('s', $Brand);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <li class="list-group-item"><?php echo $row['Prod_Name']; ?> <small class="text-muted">(<?php echo $row['Popularity']; ?> Sold)</small></li>
                                    <?php }
                                        $stmt->close();
                                    } else {
                                        echo '<li class="list-group-item">No popular products</li>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <div class="col-md-3">
                <a class="text-decoration-none" href="../Products/Preparing.php">
                    <div class="card text-bg-primary bg-gradient">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Preparing Orders</h5>
                                </div>
                                <div class="col-4">
                                    <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                        <use xlink:href="#Order" />
                                    </svg>
                                </div>
                                <?php
                                $stmt = $conn->prepare("SELECT Order_ID FROM user_Orders WHERE Status = 'pending'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $stmt->close();

                                $stmt = $conn->prepare("SELECT COUNT(Order_ID) FROM user_itemsorder WHERE Order_ID = ?");
                                $stmt->bind_param('s',  $row['Order_ID']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $Total_preparing = $row['COUNT(Order_ID)'];
                                $stmt->close();
                                ?>
                                <div class="col-8 d-flex justify-content-center align-items-center">
                                    <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_preparing; ?></h1>
                                    <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_preparing; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="text-decoration-none" href="../Products/Shipping.php">
                    <div class="card text-bg-warning bg-gradient">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Shipping Orders</h5>
                                </div>
                                <div class="col-4">
                                    <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                        <use xlink:href="#Shipping" />
                                    </svg>
                                </div>
                                <?php
                                $stmt = $conn->prepare("SELECT Order_ID FROM user_Orders WHERE Status = 'Shipping'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $stmt->close();

                                $stmt = $conn->prepare("SELECT COUNT(Order_ID) FROM user_itemsorder WHERE Order_ID = ?");
                                $stmt->bind_param('s',  $row['Order_ID']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $Total_Shipping = $row['COUNT(Order_ID)'];
                                $stmt->close();
                                ?>
                                <div class="col-8 d-flex justify-content-center align-items-center">
                                    <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_Shipping; ?></h1>
                                    <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_Shipping; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="text-decoration-none" href="../Products/Delivered.php">
                    <div class="card text-bg-success bg-gradient">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Delivered Orders</h5>
                                </div>
                                <div class="col-4">
                                    <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                        <use xlink:href="#Products" />
                                    </svg>
                                </div>
                                <?php
                                $stmt = $conn->prepare("SELECT Order_ID FROM user_Orders WHERE Status = 'Delivered'");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $stmt->close();

                                $stmt = $conn->prepare("SELECT COUNT(Order_ID) FROM user_itemsorder WHERE Order_ID = ?");
                                $stmt->bind_param('s',  $row['Order_ID']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $Total_Delivered = $row['COUNT(Order_ID)'];
                                $stmt->close();
                                ?>
                                <div class="col-8 d-flex justify-content-center align-items-center">
                                    <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_Delivered; ?></h1>
                                    <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_Delivered; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="text-decoration-none" href="../Products/Cancelled.php">
                    <div class="card">
                        <div class="card text-bg-danger bg-gradient">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="card-title">Cancelled Orders</h5>
                                    </div>
                                    <div class="col-4">
                                        <svg class="bi my-1" width="64" height="64" fill="currentColor">
                                            <use xlink:href="#PackCancel" />
                                        </svg>
                                    </div>
                                    <?php
                                    $stmt = $conn->prepare("SELECT Order_ID FROM user_Orders WHERE Status = 'Cancelled'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $stmt->close();

                                    $stmt = $conn->prepare("SELECT COUNT(Order_ID) FROM user_itemsorder WHERE Order_ID = ?");
                                    $stmt->bind_param('s',  $row['Order_ID']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $Total_Cancel = $row['COUNT(Order_ID)'];
                                    $stmt->close();
                                    ?>
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h1 class="card-text fw-bold display-5 d-none d-md-block"><?php echo $Total_Cancel; ?></h1>
                                        <h1 class="card-text fw-bold display-5 d-block d-md-none"><?php echo $Total_Cancel; ?></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row-cols-md-2 row-cols-lg-2 g-4 mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card text-bg-secondary bg-gradient">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Total Sales <small class="text-muted">(-15% Commission)</small></h5>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM user_Orders WHERE Status = 'Delivered'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $Total_Sales = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $stmt2 = $conn->prepare("SELECT * FROM user_itemsorder WHERE Order_ID = ? AND Brand = ?");
                                        $stmt2->bind_param('ss', $row['Order_ID'], $Brand);
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
                                    <div class="col-8 d-flex justify-content-center align-items-center">
                                        <h2 class="card-text fw-bold display-5 d-none d-md-block">&#8369; <?php echo number_format($Final_Sales, 2); ?></h2>
                                        <h2 class="card-text fw-bold display-5 d-block d-md-none">&#8369; <?php echo number_format($Final_Sales, 2); ?></h2>
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

</html>