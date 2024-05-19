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
    $search = $_GET['search'];
    $search = '%' . $search . '%';
    $stmt = $conn->prepare("
    SELECT * FROM product 
    WHERE Prod_Name LIKE ? 
    OR Color LIKE ? 
    OR Brand LIKE ?");
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $products = [];

        while ($row = $result->fetch_assoc()) {
            // get product images
            $stmt_img = $conn->prepare("SELECT * FROM product_image WHERE UID = ? AND Image_Order = 1");
            $stmt_img->bind_param("i", $row['UID']);
            $stmt_img->execute();
            $result_img = $stmt_img->get_result();
            $images = [];
            while ($row_img = $result_img->fetch_assoc()) {
                $img = 'data:image/jpeg;base64,' . base64_encode($row_img['Image_File']);
                if ($row['UID'] == $row_img['UID']) {
                    $images[] = [
                        'Img_Path' => $img,
                    ];
                }
            }

            // get product sizes
            $stmt_size = $conn->prepare("SELECT * FROM product_size WHERE UID = ?");
            $stmt_size->bind_param("i", $row['UID']);
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


            $products[] = [
                'UID' => $row['UID'],
                'Prod_Name' => $row['Prod_Name'],
                'Prod_Brand' => $row['Brand'],
                'Prod_Color' => $row['Color'],
                'Prod_Price' => $row['Price'],
                'Prod_Images' => $images,
                'Prod_Sizes' => $sizes,
            ];
        }

        response($products);
    } else {
        response(['info' => $search . ' not found']);
    }
} else {
    response(['error' => 'Cannot process request']);
}


?>