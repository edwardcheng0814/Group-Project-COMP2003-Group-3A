<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Bird Pictures - Birdhub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"
        type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>



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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .swiper-container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .swiper-slide img {
            width: 100%;
            height: auto;
        }

        .card {
            border-radius: 0;
        }

        .card img {
            max-width: 100% !important;
            max-height: 100% !important;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <header>
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
    </header>

    <?php

    $host = "localhost";
    $username_db = "Bird";
    $password_db = "123@Lvmh";
    $database = "bird";

    // Connect to the MySQL database
    $conn = new mysqli($host, $username_db, $password_db, $database);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the database to retrieve the bird data
    $sql = "SELECT * FROM birdform_db";
    $result = $conn->query($sql);

    // Check for query errors
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Fetch the bird data as an associative array
    $birds = array();
    while ($row = $result->fetch_assoc()) {
        $birds[] = $row;
    }

    // Close the database connection
    $conn->close();

    ?>

    <div class="feature-card">
        <div class="row row-cols-2 g-4">
            <?php foreach ($birds as $bird): ?>
                <div class="col">
                    <div class="card" style="width: 700px">
                        <?php
                        // Connect to the database
                        $servername = "localhost";
                        $username = "Bird";
                        $password = "123@Lvmh";
                        $dbname = "bird";
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Retrieve the binary data from the database
                        $sql = "SELECT image, sound FROM birdform_db WHERE name = '" . $bird["name"] . "'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $image_data = $row["image"];
                        $sound_data = $row["sound"];

                        // Encode the binary data in Base64 format
                        $base64_image = base64_encode($image_data);
                        $base64_sound = base64_encode($sound_data);

                        // Output the binary data as data URIs
                        echo '<img src="data:image/jpeg;base64,' . $base64_image . '" alt="' . $bird["name"] . '" width="400" height="400" />';
                        ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $bird["name"]; ?>
                            </h5>
                            <p class="card-text">Family:
                                <?php echo $bird["family"]; ?>
                            </p>
                            <p class="card-text">Description:
                                <?php echo $bird["description"]; ?>
                            </p>
                            <p class="card-text">Location:
                                <?php echo $bird["location"]; ?>
                            </p>
                            <p class="card-text">Date:
                                <?php echo $bird["date"]; ?>
                            </p>
                            <?php if (!empty($bird["sound"])) {
                                echo '<audio controls>';
                                echo '<source src="data:audio/mp3;base64,' . $base64_sound . '" type="audio/mp3">';
                                echo '</audio>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="footer wf-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <a class="navbar-brand" href="Homepage.html"><i class="fas fa-dove"></i> Birdhub</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
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