<?php
// Start the session
session_start();

// Function to destroy session and redirect to login page
function logoutAndRedirect() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "sign_up_info";

    // Create a connection
    $conn = new mysqli($servername, $db_username, $db_password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die ("Connection failed: " . $conn->connect_error);
    }

    // Retrieve username and password from the form
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Prepare a SQL statement to fetch user data based on the provided username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and verify the password
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        if (password_verify($input_password, $user_data["password"])) {
            // Authentication successful, set session variables
            $_SESSION["username"] = $input_username;
            $_SESSION["timestamp"] = time(); // Set initial timestamp

            // Redirect to the logged-in page
            header("Location: index.php");
            exit();
        } else {
            // Authentication failed (incorrect password)
            $error_message = "Incorrect password";
        }
    } else {
        // Authentication failed (user not found)
        $error_message = "User not found";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Check if the user is already logged in
if (isset($_SESSION["username"])) {
    // Check if the session timeout period has elapsed
    $timeout = 10800; // 3 hours in seconds
    if (isset($_SESSION["timestamp"]) && time() - $_SESSION["timestamp"] > $timeout) {
        // Session timeout, destroy the session and redirect to the login page
        logoutAndRedirect();
    } else {
        // Update the session timestamp to the current time
        $_SESSION["timestamp"] = time();
    }
}

// Close the session
session_write_close();