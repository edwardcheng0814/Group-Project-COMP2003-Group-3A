<?php
// Start the session
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $servername = "localhost";
    $username = "Bird";
    $password = "123@Lvmh";
    $dbname = "bird";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the email address from the form
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate a new random password
        $new_password = bin2hex(random_bytes(8)); // Generate a random 8-byte string and convert it to hexadecimal

        // Update the user's password in the database
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password_hash, $email);
        $stmt->execute();

        // Send an email to the user with the new password
        $to = $email;
        $subject = "Password Reset - Birdhub";
        $message = "Your new password is: " . $new_password;
        $headers = "From: Birdhub <noreply@birdhub.com>\r\n";
        $headers .= "Content-type: text/plain\r\n";

        if (mail($to, $subject, $message, $headers)) {
            // Display a success message
            $_SESSION['message'] = "Your new password has been sent to your email address.";
        } else {
            // Display an error message
            $_SESSION['error'] = "Failed to send email. Please try again later.";
        }
    } else {
        // Display an error message
        $_SESSION['error'] = "Email address not found.";
    }

    $conn->close();
}

// Redirect back to the forgot password page
header("Location: forget_password.php");
exit();
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Forgot Password - Birdhub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        type="text/css" />
    <style>
        body {
            -moz-font-feature-settings: "liga" on;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            font-feature-settings: "liga" on;
            text-rendering: optimizeLegibility;
            background-image: url("background.JPG");
            background-size: cover;
        }

        /* Set navbar to transparent */
        .navbar {
            background-color: transparent !important;
        }

        /* Move navbar links to right */
        .navbar-nav {
            margin-left: auto;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Make navbar links bold */
        .navbar-nav .nav-link {
            font-weight: bold;
        }

        /* Footer styles */
        .footer {
            background-color: black;
            color: white;
            padding: 40px 0;
            margin-top: 50px;
        }

        .footer a {
            color: white;
        }

        .footer a:hover {
            color: #ccc;
        }

        .footer .list-inline-item:not(:last-child) {
            margin-right: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-lightbg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="Homepage.html"><i class="fas fa-dove"></i> Birdhub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="Submit.html">Submit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Tracking.html">Tracking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="MyeBird.html">My eBird</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Help.html">Help</a>
                    </li>
                </ul>
                <div class="ms-3">
                    <a href="login.html" class="btn btn-primary me-2">Sign In</a>
                    <a href="signup.html" class="btn btn-outline-primary">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Forgot Password</h2>
                <form action="reset_password.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">
                        Reset Password
                    </button>
            </div>
        </div>
    </div>

    <!-- Footer-->
    <div class="footer wf-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a class="navbar-brand" href="Homepage.html"><i class="fas fa-dove"></i> Birdhub</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <p class="text-muted">
                        &copy; 2023 BirdHub Inc, All rights reserved.
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline text-md-end">
                        <li class="list-inline-item">
                            <a href="Homepage.html" class="text-decoration-none">Home</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="Submit.html" class="text-decoration-none">Submit</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="MyeBird.html" class="text-decoration-none">MyeBirds</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="Help.html" class="text-decoration-none">Help</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        type="text/javascript"></script>
    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/e62b5e12dd.js" crossorigin="anonymous"></script>
</body>

</html>