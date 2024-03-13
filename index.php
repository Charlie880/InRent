<?php
// Database connection parameters
$servername = "localhost"; // or your server IP address
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$database = "sign_up_info"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL statement to insert data into the table
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    // Check if the query executed successfully
    if ($conn->query($sql) === TRUE) {
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();