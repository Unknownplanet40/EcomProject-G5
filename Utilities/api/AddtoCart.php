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
        $prod_id = $_GET['prod_id'];
        $user_id = $_GET['user_id'];
        $size = $_GET['size'];
        $qty = $_GET['qty'];

        /* // check if product is already in cart
        $stmt_check = $conn->prepare("SELECT * FROM user_shoppingcart WHERE UID = ? AND User_ID = ? AND Size = ?");
        $stmt_check->bind_param("sss", $prod_id, $user_id, $size);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $NewQty = $qty;
            $OldQty = $result_check->fetch_assoc()['Quantity'];
            $UpdatedQty = 0;
            $removing = false;

            // NewQty = 5, OldQty = 3
            if ($NewQty > $OldQty) {
                $UpdatedQty = $NewQty + $OldQty;
            } else if ($NewQty < $OldQty) {
                $UpdatedQty = $OldQty - $NewQty;
                $removing = true;
            } else {
                response(['status' => 'info', 'message' => 'Product already in cart']);
            }

            if ($qty > $result_check->fetch_assoc()['Quantity']) {
                $stmt_update = $conn->prepare("UPDATE user_shoppingcart SET Quantity = Quantity + ? WHERE UID = ? AND User_ID = ? AND Size = ?");
                $stmt_update->bind_param("isss", $qty, $prod_id, $user_id, $size);
                $stmt_update->execute();
                if ($stmt_update->affected_rows > 0) {
                    response(['status' => 'info', 'message' => 'Your cart has been updated']);
                } else {
                    response(['status' => 'error', 'message' => 'Failed to update cart']);
                }
            } else if ($qty < $result_check->fetch_assoc()['Quantity']) {
                $stmt_update = $conn->prepare("UPDATE user_shoppingcart SET Quantity = Quantity - ? WHERE UID = ? AND User_ID = ? AND Size = ?");
                $stmt_update->bind_param("isss", $qty, $prod_id, $user_id, $size);
                $stmt_update->execute();
                if ($stmt_update->affected_rows > 0) {
                    response(['status' => 'info', 'message' => 'Your cart has been updated']);
                } else {
                    response(['status' => 'error', 'message' => 'Failed to update cart']);
                }
            } else {
                response(['status' => 'info', 'message' => 'Product already in cart']);
            }
        } else {
            // add to Database
            $stmt = $conn->prepare("INSERT INTO user_shoppingcart (UID, User_ID, Size, Quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $prod_id, $user_id, $size, $qty);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                response(['status' => 'success', 'message' => 'Product added to cart']);
            } else {
                response(['status' => 'error', 'message' => 'Failed to add product to cart']);
            }
        } */

        // add to Database
        $stmt = $conn->prepare("INSERT INTO user_shoppingcart (UID, User_ID, Size, Quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $prod_id, $user_id, $size, $qty);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            response(['status' => 'success', 'message' => 'Product added to cart']);
        } else {
            response(['status' => 'error', 'message' => 'Failed to add product to cart']);
        }
    } else {
        response(['error' => 'Invalid request method']);
    }
} catch (\Throwable $th) {
    response(['error' => $th->getMessage()]);
}
