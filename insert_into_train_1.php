<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Train Schedule</title>
    <style>
        body {
            background-image: url('adminlogin.jpeg');
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Added */
        }

        h2 {
            color: #fff; /* Added */
            margin-bottom: 20px; /* Added */
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        input[type="text"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<h2>Enter New Train</h2> <!-- Added -->
<form action="insert_into_train_2.php" method="post">
    <label for="tname">Train Name:</label>
    <input type="text" id="tname" name="tname" required><br>

    <label for="sp">Starting Point:</label>
    <select id="sp" name="sp" required>
        <option value="">Select Starting Point</option>
        <?php
        require "db.php";
        $cdquery = "SELECT sname FROM station";
        $cdresult = mysqli_query($conn, $cdquery);
        while ($cdrow = mysqli_fetch_array($cdresult)) {
            $cdTitle = $cdrow['sname'];
            echo "<option value=\"$cdTitle\">$cdTitle</option>";
        }
        ?>
    </select><br>

    <label for="st">Starting Time:</label>
    <input type="time" id="st" name="st" required><br>

    <label for="dp">Destination Point:</label>
    <select id="dp" name="dp" required>
        <option value="">Select Destination Point</option>
        <?php
        $cdquery = "SELECT sname FROM station";
        $cdresult = mysqli_query($conn, $cdquery);
        while ($cdrow = mysqli_fetch_array($cdresult)) {
            $cdTitle = $cdrow['sname'];
            echo "<option value=\"$cdTitle\">$cdTitle</option>";
        }
        ?>
    </select><br>

    <label for="dt">Destination Time:</label>
    <input type="time" id="dt" name="dt" required><br>

    <label for="dd">Day of Arrival:</label>
    <input type="text" id="dd" name="dd" required><br>

    <input type="submit" value="Submit">
</form>
</body>
</html>
