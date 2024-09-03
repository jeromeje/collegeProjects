<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials for demonstration
    $valid_username = "admin";
    $valid_password = "password";

    // Validate credentials
    if ($username === $valid_username && $password === $valid_password) {
        echo "Login successful!";
        // Redirect to another page or start a session, etc.
        // header("Location: dashboard.php");
        // exit;
    } else {
        echo "Invalid username or password!";
    }
} else {
    echo "Invalid request method.";
}
?>
