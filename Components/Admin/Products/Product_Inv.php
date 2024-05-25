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
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('../../../Utilities/Third-party/Import-ThirdParty_Admin.php') ?>
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/b-3.0.2/fh-4.0.1/r-3.0.2/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/b-3.0.2/fh-4.0.1/r-3.0.2/datatables.min.js"></script>
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/SidebarStyle.css">
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/ProductStyle.css">
    <script defer src="../../../Utilities/Scripts/ProductDataTable.js"></script>
    <title>Dashboard</title>
    <?php include_once('../../../Assets/Icons/Icon_Assets.php'); ?>
</head>

<body class="d-md-flex">
    <?php 
        include_once('../sidebar/Sidebar.php');
        include_once('../../Modal/Admin/ProductModal.php');
    ?>
    <div class="container-fluid mt-5">
        <div id="loader" class="d-block">
            <div class="Cmodal-backdrop Cfade Cshow"></div>
            <span class="custom-loader"></span>
        </div>
        <div>
            <table class="table table-striped-columns table-dark table-bordered table-hover table-responsive d-none" id="ProductTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">UID</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Color</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Popularity</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="ProductTableBody">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM product");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $ID = 0;
                    while ($row = $result->fetch_assoc()) {
                        $ID++; 
                        //Popularity - How many times the product was Ordered
                        if ($row['Popularity'] == 0) {
                            $row['Popularity'] = "Not Popular";
                        } else {
                            $row['Popularity'] = $row['Popularity'] . " Orders";
                        }
                        
                        
                        ?>
                        <tr>
                            <th scope="row"><?php echo $ID ?></th>
                            <td><?php echo $row['UID'] ?></td>
                            <td><?php echo $row['Prod_Name'] ?></td>
                            <td><?php echo $row['Brand'] ?></td>
                            <td><?php echo $row['Color'] ?></td>
                            <td><?php echo $row['Price'] ?></td>
                            <td><?php echo $row['Status'] ?></td>
                            <td><?php echo $row['Popularity'] ?></td>
                            <td class="d-flex justify-content-evenly">
                            </td>
                        </tr>
                    <?php }
                    $stmt->close(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>