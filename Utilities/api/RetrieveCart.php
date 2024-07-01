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

function is_connected()
{
    $connected = @fsockopen("www.example.com", 80);
    if ($connected) {
        $is_conn = true;
        fclose($connected);
    } else {
        $is_conn = false;
    }
    return $is_conn;
}

if (!isset($_SESSION['User_Data'])) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

try {
    if (!is_connected()) {
        response(['status' => 'error', 'message' => 'No internet connection']);
    }

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            response(['status' => 'error', 'message' => 'Invalid JSON data']);
        }

        $User_ID = $data['UserID'];
        $retrievedItems = $data['Items'];

        foreach ($retrievedItems as $item) {
            $stmt = $conn->prepare('UPDATE user_shoppingcart SET Status = NULL WHERE UUID = ?');
            $stmt->bind_param('s', $item);
            $stmt->execute();
            $stmt->close();

            response(['status' => 'success', 'message' => 'Items retrieved']);
        }

    } else {
        response(['status' => 'error', 'message' => 'Invalid request method']);
    
   }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occured']);
}