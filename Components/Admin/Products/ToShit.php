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
    <script defer src="../../../Utilities/Scripts/Order.js"></script>
    <title>Shipping Products</title>
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
            <button class="btn btn-sm btn-primary mx-1" id="updateselected">
                <svg class="bi pe-none me-1" width="16" height="16">
                    <use xlink:href="#Products" />
                </svg>
                Update Selected
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
                        <th scope="col" class="text-center">Size</th>
                        <th scope="col" class="text-center">QTY</th>
                        <th scope="col" class="text-center">Stock</th>
                        <th scope="col" class="text-center">Total Price</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Payment</th>
                        <th scope="col" class="text-center">Customer</th>
                        <th scope="col" class="text-center">Address</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="ProductTableBody">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM user_orders WHERE Status = 'Shipping' ORDER BY Created_At DESC");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $ID = 0;

                    while ($row = $result->fetch_assoc()) {
                        $ID++;

                        if ($row['Status'] == 'pending') {
                            $Status = 'Prepering';
                            $StatusColor = 'text-warning';
                        } else if ($row['Status'] == 'Shipping') {
                            $Status = 'Shipping';
                            $StatusColor = 'text-primary';
                        } else if ($row['Status'] == 'Delivered') {
                            $Status = 'Delivered';
                            $StatusColor = 'text-success';
                        } else if ($row['Status'] == 'Cancelled') {
                            $Status = 'Cancelled';
                            $StatusColor = 'text-danger';
                        } else {
                            $Status = 'Undefined';
                            $StatusColor = 'text-secondary';
                        }

                        $stmt_details = $conn->prepare("SELECT * FROM user_itemsorder WHERE Order_ID = ? AND Brand = ?");
                        $stmt_details->bind_param('ss', $row['Order_ID'], $Brand);
                        $stmt_details->execute();
                        $result_details = $stmt_details->get_result();

                        $user_name = $conn->prepare("SELECT * FROM user_informations WHERE user_ID = ?");
                        $user_name->bind_param('s', $row['User_ID']);
                        $user_name->execute();
                        $result_user = $user_name->get_result();
                        $row_user = $result_user->fetch_assoc();

                        while ($row_item = $result_details->fetch_assoc()) {

                            if ($row_item['Size'] == 'S') {
                                $Size = 'S_Qty';
                                $dSize = 'Small';
                            } else if ($row_item['Size'] == 'M') {
                                $Size = 'M_Qty';
                                $dSize = 'Medium';
                            } else if ($row_item['Size'] == 'L') {
                                $Size = 'L_Qty';
                                $dSize = 'Large';
                            } else if ($row_item['Size'] == 'XL') {
                                $Size = 'XL_Qty';
                                $dSize = 'Extra Large';
                            } else {
                                $Size = 'S_Qty';
                                $dSize = 'Diznuts';
                            }

                            $stmt_stock = $conn->prepare("SELECT $Size AS Stock FROM product_size WHERE UID = ?");
                            $stmt_stock->bind_param('s', $row_item['UID']);
                            $stmt_stock->execute();
                            $result_stock = $stmt_stock->get_result();
                            $row_stock = $result_stock->fetch_assoc();
                    ?>
                            <tr style="cursor: pointer;" class="table-row user-select-none">
                                <th scope="row" class="text-center"><?php echo $ID ?></th>
                                <td class="text-center"><?php echo $row['Order_ID'] ?></td>
                                <td class="text-center"><?php echo $row_item['Prod_Name'] ?></td>
                                <td class="text-center"><?php echo $row_item['Brand'] ?></td>
                                <td class="text-center"><?php echo $dSize ?></td>
                                <td class="text-center"><?php echo $row_item['Quantity'] ?></td>
                                <td class="text-center"><?php echo $row_stock['Stock'] ?></td>
                                <td class="text-center"><?php echo $row_item['Total_Price'] ?>.00</td>
                                <td class="text-center <?php echo $StatusColor ?>"><?php echo $Status ?></td>
                                <td class="text-center"><?php echo $row_item['PaymentMethod'] ?></td>
                                <td class="text-center"><?php echo $row_user['First_Name'] . ' ' . $row_user['Last_Name'] ?></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $row_item['Address'] ?>">
                                        <svg class="bi pe-none" width="16" height="16">
                                            <use xlink:href="#home" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                    <?php
                        }
                        $stmt_details->close();
                        $user_name->close();
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>