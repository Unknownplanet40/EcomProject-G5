<?php
session_start();
include '../Databases/DB_Configurations.php';

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo $hash;
}

?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<p>Convert to Hash</p>
<input type="text" name="password" placeholder="Password">
<button type="submit" name="submit">Convert</button>
</form>