<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('railwayset.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .message {
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .message p {
            margin: 0;
        }
        .btn-container {
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 0 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Reservation Details</h1>
    <div class="message <?php echo isset($error) ? 'error' : (isset($success) ? 'success' : ''); ?>">
        <?php 
        session_start();
        require "db.php";

        $tno = $_SESSION["tno"];
        $doj = $_SESSION["doj"];
        $sp = trim($_SESSION["sp"]); // Trim to remove leading/trailing spaces
        $dp = trim($_SESSION["dp"]); // Trim to remove leading/trailing spaces
        $class = $_SESSION["class"];

        $query = "SELECT fare FROM classseats WHERE trainno='$tno' AND class='$class' AND doj='$doj' AND sp='$sp' AND dp='$dp'";
        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_array($result);
        $fare = $row[0];

        $pname = $_POST["pname"];
        $page = $_POST["page"];
        $pgender = $_POST["pgender"];

        $tempfare = 0;
        $temp = 0;

        for ($i = 0; $i < count($page); $i++) {
            if ($page[$i] >= 18) {
                $temp++;
                $tempfare += $fare;
            } elseif ($page[$i] < 18 || $page[$i] >= 60) {
                $tempfare += 0.5 * $fare;
            }
        }

        if ($temp == 0) {
            $error = "At least one adult must accompany!!!";
        } else {
            $success = "Total fare is Rs." . $tempfare . "/-";
            $sql = "INSERT INTO resv(id,trainno,sp,dp,doj,tfare,class,nos) VALUES ('".$_SESSION["id"]."','".$_SESSION["tno"]."','".$_SESSION["sp"]."','".$_SESSION["dp"]."','".$_SESSION["doj"]."','".$tempfare."','".$_SESSION["class"]."','".$_SESSION["nos"]."' )";

            if ($conn->query($sql) === TRUE) {
                $success .= "<br>Reservation Successful";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }

            $tid = $_SESSION["id"];
            $ttno = $_SESSION["tno"];
            $tdoj = $_SESSION["doj"];

            $query = "SELECT pnr FROM resv WHERE id='$tid' AND trainno='$ttno' AND doj='$tdoj'";
            $result = mysqli_query($conn, $query);

            $row = mysqli_fetch_array($result);
            $rpnr = $row['pnr'];

            for ($i = 0; $i < count($pname); $i++) {
                $sql = "INSERT INTO pd (pnr, pname, page, pgender) 
                        VALUES ('$rpnr', '{$pname[$i]}', '{$page[$i]}', '{$pgender[$i]}')";
                if (mysqli_query($conn, $sql)) {
                    $success .= "<br>Passenger details added!!!";
                } else {
                    $error = "Error: " . mysqli_error($conn);
                }
            }
        }

        echo isset($error) ? "<p class='error'>$error</p>" : (isset($success) ? "<p class='success'>$success</p>" : '');
        ?>
    </div>
    <div class="btn-container">
        <a href="http://localhost/railway/enquiry.php" class="btn">Back to Enquiry</a>
        <a href="http://localhost/railway/process_payment.php" class="btn">Payment Method</a>
    </div>
</div>

</body>
</html>
