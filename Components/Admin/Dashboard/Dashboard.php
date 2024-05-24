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
if (!$login){
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
    <div class="container-fluid">
        asdadasd
    </div>
</body>