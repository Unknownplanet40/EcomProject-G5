<?php
$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "playaz_db";

try {
    $conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);
    if ($conn) { ?>
        <script>
            console.log('%c Database Connection Successful', 'color: green; font-size: 20px;');
        </script>
<?php } else { ?>
        <script>
            console.log('%c Database Connection Failed', 'color: red; font-size: 20px;');
        </script>
<?php }
} catch (\Throwable $th) {
    header("location: ErrorPage.php?error=500");
}
?>