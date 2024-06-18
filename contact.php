<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $to = "weekdays135@gmail.com"; // Change this to your email address
    $subject = "Feedback from $name";
    $body = "From: $name\nEmail: $email\nMessage:\n$message";

    // Send email
    if (mail($to, $subject, $body)) {
        echo "Thank you for your feedback. We will get back to you soon!";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    // If it's not a POST request, return an error message
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed";
}
?>
