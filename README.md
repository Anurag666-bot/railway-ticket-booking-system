# 🚆 Railway Management System



Railway Management System is a DBMS-based web application developed as part of a BCA academic project. The system demonstrates real-world railway reservation workflows using PHP and MySQL.

It is built using **PHP, MySQL, HTML, and CSS** and runs on a local server environment like XAMPP.



---



## 📌 Features



* User registration and login system

* Train search and scheduling

* Seat booking and cancellation

* Admin panel for managing trains, stations, and users

* Database-driven CRUD operations

* Simple and responsive UI



---



## 🛠 Tech Stack



* Frontend: HTML, CSS, JavaScript

* Backend: PHP

* Database: MySQL

* Server: XAMPP / Apache



---



## ⚙️ Installation Guide



### 1. Install Requirements



* Install **XAMPP** (recommended) or any local PHP server

* Start **Apache** and **MySQL** from XAMPP Control Panel



---



### 2. Setup Database



1. Open phpMyAdmin (`http://localhost/phpmyadmin`)

2. Create a new database (example: `railway`)

3. Import the file:



   ```

   railway.sql

   ```



---



### 3. Configure Database Connection



Open `db.php` and update:



```php

$servername = "localhost";

$username = "your_mysql_username";

$password = "your_mysql_password";

$dbname = "railway";

```



---



### 4. Project Setup (XAMPP)



1. Move project folder to:



   ```

   C:\xampp\htdocs\railway

   ```

2. Ensure all project files are inside this folder



---



### 5. Run the Project



Open your browser and visit:



```

http://localhost/railway/index.htm

```



---



## 📁 Project Structure



* `/admin_login.php` - Admin login system

* `/user_login.php` - User login system

* `/schedule.php` - Train schedule

* `/resvn.php` - Ticket reservation

* `/cancel.php` - Ticket cancellation

* `/db.php` - Database connection file

* `/railway.sql` - Database schema



---



## ⚠️ Notes



* Make sure MySQL is running before starting the project

* Ensure database credentials in `db.php` are correct

* Use XAMPP for easiest local setup



---



## 👨‍💻 Author



Project developed as part of academic coursework (B.Tech DBMS Project).



---



## 📬 Support



If you face any issues while installing or running the project, feel free to ask for help.
