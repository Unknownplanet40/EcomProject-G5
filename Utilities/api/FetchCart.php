<?php
session_start();
// Set local timezone
date_default_timezone_set('Asia/Manila');

@require_once '../../Databases/API_Connection.php';

header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}


try {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $user_id = $_GET['user_id'];

        // Fetch cart items
        $stmt = $conn->prepare("SELECT * FROM user_shoppingcart WHERE User_ID = ? AND Status IS NULL");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cart_items = [];
            while ($row = $result->fetch_assoc()) {
                // Fetch product details
                $stmt_prod = $conn->prepare("SELECT * FROM product WHERE UID= ?");
                $stmt_prod->bind_param("s", $row['UID']);
                $stmt_prod->execute();
                $result_prod = $stmt_prod->get_result();

                if ($result_prod->num_rows > 0) {
                    $prod_Details = [];
                    while ($row_prod = $result_prod->fetch_assoc()) {
                        if ($row_prod['UID'] == $row['UID']){
                            $prod_Details = [
                                'Prod_Name' => $row_prod['Prod_Name'],
                                'Prod_Price' => $row_prod['Price'],
                                'prod_Brand' => $row_prod['Brand'],
                                'Prod_Color' => $row_prod['Color'],
                            ];
                        }
                    }
                }

                $stmt_Img = $conn->prepare("SELECT * FROM product_image WHERE UID= ? AND Image_Order = 1");
                $stmt_Img->bind_param("s", $row['UID']);
                $stmt_Img->execute();
                $result_Img = $stmt_Img->get_result();

                if ($result_Img->num_rows > 0) {
                    $prod_Img = [];
                    while ($prod_img = $result_Img->fetch_assoc()) {
                        $img = 'data:image/jpeg;base64,' . base64_encode($prod_img['Image_File']);
                        if ($row['UID'] == $prod_img['UID']) {
                            $prod_Img = [
                                'Image' => $img,
                            ];
                        }
                    }
                }
                $cart_items[] = [
                    'Prod_ID' => $row['UID'],
                    'Item_size' => $row['Size'],
                    'Item_Qty' => $row['Quantity'],
                    'prod_Details' => $prod_Details,
                    'prod_Img' => $prod_Img,
                ];

                // TODO: if the product is same name, size, and quantity, combine them
            }
            response(['status' => 'success', 'cart_items' => $cart_items]);
        } else {
            response(['status' => 'error', 'message' => 'No items in cart']);
        }


    } else {
        response(['info' => 'Invalid request method']);
    }
} catch (\Throwable $th) {
    response(['error' => $th->getMessage()]);
}