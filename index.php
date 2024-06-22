<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>City Taxi Tracking</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin-top: 50px;
      }
    </style>
  </head>
  <body>
    <h1>City Taxi Tracking</h1>
    <button id="getLocationBtn">Get Location</button>

    <script>
      document
        .getElementById("getLocationBtn")
        .addEventListener("click", getLocation);

      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const latitude = position.coords.latitude;
              const longitude = position.coords.longitude;
              alert(`Latitude: ${latitude}\nLongitude: ${longitude}`);
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

      function sendLocationToServer(latitude, longitude) {
        // Use AJAX or other methods to send the location data to your server
        // For simplicity, you can use the fetch API
        fetch("process_location.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            latitude: latitude,
            longitude: longitude,
            driver_id: "123", // Replace with actual driver ID
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            console.log("Location data sent successfully:", data);
          })
          .catch((error) => {
            console.error("Error sending location data:", error);
          });
      }
    </script>
  </body>
</html>
