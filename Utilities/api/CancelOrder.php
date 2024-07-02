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
    $orderID = $_GET['order_id'];

    $stmt = $conn->prepare("UPDATE user_orders SET Status = 'Cancelled' WHERE Order_ID = ?");
    $stmt->bind_param('s', $orderID);
    $stmt->execute();

    response(['status' => 'success', 'message' => 'Order has been cancelled']);
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => $th->getMessage()]);
}