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

if (!isset($_SESSION['User_Data'])) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

if ($_SESSION['User_Data']['Is_user_logged_in'] != 1) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

try {
    // Check the request method
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['get'])) {

        $user_ID = $_SESSION['User_Data']['user_ID'];

        $sql = "
            SELECT 
                account.Email_Address,
                user_informations.First_Name, 
                user_informations.Last_Name, 
                user_informations.Gender, 
                user_informations.ContactInfo, 
                user_informations.Have_Address, 
                user_informations.Paymentmethod
            FROM 
                account
            JOIN 
                user_informations ON account.User_ID = user_informations.User_ID
            WHERE 
                account.User_ID = ?";

        $result = $conn->prepare($sql);

        if ($result === false
        ) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $result->bind_param("s", $user_ID); // Assuming User_ID is an integer, adjust if it's not

        $result->execute();
        $result->store_result();
        $data = [];

        if ($result->num_rows > 0) {
            $result->bind_result($Email_Address, $First_Name, $Last_Name, $Gender, $ContactInfo, $Have_Address, $Paymentmethod);
            $result->fetch();

            if ($Have_Address == 1) {
                $Address = true;
            } else {
                $Address = false;
            }

            if ($Gender == 1) {
                $Gender = "Male";
            } else if ($Gender == 0) {
                $Gender = "Female";
            } else {
                $Gender = "Unknown";
            }

            if ($Paymentmethod == 1) {
                $Paymentmethod = 'Cash on Delivery';
            } else if ($Paymentmethod == 2) {
                $stmt_payment = $conn->prepare("SELECT * FROM user_onlinewallet WHERE User_ID = ?");
                $stmt_payment->bind_param('s', $user_ID);
                $stmt_payment->execute();
                $result_payment = $stmt_payment->get_result();
                $row_payment = $result_payment->fetch_assoc();
                if ($row_payment['Wallet_Type'] > 0) {
                    $Paymentmethod = $row_payment['Wallet_Type'];
                } else {
                    $Paymentmethod = 'none';
                }
            } else if ($Paymentmethod == 3) {
                $Paymentmethod = 'Credit Card';
            } else {
                $Paymentmethod = 'none';
            }

            $data = [
                    'Email_Address' => $Email_Address,
                    'First_Name' => $First_Name,
                    'Last_Name' => $Last_Name,
                    'Gender' => $Gender,
                    'ContactInfo' => $ContactInfo,
                    'Have_Address' => $Address,
                    'Paymentmethod' => $Paymentmethod
                ];

            response(['status' => 'success', 'data' => $data]);
        } else {
            response(['status' => 'error', 'message' => 'No data found']);
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['password']) && !isset($_GET['newpassword'])) {
        $pass = $_GET['password'];

        $user_ID = $_SESSION['User_Data']['user_ID'];

        $stmt = $conn->prepare("SELECT Password FROM account WHERE User_ID = ?");
        $stmt->bind_param('s', $user_ID);
        $stmt->execute();

        $stmt->store_result();
        $stmt->bind_result($Password);
        $stmt->fetch();

        if (password_verify($pass, $Password)) {
            response(['status' => 'valid']);
        } else {
            response(['status' => 'invalid']);
        }

    } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['password']) && isset($_GET['newpassword'])) {
        $oldPass = $_GET['password'];
        $newPass = $_GET['newpassword'];
        $user_ID = $_SESSION['User_Data']['user_ID'];
        $stmt = $conn->prepare("SELECT Password FROM account WHERE User_ID = ?");
        $stmt->bind_param('s', $user_ID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($Password);
        $stmt->fetch();
        if (password_verify($oldPass, $Password)) {
            $newPass = password_hash($newPass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE account SET Password = ? WHERE User_ID = ?");
            $stmt->bind_param('ss', $newPass, $user_ID);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                response(['status' => 'valid' , 'message' => 'New password has been set']);
            } else {
                response(['status' => 'invalid']);
            }
        } else {
            response(['status' => 'invalid', 'message' => 'Password is incorrect']);
        }
    } else {
        response(['status' => 'error', 'message' => 'Invalid request method']);
    }


    
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'Something went wrong! (' . $th->getMessage() . ')']);
}