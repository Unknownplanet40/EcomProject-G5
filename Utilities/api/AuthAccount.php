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
    // Check the request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        response(['error' => 'Invalid request method']);
    }

    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    // Check if the data is not empty and contains the required fields
    if (empty($data) || !isset($data['email']) || !isset($data['password'])) {
        response(['error' => 'Invalid request data']);
    }

    $email = $data['email'];
    $password = $data['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM Account WHERE Email_Address = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // status: Active, Pending, Archived, Suspended
        $status = array("Active", "Pending", "Archived", "Suspended");
        if ($row['Status'] == $status[2]) {
            response(['status' => 'warning', 'message' => 'Sorry, We could not find your account']);
        } else if ($row['Status'] == $status[3]) {
            response(['status' => 'info', 'message' => '<b>Your account is suspended</b>, please check your email for more information.']);
        }


        // Check if the password is correct
        if (password_verify($password, $row['Password'])) {
            $_SESSION['User_ID'] = $row['User_ID'];

            // Prepare the update statement to prevent SQL injection
            $update_stmt = $conn->prepare("UPDATE user_informations SET Is_user_logged_in = 1, Last_Login = ? WHERE User_ID = ?");
            $current_time = date('Y-m-d H:i:s');
            $update_stmt->bind_param("si", $current_time, $row['User_ID']);
            $update_result = $update_stmt->execute();

            if (!$update_result) {
                response(['status' => 'error', 'message' => 'Something went wrong. Please try again later']);
            } else {
                response(['status' => 'success', 'message' => '<b>Logging you in</b>. Please wait...']);
            }

            // Close the update statement
            $update_stmt->close();
        } else {
            response(['status' => 'error', 'message' => 'Your <b>password</b> is incorrect']);
        }
    } else {
        response(['status' => 'info', 'message' => '<b>Email</b> or <b>password</b> is incorrect']);
    }

    // Close the select statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    response(['error' => $e->getMessage()]);
}
