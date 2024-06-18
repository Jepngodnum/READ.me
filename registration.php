<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Password to be hashed
    $confirm_password = $_POST['confirm_password'];
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($age)) {
        die("All fields are required.");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Connect to your database (replace these with your actual database credentials)
    $servername = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $dbname = 'weekdays';

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO registration (username, email, password, age) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $bind = $stmt->bind_param("sssi", $username, $email, $hashed_password, $age);
    if ($bind === false) {
        die("Bind failed: " . $stmt->error);
    }

    $execute = $stmt->execute();
    if ($execute === false) {
        die("Execute failed: " . $stmt->error);
    } else {
        echo "New record created successfully.<br>";
    }
    header("Location: login.html");
        exit();
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
