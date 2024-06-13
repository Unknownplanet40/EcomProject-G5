<?php
// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

@require_once '../../Databases/DB_Configurations.php';

if (isset($_SESSION['User_ID'])) {
    $user_id = $_SESSION['User_ID'];

    $stmt = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // User Configuration
        $stmt_Uconfig = $conn->prepare("SELECT * FROM user_settings WHERE User_ID = ?");
        $stmt_Uconfig->bind_param("s", $user_id);
        $stmt_Uconfig->execute();
        $result_Uconfig = $stmt_Uconfig->get_result();
        $Uconfig_Data = [];

        if ($result_Uconfig->num_rows > 0) {
            $row_Uconfig = $result_Uconfig->fetch_assoc();

            if ($row_Uconfig['User_ID'] == $user_id) {
                $Uconfig_Data = [
                    'Theme' => $row_Uconfig['Theme'],
                ];
            }
        }

        $stmt_Uconfig->close();

        $stmt_email = $conn->prepare("SELECT * FROM account WHERE User_ID = ?");
        $stmt_email->bind_param("s", $user_id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        $email = 'Undefined';

        if ($result_email->num_rows > 0) {
            $row_email = $result_email->fetch_assoc();

            if ($row_email['User_ID'] == $user_id) {
                $email = $row_email['Email_Address'];
            }
        }

        $stmt_email->close();
        $stmt->close();

        $stmt_profile = $conn->prepare("SELECT * FROM user_profile WHERE User_ID = ?");
        $stmt_profile->bind_param("s", $user_id);
        $stmt_profile->execute();
        $result_profile = $stmt_profile->get_result();
        $profile = 'Undefined';

        if ($result_profile->num_rows > 0) {
            $row_profile = $result_profile->fetch_assoc();
            $profile = base64_encode($row_profile['Image_File']);
            $profile_type = $row_profile['Image_Type'];
            $profile = 'data:image/' . $profile_type . ';base64,' . base64_encode($row_profile['Image_File']);
            $profile_available = true;
        } else {
            $profile = null;
            $profile_available = false;
        }

        $data = [
            'user_ID' => $row['User_ID'],
            'First_Name' => $row['First_Name'],
            'Last_Name' => $row['Last_Name'],
            'Email' => $email,
            'Role' => $row['Role'],
            'HaveAddress' => $row['Have_Address'],
            'Is_user_logged_in' => $row['Is_user_logged_in'],
            'Last_Login' => $row['Last_Login'],
            'User_Settings' => $Uconfig_Data,
            'Has_Profile' => $profile_available,
            'Profile' => $profile,
        ];
        // clear session
        session_destroy();
        // set session
        session_start();
        // set session data
        $_SESSION['User_Data'] = $data;
        // redirect to the previous page
        header('Location: ../../Components/Home/Homepage.php');
    } else {
        session_destroy();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    session_destroy();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>