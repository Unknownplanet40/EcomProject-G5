<?php

@require_once '../../Databases/API_Connection.php';

header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}

try {
    if (isset($_GET['id'])) {
        $UID = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM product WHERE UID = ?");
        $stmt->bind_param("s", $UID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt_img = $conn->prepare("SELECT * FROM product_image WHERE UID = ?");
            $stmt_img->bind_param("s", $UID);
            $stmt_img->execute();
            $result_img = $stmt_img->get_result();
            $images = [];
            while ($row_img = $result_img->fetch_assoc()) {
                $img = 'data:image/jpeg;base64,' . base64_encode($row_img['Image_File']);
                if ($row['UID'] == $row_img['UID']) {
                    $images[] = [
                        'Img_Path' => $img,
                        'Order' => $row_img['Image_Order'],
                    ];
                }
            }

            $stmt_size = $conn->prepare("SELECT * FROM product_size WHERE UID = ?");
            $stmt_size->bind_param("s", $UID);
            $stmt_size->execute();
            $result_size = $stmt_size->get_result();
            $sizes = [];
            while ($row_size = $result_size->fetch_assoc()) {
                if ($row['UID'] == $row_size['UID']) {
                    $sizes[] = [
                        'S' => $row_size['S_Qty'],
                        'M' => $row_size['M_Qty'],
                        'L' => $row_size['L_Qty'],
                        'XL' => $row_size['XL_Qty'],
                    ];
                }
            }

            $response = [
                'UID' => $row['UID'],
                'Prod_Name' => $row['Prod_Name'],
                'Brand' => $row['Brand'],
                'Color' => $row['Color'],
                'Price' => $row['Price'],
                'Images' => $images,
                'Sizes' => $sizes,
            ];

            response($response);
        } else {
            response(['error' => 'Product not found']);
        }
    } else {
        response(['error' => 'Invalid Request']);
    }
} catch (\Throwable $th) {
    response(['error' => 'Error: ' . $th->getMessage()]);
}
