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

try {
    if (isset($_GET['archive'])) {
        $stat = $_GET['archive'];
        $Brand = $_GET['brand'];
        
        if ($stat == 0) {
            $stmt = $conn->prepare("SELECT * FROM product WHERE Status = 1 AND Brand = ?");
            $stmt->bind_param("s", $Brand);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        'ID' => $row['UID'],
                        'Prod_Name' => $row['Prod_Name'],
                        'Brand' => $row['Brand'],
                        'Color' => $row['Color'],
                        'Price' => $row['Price'],
                        'Popularity' => $row['Popularity'],
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
            }

            response(['status' => 'success', 'message' => 'Account(s) restored successfully']);
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['delete'])) {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        $ID = $data['data'];
        $successresult = [];

        $conn->begin_transaction();

        foreach ($ID as $value) {
            $stmt = $conn->prepare("UPDATE product SET Status = 0 WHERE UID = ?");
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("SELECT Prod_Name FROM product WHERE UID = ?");
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            $successresult[] = $row['Prod_Name'];
        }
        
        $conn->commit();
        response(['status' => 'success', 'message' => 'Product(s) Removed successfully', 'data' => $successresult]);
    }
    else {
        response(['status' => 'error', 'message' => 'Invalid request']);
    }
} catch (\Throwable $th) {
    response(['status' => 'error', 'message' => 'An error occurred - (' . $th->getMessage() . ')']);
}
