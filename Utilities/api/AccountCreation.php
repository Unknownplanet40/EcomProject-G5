<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

@require_once '../../Databases/API_Connection.php';
require '../../Utilities/Third-party/PHPMailer/src/Exception.php';
require '../../Utilities/Third-party/PHPMailer/src/PHPMailer.php';
require '../../Utilities/Third-party/PHPMailer/src/SMTP.php';

header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');

function response($data)
{
    echo json_encode($data);
    exit;
}

try {
    if (isset($_GET['functionname'])) {
        switch ($_GET['functionname']) {
            case 'isEmailExist':
                $Email = $_GET['email'];
                $Email = strtolower($Email);
                $stmt_check = $conn->prepare("SELECT COUNT(Email_Address) AS Exist FROM account WHERE Email_Address = ?");
                $stmt_check->bind_param("s", $Email);

                if ($stmt_check->execute()) {
                    $result = $stmt_check->get_result();
                    $row = $result->fetch_assoc();
                    if ($row['Exist'] > 0) {
                        response(['valid' => true]);
                    } else {
                        response(['valid' => false]);
                    }
                } else {
                    response(['error' => 'Error in checking email']);
                }
                break;
            case 'sendOTP':
                $stmt_get_Key = $conn->prepare("SELECT Credential FROM secret_keys WHERE Key_Name = 'SMTP_Pass'");
                $stmt_get_Key->execute();
                $result = $stmt_get_Key->get_result();
                $row = $result->fetch_assoc();
                $SMTP_Pass = $row['Credential'];
                $stmt_get_Key->close();


                $Email = $_GET['email'];
                $Email = strtolower($Email);
                $OTP = $_GET['otp'];
                $name = $_GET['name'];

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ryanjamesc4@gmail.com';
                $mail->Password = $SMTP_Pass;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ryanjamesc4@gmail.com');
                $mail->addAddress($Email);

                $mail->isHTML(true);
                $mail->Subject = 'OTP Verification';
                $mail->Body    = 'Hello ' . $name . ',<br><br>Thank you for registering with us. To complete your email verification, please use the following OTP code:<br><br><b>' . $OTP . '</b><br><br>If you did not request this, please ignore this email.<br><br>Best regards,<br>Your Company Name';
                $mail->AltBody = 'Hello ' . $name . ',\n\nThank you for registering with us. To complete your email verification, please use the following OTP code:\n\n' . $OTP . '\n\nIf you did not request this, please ignore this email.\n\nBest regards,\nYour Company Name';


                if ($mail->send()) {
                    response(['isSent' => true]);
                } else {
                    response(['isSent' => false]);
                }
                break;
            case 'createAccount':
                $Email = strtolower($_GET['email']);
                $plaintext_Password = $_GET['password'];
                $FirstName = $_GET['firstname'];
                $LastName = $_GET['lastname'];

                // Generate a UUID version 4
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

                // Hash the password
                $Password = password_hash($plaintext_Password, PASSWORD_DEFAULT);

                // Get the current timestamp
                $created = date('Y-m-d H:i:s');

                // Start a transaction
                $conn->begin_transaction();

                try {
                    // Prepare the SQL statement for inserting into the account table
                    $stmt_insert_account = $conn->prepare("INSERT INTO account (User_ID, Email_Address, Password, Password_Plaintext, Status, Created) VALUES (?, ?, ?, 'active', ?)");
                    $stmt_insert_account->bind_param("ssss", $uuid, $Email, $Password, $plaintext_Password, $created);

                    // Execute the statement
                    if ($stmt_insert_account->execute()) {
                        $stmt_insert_account->close();

                        // Prepare the SQL statement for inserting into the user_informations table
                        $stmt_insert_user_info = $conn->prepare("INSERT INTO user_informations (User_ID, First_Name, Last_Name, Gender, Last_Login) VALUES (?, ?, ?, NULL, ?)");
                        $stmt_insert_user_info->bind_param("ssss", $uuid, $FirstName, $LastName, $created);

                        // Execute the statement
                        if ($stmt_insert_user_info->execute()) {
                            $stmt_insert_user_config = $conn->prepare("INSERT INTO user_settings (User_ID, Theme) VALUES (?, 'light')");
                            $stmt_insert_user_config->bind_param("s", $uuid);

                            if ($stmt_insert_user_config->execute()) {
                                // Commit the transaction if all statements are executed successfully
                                $conn->commit();
                                response(['isCreated' => true]);
                            } else {
                                // Rollback the transaction if there is an error
                                $conn->rollback();
                                response(['isCreated' => false]);
                            }
                            $stmt_insert_user_config->close();
                        } else {
                            // Rollback the transaction if there is an error
                            $conn->rollback();
                            response(['isCreated' => false]);
                        }
                        $stmt_insert_user_info->close();
                    } else {
                        // Rollback the transaction if there is an error
                        $conn->rollback();
                        response(['isCreated' => false]);
                    }
                } catch (Exception $e) {
                    // Rollback the transaction in case of an exception
                    $conn->rollback();
                    response(['isCreated' => false]);
                }
                break;
            default:
                response(['error' => 'Function not found']);
                break;
        }
    } else {
        response(['error' => 'Function name is not defined']);
    }
} catch (Exception $e) {
    response(['error' => $e->getMessage()]);
}
