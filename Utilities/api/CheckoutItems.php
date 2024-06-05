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
    if (isset($_GET['UserID'])) {
        $UserID = $_GET['UserID'];

        global $conn;

        $stmt_cart = $conn->prepare("SELECT * FROM user_shoppingcart WHERE User_ID = ? AND Status IS NULL");
        $stmt_cart->bind_param("s", $UserID);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();

        if ($result_cart->num_rows > 0) {
            $cart_items = [];
            while ($row_cart = $result_cart->fetch_assoc()) {
                $Prod_ID = $row_cart['UID'];

                // Fetch product details
                $stmt_prod = $conn->prepare("SELECT Prod_Name, Brand, Color, Price FROM product WHERE UID = ?");
                $stmt_prod->bind_param("s", $Prod_ID);
                $stmt_prod->execute();
                $result_prod = $stmt_prod->get_result();
                $Prod_Details = $result_prod->fetch_assoc();
                $stmt_prod->close();
                $result_prod->close();

                // Fetch product images
                $stmt_img = $conn->prepare("SELECT Image_File FROM product_image WHERE UID = ? AND Image_Order = 1");
                $stmt_img->bind_param("s", $Prod_ID);
                $stmt_img->execute();
                $result_img = $stmt_img->get_result();
                $images = [];
                while ($row_img = $result_img->fetch_assoc()) {
                    $img = 'data:image/jpeg;base64,' . base64_encode($row_img['Image_File']);
                    $images[] = ['Img_Path' => $img];
                }
                $stmt_img->close();
                $result_img->close();

                $stmt_size = $conn->prepare("SELECT * FROM product_size WHERE UID = ?");
                $stmt_size->bind_param("s", $Prod_ID);
                $stmt_size->execute();
                $result_size = $stmt_size->get_result();
                $sizes = [];
                while ($row_size = $result_size->fetch_assoc()) {
                    $sizes[] = [
                        'S' => $row_size['S_Qty'],
                        'M' => $row_size['M_Qty'],
                        'L' => $row_size['L_Qty'],
                        'XL' => $row_size['XL_Qty'],
                    ];
                }
                $stmt_size->close();
                $result_size->close();

                $cart_items[] = [
                    'Prod_ID' => $Prod_ID,
                    'Ordered_Qty' => $row_cart['Quantity'],
                    'Ordered_Size' => $row_cart['Size'],
                    'UUID' => $row_cart['UUID'], // 'UUID' is the unique identifier for the cart item, not 'UID
                    'Prod_Details' => $Prod_Details,
                    'Images' => $images,
                    'Sizes' => $sizes,
                ];
            }
            $stmt_cart->close();
            $result_cart->close();
            response($cart_items);
        } else {
            response(['error' => 'No items in cart']);
        }
    } else {
        response(['error' => 'Invalid Request']);
    }
} catch (Throwable $th) {
    response(['error' => $th->getMessage()]);
}
