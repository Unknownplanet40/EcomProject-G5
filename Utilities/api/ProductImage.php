<?php

@require_once '../../Databases/API_Connection.php';

header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}

// php get method
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $UID = $_GET['prod_id'];

    $stmt = $conn->prepare("SELECT * FROM product_image WHERE UID = ?");
    $stmt->bind_param("s", $UID);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $img = 'data:image/jpeg;base64,' . base64_encode($row['Image_File']);
            $images[] = [
                'Img_Path' => $img,
                'order' => $row['Image_Order']
            ];
        }
        response($images);
    } else {
        response(['error' => 'No Image Found']);
    }
} else {
    response(['error' => 'Invalid Request Method']);
}