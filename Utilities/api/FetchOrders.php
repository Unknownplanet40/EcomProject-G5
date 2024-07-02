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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    response(['error' => 'Method Not Allowed']);
}

try {
    $UserID = $_SESSION['User_Data']['user_ID'];
    $Status = $_GET['status'];
    $valid_status = ['pending', 'Shipping', 'Delivered', 'Cancelled'];
    if (!in_array($Status, $valid_status)) {
        response(['status' => 'error', 'message' => 'Invalid status']);
    }

    $stmt_fetch_orders = $conn->prepare("SELECT Order_ID FROM user_orders WHERE user_ID = ? AND Status = ?");
    $stmt_fetch_orders->bind_param("ss", $UserID, $Status);
    $stmt_fetch_orders->execute();
    $result = $stmt_fetch_orders->get_result();

    $orders = [];
    $order_details = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    foreach ($orders as $key => $order) {
        $stmt_fetch_order_details = $conn->prepare("SELECT * FROM user_itemsorder WHERE Order_ID = ?");
        $stmt_fetch_order_details->bind_param("s", $order['Order_ID']);
        $stmt_fetch_order_details->execute();
        $result = $stmt_fetch_order_details->get_result();

        while ($row = $result->fetch_assoc()) {
            $order_details[] = $row;
        }
    }
    response(['status' => 'success', 'orders' => $order_details]);
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => $th->getMessage()]);
}
