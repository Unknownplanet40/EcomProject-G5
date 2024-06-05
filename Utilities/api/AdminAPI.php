<?php

@require_once '../../Databases/API_Connection.php';

header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}


try {
    if (isset($_GET['ID'])) {
        $UID = $_GET['ID'];

        $stmt_tb1 = $conn->prepare("SELECT * FROM account WHERE User_ID = ?");
        $stmt_tb1->bind_param("s", $UID);
        $stmt_tb1->execute();
        $result_tb1 = $stmt_tb1->get_result();

        if ($result_tb1->num_rows > 0) {
            $row_tb1 = $result_tb1->fetch_assoc();

            // for User Informations
            $stmt_tb2 = $conn->prepare("SELECT * FROM user_informations WHERE User_ID = ?");
            $stmt_tb2->bind_param("s", $UID);
            $stmt_tb2->execute();
            $result_tb2 = $stmt_tb2->get_result();
            $row_tb2 = $result_tb2->fetch_assoc();
            $info = [];

            if ($result_tb2->num_rows > 0) {
                $info = [
                    'First_Name' => $row_tb2['First_Name'],
                    'Last_Name' => $row_tb2['Last_Name'],
                ];
            } else {
                $info = [
                    'First_Name' => '',
                    'Last_Name' => '',
                ];
            }

            // for User Address (if exists)
            $stmt_tb3 = $conn->prepare("SELECT * FROM user_addressinfo WHERE User_ID = ?");
            $stmt_tb3->bind_param("s", $UID);
            $stmt_tb3->execute();
            $result_tb3 = $stmt_tb3->get_result();
            $row_tb3 = $result_tb3->fetch_assoc();
            $address = [];

            if ($result_tb3->num_rows > 0) {
                $address = [
                    'Province' => $row_tb3['Province'],
                    'Municipality' => $row_tb3['Municipality'],
                    'Barangay' => $row_tb3['Barangay'],
                    'House_No' => $row_tb3['HouseNo'],
                    'Zip_Code' => $row_tb3['zipcode'],
                    'landmark' => $row_tb3['landmark'],
                ];
            } else {
                $address = [
                    'Province' => '',
                    'Municipality' => '',
                    'Barangay' => '',
                    'House_No' => '',
                    'Zip_Code' => '',
                    'landmark' => '',
                ];
            }

            $response = [
                'User_ID' => $row_tb1['User_ID'],
                'Email_Address' => $row_tb1['Email_Address'],
                'Password' => $row_tb1['Password'],
                'Plaintext' => $row_tb1['Password_Plaintext'],
                'Status' => $row_tb1['Status'],
                'Info' => $info,
                'Address' => $address,
            ];

            response([
                'status' => 'success',
                'data' => $response
            ]);
        } else {
            response([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
    }
} catch (\Throwable $th) {
    response([
        'status' => 'error',
        'message' => $th->getMessage()
    ]);
}
