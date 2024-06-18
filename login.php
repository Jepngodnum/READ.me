<?php
session_start(); // Start the session
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Password should be hashed

    // Validate form data
    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        exit();
    }

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

    // Prepare and execute SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to main page
            $_SESSION['email'] = $email;
            header("Location: main.html");
            exit();
        } else {
            // Incorrect password, redirect back with error
            header("Location: login.html?error=incorrectpassword");
            exit();
        }
    } else {
        // User not found, redirect back with error
        header("Location: login.html?error=usernotfound");
        exit();
    }


            // Display error messages if set in login.php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === "usernotfound") {
                    echo "<p class='error-message'>User not found. Please check your email address.</p>";
                } elseif ($error === "incorrectpassword") {
                    echo "<p class='error-message'>Incorrect password</p>";
                }
            }
       
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    if ($error === "usernotfound") {
                        echo "<p class='error-message'>User not found. Please check your email address.</p>";
                    } elseif ($error === "incorrectpassword") {
                        echo "<p class='error-message'>Incorrect password. Please try again.</p>";
                    } elseif ($error === "missingfields") {
                        echo "<p class='error-message'>Please fill in both email and password fields.</p>";
                    }
                }
            

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}


?>
