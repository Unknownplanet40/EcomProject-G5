<?php
// UpdateImage.php
@require_once '../../Databases/API_Connection.php';

header('Content-Type: application/json');

function response($data)
{
    echo json_encode($data);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check required POST fields
        $requiredFields = ['Prod_ID', 'Item_Name', 'Prod_Brand', 'Prod_Color', 'Prod_Price', 'Size_S', 'Size_M', 'Size_L', 'Size_XL'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field])) {
                response(['error' => 'Invalid Request Data']);
            }
        }

        // Check required FILE fields
        $requiredFiles = ['Img_1', 'Img_2', 'Img_3', 'Img_4'];
        foreach ($requiredFiles as $file) {
            if (!isset($_FILES[$file])) {
                response(['error' => 'Invalid Request Data']);
            }
        }

        // Sanitize and assign POST variables
        $Prod_ID = $_POST['Prod_ID'];
        $Item_Name = $_POST['Item_Name'];
        $Prod_Brand = $_POST['Prod_Brand'];
        $Prod_Color = $_POST['Prod_Color'];
        $Prod_Price = (float)$_POST['Prod_Price'];
        $Size_S = (int)$_POST['Size_S'];
        $Size_M = (int)$_POST['Size_M'];
        $Size_L = (int)$_POST['Size_L'];
        $Size_XL = (int)$_POST['Size_XL'];

        // Sanitize and assign FILE variables
        $Img_1 = $_FILES['Img_1'];
        $Img_2 = $_FILES['Img_2'];
        $Img_3 = $_FILES['Img_3'];
        $Img_4 = $_FILES['Img_4'];

        if ($conn->connect_error) {
            response(['error' => 'Database connection failed']);
        }

        // Begin transaction
        $conn->begin_transaction();

        // Product Insert
        $stmt_Product = $conn->prepare("INSERT INTO product (UID, Prod_Name, Color, Brand, Price) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_Product) {
            $conn->rollback();
            response(['error' => 'Failed to prepare product statement']);
        }
        $stmt_Product->bind_param("ssssd", $Prod_ID, $Item_Name, $Prod_Color, $Prod_Brand, $Prod_Price);
        $stmt_Product->execute();
        if ($stmt_Product->affected_rows < 1) {
            $conn->rollback();
            response(['error' => 'Failed to add product']);
        }

        // Size Insert
        $stmt_Size = $conn->prepare("INSERT INTO product_size (UID, S_Qty, M_Qty, L_Qty, XL_Qty) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_Size) {
            $conn->rollback();
            response(['error' => 'Failed to prepare size statement']);
        }
        $stmt_Size->bind_param("siiii", $Prod_ID, $Size_S, $Size_M, $Size_L, $Size_XL);
        $stmt_Size->execute();
        if ($stmt_Size->affected_rows < 1) {
            $conn->rollback();
            response(['error' => 'Failed to add product size']);
        }

        // Function to get file content safely
        function getFileContent($file)
        {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return false;
            }
            return file_get_contents($file['tmp_name']);
        }

        // Prepare the image data
        $images = [
            ['image' => getFileContent($Img_1), 'order' => 1],
            ['image' => getFileContent($Img_2), 'order' => 2],
            ['image' => getFileContent($Img_3), 'order' => 3],
            ['image' => getFileContent($Img_4), 'order' => 4],
        ];

        // Image Insert
        $stmt_Image = $conn->prepare("INSERT INTO product_image (UID, Image_File, Image_Order) VALUES (?, ?, ?)");
        if (!$stmt_Image) {
            $conn->rollback();
            response(['error' => 'Failed to prepare image statement']);
        }

        foreach ($images as $img) {
            if ($img['image'] === false) {
                $conn->rollback();
                response(['error' => 'Failed to read image ' . $img['order']]);
            }

            $imageContent = $img['image'];
            $imageOrder = $img['order'];
            $null = null; // Create a variable to be passed by reference

            $stmt_Image->bind_param("sbi", $Prod_ID, $null, $imageOrder); // Pass $null by reference
            $stmt_Image->send_long_data(1, $imageContent);
            $stmt_Image->execute();
            if ($stmt_Image->affected_rows < 1) {
                $conn->rollback();
                response(['error' => 'Failed to add product image ' . $imageOrder]);
            }
        }

        // Commit transaction
        $conn->commit();

        // Close statements and connection
        $stmt_Product->close();
        $stmt_Size->close();
        $stmt_Image->close();
        $conn->close();

        response(['success' => 'Product added successfully']);
    }
} catch (\Throwable $th) {
    // Rollback transaction if an error occurred
    $conn->rollback();
    response(['error' => 'An error occurred ' . $th->getMessage()]);
}
