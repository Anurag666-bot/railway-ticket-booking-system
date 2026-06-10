<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login and Reservation Details</title>
    <style>
        body {
            background-image: url(Nepal_Railway1.jpg);
            height: 100vh; /* Use the full height of the viewport */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: white;
        }
        .container {
            display: flex;
            justify-content: center; /* Horizontally center content */
            align-items: center; /* Vertically center content */
            height: 100vh; /* Use the full height of the viewport */
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
            max-width: 500px; /* Set maximum width of the form */
            width: 90%; /* Adjust width */
        }
        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Include padding and border in the element's total width */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid white;
        }
        th {
            background-color: #007bff;
        }
        a {
            color: white;
            text-decoration: none;
            display: block;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <?php
        session_start();
        require "db.php";

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $phone = $_POST["phone"];
        $password = $_POST["password"];

        $query = mysqli_query($conn, "SELECT * FROM user WHERE user.phone='$phone' AND user.password='$password'") or die(mysqli_error($conn));

        if (mysqli_num_rows($query) == 0) {
            echo "Wrong Combination!!! <br><br>";
            echo "<a href='index.htm'>Home Page</a><br>";
            die();
        }

        $temp1 = "";
        $temp2 = "";

        if ($row = mysqli_fetch_array($query)) {
            echo "Welcome ";
            $temp1 = $row['email'];
            $temp2 = $row['id'];
            echo "$temp1<br><br>";

            $query2 = mysqli_query($conn, "SELECT * FROM user ,resv WHERE user.id=resv.id AND user.phone=$phone") or die(mysqli_error($conn));

            echo "<table><thead><tr><th>PNR</th><th>Train No</th><th>Date of Journey</th><th>Total Fare</th><th>Train Class</th><th>Seats Reserved</th><th>Status</th></tr></thead>";

            while ($row = mysqli_fetch_array($query2)) {
                echo "<tr><td>".$row["pnr"]."</td><td>".$row["trainno"]."</td><td>".$row["doj"]."</td><td>".$row["tfare"]."</td><td>".$row["class"]."</td><td>".$row["nos"]."</td><td>".$row["status"]."</td></tr>";
            }

            echo "</table>";

            if (mysqli_num_rows($query2) == 0) {
                echo "No Reservations Yet !!! <br><br>";
            }
        }

        $_SESSION["id"] = $temp2;
        ?>

        <form action="cancel.php" method="post">
            Enter PNR for Cancellation: <input type="text" name="cancpnr" required><br><br>
            <input type="submit" value="Cancel"><br><br>
        </form>

        <a href="index.htm">Home Page</a>
    </div>
</div>

<?php
$conn->close();
?>
</body>
</html>
