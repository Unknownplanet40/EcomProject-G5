<?php
session_start();
@require_once '../../Databases/DB_Configurations.php';

if (isset($_SESSION['User_Data'])) {
    $user_id = $_SESSION['User_Data']['user_ID'];
    $stmt = $conn->prepare("UPDATE user_informations SET Is_user_logged_in = 0 WHERE User_ID = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    header('Location: ../Home/Homepage.php');
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}



?>