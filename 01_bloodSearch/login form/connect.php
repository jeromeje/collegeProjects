<?php
// Start session to store user data after successful login
session_start();

// Database credentials
$servername = "localhost"; // Change if needed
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "your_database"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$userid = $password = "";
$useridErr = $passwordErr = "";

// Form submission and validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate userid
    if (empty($_POST["userid"])) {
        $useridErr = "User ID is required";
    } else {
        $userid = test_input($_POST["userid"]);
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    // If no validation errors, check the database for matching credentials
    if (empty($useridErr) && empty($passwordErr)) {
        // Prepare a SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE userid = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $stmt->store_result();

        // Check if a user exists with the provided userid
        if ($stmt->num_rows > 0) {
            // Bind the result variables
            $stmt->bind_result($user_id, $db_password);
            $stmt->fetch();

            // Verify the password (in a real application, use hashed passwords)
            if (password_verify($password, $db_password)) {
                // Store user ID in the session and redirect to content page
                $_SESSION["userid"] = $user_id;
                header("Location: content.php"); // Redirect to content page
                exit();
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User ID not found";
        }
        $stmt->close();
    } else {
        echo "<p>$useridErr</p>";
        echo "<p>$passwordErr</p>";
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();
?>



<!--

    CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userid VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL -- password should be hashed in a real system
); 

-->
