<?php
@require_once 'Database_Credentials.php';

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
    header("location: ../Exceptions/ErrorPage.php");
}
?>