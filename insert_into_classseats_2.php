<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Train Schedule</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('adminlogin.jpeg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh; /* Viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form container styles */
        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%; /* Ensure form fills container */
        }

        /* Form header styles */
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form group styles */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label styles */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Input styles */
        input[type="text"],
        input[type="date"],
        select {
            width: calc(100% - 16px); /* Subtract padding and borders */
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        /* Button styles */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50; /* Green */
            color: white;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049; /* Darker green */
        }

        /* Footer styles */
        footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php
require "db.php";

if(isset($_POST["tno"]) && isset($_POST["doj"]) && isset($_POST["class"]) && isset($_POST["fps"]) && isset($_POST["seatsleft"]) && isset($_POST["sp"]) && !empty($_POST["sp"])) {
    // Escape user inputs for security
    $trainno = $conn->real_escape_string($_POST["tno"]);
    $doj = $conn->real_escape_string($_POST["doj"]);
    $class = $conn->real_escape_string($_POST["class"]);
    $seatsleft = $conn->real_escape_string($_POST["seatsleft"]);
    $fare = $conn->real_escape_string($_POST["fps"]);
    $sp = $conn->real_escape_string($_POST["sp"]);

    // Check if the provided station name exists in the station table before insertion
    $stationExistsQuery = "SELECT COUNT(*) AS count FROM station WHERE sname = '$sp'";
    $stationExistsResult = $conn->query($stationExistsQuery);
    $stationExistsRow = $stationExistsResult->fetch_assoc();
    $stationExists = $stationExistsRow['count'];

    if ($stationExists > 0) {
        // If station exists, proceed with insertion
        $sql = "INSERT INTO classseats (trainno, doj, class, seatsleft, fare, sp) VALUES ('$trainno', '$doj', '$class', '$seatsleft', '$fare', '$sp')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>New record created successfully</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        // If station does not exist, display an error message
        echo "<p>Error: Station '$sp' does not exist. Please ensure the station name is valid.</p>";
    }
} else {
    // If any required field is missing, display an error message
    echo "<p>Error: Missing required fields. Please fill all the fields.</p>";
}
?>

<footer>
    <a href="http://localhost/railway/admin_login.php">Go Back to Admin Menu!!!</a>
</footer>

    <a href="http://localhost/railway/admin_login.php">Go Back to Admin Menu!!!</a>
</footer>

</body>
</html>
