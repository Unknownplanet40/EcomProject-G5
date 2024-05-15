<?php
session_start();
include '../Databases/DB_Configurations.php';

?>

<h1>View Account</h1>
<p>User ID: <?php echo $_SESSION['User_ID']; ?></p>
<p>Username: <?php echo $_SESSION['Username']; ?></p>
<p>Password: <?php echo $_SESSION['Password']; ?></p>