<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weekdays";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $email, $age);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>