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

        $stmt_check_if_exists = $conn->prepare("SELECT * FROM user_shoppingcart WHERE User_ID = ? AND UID = ? AND Size = ?");
        $stmt_check_if_exists->bind_param("sss", $user_id, $prod_id, $size);
        $stmt_check_if_exists->execute();
        $result_check_if_exists = $stmt_check_if_exists->get_result();
        $stmt_check_if_exists->close();

        if ($result_check_if_exists->num_rows > 0) {
            $conn->begin_transaction();
            $stmt_update = $conn->prepare("UPDATE user_shoppingcart SET Quantity = Quantity + ? WHERE UID = ?");
            $stmt_update->bind_param("is", $qty, $prod_id);
            $stmt_update->execute();
            if ($stmt_update->affected_rows > 0) {
                $conn->commit();
                $stmt_update->close();
                response(['status' => 'success', 'message' => 'Product added to cart', 'type' => 'update']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to add product to cart']);
            }
        }

        // generate 6-digit random number
        $uuid = mt_rand(100000, 999999);
        $UNIQUE_ID = true;

        while ($UNIQUE_ID) {
            $stmt_check = $conn->prepare("SELECT * FROM user_shoppingcart WHERE UUID = ?");
            $stmt_check->bind_param("i", $uuid);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $uuid = mt_rand(100000, 999999);
            } else {
                $UNIQUE_ID = false;
            }
        }
        $stmt_check->close();

        // add to Database
        $conn->begin_transaction();
        $stmt = $conn->prepare("INSERT INTO user_shoppingcart (UID, User_ID, Size, Quantity, UUID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $prod_id, $user_id, $size, $qty, $uuid);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $conn->commit();
            response(['status' => 'success', 'message' => 'Product added to cart']);
        } else {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'Failed to add product to cart']);
        }
    } else {
        response(['error' => 'Invalid request method']);
    }
} catch (\Throwable $th) {
    response(['error' => $th->getMessage()]);
}
