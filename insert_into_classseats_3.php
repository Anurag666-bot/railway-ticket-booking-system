<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('railway5.jpeg');
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 90%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        input[type="text"], input[type="date"], select {
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 90%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            margin-top: 20px;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            width: 100%;
            max-width: 800px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php
session_start();
require "db.php";

if ($_POST["tno"]) {
    $trainno = $_POST["tno"];
    $_SESSION["trainno"] = $trainno;
    $doj = $_POST["doj"];
    $_SESSION["doj"] = $doj;

    $cdquery = "SELECT * FROM train WHERE trainno='$trainno'";
    $cdresult = mysqli_query($conn, $cdquery);
    $cdrow = mysqli_fetch_array($cdresult);

    echo "<table><thead><tr><th>Train_no</th><th>Train_name</th><th>Starting_point</th><th>Starting_time</th><th>Destination_point</th><th>Destination_time</th><th>Day_of_arrival</th><th>Distance</th><th>Date_Of_Journey</th></tr></thead>";
    echo "<tr><td>" . $cdrow['trainno'] . "</td><td>" . $cdrow['tname'] . "</td><td>" . $cdrow['sp'] . "</td><td>" . $cdrow['st'] . "</td><td>" . $cdrow['dp'] . "</td><td>" . $cdrow['dt'] . "</td><td>" . $cdrow['doa'] . "</td><td>" . $cdrow['distance'] . "</td><td>" . $doj . "</td></tr></table>";

    $cdquery = "SELECT sname FROM schedule WHERE trainno='$trainno' ORDER BY distance ASC";
    $cdresult = mysqli_query($conn, $cdquery);
    $stations = array();
    $i = 0;
    while ($cdrow = mysqli_fetch_array($cdresult)) {
        $stations[$i] = $cdrow["sname"];
        $i += 1;
    }

    $_SESSION["ns"] = $i - 1;
    $_SESSION["stations"] = $stations;

    echo "<form action=\"insert_into_classseats_4.php\" method=\"post\">";
    echo "<table><thead><tr><th>Starting Point</th><th>Destination Point</th><th>AC1 seats</th><th>AC1 Fare</th><th>AC2 seats</th><th>AC2 Fare</th><th>AC3 seats</th><th>AC3 Fare</th><th>CC seats</th><th>CC Fare</th><th>EC seats</th><th>EC Fare</th><th>SL seats</th><th>SL Fare</th></tr></thead>";

    for ($temp = 0; $temp < $_SESSION["ns"]; $temp++) {
        echo "<tr><td>" . $stations[$temp] . "</td>
        <td>" . $stations[$temp + 1] . "</td>
        <td><input type=\"text\" name=\"s1$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"f1$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"s2$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"f2$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"s3$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"f3$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"s4$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"f4$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"s5$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"f5$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"s6$temp\" value=\"0\" required></td>
        <td><input type=\"text\" name=\"f6$temp\" value=\"0\" required></td></tr>";
    }

    echo "</table><input type=\"submit\" value=\"Submit\"></form>";
} else {
    echo "<form action=\"insert_into_classseats_3.php\" method=\"post\">
    <table>
    <thead><tr><th>Train</th><th>Date Of Journey</th></tr></thead>
    <tr><td><select id=\"tno\" name=\"tno\" required>";

    $query = "SELECT * FROM train";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
        $tno = $row['trainno'];
        $tn = $row['tname'] . " starting at " . $row['sp'];
        echo "<option value=\"$tno\">$tn</option>";
    }

    echo "</select></td>
    <td><input type=\"date\" name=\"doj\" required></td></tr>
    </table>
    <input type=\"submit\" value=\"Enter Train Details\">
    </form>";
}

echo "<br><a href=\"http://localhost/railway/admin_login.php\">Go Back to Admin Menu</a>";
?>
</body>
</html>
