<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Sign In - Birdhub</title>
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
    // Start a session
    session_start();

    // Check if the user is already logged in
    if (isset($_SESSION["username"])) {
        header("Location: Homepgage.html");
        exit;
    }

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the email and password from the form
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Query the MySQL database to check if the email and password are valid
        $servername = "localhost";
        $username = "Bird";
        $password_db = "123@Lvmh";
        $dbname = "bird";
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the user exists, store the username in the session and redirect to the dashboard
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION["username"] = $user["username"];
            header("Location: MyeBird.html");
            exit;
        } else {
            // If the user does not exist, display an error message
            $error = "Invalid email or password";
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    }
    ?>


    <!-- Main content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Sign In</h2>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">
                        Sign In
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="forget.html">Forgot Password?</a>
                </div>
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