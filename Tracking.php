<?php
// Retrieve the address, date and bird family from the AJAX request
$address = $_GET["address"];
$date = $_GET["date"];
$family = $_GET["family"];

// Connect to the database
$servername = "localhost";
$username = "Bird";
$password = "123@Lvmh";
$dbname = "bird";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize response object
$response = array();

// Use Google Maps Geocoding API to get the latitude and longitude of the address
$geocode_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&AIzaSyA3C2EFmxoNp8lAaCL06bO6uFqgICaCp5A>";
$geocode_data = json_decode(file_get_contents($geocode_url), true);

if ($geocode_data['status'] == 'OK') {
    $latitude = $geocode_data['results'][0]['geometry']['location']['lat'];
    $longitude = $geocode_data['results'][0]['geometry']['location']['lng'];

    //Prepare the SQL query to retrieve the sightings based on latitude and longitude
    $stmt = $conn->prepare("SELECT family, location FROM birdform_db WHERE latitude = ? AND longitude = ? AND date = ? AND family = ?");
    $stmt->bind_param("ddss", $latitude, $longitude, $date, $family);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare the response object
    if ($result->num_rows > 0) {
        $response["status"] = "OK";
        $response["sightings"] = array();

        // Loop through each sighting and add it to the response object
        while ($row = $result->fetch_assoc()) {
            $sighting = array(
                "family" => $row["family"],
                "location" => $row["location"]
            );
            array_push($response["sightings"], $sighting);
        }
    } else {
        // No sightings found
        $response["status"] = "NOT_FOUND";
    }
} else {
    // Geocoding API error
    $response["status"] = "GEOCODING_ERROR";
}

// Return the response object as JSON
echo json_encode($response);

// Close the database connection
$stmt->close();
$conn->close();
?>