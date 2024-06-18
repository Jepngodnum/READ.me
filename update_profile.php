<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.html");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];

    // Connect to your database (replace these with your actual database credentials)
    $servername = "localhost";
    $db_username = "root"; // Replace with your actual username
    $db_password = ""; // Replace with your actual password
    $dbname = "weekdays";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to update user profile
    $stmt = $conn->prepare("UPDATE registration SET username=?, name=?, email=?, phone=?, age=? WHERE email=?");
    $stmt->bind_param("ssssss", $username, $name, $email, $phone, $age, $_SESSION['email']);
    $stmt->execute();

    // Check if update was successful
    if ($stmt->affected_rows > 0) {
        echo "Profile updated successfully";
    } else {
        echo "Failed to update profile";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
