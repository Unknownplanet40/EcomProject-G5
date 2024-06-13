<?php
session_start();
date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

if (!isset($_SESSION['User_Data'])) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

if ($_SESSION['User_Data']['Is_user_logged_in'] != 1) {
    response(['status' => 'error', 'message' => 'Unauthorized']);
}

try {
    // Check the request method
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['update'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (empty($data) || !isset($data['firstname']) || !isset($data['lastname']) || !isset($data['contact']) || !isset($data['email']) || !isset($data['gender'])) {
            response(['status' => 'error', 'message' => 'Invalid request']);
        }

        $user_ID = $_SESSION['User_Data']['user_ID'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $contact = $data['contact'];
        $email = $data['email'];
        $gender = $data['gender'];

        if ($gender == "Male") {
            $gender = 1;
        } else {
            $gender = 0;
        }

        $conn->begin_transaction();

        $stmt_update = $conn->prepare("UPDATE user_informations SET First_Name = ?, Last_Name = ?, Gender = ?, ContactInfo = ? WHERE User_ID = ?");
        $stmt_update->bind_param('sssss', $firstname, $lastname, $gender, $contact, $user_ID);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            $stmt_update->close();
            $stmt_email = $conn->prepare("Select Email_Address FROM account WHERE User_ID = ?");
            $stmt_email->bind_param('s', $user_ID);
            $stmt_email->execute();
            $stmt_email->store_result();

            if ($stmt_email->num_rows > 0) {
                $stmt_email->bind_result($Email_Address);
                $stmt_email->fetch();

                if ($Email_Address != $email) {
                    $stmt_email->close();
                    $stmt_check = $conn->prepare("SELECT * FROM account WHERE Email_Address = ?");
                    $stmt_check->bind_param('s', $email);
                    $stmt_check->execute();
                    $stmt_check->store_result();

                    if ($stmt_check->num_rows > 0) {
                        $conn->rollback();
                        response(['status' => 'info', 'message' => 'Email address already exists']);
                    } else {
                        $stmt_check->close();
                        $stmt_update_email = $conn->prepare("UPDATE account SET Email_Address = ? WHERE User_ID = ?");
                        $stmt_update_email->bind_param('ss', $email, $user_ID);
                        $stmt_update_email->execute();

                        if ($stmt_update_email->affected_rows > 0) {
                            $conn->commit();
                            response(['status' => 'success', 'message' => 'User information has been updated']);
                        } else {
                            $conn->rollback();
                            response(['status' => 'error', 'message' => 'Failed to update user information']);
                        }
                    }
                } else {
                    $conn->commit();
                    response(['status' => 'success', 'message' => 'User information has been updated']);
                }
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update user information']);
            }
        } else {
            $conn->rollback();
            response(['status' => 'error', 'message' => 'Failed to update user information']);
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['address'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (empty($data) || !isset($data['UserID']) || !isset($data['province']) || !isset($data['municipality']) || !isset($data['barangay']) || !isset($data['zipcode']) || !isset($data['houseno'])) {
            response(['status' => 'error', 'message' => 'Invalid request']);
        }

        $user_ID = $data['UserID'];
        $province = $data['province'];
        $municipality = $data['municipality'];
        $barangay = $data['barangay'];
        $zipcode = $data['zipcode'];
        $houseno = $data['houseno'];
        $landmark = $data['landmark'];

        if ($user_ID != $_SESSION['User_Data']['user_ID']) {
            response(['status' => 'error', 'message' => 'Unauthorized']);
        }

        if ($data['landmark'] == "") {
            $landmark = "N/A";
        }

        if ($_GET['address'] == "add") {
            $conn->begin_transaction();
            $stmt_insert_address = $conn->prepare("INSERT INTO user_addressinfo (User_ID, Province, Municipality, Barangay, HouseNo, zipcode, Landmark) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt_insert_address->bind_param('sssssss', $user_ID, $province, $municipality, $barangay, $houseno, $zipcode, $landmark);
            $stmt_insert_address->execute();

            if ($stmt_insert_address->affected_rows > 0) {
                $stmt_insert_address->close();
                // Update user_informations
                $stmt_update = $conn->prepare("UPDATE user_informations SET Have_Address = 1 WHERE User_ID = ?");
                $stmt_update->bind_param('s', $user_ID);
                $stmt_update->execute();

                if ($stmt_update->affected_rows > 0) {
                    $conn->commit();
                    response(['status' => 'success', 'message' => 'Address has been added']);
                } else {
                    $conn->rollback();
                    response(['status' => 'error', 'message' => 'Failed to add address']);
                }
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to add address']);
            }
        } else {
            $conn->begin_transaction();
            $stmt_update_address = $conn->prepare("UPDATE user_addressinfo SET Province = ?, Municipality = ?, Barangay = ?, HouseNo = ?, zipcode = ?, Landmark = ? WHERE User_ID = ?");
            $stmt_update_address->bind_param('sssssss', $province, $municipality, $barangay, $houseno, $zipcode, $landmark, $user_ID);
            $stmt_update_address->execute();

            if ($stmt_update_address->affected_rows > 0) {
                $stmt_update_address->close();
                $conn->commit();
                response(['status' => 'success', 'message' => 'Address has been updated']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update address']);
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['profile'])) {
        $user_ID = $_POST['UserID'];
        $image = $_FILES['image'];

        if (empty($user_ID) || empty($image)) {
            response(['status' => 'error', 'message' => 'Invalid request']);
        }

        if ($user_ID != $_SESSION['User_Data']['user_ID']) {
            response(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $imagecontent = file_get_contents($image['tmp_name']);
        $imagetype = pathinfo($image['name'], PATHINFO_EXTENSION);

        $stmt_check = $conn->prepare("SELECT * FROM user_profile WHERE User_ID = ? AND Current = 1");
        $stmt_check->bind_param('s', $user_ID);
        $stmt_check->execute();
        $stmt_check->store_result();

        $conn->begin_transaction();

        if ($stmt_check->num_rows > 0) {
            $stmt_check->close();
            $stmt_update = $conn->prepare("UPDATE user_profile SET Image_File = ?, Image_Type = ? WHERE User_ID = ? AND Current = 1");
            $stmt_update->send_long_data(0, $imagecontent);
            $stmt_update->bind_param('sss', $imagecontent, $imagetype, $user_ID);
            $stmt_update->execute();

            if ($stmt_update->affected_rows > 0) {
                $stmt_update->close();
                $conn->commit();
                response(['status' => 'success', 'message' => 'Profile picture has been updated']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update profile picture']);
            }
        } else {
            $stmt_check->close();
            $stmt_insert = $conn->prepare("INSERT INTO user_profile (User_ID, Image_File, Image_Type, Current) VALUES (?, ?, ?, 1)");
            $stmt_insert->send_long_data(1, $imagecontent);
            $stmt_insert->bind_param('sss', $user_ID, $imagecontent, $imagetype);
            $stmt_insert->execute();

            if ($stmt_insert->affected_rows > 0) {
                $stmt_insert->close();
                $conn->commit();
                response(['status' => 'success', 'message' => 'Profile picture has been updated']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update profile picture']);
            }
        }

    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['ewallet'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        if (empty($data) || !isset($data['UserID']) || !isset($data['payment']) || !isset($data['email']) || !isset($data['number'])) {
            response(['status' => 'error', 'message' => 'Invalid request']);
        }

        $user_ID = $data['UserID'];
        $payment = $data['payment'];
        $email = $data['email'];
        $number = $data['number'];


        if ($user_ID != $_SESSION['User_Data']['user_ID']) {
            response(['status' => 'error', 'message' => 'Unauthorized']);
        }

        switch ($payment) {
            case 'GCash':
            case 'Maya':
                $paymentmethod = 1;
                break;
            case 'Credit Card':
                $paymentmethod = 2;
                break;
            case 'Cash on Delivery':
                $paymentmethod = 3;
                break;
            default:
                $paymentmethod = 3;
                break;
        }

        $stmt_check_payment = $conn->prepare("SELECT * FROM user_onlinewallet WHERE User_ID = ?");
        $stmt_check_payment->bind_param('s', $user_ID);
        $stmt_check_payment->execute();
        $stmt_check_payment->store_result();

        $conn->begin_transaction();

        if ($stmt_check_payment->num_rows > 0) {
            $stmt_check_payment->close();
            $stmt_update_payment = $conn->prepare("UPDATE user_onlinewallet SET Wallet_Type = ?, Email_address = ?, Account_Number = ? WHERE User_ID = ?");
            $stmt_update_payment->bind_param('ssss', $payment, $email, $number, $user_ID);
            $stmt_update_payment->execute();

            if ($stmt_update_payment->affected_rows > 0) {
                $stmt_update_payment->close();
                $conn->commit();
                response(['status' => 'success', 'message' => 'Payment method has been updated']);
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update payment method']);
            }
        } else {
            $stmt_check_payment->close();
            $stmt_insert_payment = $conn->prepare("INSERT INTO user_onlinewallet (User_ID, Wallet_Type, Email_address, Account_Number) VALUES (?, ?, ?, ?)");
            $stmt_insert_payment->bind_param('ssss', $user_ID, $paymentmethod, $email, $number);
            $stmt_insert_payment->execute();

            if ($stmt_insert_payment->affected_rows > 0) {
                $stmt_insert_payment->close();

                $stmt_update_payment = $conn->prepare("UPDATE user_informations SET Paymentmethod = ? WHERE User_ID = ?");
                $stmt_update_payment->bind_param('is', $paymentmethod, $user_ID);
                $stmt_update_payment->execute();

                if ($stmt_update_payment->affected_rows > 0) {
                    $stmt_update_payment->close();
                    $conn->commit();
                    response(['status' => 'success', 'message' => 'Payment method has been updated']);
                } else {
                    $conn->rollback();
                    response(['status' => 'error', 'message' => 'Failed to update payment method']);
                }
            } else {
                $conn->rollback();
                response(['status' => 'error', 'message' => 'Failed to update payment method']);
            }
        }


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

        if (
            $result === false
        ) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $result->bind_param("s", $user_ID); // Assuming User_ID is an integer, adjust if it's not

        $result->execute();
        $result->store_result();
        $data = [];
        $details = [];

        if ($result->num_rows > 0) {
            $result->bind_result($Email_Address, $First_Name, $Last_Name, $Gender, $ContactInfo, $Have_Address, $Paymentmethod);
            $result->fetch();
            $result->close();

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
                $stmt_payment = $conn->prepare("SELECT * FROM user_onlinewallet WHERE User_ID = ?");
                $stmt_payment->bind_param('s', $user_ID);
                $stmt_payment->execute();
                $result_payment = $stmt_payment->get_result();
                $row_payment = $result_payment->fetch_assoc();
                if ($row_payment['Wallet_Type'] > 0) {
                    $Paymentmethod = $row_payment['Wallet_Type'];
                    $details = [
                        'Email_Address' => $row_payment['Email_address'],
                        'Account_Number' => $row_payment['Account_Number']
                    ];
                } else {
                    $Paymentmethod = 'none';
                }
                $stmt_payment->close();
            } else if ($Paymentmethod == 2) {
                $Paymentmethod = 'Credit Card';
            } else if ($Paymentmethod == 3) {
                $Paymentmethod = 'Cash on Delivery';
            } else {
                $Paymentmethod = 'none';
            }

            if ($Address) {
                $stmt_address = $conn->prepare("SELECT * FROM user_addressinfo WHERE User_ID = ?");
                $stmt_address->bind_param('s', $user_ID);
                $stmt_address->execute();
                $result_address = $stmt_address->get_result();
                $row_address = $result_address->fetch_assoc();
                $address_data = [
                    'Province' => $row_address['Province'],
                    'Municipality' => $row_address['Municipality'],
                    'Barangay' => $row_address['Barangay'],
                    'HouseNo' => $row_address['HouseNo'],
                    'Zipcode' => $row_address['zipcode'],
                    'Landmark' => $row_address['Landmark']
                ];
                $stmt_address->close();
            }

            $stmt_profile = $conn->prepare("SELECT Image_File, Image_Type FROM user_profile WHERE User_ID = ? AND Current = 1");
            $stmt_profile->bind_param('s', $user_ID);
            $stmt_profile->execute();
            $result_profile = $stmt_profile->get_result();

            if ($result_profile->num_rows > 0) {
                $row_profile = $result_profile->fetch_assoc();
                $profile = base64_encode($row_profile['Image_File']);
                $profile_type = $row_profile['Image_Type'];
                $profile = 'data:image/' . $profile_type . ';base64,' . base64_encode($row_profile['Image_File']);
                $profile_available = true;
                $stmt_profile->close();
            } else {
                $profile = null;
                $profile_available = false;
                $stmt_profile->close();
            }

            $data = [
                'Email_Address' => $Email_Address,
                'First_Name' => $First_Name,
                'Last_Name' => $Last_Name,
                'Gender' => $Gender,
                'ContactInfo' => $ContactInfo,
                'Have_Address' => $Address,
                'Address' => $address_data,
                'Have_Profile' => $profile_available,
                'Profile' => $profile,
                'Paymentmethod' => $Paymentmethod,
                'Payment_Details' => $details
            ];

            $_SESSION['User_Data']['Profile'] = $profile;
            $_SESSION['User_Data']['Has_Profile'] = $profile_available;

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
                response(['status' => 'valid', 'message' => 'New password has been set']);
            } else {
                response(['status' => 'invalid']);
            }
        } else {
            response(['status' => 'invalid', 'message' => 'Password is incorrect']);
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['email'])) {
        $stmt_get_Key = $conn->prepare("SELECT Credential FROM secret_keys WHERE Key_Name = 'SMTP_Pass'");
        $stmt_get_Key->execute();
        $result = $stmt_get_Key->get_result();
        $row = $result->fetch_assoc();
        $SMTP_Pass = $row['Credential'];
        $stmt_get_Key->close();


        $Email = $_GET['email'];
        $Email = strtolower($Email);
        $OTP = $_GET['code'];
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
        $mail->Subject = 'Verification Code';
        $mail->Body = '
        <html>
        <head>
            <style>
                .email-container {
                    font-family: Arial, sans-serif;
                    color: #333;
                    line-height: 1.5;
                }
                .email-header {
                    font-size: 18px;
                    font-weight: bold;
                }
                .email-body {
                    margin-top: 10px;
                    margin-bottom: 10px;
                }
                .email-footer {
                    margin-top: 20px;
                    font-size: 14px;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">Hello ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . ',</div>
                <div class="email-body">
                    Your verification code is: <strong>' . htmlspecialchars($OTP, ENT_QUOTES, 'UTF-8') . '</strong><br><br>
                    Please enter this code in the verification form to complete your registration.
                </div>
                <div class="email-footer">
                    Thank you!<br>
                    Your Company Team
                </div>
            </div>
        </body>
        </html>';

        // Plain text message
        $mail->AltBody = 'Hello ' . $name . ",\n\nYour verification code is: " . $OTP . "\n\nPlease enter this code in the verification form to complete your registration.\n\nThank you!\nYour Company Team";

        if ($mail->send()) {
            response(['status' => 'valid', 'code' => $OTP]);
        } else {
            response(['status' => 'invalid']);
        }
    } else {
        response(['status' => 'error', 'message' => 'Invalid request method']);
    }



} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'Something went wrong! (' . $th->getMessage() . ')']);
}