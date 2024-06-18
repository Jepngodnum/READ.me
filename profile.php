<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weekdays";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize user info
$registration = [];

header('Content-Type: application/json');

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT id, name, username, email, phone, avatar, age FROM registration WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($user_id, $name, $username, $email, $phone, $avatar, $age);
        if ($stmt->fetch()) {
            $registration = [
                'id' => $user_id,
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'phone' => $phone,
                'avatar' => $avatar,
                'age' => $age,
                'favorites' => []
            ];
        }
        $stmt->close();
    }

    // Fetch favorite albums
    $sql = "SELECT album_id FROM favorites WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($album_id);
        while ($stmt->fetch()) {
            // Here we just use album_id, replace this with actual album details retrieval if available
            $registration['favorites'][] = [
                'album_id' => $album_id,
                'title' => "Album title for ID $album_id", // Replace with actual album title
                'link' => "#", // Replace with actual album link
            ];
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user information
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];

    // Handle file upload
    $avatar_path = $registration['avatar'];
    if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $avatar_tmp_name = $_FILES['avatar']['tmp_name'];
        $avatar_name = basename($_FILES['avatar']['name']);
        $avatar_path = 'uploads/' . $avatar_name;

        if (!move_uploaded_file($avatar_tmp_name, $avatar_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload avatar']);
            exit();
        }
    }

    // Update user information in the database
    $sql = "UPDATE registration SET name=?, username=?, email=?, phone=?, avatar=?, age=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('sssssss', $name, $username, $email, $phone, $avatar_path, $age, $_SESSION['email']);
        if ($stmt->execute()) {
            // Update session email
            $_SESSION['email'] = $email;
            // Update avatar path in registration array
            $registration['avatar'] = $avatar_path;
            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully', 'data' => $registration]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating account: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error in preparing statement: ' . $conn->error]);
    }
    exit();
} else {
    echo json_encode($registration);
}

$conn->close();
?>
