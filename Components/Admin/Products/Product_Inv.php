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

        if ($_SESSION['User_Data']['First_Name'] == 'UND') {
            $Brand = 'UNDRAFTED';
            echo '<script>var Brand = "UNDRAFTED";</script>';
        } else {
            $Brand = $_SESSION['User_Data']['First_Name'];
            echo '<script>var Brand = "' . $_SESSION['User_Data']['First_Name'] . '";</script>';
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
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/af-2.7.0/b-3.0.2/r-3.0.2/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/af-2.7.0/b-3.0.2/r-3.0.2/datatables.min.js"></script>
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/SidebarStyle.css">
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/ProductStyle.css">
    <script defer src="../../../Utilities/Scripts/ProductDataTable.js"></script>
    <title>Products</title>
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
    include_once('../../Modal/Admin/ProductModal.php');
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
            <table class="table table-striped-columns table-bordered table-hover d-none" id="ProductTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">UID</th>
                        <th scope="col" class="text-center">Item Name</th>
                        <th scope="col" class="text-center">Brand</th>
                        <th scope="col" class="text-center">Color</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Popularity</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="ProductTableBody">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM product WHERE Status = 0 AND Brand = ? ORDER BY Popularity DESC");
                    $stmt->bind_param("s", $Brand);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $ID = 0;
                    while ($row = $result->fetch_assoc()) {
                        $ID++;
                        //Popularity - How many times the product was Ordered
                        if ($row['Popularity'] == 0) {
                            $row['Popularity'] = "<span class='text-danger'>No Orders</span>";
                        } else {
                            $row['Popularity'] = number_format($row['Popularity']);
                            $row['Popularity'] = "<span class='text-success fw-bold'>" . $row['Popularity'] . " Sold</span>";
                        }
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $ID ?></th>
                            <td class="text-center"><?php echo $row['UID'] ?></td>
                            <td><?php echo $row['Prod_Name'] ?></td>
                            <td><?php echo $row['Brand'] ?></td>
                            <td><?php echo $row['Color'] ?></td>
                            <td class="text-start" data-price="<?php echo $row['Price'] ?>"><?php echo number_format($row['Price'], 2) ?></td>
                            <td class="text-center"><?php echo $row['Status'] ?></td>
                            <td class="text-center"><?php echo $row['Popularity'] ?></td>
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