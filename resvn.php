<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-image: url('railway5.jpeg');
            height: 100vh; /* vh: viewport height */
            margin: 0; /* Remove default margin */
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        form {
            background-color: rgba(255, 255, 255, 0.8); /* semi-transparent white */
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            display: block;
            margin-top: 10px;
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

function redirect($url) {
    echo "<script>window.location.href='$url';</script>";
    exit();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if (!isset($_POST["phone"]) || !isset($_POST["password"])) {
    redirect("http://localhost/railway/enquiry_result.php");
}

$phone = $_POST["phone"];
$password = $_POST["password"];

$query = $conn->prepare("SELECT * FROM user WHERE phone=? AND password=?");
$query->bind_param("ss", $phone, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo ($result->num_rows === 0) ? "Phone number does not exist!" : "Incorrect password!";
    echo "<br><br><a href=\"http://localhost/railway/enquiry_result.php\">Go Back</a>";
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
$_SESSION["id"] = $row['id'];
$_SESSION["tno"] = $_POST["tno"];
$_SESSION["class"] = $_POST["class"];
$_SESSION["nos"] = $_POST["nos"];

$conn->close(); 
?>

<form action="new_png.php" method="post">
    <?php 
    for ($i = 0; $i < $_SESSION["nos"]; $i++) {
        echo "<input type='text' name='pname[]' placeholder=\"Passenger Name\" required><br>";
        echo "<input type='text' name='page[]' placeholder=\"Passenger Age\" required><br>";
        echo "<input type='text' name='pgender[]' placeholder=\"Passenger Gender\" required><br>";
    }
    ?>
    <a href="http://localhost/railway/enquiry.php">Back to Enquiry</a><br><br>
    <input type="submit" value="Book">
</form>

</body>
</html>
