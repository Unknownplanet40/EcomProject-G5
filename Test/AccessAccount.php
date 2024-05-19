<?php
session_start();
include '../Databases/DB_Configurations.php';

// Display the POST data for debugging purposes
print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user inputs
    $username = htmlspecialchars(trim($_POST['Uname']));
    $password = htmlspecialchars(trim($_POST['Pword']));

    echo password_hash($password, PASSWORD_DEFAULT);

    // Basic validation (you can expand this)
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM account WHERE Username = '$username'";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

        if ($row) {
            $verified = password_verify($password, $row['Password']);

            if ($verified) {
                $_SESSION['User_ID'] = $row['User_ID'];
                $_SESSION['Username'] = $row['Username'];
                $_SESSION['Password'] = $row['Password'];
                header('Location: ViewAccount.php');
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Account not found.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Insert Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="container mt-5">
        <div class="mb-3">
            <label for="Uname" class="form-label">Username</label>
            <input type="text" class="form-control" id="Uname" name="Uname" required>
        </div>
        <div class="mb-3">
            <label for="Pword" class="form-label">Password</label>
            <input type="password" class="form-control" id="Pword" name="Pword" required>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit">
    </form>

</body>

</html>