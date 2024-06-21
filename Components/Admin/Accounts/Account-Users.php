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
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/ProductStyle.css">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/af-2.7.0/b-3.0.2/r-3.0.2/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/af-2.7.0/b-3.0.2/r-3.0.2/datatables.min.js"></script>
    <script defer src="../../../Utilities/Scripts/AdminScript.js"></script>
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
    <?php
    include_once('../sidebar/Sidebar.php');
    include_once('../../Modal/Admin/AccountINFO.php');
    ?>
    <div class="container-fluid mt-5">
        <div id="loader" class="d-block">
            <div class="Cmodal-backdrop Cfade Cshow"></div>
            <span class="custom-loader"></span>
        </div>
        <div class="d-flex justify-content-center">
            <input type="text" class="form-control form-control-sm w-50" id="SearchProduct" placeholder="Search Product">
            <button class="btn btn-sm btn-primary mx-1" id="AddProduct">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#Adprod" />
                </svg>
                Add Product
            </button>
            <button class="btn btn-sm btn-primary mx-1" id="ArchiveProduct">
                <svg class="bi pe-none me-1" width="16" height="16">
                    <use xlink:href="#Archive" />
                </svg>
                Archive
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped-columns table-bordered table-hover d-none" id="UserTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">User_ID</th>
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Email</th>
                        <th scope="col" class="text-center">Password</th>
                        <th scope="col" class="text-center">Gender</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="ProductTableBody">
                    <?php
                    // Prepare and execute the first query
                    $stmt_tb1 = $conn->prepare("SELECT * FROM account" );
                    $stmt_tb1->execute();
                    $result_tb1 = $stmt_tb1->get_result();
                    $ID = 0;

                    // Loop through each row of the account table
                    while ($row_tb1 = $result_tb1->fetch_assoc()) {
                        $ID++;

                        // Prepare and execute the second query
                        $stmt_tb2 = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ?");
                        $stmt_tb2->bind_param("s", $row_tb1['User_ID']);
                        $stmt_tb2->execute();
                        $result_tb2 = $stmt_tb2->get_result();
                        $row_tb2 = $result_tb2->fetch_assoc();

                        if ($row_tb2) { // Ensure the row exists
                            if ($row_tb2['Gender'] == 1) {
                                $row_tb2['Gender'] = 'Male';
                            } else if ($row_tb2['Gender'] == NULL) {
                                $row_tb2['Gender'] = '<small class="text-danger">No Data</small>';
                            } else {
                                $row_tb2['Gender'] = 'Female';
                            }
                        } else {
                            $row_tb2['First_Name'] = $row_tb2['Last_Name'] = $row_tb2['Gender'] = $row_tb2['Address'] = "";
                        }

                        if ($row_tb1['Status'] == 'active') {
                            $row_tb1['Status'] = 'Active';
                        } else {
                            $row_tb1['Status'] = 'Inactive';
                        }

                        if ($row_tb2['Role'] == 'user') {
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $ID ?></th>
                            <td><?php echo $row_tb1['User_ID'] ?></td>
                            <td><?php echo $row_tb2['First_Name'] . ' ' . $row_tb2['Last_Name'] ?></td>
                            <td><?php echo $row_tb1['Email_Address'] ?></td>
                            <td class="text-center"><?php echo $row_tb1['Password'] ?></td>
                            <td class="text-center"><?php echo $row_tb2['Gender'] ?></td>
                            <td class="text-center"><?php echo $row_tb1['Status'] ?></td>
                            <td class="text-center">Tangina mo</td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>