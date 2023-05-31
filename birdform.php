<?php
// Start the session
session_start();


$host = 'localhost';
$username = 'Bird';
$password = '123@Lvmh';
$dbname = 'bird';

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Insert the submitted bird information into the "birdform_db" table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = NULL;
    $name = $_POST['name'];
    $family = $_POST['family'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = $_POST['date'];

    // Check if the uploaded file is a picture
    if ($_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/png') {
        $_SESSION['error'] = 'Invalid file type for image. Only JPEG and PNG files are allowed.';
        header('Location: Submit.html');
        exit();
    } else {
        // Get the uploaded image file
        if ($_FILES['image']['size'] > 0) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            $_SESSION['error'] = 'No image file selected.';
            header('Location: Submit.html');
            exit();
        }
    }

    // Check if the uploaded file is a sound file
    if ($_FILES['sound']['type'] != 'audio/mpeg' && $_FILES['sound']['type'] != 'audio/wav') {
        $_SESSION['error'] = 'Invalid file type for sound. Only MP3 and WAV files are allowed.';
        header('Location: Submit.html');
        exit();
    } else {
        // Get the uploaded sound file
        if ($_FILES['sound']['size'] > 0) {
            $sound = file_get_contents($_FILES['sound']['tmp_name']);
        } else {
            $_SESSION['error'] = 'No sound file selected.';
            header('Location: Submit.html');
            exit();
        }
    }

    // Prepare the SQL statement to insert the bird data (including the image and sound as BLOB data)
    $stmt = $pdo->prepare("INSERT INTO birdform_db (id, name, family, description, image, sound, location, date) VALUES (:id, :name, :family, :description, :image, :sound, :location, :date)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':family', $family);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image, PDO::PARAM_LOB);
    $stmt->bindParam(':sound', $sound, PDO::PARAM_LOB);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':date', $date);

    // Insert the data into the database and display a success or error message
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Data has been successfully inserted into the database.';
        header('Location: Submit.html');
        exit();
    } else {
        $_SESSION['error'] = 'Error inserting data into the database.';
        header('Location: Submit.html');
        exit();
    }
}
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Display the error or success message on the form page
if (isset($_SESSION['error'])) {
    echo '<p class="error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
} elseif (isset($_SESSION['success'])) {
    echo '<p class="success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}


?>