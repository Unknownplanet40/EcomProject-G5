<?php
session_start();
// Set local timezone
date_default_timezone_set('Asia/Manila');

@require_once '../../Databases/API_Connection.php';

header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}

try {
    if (isset($_GET['UUID'])) {
        $UUID = $_GET['UUID'];
        $UserID = $_GET['UserID'];

        $stmt_cart = $conn->prepare("UPDATE user_shoppingcart SET Status = 2 WHERE User_ID = ? AND UUID = ?");
        $stmt_cart->bind_param("si", $UserID, $UUID);
        $stmt_cart->execute();
        $stmt_cart->close();

        response(['Status' => 'Success']);
    } else {
        response(['Status' => 'Failed']);
    }
} catch (Exception $e) {
    response(['Status' => $e->getMessage()]);
}