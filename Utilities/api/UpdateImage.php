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
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if the necessary fields are present
        if (!isset($_POST['UID']) || !isset($_POST['Order']) || !isset($_FILES['Image'])) {
            response(['error' => 'Invalid Request Data']);
        }

        $UID = $_POST['UID'];
        $Order = $_POST['Order'];
        $Image = $_FILES['Image'];

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedSize = 1024 * 1024 * 5; // 5MB
        $fileExt = pathinfo($Image['name'], PATHINFO_EXTENSION);

        // Check if the file is an image
        if (!in_array($fileExt, $allowed)) {
            response(['error' => 'Invalid Image Format']);
        }

        // Check if the file is a valid image
        if (!in_array($Image['type'], $allowedMime)) {
            response(['error' => 'Invalid Image Type']);
        }

        // Check if the file size is within the allowed size
        if ($Image['size'] > $allowedSize) {
            response(['error' => 'Image Size is too large']);
        }

        // Read the image content from the temporary file location
        $imageContent = file_get_contents($Image['tmp_name']);

        $UpdateStmt = $conn->prepare("UPDATE product_image SET Image_File = ? WHERE UID = ? AND Image_Order = ?");
        $UpdateStmt->bind_param("bss", $null, $UID, $Order);
        $UpdateStmt->send_long_data(0, $imageContent);
        $UpdateStmt->execute();

        if ($UpdateStmt->affected_rows < 1) {
            response(['error' => 'Failed to update image']);
        } else {
            response(['success' => 'Image updated successfully']);
        }
    } else {
        response(['error' => 'Invalid Request']);
    }
} catch (\Throwable $th) {
    response(['error' => $th->getMessage()]);
}
