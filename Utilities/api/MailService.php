<?php
session_start();
date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

@require_once '../../Databases/API_Connection.php';
header('Content-Type: application/json');

require '../../Utilities/Third-party/PHPMailer/src/Exception.php';
require '../../Utilities/Third-party/PHPMailer/src/PHPMailer.php';
require '../../Utilities/Third-party/PHPMailer/src/SMTP.php';

function response($data)
{
    echo json_encode($data);
    exit;
}

function getCredential($conn, $keyName)
{
    $stmt = $conn->prepare("SELECT Credential FROM secret_keys WHERE Key_Name = ?");
    $stmt->bind_param("s", $keyName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['Credential'];
}

if (!isset($_SESSION['User_Data'])) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

if ($_SESSION['User_Data']['Is_user_logged_in'] != 1) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        $email = $data['Email'];
        $password = $data['Password'];

        $stmt = $conn->prepare("UPDATE secret_keys Set Credential = ? WHERE Key_Name = 'SMTP_uname'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("UPDATE secret_keys Set Credential = ? WHERE Key_Name = 'SMTP_Pass'");
        $stmt->bind_param("s", $password);
        $stmt->execute();
        $stmt->close();

        $randomNumber = rand(3, 10);
        sleep($randomNumber);

        response(['status' => 'success', 'message' => 'SMTP credentials updated']);
    } else {
        response(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => $th->getMessage()]);
}