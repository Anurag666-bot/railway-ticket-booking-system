<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Station</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('railway1.webp');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
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

<div class="container">
    <?php
    require "db.php";

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input: check if sname is set and not empty
        if (isset($_POST["sname"]) && !empty($_POST["sname"])) {
            // Prepare and bind the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO station (sname) VALUES (?)");
            $stmt->bind_param("s", $sname);

            // Set parameters
            $sname = $_POST["sname"];

            // Execute the statement
            if ($stmt->execute()) {
                echo "<p class='success'>Station '$sname' added successfully!</p>";
            } else {
                echo "<p class='error'>Error: " . $stmt->error . "</p>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<p class='error'>Station name is required!</p>";
        }
    }
    ?>

    <br>
    <a href="http://localhost/railway/admin_login.php">Go Back to Admin Menu</a>
</div>

</body>
</html>

