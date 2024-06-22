<!-- process_signup.php -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];

    // Hash the password (use a secure hashing algorithm like bcrypt in production)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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

    // Insert driver data into the 'drivers' table
    $sql = "INSERT INTO drivers (username, password, email, phone_number)
            VALUES ('$username', '$hashed_password', '$email', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}

?>
