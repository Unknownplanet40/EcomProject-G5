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

    if(isset($_GET['UserID'])){
        $UserID = $_GET['UserID'];

        $stmt = $conn->prepare('SELECT * FROM user_shoppingcart WHERE User_ID = ? AND Status = 2');
        $stmt->bind_param('s', $UserID);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            response(['status' => 'error', 'message' => 'No archived items found.']);
        }

        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $response = [];

        foreach ($cartItems as $item) {
            $stmt_Details = $conn->prepare('SELECT * FROM product WHERE UID = ?');
            $stmt_Details->bind_param('s', $item['UID']);
            $stmt_Details->execute();

            $result_Details = $stmt_Details->get_result();

            if ($result_Details->num_rows === 0) {
                $stmt_Details->close();
                response(['status' => 'error', 'message' => 'Product not found.']);
            }

            $product = $result_Details->fetch_assoc();
            $stmt_Details->close();

            $response[] = [
                'UUID' => $item['UUID'],
                'Product' => $product['Prod_Name'],
                'Brand' => $product['Brand'],
                'Size' => $item['Size'],
                'Price' => $product['Price'],
                'Quantity' => $item['Quantity'],
            ];
        }

        response(['status' => 'success', 'data' => $response]);
    } else if (isset($_GET['Restore'])){
        
    } else {
        response(['status' => 'error', 'message' => 'Missing required data.']);
    }

} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred. - (' . $th->getMessage() . ')']);
}