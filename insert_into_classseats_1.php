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

    <form action="insert_into_classseats_2.php" method="post">
        <header>
            <h1>Add Train Schedule</h1>
        </header>

        <div class="form-group">
            <label for="tno">Select a Train:</label>
            <select id="tno" name="tno" required>
                <option value="" disabled selected>train</option>

                <?php
                require "db.php";
                $query = "SELECT * FROM train";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $tno = $row['trainno'];
                    $tn = $row['tname'] . " starting at " . $row['sp'];
                    echo "<option value=\"$tno\">$tn</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
              <label for="sp">Starting Point:</label>
             <input type="text" id="sp" name="sp" required>
        </div>

        <div class="form-group">
            <label for="doj">Date Of Journey:</label>
            <input type="date" id="doj" name="doj" required>
        </div>

        <div class="form-group">
            <label for="class">Class Name:</label>
            <input type="text" id="class" name="class" required>
        </div>

        <div class="form-group">
            <label for="fps">Fare per Seat:</label>
            <input type="text" id="fps" name="fps" required>
        </div>

        <div class="form-group">
            <label for="seatsleft">Total Seats:</label>
            <input type="text" id="seatsleft" name="seatsleft" required>
        </div>

        <div class="form-group">
            <button type="submit">Add Train Schedule</button>
        </div>
    </form>

</body>
</html>
