<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQ4TFwG8mN9VNCENp0Yg/81st9Hj" crossorigin="anonymous">
    <!-- Add custom CSS -->
    <style>
       body {
    background-color: #f8f9fa; /* Replaced green with a neutral color */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.container-box {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    max-width: 800px;
}

.card-header {
    background-color: #4CAF50; /* Changed to a new color */
    color: #ffffff;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.dashboard-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
}

.btn {
    font-size: 1.2rem;
    padding: 0.75rem 1.5rem;
    font-weight: bold;
}

.btn-primary {
    background-color: #007bff; /* Changed to a new color */
    border: none;
}

.btn-primary:hover {
    background-color: #45a049;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.footer-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
}


    </style>
</head>
<body>
    <div class="container-box">
        <div class="card-header text-center">
            <h1>Admin Dashboard</h1>
        </div>
        <div class="card-body">
            <div class="dashboard-links">
                <a href="http://localhost/railway/insert_into_stations.php" class="btn btn-primary">Show All Stations</a>
                <a href="http://localhost/railway/insert_into_train_1.php" class="btn btn-primary">Enter New Train</a>
                <a href="http://localhost/railway/insert_into_classseats_1.php" class="btn btn-primary">Enter Train Schedule</a>
                <a href="http://localhost/railway/booked.php" class="btn btn-primary">View all booked tickets</a>
                <a href="http://localhost/railway/cancelled.php" class="btn btn-primary">View all cancelled tickets</a>
            </div>
        </div>
        <div class="card-footer">
            <div class="footer-links">
                <a href="http://localhost/railway/logout.php" class="btn btn-danger">Logout</a>
                <a href="http://localhost/railway/index.htm" class="btn btn-secondary">Home Page</a>
            </div>
        </div>
    </div>
    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoJtKv1fQmSGAOjVETYsM2ZnQkduD8M-2RlTMOhUdzgIkvY" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWYuSj7l/0Ql9ZUlB/fX0GBIsSV1w9UtlZ7pimQD1jw01E5SgLZ8H3" crossorigin="anonymous"></script>
</body>
</html>
