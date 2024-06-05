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

try {
    if (!isset($_SESSION['User_Data'])) {
        response(['status' => 'error', 'message' => 'User not logged in.']);
        exit;
    }

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    if (!isset($data['Items'], $data['Address'], $data['PaymentMethod'], $data['TotalPrice'], $data['User_ID'])) {
        response(['status' => 'error', 'message' => 'Missing required data.']);
        exit;
    }

    $DataItem = $data['Items'];
    $address = $data['Address'];
    $paymentMethod = $data['PaymentMethod'];
    $totalPrice = $data['TotalPrice'];
    $userId = $data['User_ID'];
    $orderNumber = mt_rand(100000, 999999);

    // for each item in DataItem
    foreach ($DataItem as $item) {
        $itemId = $item['Item_ID'];
        $stmt_getUID = $conn->prepare("SELECT * FROM user_shoppingcart WHERE UUUID = ? AND User_ID = ?");
        $stmt_getUID->bind_param('is', $itemId, $userId);
        $stmt_getUID->execute();
        $result = $stmt_getUID->get_result();
        
    }


} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later. ' . $th->getMessage()]);
}