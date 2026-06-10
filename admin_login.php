<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            background-image: url(Admin_Train.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif; /* Added font-family for better readability */
        }
        .container {
            max-width: 800px;
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1.2rem;
            margin: 1rem 0;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.3s ease;
            display: inline-block;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin: 5px;
        }

        a:hover {
            color: #45a049;
            background-color: #e0e0e0;
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 1rem;
        }

        .dashboard {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }

        .btn {
            font-size: 1.2rem;
            padding: 0.75rem 1.5rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .error-message {
            color: red;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // Start the session
    session_start();

    // Initialize error, uid, and password variables
    $error = '';
    $uid = '';
    $password = '';

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate user ID input
        if (empty(trim($_POST["uid"])) || empty(trim($_POST["password"]))) {
            $error = 'Please enter both User ID and Password.';
        } else {
            $uid = trim($_POST["uid"]);
            $password = trim($_POST["password"]);

            // Check credentials
            if ($uid != 'admin' || $password != 'admin') {
                $error = 'Invalid User ID or Password.';
            } else {
                // Set the admin_login session variable to true
                $_SESSION["admin_login"] = true;
            }
        }
    }

    // Display content based on the admin_login session variable
    if (isset($_SESSION["admin_login"]) && $_SESSION["admin_login"] === true) {
        echo '
        <div class="card dashboard">
            <div class="card-header text-center">
                <h1>Admin Dashboard</h1>
            </div>
            <div class="card-body">
                <div class="dashboard-links">
                    <a href="http://localhost/railway/insert_into_stations.php">Show All Stations</a>
                    <a href="http://localhost/railway/show_trains.php">Show All Trains</a>
                    <a href="http://localhost/railway/show_users.php">Show All Users</a>
                    <a href="http://localhost/railway/insert_into_train_3.php">Enter New Train</a>
                    <a href="http://localhost/railway/insert_into_classseats_3.php">Enter Train Schedule</a>
                    <a href="http://localhost/railway/booked.php">View all booked tickets</a>
                    <a href="http://localhost/railway/cancelled.php">View all cancelled tickets</a>
                </div>
            </div>
            <div class="card-footer">
                <div class="footer-links">
                    <a href="http://localhost/railway/logout.php" class="btn btn-danger">Logout</a>
                    <a href="http://localhost/railway/index.htm" class="btn btn-secondary">Home Page</a>
                </div>
            </div>
        </div>
        ';
    } else {
        // Display the login form
        echo '
        <div class="card login-box">
            <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                <h1>Admin Login</h1>
                <label for="uid">User ID:</label>
                <input type="text" name="uid" id="uid" value="' . htmlspecialchars($uid) . '">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <input type="submit" value="Login">
                <br><br>
                <a href="http://localhost/railway/index.htm"> Home Page!</a>
            </form>';

        // Display error message if there is an error
        if (!empty($error)) {
            echo '<div class="error-message">' . htmlspecialchars($error) . '</div>';
        }

        echo '</div>'; // Close login-box div
    }
    ?>
</div>
</body>
</html>
