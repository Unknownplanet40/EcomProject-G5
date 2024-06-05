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

    if (isset($_GET['UserID'])) {
        $UUID = $_GET['UserID'];
        $stmt = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ?");
        $stmt->bind_param('s', $UUID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $isAddressExist = $row['Have_Address'];
            $payment_method = $row['Paymentmethod'];
            if ($payment_method == 1) {
                $stmt_getPayment = $conn->prepare("SELECT * FROM user_onlinewallet WHERE User_ID = ?");
                $stmt_getPayment->bind_param('s', $UUID);
                $stmt_getPayment->execute();
                $result_payment = $stmt_getPayment->get_result();
                if ($result_payment->num_rows > 0) {
                    $row_payment = $result_payment->fetch_assoc();
                    $payment_method = $row_payment['Wallet_Type'];
                } else {
                    $payment_method = 'none';
                }
                $stmt_getPayment->close();
            } else if ($payment_method == 2) {
                $payment_method = 'Credit Card';
            } else if ($payment_method == 3) {
                $payment_method = 'Cash on Delivery';
            } else {
                $payment_method = 'none';
            }
        } else {
            response(['status' => 'error', 'message' => 'User not found.']);
        }

        if ($isAddressExist == 1) {
            $stmt = $conn->prepare("SELECT * FROM user_addressinfo WHERE User_ID = ?");
            $stmt->bind_param('s', $UUID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $houseNo = $row['HouseNo'];
                $barangay = $row['Barangay'];
                $municipality = $row['Municipality'];
                $province = $row['Province'];
                $zipCode = $row['zipcode'];
                $landmark = isset($row['Landmark']) ? $row['Landmark'] : '';

                $completeAddress = $houseNo . ', ' . $barangay . ', ' . $municipality . ', ' . $province . ' ' . $zipCode;

                if (!empty($landmark)) {
                    $completeAddress .= ' (' . $landmark . ')';
                }
            } else {
                response(['status' => 'error', 'message' => 'User address not found.']);
            }
        } else {
            $address = 'No address found.';
        }

        response(['status' => 'success', 'data' => ['isAddressExist' => $isAddressExist, 'address' => $completeAddress, 'payment_method' => $payment_method]]);
    } else {
        response(['status' => 'error', 'message' => 'Invalid request method.']);
    }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later. ' . $th->getMessage()]);
}
