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
    }

    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        response(['status' => 'error', 'message' => 'Invalid JSON data.']);
    }

    if (!isset($data['Items'], $data['Address'], $data['PaymentMethod'], $data['TotalPrice'], $data['User_ID'])) {
        response(['status' => 'error', 'message' => 'Missing required data.']);
    }

    $Items = $data['Items'];
    $Address = $data['Address'];
    $PaymentMethod = $data['PaymentMethod'];
    $TotalPrice = $data['TotalPrice'];
    $User_ID = $data['User_ID'];

    foreach ($Items as $item) {
        $stmt = $conn->prepare('SELECT * FROM user_shoppingcart WHERE UUID = ?');
        $stmt->bind_param('s', $item);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            response(['status' => 'error', 'message' => 'Item not found in the shopping cart.']);
            exit; // Ensure no further processing happens
        }

        $cartItem = $result->fetch_assoc();
        $stmt->close();

        $stmt_Details = $conn->prepare('SELECT * FROM product WHERE UID = ?');
        $stmt_Details->bind_param('s', $cartItem['UID']);
        $stmt_Details->execute();

        $result_Details = $stmt_Details->get_result();

        if ($result_Details->num_rows === 0) {
            $stmt_Details->close();
            response(['status' => 'error', 'message' => 'Product not found.']);
            exit; // Ensure no further processing happens
        }

        $product = $result_Details->fetch_assoc();
        $stmt_Details->close();

        $userID = $User_ID;
        $orderID = uniqid('ORD-');
        $Brand = $product['Brand'];
        $name = $product['Prod_Name'];
        $size = $cartItem['Size'];
        $Quantity = $cartItem['Quantity'];
        $Price = $product['Price'];
        $TotalPrice = $Price * $Quantity;
        $createdAt = date('Y-m-d H:i:s');

        $conn->begin_transaction();

        $stmt_Order = $conn->prepare('INSERT INTO user_orders (User_ID, Order_ID, TotalPrice, created_at) VALUES (?, ?, ?, ?)');
        $stmt_Order->bind_param('ssds', $userID, $orderID, $TotalPrice, $createdAt);
        $stmt_Order->execute();
        $stmt_Order->close();

        if ($conn->affected_rows === 0) {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later.']);
        }

        $stmt_OrderDetails = $conn->prepare('INSERT INTO user_itemsorder (User_ID, UID, Order_ID, Brand, Prod_Name, Size, Quantity, Price, Total_Price, PaymentMethod, Address, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt_OrderDetails->bind_param('sssssssdssss', $userID, $cartItem['UID'], $orderID, $Brand, $name, $size, $Quantity, $Price, $TotalPrice, $PaymentMethod, $Address, $createdAt);
        $stmt_OrderDetails->execute();
        $stmt_OrderDetails->close();

        if ($conn->affected_rows === 0) {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later.']);
        }
        
        $stmt_ChangeStat = $conn->prepare('UPDATE user_shoppingcart SET Status = 1 WHERE UUID = ?');
        $stmt_ChangeStat->bind_param('s', $item);
        $stmt_ChangeStat->execute();
        $stmt_ChangeStat->close();

        if ($conn->affected_rows === 0) {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later.']);
        }
    }

    $conn->commit();
    response(['status' => 'success', 'message' => 'Order successfully placed.']);

} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later. ' . $th->getMessage() . 'Line: ' . $th->getLine()]);
}
