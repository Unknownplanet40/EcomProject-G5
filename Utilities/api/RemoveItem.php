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
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $uuid = $_GET['uuid'];

        // update status of item to 'removed'
        $stmt = $conn->prepare("UPDATE user_shoppingcart SET Status = 2 WHERE UUID = ?");
        $stmt->bind_param("s", $uuid);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            response(['status' => 'success', 'message' => 'Item has been removed from cart']);
        } else {
            response(['status' => 'error', 'message' => 'Failed to remove item from cart']);
        }
    } else {
        response(['error' => 'Invalid request method']);
    }
} catch (\Throwable $th) {
    response(['error' => $th->getMessage()]);
}