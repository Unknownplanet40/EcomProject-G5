<?php
// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

@require_once '../../Databases/DB_Configurations.php';

if (isset($_SESSION['User_ID'])) {
    $user_id = $_SESSION['User_ID'];

    $stmt = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = [
            'user_ID' => $row['User_ID'],
            'First_Name' => $row['First_Name'],
            'Last_Name' => $row['Last_Name'],
            'Role' => $row['Role'],
            'Is_user_logged_in' => $row['Is_user_logged_in'],
            'Last_Login' => $row['Last_Login']
        ];
        // clear session
        session_destroy();
        // set session
        session_start();
        // set session data
        $_SESSION['User_Data'] = $data;
        // redirect to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        session_destroy();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    session_destroy();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>