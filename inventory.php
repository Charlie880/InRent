<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            padding: 20px 0;
            color: #333;
        }

        form {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: calc(100% - 20px); /* Adjusted width */
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            display: block; /* Changed to block */
            margin: 0 auto; /* Centering the button */
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <h2>Add New Item</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50"></textarea>

        <input type="submit" value="Submit">
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
        $username = "root"; // Enter your MySQL username
        $password = ""; // Enter your MySQL password
        $database = "sign_up_info"; // Enter your MySQL database name
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO items (name, model, price, quantity, image, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiss", $name, $model, $price, $quantity, $image, $description);

        // Set parameters and execute
        $name = $_POST['name'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];

        // Upload image
        $target_dir = "uploads/"; // Directory where uploaded images will be saved
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;

            // Check if data is inserted successfully
            if ($stmt->execute()) {
                echo "<p style='color: green;'>New record inserted successfully</p>";
                header("Location: inventory.php");
                exit();
            } else {
                echo "<p class='error'>Error: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

</body>

</html>
