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

    if (isset($_GET['UserID']) && isset($_GET['PaymentMethod'])) {
        $userId = $_GET['UserID'];
        $paymentMethod = $_GET['PaymentMethod'];
        $Payment_Existed = false;

        $stmt_UI = $conn->prepare("SELECT Paymentmethod FROM user_informations WHERE User_ID = ?");
        $stmt_UI->bind_param('s', $userId);
        $stmt_UI->execute();
        $result_UI = $stmt_UI->get_result();

        if ($result_UI->num_rows > 0) {
            $row_UI = $result_UI->fetch_assoc();
            $Payment_Existed = true;
            $stmt_UI->close();
        } else {
            $stmt_UI->close();
            response(['status' => 'error', 'message' => 'User not found.']);
        }

        if ($paymentMethod == "GCash" || $paymentMethod == "Maya") {
            if ($Payment_Existed) {
                $stmt_OW = $conn->prepare("SELECT * FROM user_onlinewallet WHERE User_ID = ? AND Wallet_Type  = ?");
                $stmt_OW->bind_param('ss', $userId, $paymentMethod);
                $stmt_OW->execute();
                $result_OW = $stmt_OW->get_result();

                if ($result_OW->num_rows > 0) {
                    $row_OW = $result_OW->fetch_assoc();
                    $Email = $row_OW['Email_address'];
                    $AccountNo = $row_OW['Account_Number'];
                    $stmt_OW->close();
                    response(['status' => 'success', 'Type' => $paymentMethod, 'Email' => $Email, 'AccountNo' => $AccountNo]);
                } else {
                    $stmt_OW->close();
                    response(['status' => 'error', 'message' => 'Wallet not found.']);
                }
            } else {
                response(['status' => 'error', 'message' => 'No Existing Payment Method.']);
            }
        } else if ($paymentMethod == "Credit Card") {
            if ($Payment_Existed) {
                $stmt_CC = $conn->prepare("SELECT * FROM user_cardinfo WHERE User_ID = ?");
                $stmt_CC->bind_param('s', $userId);
                $stmt_CC->execute();
                $result_CC = $stmt_CC->get_result();

                if ($result_CC->num_rows > 0) {
                    $row_CC = $result_CC->fetch_assoc();
                    $CardNo = $row_CC['Card_Number'];
                    $CardHolder = $row_CC['Card_Holder'];
                    $ExpiryDate = $row_CC['Expiry_Date'];
                    $BillingAddress = $row_CC['Billing_Address'];
                    $stmt_CC->close();
                    response(['status' => 'success', 'Type' => $paymentMethod, 'CardNo' => $CardNo, 'CardHolder' => $CardHolder, 'ExpiryDate' => $ExpiryDate, 'BillingAddress' => $BillingAddress]);
                } else {
                    $stmt_CC->close();
                    response(['status' => 'error', 'message' => 'Credit card not found.']);
                }
            } else {
                response(['status' => 'error', 'message' => 'No Existing Payment Method.']);
            }
        } else if ($paymentMethod == "Cash on Delivery") {
            response(['status' => 'success', 'Type' => $paymentMethod]);
        } else {
            response(['status' => 'error', 'message' => 'Invalid payment method.']);
        }
    } else {
        response(['status' => 'error', 'message' => 'User not found.']);
    }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred while processing your request. Please try again later. ' . $th->getMessage()]);
}
