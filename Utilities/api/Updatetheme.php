<?php
session_start();
date_default_timezone_set('Asia/Manila');

@require_once '../../Databases/API_Connection.php';
header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}

if (!isset($_SESSION['User_Data'])) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

if ($_SESSION['User_Data']['Is_user_logged_in'] != 1) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

try {
    if (isset($_GET['theme'])) {
        $theme = $_GET['theme'];
        $user_ID = $_SESSION['User_Data']['user_ID'];

        $stmt_settheme = $conn->prepare("UPDATE user_settings SET Theme = ? WHERE User_ID = ?");
        $stmt_settheme->bind_param('ss', $theme, $user_ID);
        $stmt_settheme->execute();
        $stmt_settheme->close();

        $_SESSION['User_Data']['User_Settings']['Theme'] = $theme;
        response(['status' => 'success', 'message' => 'Theme updated successfully']);
    } else {
        response(['status' => 'error', 'message' => 'Invalid request']);
    }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'Something went wrong while updating the theme (' . $th->getMessage() . ')']);
}