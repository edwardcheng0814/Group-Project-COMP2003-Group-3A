<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Sign Up - Birdhub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
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

        .message {
            font-weight: bold;
            padding: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
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

    <?php

    $servername = "localhost";
    $username = "Bird";
    $password = "123@Lvmh";
    $dbname = "bird";

    // Create a connection to the MySQL database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email or username is already in use
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User with the same email or username already exists
            // Display an error message
            echo "Error: The email or username is already in use. Please choose a different one.";

        } else {
            // If the email and username are available, insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            // Execute the SQL statement
            if ($stmt->execute()) {
                echo "User created successfully!";
            } else {
                echo "Error creating user: " . $conn->error;
            }

            // Close the statement
            $stmt->close();
        }
    }

    // Close the database connection
    $conn->close();
    ?>



    <!-- Sign-up form -->
    <div class="container mt-5">
        <form action="signup.php" method="POST">
            <h2 class="mb-4">Sign Up</h2>
            <div class="mb-3">
                <label for="username" class="form-label">Name</label>
                <input type="text" class="form-control" id="username" name="username" required />
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer wf-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a class="navbar-brand" href="#"><i class="fas fa-dove"></i> Birdhub</a>
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

    <script>
        function checkPassword() {
            var password = document.getElementById("password").value;

            // Define the regular expression pattern to match the password criteria
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{12,}$/;

            // Check if the password matches the pattern
            if (!pattern.test(password)) {
                alert(
                    "Password must be at least 12 characters long and include uppercase and lowercase letters, numbers, and symbols."
                );
                return false;
            }

            return true;
        }
    </script>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        type="text/javascript"></script>
    <!-- Font Awesome icons -->
    <script src="https://kit.fontawesome.com/e62b5e12dd.js" crossorigin="anonymous"></script>
</body>

</html>