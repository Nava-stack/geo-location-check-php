<!-- dashboard.php -->

<?php
session_start();

// Check if the driver is logged in
if (!isset($_SESSION['driver_id'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit();
}

$driver_id = $_SESSION['driver_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Driver Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Driver Dashboard</h1>
    
    <div id="map"></div>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        // Display location on the map (you can use a map library like Google Maps)
                        updateMap(latitude, longitude);

                        // Send location to the server
                        sendLocationToServer(latitude, longitude);
                    },
                    (error) => {
                        console.error("Error getting location:", error.message);
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function updateMap(latitude, longitude) {
            // Implement map update logic here (e.g., using Google Maps API)
            // This is just a placeholder
            document.getElementById('map').innerText = `Latitude: ${latitude}\nLongitude: ${longitude}`;
        }

        function sendLocationToServer(latitude, longitude) {
            // Use AJAX or other methods to send the location data to your server
            // For simplicity, you can use the fetch API
            fetch('process_location.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude,
                    driver_id: <?php echo $driver_id; ?>,
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Location data sent successfully:', data);
            })
            .catch(error => {
                console.error('Error sending location data:', error);
            });
        }

        // Initial fetch on page load
        getLocation();

        // Refresh the location every 10 seconds (adjust as needed)
        setInterval(() => {
            getLocation();
        }, 10000);
    </script>
</body>
</html>
