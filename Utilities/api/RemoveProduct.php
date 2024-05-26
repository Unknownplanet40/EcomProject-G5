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
    if (isset($_GET['UID'])) {
        $UID = $_GET['UID'];

        $stmt = $conn->prepare("UPDATE product SET Status = 1 WHERE UID = ?");
        $stmt->bind_param("s", $UID);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            response(['success' => 'Product has been Moved to Archive']);
        } else {
            response(['error' => 'Could not Archive Product']);
        }
        $stmt->close();
    } else {
        response(['error' => 'Invalid Request Data']);
    }
} catch (\Throwable $th) {
    response(['error' => 'An error occurred']);
}
