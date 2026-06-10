<?php
// Include the database connection logic
require "db.php"; // Assuming db.php contains the database connection logic

// Initialize variables with default values to avoid errors
$fullname = $email = $username = $phone = $password = $confirmpassword = $gender = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required form fields are set
    if(isset($_POST["fullname"], $_POST["email"], $_POST["username"], $_POST["phone"], $_POST["password"], $_POST["confirmpassword"], $_POST["gender"])) {
        // Sanitize and validate input data
        $fullname = htmlspecialchars($_POST["fullname"]);
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $password = htmlspecialchars($_POST["password"]);
        $confirmpassword = htmlspecialchars($_POST["confirmpassword"]);
        $gender = htmlspecialchars($_POST["gender"]);

        // Check if passwords match
        if ($password !== $confirmpassword) {
            echo "<div class='error-message'><b>Error:</b> Passwords do not match. <a href='http://localhost/railway/new_user_form.htm'>Go Back to Registration Form</a></div>";
            exit(); // Stop execution if passwords don't match
        }

        // Prepare and bind parameters to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user (fullname, email, username, phone, password, gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname, $email, $username, $phone, $password, $gender);

        // Execute the query
        if ($stmt->execute()) {
            echo "<div class='success-message'><b>New record created successfully.</b> <div class='click-here-box'><a href='http://localhost/railway/index.htm'>Click here</a></div> to browse through our website!</div>";
        } else {
            echo "<div class='error-message'><b>Error:</b> " . $stmt->error . ". <a href='http://localhost/railway/new_user_form.htm'>Go Back to Registration Form</a></div>";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<div class='error-message'><b>Error:</b> Some form fields are missing! <a href='http://localhost/railway/new_user_form.htm'>Go Back to Registration Form</a></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            background-image: url(New_User.jpg);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        form {
            margin: 0 auto;
            width: 400px; /* Increased width */
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: calc(100% - 20px); /* Adjusted width */
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-top: 5px;
            font-weight: bold;
        }
        .success-message {
            color: green;
            margin-top: 5px;
            font-weight: bold;
        }
        .click-here-box {
            border: 2px solid #4CAF50;
            border-radius: 5px;
            background-color: #e9f5ea; /* Light green background color */
            padding: 5px 10px;
            margin-top: 10px;
            display: inline-block;
        }
        .click-here-box a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmpassword").value;
            if (password !== confirmPassword) {
                document.getElementById("confirmpasswordError").innerText = "Passwords do not match";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
