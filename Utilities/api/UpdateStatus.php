<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@require_once '../../Databases/API_Connection.php';
require '../../Utilities/Third-party/PHPMailer/src/Exception.php';
require '../../Utilities/Third-party/PHPMailer/src/PHPMailer.php';
require '../../Utilities/Third-party/PHPMailer/src/SMTP.php';

header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');

@require_once '../../Databases/API_Connection.php';
header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}

function is_connected()
{
    $connected = @fsockopen("www.example.com", 80);
    if ($connected) {
        $is_conn = true;
        fclose($connected);
    } else {
        $is_conn = false;
    }
    return $is_conn;
}

if (!is_connected()) {
    response(array('status' => 'error', 'message' => 'No internet connection'));
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

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $order_id = $data['SelectedID'];
    $status = $data['Status'];
    $send = [];

    $conn->begin_transaction();

    foreach ($order_id as $id) {

        $old_stmt = $conn->prepare("SELECT Status FROM user_orders WHERE Order_ID = ?");
        $old_stmt->bind_param('s', $id);
        $old_stmt->execute();
        $old_result = $old_stmt->get_result();
        $old_row = $old_result->fetch_assoc();

        $stmt = $conn->prepare("UPDATE user_orders SET status = ? WHERE Order_ID = ?");
        $stmt->bind_param('ss', $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'Failed to update status']);
        }

        $stmt->close();

        $stmt_details = $conn->prepare("SELECT User_ID, Address, Created_at, Quantity, Size, UID FROM user_itemsorder WHERE Order_ID = ?");
        $stmt_details->bind_param('s', $id);
        $stmt_details->execute();
        $result_details = $stmt_details->get_result();
        $row_details = $result_details->fetch_assoc();

        if ($status == 'Shipping') {
            $sql1 = "";
            if ($row_details['Size'] == 'S') {
                $sql1 = "UPDATE product_size SET S_Qty = S_Qty - ? WHERE UID = ?";
            } else if ($row_details['Size'] == 'M') {
                $sql1 = "UPDATE product_size SET M_Qty = M_Qty - ? WHERE UID = ?";
            } else if ($row_details['Size'] == 'L') {
                $sql1 = "UPDATE product_size SET L_Qty = L_Qty - ? WHERE UID = ?";
            } else if ($row_details['Size'] == 'XL') {
                $sql1 = "UPDATE product_size SET XL_Qty = XL_Qty - ? WHERE UID = ?";
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update product size']);
            }
            $stmt_size = $conn->prepare($sql1);
            $stmt_size->bind_param('ss', $row_details['Quantity'], $row_details['UID']);
            $stmt_size->execute();
            $stmt_size->close();

            $prod_Pop = $conn->prepare("UPDATE product SET Popularity = Popularity + ? WHERE UID = ?");
            $prod_Pop->bind_param('ss', $row_details['Quantity'], $row_details['UID']);
            $prod_Pop->execute();
            $prod_Pop->close();
        }
        
        if ($status == 'Cancelled') {
            if ($old_row['Status'] == 'Shipping') {
                $sql2 = "";
                if ($row_details['Size'] == 'S') {
                    $sql2 = "UPDATE product_size SET S_Qty = S_Qty + ? WHERE UID = ?";
                } else if ($row_details['Size'] == 'M') {
                    $sql2 = "UPDATE product_size SET M_Qty = M_Qty + ? WHERE UID = ?";
                } else if ($row_details['Size'] == 'L') {
                    $sql2 = "UPDATE product_size SET L_Qty = L_Qty + ? WHERE UID = ?";
                } else if ($row_details['Size'] == 'XL') {
                    $sql2 = "UPDATE product_size SET XL_Qty = XL_Qty + ? WHERE UID = ?";
                } else {
                    $conn->rollback();
                    response(['status' => 'error', 'message' => 'Failed to update product size']);
                }
                $stmt_size = $conn->prepare($sql2);
                $stmt_size->bind_param('ss', $row_details['Quantity'], $row_details['UID']);
                $stmt_size->execute();
                $stmt_size->close();
            }
        }

        $stmt_user = $conn->prepare("SELECT Email_Address FROM account WHERE user_ID = ?");
        $stmt_user->bind_param('s', $row_details['User_ID']);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $row_user = $result_user->fetch_assoc();

        $stmt_name = $conn->prepare("SELECT First_Name, Last_Name FROM user_informations WHERE User_ID = ?");
        $stmt_name->bind_param('s', $row_details['User_ID']);
        $stmt_name->execute();
        $result_name = $stmt_name->get_result();
        $row_name = $result_name->fetch_assoc();

        $stmt_user->close();
        $stmt_details->close();
        $stmt_name->close();

        $SMTP_Pass = getCredential($conn, 'SMTP_Pass');
        $SMTP_Uname = getCredential($conn, 'SMTP_Uname');


        //$Email = $row_user['Email_Address'];
        $Email = "newite1635@joeroc.com";
        $Email = strtolower($Email);
        $name = $row_name['First_Name'] . ' ' . $row_name['Last_Name'];
        $address = $row_details['Address'];
        $orderDate = date('F d, Y', strtotime($row_details['Created_at']));
        $orderNumber = $id;
        if ($status == 'Shipping') {
            $orderStatus = 'Ship Out';
        } else if ($status == 'Delivered') {
            $orderStatus = 'Delivered';
        } else if ($status == 'Cancelled') {
            $orderStatus = 'Cancelled';
        } else {
            $orderStatus = $status;
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $SMTP_Uname;
        $mail->Password = $SMTP_Pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($SMTP_Uname, 'Playaz Luxury Streetwears');
        $mail->addAddress($Email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Order Status Update';
        $mail->Body = '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Order Status Update</title><style>body{font-family:Arial,sans-serif;line-height:1.6}.container{max-width:600px;margin:0 auto;padding:20px;border:1px solid #ddd;border-radius:10px}.header{background-color:#4CAF50;color:white;padding:5px 0;text-align:center;border-radius:10px 10px 0 0;display:flex;align-items:center;justify-content:center}.content{padding:10px 20px 20px 20px}.footer{margin-top:20px;text-align:center;font-size:0.9em;color:#777}table{width:100%}td{padding:10px}img{display:block;margin:0 auto}h2{margin:0;color:#fff}ul{list-style-type:none;padding:0}li{margin-bottom:10px}p{margin:0 0 10px}</style></head><body><div class="container"><div class="header"><table><tr><td><img src="https://raw.githubusercontent.com/Unknownplanet40/EcomProject-G5/main/Assets/Images/Logo_1.png" alt="Company Logo" style="display: block;" width="32"></td><td><h2>Playaz Luxury Streetwears</h2></td></tr></table></div><hr><h3 style="text-align: center;">Order Status Update</h3><div class="content"><p>Dear <b>' . $name . '</b>,</p><p>Your order <b>#' . $orderNumber . '</b> status has been updated to: <b>' . $orderStatus . '</b>.</p><p>Order Details:</p><ul><li><b>Order Number:</b> ' . $orderNumber . '</li><li><b>Order Date:</b> ' . $orderDate . '</li><li><b>Shipping Address:</b> ' . $address . '</li></ul><p>If you have any questions, please contact our support team.</p><div style="text-align: end;"><p>Thank you!</p><p>Best regards,<br>The Playaz Team</p></div></div><div class="footer"><p>&copy; ' . date('Y') . ' Playaz Luxury Streetwear. All rights reserved.</p></div></div></body></html>';
        $mail->AltBody = 'Hello ' . $name . ',\n\nYour order #' . $orderNumber . ' status has been updated to: ' . $orderStatus . '.\n\nOrder Details:\n- Order Number: ' . $orderNumber . '\n- Order Date: ' . $orderDate . '\n- Shipping Address: ' . $address . '\n\nIf you have any questions, please contact our support team.\n\nBest regards,\nThe Playaz Team';


        if ($mail->send()) {
            continue;
        } else {
            $send[] = $Email;
        }
    }
    if (count($send) > 0) {
        response(['status' => 'error', 'message' => 'Failed to send email to: ' . implode(', ', $send)]);
    } else {
        $conn->commit();
        response(['status' => 'success', 'message' => 'Order(s) status updated successfully']);
    }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => $th->getMessage()]);
}
