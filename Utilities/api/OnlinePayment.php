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
    
    if(isset($_GET['Type']) && isset($_GET['Number']) && isset($_GET['Email']) && isset($_GET['UserID'])){
        $Type = $_GET['Type'];
        $Number = $_GET['Number'];
        $Email = $_GET['Email'];
        $UserID = $_GET['UserID'];

        $stmt_OW = $conn->prepare("INSERT INTO user_onlinewallet (User_ID, Wallet_Type, Email_address, Account_Number) VALUES (?, ?, ?, ?)");
        $stmt_OW->bind_param('ssss', $UserID, $Type, $Email, $Number);
        $stmt_OW->execute();
        $stmt_OW->close();

        // 0 - none | 1 - Online Wallet | 2 - Credit Card | 3 - Cash on Delivery
        $stmt_UI = $conn->prepare("UPDATE user_informations SET Paymentmethod = 1 WHERE User_ID = ?");
        $stmt_UI->bind_param('s', $UserID);
        $stmt_UI->execute();
        $stmt_UI->close();

        response(['status' => 'success', 'message' => 'Wallet added successfully.']);
    } else {
        response(['status' => 'error', 'message' => 'Invalid request.']);
    }



} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occured.']);
}