<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('back.jpg');
      background-size: cover;
      background-position: center;
      margin: 0;
      padding: 0;
    }
    form {
      width: 300px;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
      background-color: #fff;
    }
    label {
      display: block;
      margin-top: 10px;
      font-size: 16px;
      font-weight: bold;
    }
    input[type="text"], input[type="number"] {
      width: calc(100% - 22px);
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
    }
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
    .card-image {
      width: 100%;
      margin-top: 20px;
      border-radius: 8px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 8px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .success-message {
      margin-top: 20px;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      text-align: center;
      border-radius: 5px;
    }
    .back-button {
      display: block;
      width: 100px;
      margin: 20px auto;
      padding: 10px;
      text-align: center;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .back-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <form method="post">
    <label for="bankName">Bank Name:</label>
    <input type="text" id="bankName" name="bankName" placeholder="Enter bank name" required>
    <label for="cardNumber">Card Number:</label>
    <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter your card number" required>
    <label for="cardHolderName">Cardholder Name:</label>
    <input type="text" id="cardHolderName" name="cardHolderName" placeholder="Enter cardholder name" required>
    <label for="expirationDate">Date:</label>
    <input type="text" id="Date" name="Date" placeholder="MM/YYYY" required>
    <label for="cvv">CVV:</label>
    <input type="text" id="cvv" name="cvv" placeholder="Enter CVV" required>
    <input type="submit" value="Confirm and Pay">
  </form>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bankName = $_POST["bankName"];
    $cardNumber = $_POST["cardNumber"];
    $cardHolderName = $_POST["cardHolderName"];
    $expirationDate = $_POST["expirationDate"];
    $cvv = $_POST["cvv"];
    ?>
    <table>
      <tr>
        <th>Bank Name</th>
        <th>Card Number</th>
        <th>Cardholder Name</th>
        <th>Expiration Date</th>
        <th>CVV</th>
      </tr>
      <tr>
        <td><?php echo $bankName; ?></td>
        <td><?php echo $cardNumber; ?></td>
        <td><?php echo $cardHolderName; ?></td>
        <td><?php echo $expirationDate; ?></td>
        <td><?php echo $cvv; ?></td>
      </tr>
    </table>
    <div class="success-message">Payment successful!</div>
  <?php } ?>
  <a href="http://localhost/railway/index.htm" class="back-button">Back</a>
</body>
</html>
