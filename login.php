<!-- login.php -->

<?php
session_start();

// Check if the driver is already logged in, redirect to dashboard if true
if (isset($_SESSION['driver_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection details
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "cartaxitest1";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve driver data from the 'drivers' table
    $sql = "SELECT driver_id, username, password FROM drivers WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session and redirect to dashboard
            $_SESSION['driver_id'] = $row['driver_id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = "Invalid password";
        }
    } else {
        $error_message = "Driver not found";
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Driver Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h1>Driver Login</h1>
    
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
