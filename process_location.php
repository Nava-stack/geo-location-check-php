<?php

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$driverId = $_POST['driver_id'];

// Store location data in the database (MySQL)
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for your local environment
$dbname = "cartaxitest1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Store location data in the database
$sql = "INSERT INTO vehicle_locations (driver_id, latitude, longitude, timestamp) VALUES ('$driverId', '$latitude', '$longitude', NOW())";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Location data stored successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error storing location data']);
}

$conn->close();

?>