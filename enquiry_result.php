<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Enquiry</title>
    <style>
        body {
            background-image: url(Nepal_Railway1.jpg);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            padding: 20px;
            margin: 0 auto;
            max-width: 1000px;
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
            color: white;
        }
        .form-container {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            margin: 0 auto;
        }
        input[type="text"], input[type="password"], input[type="submit"] {
            width: calc(100% - 16px);
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
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

<?php 
session_start();
require "db.php";

$doj = $_POST["doj"];
$_SESSION["doj"] = "$doj";
$sp = $_POST["sp"];
$_SESSION["sp"] = "$sp";
$dp = $_POST["dp"];
$_SESSION["dp"] = "$dp";

$query = mysqli_query($conn,"SELECT t.trainno, t.tname, c.sp, s1.departure_time, c.dp, s2.arrival_time, t.dd, c.class, c.fare, c.seatsleft FROM train AS t, classseats AS c, schedule AS s1, schedule AS s2 WHERE s1.trainno=t.trainno AND s2.trainno=t.trainno AND s1.sname='".$sp."' AND s2.sname='".$dp."' AND t.trainno=c.trainno AND c.sp='".$sp."' AND c.dp='".$dp."' AND c.doj='".$doj."' ");

echo "<div class='container'>";
echo "<table>";
echo "<thead><tr><th>Train No</th><th>Train Name</th><th>Starting Point</th><th>Departure Time</th><th>Destination Point</th><th>Arrival Time</th><th>Day</th><th>Train Class</th><th>Fare</th><th>Seats Left</th></tr></thead>";

while($row = mysqli_fetch_array($query))
{
 echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[8]."</td><td>".$row[9]."</td></tr>";
}
echo "</table>";

if(mysqli_num_rows($query) == 0)
{
 echo "No such train <br>";
}
?>
        <div class="form-container">
            <p>If you wish to proceed with booking, fill in the following details:</p>
            <form action="resvn.php" method="post">
                <input type="text" name="phone" placeholder="phone" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="tno" placeholder="Train No" required>
                <input type="text" name="class" placeholder="Class" required>
                <input type="text" name="nos" placeholder="No. of Seats" required>
                <input type="submit" value="Proceed">
            </form>
        </div>
        <div class="footer">
            <a href="http://localhost/railway/enquiry.php">More Enquiry</a> | 
            <a href="http://localhost/railway/index.htm">Home</a>
        </div>
    </div>
</body>
</html>
