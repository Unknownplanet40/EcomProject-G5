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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $requiredFields = ['UID', 'Prod_Name', 'Price', 'Brand', 'Color', 'S', 'M', 'L', 'XL'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field])) {
                response(['error' => 'Invalid Request Data']);
            }
        }

        $UID = $_POST['UID'];
        $Prod_Name = $_POST['Prod_Name'];
        $Price = (float)$_POST['Price'];
        $Brand = $_POST['Brand'];
        $Color = $_POST['Color'];
        $S = (int)$_POST['S'];
        $M = (int)$_POST['M'];
        $L = (int)$_POST['L'];
        $XL = (int)$_POST['XL'];

        // Ensure the database connection is established
        if ($conn->connect_error) {
            response(['error' => 'Database connection failed: ' . $conn->connect_error]);
        }

        // Begin transaction
        $conn->begin_transaction();

        // Update Product
        $stmt_Product = $conn->prepare("UPDATE product SET Prod_Name = ?, Color = ?, Brand = ?, Price = ? WHERE UID = ?");
        if (!$stmt_Product) {
            $conn->rollback();
            response(['error' => 'Failed to prepare product statement: ' . $conn->error]);
        }
        $stmt_Product->bind_param("sssds", $Prod_Name, $Color, $Brand, $Price, $UID);
        $stmt_Product->execute();

        if ($stmt_Product->affected_rows < 1) {
            $conn->rollback();
            $stmt_Product->close();
            response(['error' => 'Failed to update product: No rows affected']);
        }

        // Check if the size record exists and get current values
        $stmt_CheckSize = $conn->prepare("SELECT S_Qty, M_Qty, L_Qty, XL_Qty FROM product_size WHERE UID = ?");
        if (!$stmt_CheckSize) {
            $conn->rollback();
            response(['error' => 'Failed to prepare check size statement: ' . $conn->error]);
        }
        $stmt_CheckSize->bind_param("s", $UID);
        $stmt_CheckSize->execute();
        $result = $stmt_CheckSize->get_result();
        if ($result->num_rows == 0) {
            $conn->rollback();
            response(['error' => 'UID does not exist in product_size table']);
        }
        $currentSizes = $result->fetch_assoc();
        $stmt_CheckSize->close();

        // Only update size if values are different
        if ($currentSizes['S_Qty'] != $S || $currentSizes['M_Qty'] != $M || $currentSizes['L_Qty'] != $L || $currentSizes['XL_Qty'] != $XL) {
            $stmt_Size = $conn->prepare("UPDATE product_size SET S_Qty = ?, M_Qty = ?, L_Qty = ?, XL_Qty = ? WHERE UID = ?");
            if (!$stmt_Size) {
                $conn->rollback();
                response(['error' => 'Failed to prepare size statement: ' . $conn->error]);
            }

            $stmt_Size->bind_param("iiiis", $S, $M, $L, $XL, $UID);
            $stmt_Size->execute();

            if ($stmt_Size->affected_rows < 1) {
                $conn->rollback();
                $stmt_Size->close();
                $stmt_Product->close();
                $conn->close();
                response(['error' => 'Failed to update size: No rows affected']);
            }
            $stmt_Size->close();
        }

        // Commit transaction
        $conn->commit();

        // Close statements and connection
        $stmt_Product->close();
        $conn->close();

        response(['success' => 'Product updated successfully']);
    } else {
        response(['error' => 'Invalid Request Method']);
    }
} catch (Exception $e) {
    if (isset($conn) && $conn->connect_errno == 0) {
        $conn->rollback();
        $conn->close();
    }
    response(['error' => 'An error occurred: ' . $e->getMessage()]);
}
