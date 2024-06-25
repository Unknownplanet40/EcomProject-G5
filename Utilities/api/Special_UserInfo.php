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
    if (isset($_GET['ID'])) {
        $ID = $_GET['ID'];
        $Role = $_GET['Role'];
        $data = [];
        $address = [];

        $stmt = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ?");
        $stmt->bind_param("s", $ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            $stmt->close();

            if ($row['Have_Address'] == 1) {
                $stmt = $conn->prepare("SELECT * FROM user_addressinfo WHERE User_ID = ?");
                $stmt->bind_param("s", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                $row2 = $result->fetch_assoc();
                $stmt->close();

                if ($row2) {
                    $address = [
                        'Province' => $row2['Province'],
                        'Municipality' => $row2['Municipality'],
                        'Barangay' => $row2['Barangay'],
                        'HouseNo' => $row2['HouseNo'],
                        'Zipcode' => $row2['zipcode'],
                        'Landmark' => $row2['Landmark'],
                    ];
                }
            }

            $data = [
                'First_Name' => $row['First_Name'],
                'Last_Name' => $row['Last_Name'],
                'ContactInfo' => $row['ContactInfo'],
                'Have_Address' => $row['Have_Address'] == 1 ? 'Yes' : 'No',
                'Address' => $address,
            ];

            response(['status' => 'success', 'data' => $data]);
        } else {
            response(['status' => 'error', 'message' => 'No data']);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['update'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        $ID = $data['ID'];
        $FirstName = $data['First_Name'];
        $LastName = $data['Last_Name'];
        $Email = $data['Email_Address'];
        $Gender = $data['Gender'];
        $Role = $data['Role'];
        $Contact = $data['Contact'];
        $Status = $data['Status'];
        $AddressStat = $data['Have_Address'];
        $Province = $data['Province'];
        $Municipality = $data['Municipality'];
        $Barangay = $data['Barangay'];
        $HouseNo = $data['HouseNo'];
        $Zipcode = $data['Zipcode'];
        $Landmark = $data['Landmark'];
        $has_changed = $data['isChanged'];
        $addressData = ["Province", "Municipality", "Barangay", "HouseNo", "Zipcode", "Landmark"];
        $changedFields = array_intersect($has_changed, $addressData);

        $Gender = ($Gender === "Male") ? 1 : 0;

        $conn->begin_transaction();

        try {
            // Update user information
            $stmt = $conn->prepare("UPDATE user_informations SET First_Name = ?, Last_Name = ?, ContactInfo = ?, Role = ?, Gender = ? WHERE User_ID = ?");
            $stmt->bind_param("ssssis", $FirstName, $LastName, $Contact, $Role, $Gender, $ID);
            $stmt->execute();
            $stmt->close();

            // Update email and status
            $Email = strtolower($Email);
            $Status = strtolower($Status);
            $stmt = $conn->prepare("UPDATE account SET Email_Address = ?, Status = ? WHERE User_ID = ?");
            $stmt->bind_param("sss", $Email, $Status, $ID);
            $stmt->execute();
            $stmt->close();

            if (!empty($changedFields)) {
                // Check if user has address
                $stmt = $conn->prepare("SELECT * FROM user_addressinfo WHERE User_ID = ?");
                $stmt->bind_param("s", $ID);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                if ($result->num_rows > 0) {
                    // Update address information
                    $stmt = $conn->prepare("UPDATE user_addressinfo SET Province = ?, Municipality = ?, Barangay = ?, HouseNo = ?, zipcode = ?, Landmark = ? WHERE User_ID = ?");
                    $stmt->bind_param("sssssss", $Province, $Municipality, $Barangay, $HouseNo, $Zipcode, $Landmark, $ID);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // Insert new address information
                    $stmt = $conn->prepare("INSERT INTO user_addressinfo (User_ID, Province, Municipality, Barangay, HouseNo, zipcode, Landmark) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssss", $ID, $Province, $Municipality, $Barangay, $HouseNo, $Zipcode, $Landmark);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        $stmt->close();
                        $stmt = $conn->prepare("UPDATE user_informations SET Have_Address = 1 WHERE User_ID = ?");
                        $stmt->bind_param("s", $ID);
                        $stmt->execute();
                        $stmt->close();
                    } else {
                        throw new Exception('No rows affected in user_addressinfo insert.');
                    }
                }
            }

            $conn->commit();
            response(['status' => 'success', 'message' => 'Account updated successfully']);
        } catch (Exception $e) {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'An error occurred: (' . $e->getMessage()]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['reset'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if ($_SESSION['User_Data']['Role'] == 'admin') {
            $Role = "Administrator";
        } else if ($_SESSION['User_Data']['user_ID'] == $ID) {
            $Role = "Yourself";
        } else {
            $Role = "User";
        }

        $ID = $data['ID'];
        $Email = $data['Email_Address'];
        $Password = $data['Password'];
        $changeby = $_SESSION['User_Data']['First_Name'] . ' - ' . $Role;
        $LastName = $data['Lname'];
        $FirstName = $data['Fname'];

        $conn->begin_transaction();

        $HashPassword = password_hash($Password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE account SET Password = ? WHERE User_ID = ?");
        $stmt->bind_param("ss", $HashPassword, $ID);
        $stmt->execute();
        $stmt->close();

        $SMTP_Pass = getCredential($conn, 'SMTP_Pass');
        $SMTP_Uname = getCredential($conn, 'SMTP_Uname');

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $SMTP_Uname;
        $mail->Password = $SMTP_Pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($SMTP_Uname, 'Playaz Luxury Streetwears');
        $mail->addAddress($Email);

        $mail->isHTML(true);
        $date = date('F j, Y \a\t h:i A');
        $mail->Subject = 'Password Reset - ' . $date;
        $mail->Body = '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Password Reset Notification</title><style>body{font-family:Arial,sans-serif;line-height:1.6}.container{max-width:600px;margin:0 auto;padding:20px;border:1px solid #ddd;border-radius:10px}.header{background-color:#4CAF50;color:white;padding:5px 0;text-align:center;border-radius:10px 10px 0 0;display:flex;align-items:center;justify-content:center}.content{padding:10px 20px 20px 20px}.footer{margin-top:20px;text-align:center;font-size:0.9em;color:#777}table{width:100%}td{padding:10px}img{display:block;margin:0 auto}h2{margin:0;color:#fff}ul{list-style-type:none;padding:0}li{margin-bottom:10px}p{margin:0 0 10px}</style></head><body><div class="container"><div class="header"><table><tr><td><img src="https://raw.githubusercontent.com/Unknownplanet40/EcomProject-G5/main/Assets/Images/Logo_1.png" alt="Company Logo" style="display: block;" width="32"></td><td><h2>Playaz Luxury Streetwears</h2></td></tr></table></div><hr><h3 style="text-align: center;">Password Reset Notification</h3><div class="content"><p>Your password has been reset by ' . htmlspecialchars($changeby) . '.</p><p>Your new password is: <b>' . htmlspecialchars($Password) . '</b></p><p>We recommend that you change your password regularly and keep your account information secure.</p><div style="text-align: end;"><p>Thank you for being with us!</p><p>Best regards,<br>The Playaz Team</p></div></div><div class="footer"><p>&copy; ' . date('Y') . ' Playaz Luxury Streetwear. All rights reserved.</p></div></div></body></html>';

        $mail->AltBody = 'Your password has been reset by ' . htmlspecialchars($changeby) . '.
        Your new password is: ' . htmlspecialchars($Password) . '
        Please change your password after logging in for security reasons.
        
        If you did not request this change, please contact support immediately.';

        if ($mail->send()) {
            $conn->commit();
            response(['status' => 'success', 'message' => 'Password reset successfully']);
        } else {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'An error occurred: ' . $mail->ErrorInfo]);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['add'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);
        $FirstName = $data['First_Name'];
        $LastName = $data['Last_Name'];
        $Email = $data['Email_Address'];
        $Password = $data['Password'];
        $Password2 = $data['Password'];
        $Contact = $data['Contact'];
        $Role = $data['Role'];
        $Status = $data['Status'];
        $Gender = $data['Gender'];

        if ($Gender == "Male") {
            $Gender = 1;
        } else {
            $Gender = 0;
        }

        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        $created = date('Y-m-d H:i:s');
        $Password = password_hash($Password, PASSWORD_DEFAULT);

        // check if email already exists
        $stmt = $conn->prepare("SELECT * FROM account WHERE Email_Address = ?");
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            response(['status' => 'info', 'message' => 'Email already exists']);
        }

        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("INSERT INTO account (User_ID, Email_Address, Password, Status, Created) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $uuid, $Email, $Password, $Status, $created);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO user_informations (User_ID, First_Name, Last_Name, Gender, ContactInfo, Role, Have_Address, Paymentmethod, Is_user_logged_in, Last_Login) VALUES (?, ?, ?, ?, ?, ?, 0, 0, 0, ?)");
            $stmt->bind_param("sssisss", $uuid, $FirstName, $LastName, $Gender, $Contact, $Role, $created);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO user_settings (User_ID, Theme) VALUES (?, 'light')");
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $stmt->close();
            
            $SMTP_Pass = getCredential($conn, 'SMTP_Pass');
            $SMTP_Uname = getCredential($conn, 'SMTP_Uname');

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $SMTP_Uname;
            $mail->Password = $SMTP_Pass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($SMTP_Uname, 'Playaz Luxury Streetwears');
            $mail->addAddress($Email);

            $mail->isHTML(true);
            $date = date('F j, Y \a\t h:i A');
            $mail->Subject = 'Your account has been created - ' . $date;

            $mail->Body = '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Account Creation Successful</title><style>body{font-family:Arial,sans-serif;line-height:1.6}.container{max-width:600px;margin:0 auto;padding:20px;border:1px solid #ddd;border-radius:10px}.header{background-color:#4CAF50;color:white;padding:5px 0;text-align:center;border-radius:10px 10px 0 0;display:flex;align-items:center;justify-content:center}.content{padding:10px 20px 20px 20px}.footer{margin-top:20px;text-align:center;font-size:0.9em;color:#777}table{width:100%}td{padding:10px}img{display:block;margin:0 auto}h2{margin:0;color:#fff}ul{list-style-type:none;padding:0}li{margin-bottom:10px}p{margin:0 0 10px}</style></head><body><div class="container"><div class="header"><table><tr><td><img src="https://raw.githubusercontent.com/Unknownplanet40/EcomProject-G5/main/Assets/Images/Logo_1.png" alt="Company Logo" style="display: block;" width="32"></td><td><h2>Playaz Luxury Streetwears</h2></td></tr></table></div><hr><h3 style="text-align: center;">Account Creation Successful</h3><div class="content"><p>Dear <b>' . $FirstName . '</b> <b>' . $LastName . '</b>,</p><p>We are thrilled to inform you that your account has been created successfully!</p><p>You can now access your account using the following details:</p><ul><li>Email: <b>' . $Email . '</b></li><li>Password: <b>' . $Password2 . '</b></li></ul><p>We recommend that you change your password regularly and keep your account information secure.</p><p>Feel free to explore our website and discover our latest collections.</p><div style="text-align: end;"><p>Thank you for joining us!</p><p>Best regards,<br>The Playaz Team</p></div></div><div class="footer"><p>&copy; ' . date('Y') . ' Playaz Luxury Streetwear. All rights reserved.</p></div></div></body></html>';

            $mail->AltBody = 'Welcome to Our Service!
            
            Dear ' . $FirstName . ' ' . $LastName . ',
            
            We are thrilled to inform you that your account has been created successfully!
            
            You can now access your account using the following details:
            
            - Email: ' . $Email . '
            - Password: ' . $Password2 . '
            
            We recommend that you change your password regularly and keep your account information secure.
            
            If you have any questions or need assistance, please do not hesitate to contact our support team.
            
            Thank you for joining us!
            Best regards,
            The Playaz Team

            © ' . date('Y') . ' Playaz Luxury Streetwear. All rights reserved.';

            if ($mail->send()) {
                $conn->commit();
                response(['status' => 'success', 'message' => 'Account created successfully']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'An error occurred while sending email: (' . $mail->ErrorInfo . ')']);
            }
        } catch (Exception $e) {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'An error occurred: (' . $e->getMessage()]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['archive'])) {
        $stat = $_GET['archive'];
        $UserType = $_GET['user'];

        if ($UserType == 1){
            $UserType = "admin";
        } else if ($UserType == 2){
            $UserType = "seller";
        } else if ($UserType == 3){
            $UserType = "user";
        }

        if ($stat == 0) {
            $stmt = $conn->prepare("SELECT * FROM account WHERE Status = 'Suspended'");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $stmt = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ? AND Role = ?");
                    $stmt->bind_param("ss", $row['User_ID'], $UserType);
                    $stmt->execute();
                    $result2 = $stmt->get_result();
                    $row2 = $result2->fetch_assoc();
                    $stmt->close();

                    $data[] = [
                        'ID' => $row['User_ID'],
                        'Email' => $row['Email_Address'],
                        'First_Name' => $row2['First_Name'],
                        'Last_Name' => $row2['Last_Name'],
                        'Role' => $row2['Role'],
                        'Status' => $row['Status'],
                    ];
                }
                response(['status' => 'success', 'data' => $data]);
            } else {
                response(['status' => 'error', 'message' => 'No data']);
            }
        } else if ($stat == 1) {
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);

            $ID = $data['ID'];

            $conn->begin_transaction();

            $stmt = $conn->prepare("UPDATE account SET Status = 'Suspended' WHERE User_ID = ?");
            $stmt->bind_param("s", $ID);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("SELECT First_Name, Last_Name FROM user_informations WHERE User_ID = ?");
            $stmt->bind_param("s", $ID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            $stmt = $conn->prepare("SELECT Email_Address FROM account WHERE User_ID = ?");
            $stmt->bind_param("s", $ID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row2 = $result->fetch_assoc();
            $stmt->close();

            $SMTP_Pass = getCredential($conn, 'SMTP_Pass');
            $SMTP_Uname = getCredential($conn, 'SMTP_Uname');

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $SMTP_Uname;
            $mail->Password = $SMTP_Pass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($SMTP_Uname, 'Playaz Luxury Streetwears');
            $mail->addAddress($row2['Email_Address']);
            
            $mail->isHTML(true);
            $date = date('F j, Y \a\t h:i A');
            $mail->Subject = 'Account Suspended - ' . $date;
            $mail->Body = '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Account Suspended</title><style>body{font-family:Arial,sans-serif;line-height:1.6}.container{max-width:600px;margin:0 auto;padding:20px;border:1px solid #ddd;border-radius:10px}.header{background-color:#4CAF50;color:white;padding:5px 0;text-align:center;border-radius:10px 10px 0 0;display:flex;align-items:center;justify-content:center}.content{padding:10px 20px 20px 20px}.footer{margin-top:20px;text-align:center;font-size:0.9em;color:#777}table{width:100%}td{padding:10px}img{display:block;margin:0 auto}h2{margin:0;color:#fff}ul{list-style-type:none;padding:0}li{margin-bottom:10px}p{margin:0 0 10px}</style></head><body><div class="container"><div class="header"><table><tr><td><img src="https://raw.githubusercontent.com/Unknownplanet40/EcomProject-G5/main/Assets/Images/Logo_1.png" alt="Company Logo" style="display: block;" width="32"></td><td><h2>Playaz Luxury Streetwears</h2></td></tr></table></div><hr><h3 style="text-align: center;">Account Suspended</h3><div class="content"><p>Dear <b>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</b>,</p><p>We regret to inform you that your account has been suspended due to violation of our terms and conditions.</p><p>If you believe this is an error, please contact our support team immediately.</p><div style="text-align: end;"><p>Thank you for your understanding.</p><p>Best regards,<br>The Playaz Team</p></div></div><div class="footer"><p>&copy; ' . date('Y') . ' Playaz Luxury Streetwear. All rights reserved.</p></div></div></body></html>';
            $mail->AltBody = 'We regret to inform you that your account has been suspended due to violation of our terms and conditions.
            If you believe this is an error, please contact our support team immediately.';

            if ($mail->send()) {
                $conn->commit();
                response(['status' => 'success', 'message' => 'Account has been suspended']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'An error occurred: ' . $mail->ErrorInfo]);
            }
            
        } else {
            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);

            $ID = $data['ID'];

            $conn->begin_transaction();

            foreach ($ID as $value) {
                $stmt = $conn->prepare("UPDATE account SET Status = 'Active' WHERE User_ID = ?");
                $stmt->bind_param("s", $value);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("SELECT First_Name, Last_Name FROM user_informations WHERE User_ID = ? AND Role = ?");
                $stmt->bind_param("ss", $value, $UserType);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                $stmt = $conn->prepare("SELECT Email_Address FROM account WHERE User_ID = ?");
                $stmt->bind_param("s", $value);
                $stmt->execute();
                $result = $stmt->get_result();
                $row2 = $result->fetch_assoc();
                $stmt->close();


                $SMTP_Pass = getCredential($conn, 'SMTP_Pass');
                $SMTP_Uname = getCredential($conn, 'SMTP_Uname');

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $SMTP_Uname;
                $mail->Password = $SMTP_Pass;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($SMTP_Uname, 'Playaz Luxury Streetwears');
                $mail->addAddress($row2['Email_Address']);

                $mail->isHTML(true);
                $date = date('F j, Y \a\t h:i A');
                $mail->Subject = 'Account Restored - ' . $date;
                $mail->Body = '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Account Restored</title><style>body{font-family:Arial,sans-serif;line-height:1.6}.container{max-width:600px;margin:0 auto;padding:20px;border:1px solid #ddd;border-radius:10px}.header{background-color:#4CAF50;color:white;padding:5px 0;text-align:center;border-radius:10px 10px 0 0;display:flex;align-items:center;justify-content:center}.content{padding:10px 20px 20px 20px}.footer{margin-top:20px;text-align:center;font-size:0.9em;color:#777}table{width:100%}td{padding:10px}img{display:block;margin:0 auto}h2{margin:0;color:#fff}ul{list-style-type:none;padding:0}li{margin-bottom:10px}p{margin:0 0 10px}</style></head><body><div class="container"><div class="header"><table><tr><td><img src="https://raw.githubusercontent.com/Unknownplanet40/EcomProject-G5/main/Assets/Images/Logo_1.png" alt="Company Logo" style="display: block;" width="32"></td><td><h2>Playaz Luxury Streetwears</h2></td></tr></table></div><hr><h3 style="text-align: center;">Account Restored</h3><div class="content"><p>Dear <b>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</b>,</p><p>We are pleased to inform you that your account has been restored.</p><p>You can now access your account and continue shopping with us.</p><div style="text-align: end;"><p>Thank you for your patience.</p><p>Best regards,<br>The Playaz Team</p></div></div><div class="footer"><p>&copy; ' . date('Y') . ' Playaz Luxury Streetwear. All rights reserved.</p></div></div></body></html>';
                $mail->AltBody = 'We are pleased to inform you that your account has been restored. You can now access your account and continue shopping with us. Thank you for your patience. Best regards, The Playaz Team';

                if ($mail->send()) {
                    $conn->commit();
                    continue;
                } else {
                    $conn->rollback();
                    response(['status' => 'error', 'message' => 'An error occurred: ' . $mail->ErrorInfo]);
                }
            }

            response(['status' => 'success', 'message' => 'Account(s) restored successfully']);
        }
    }


} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred (' . $th->getMessage() . ')']);
}
