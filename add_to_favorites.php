<?php
session_start();
include 'config.php';

$response = array("status" => "", "message" => "");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $album_id = $data['album_id'];
    
    if (!isset($_SESSION['user_id'])) {
        $response['status'] = 'error';
        $response['message'] = 'User not logged in';
        echo json_encode($response);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO favorites (user_id, album_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $album_id);
    
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Album added to favorites';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to add album to favorites';
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
