# Legacy architecture

## 1. Current PHP structure

This project is a monolithic PHP application built around directly embedded HTML, MySQL queries, and session-based state. The core files are all at the project root and are mostly procedural scripts rather than a layered MVC framework.

### Entry points and responsibilities

- `index.htm`  
  Homepage and navigation entry point.

- `user_login.php`  
  Handles user login by checking `user.phone` and `user.password`. On success, it loads that user’s reservations and exposes cancellation controls.

- `admin_login.php`  
  Simple admin dashboard with fixed credentials (`uid=admin`, `password=admin`). After successful login, it renders links to management screens.

- `enquiry.php`  
  Search form to select start station, destination station, and journey date.

- `enquiry_result.php`  
  Runs the train availability query and presents matching routes/classes/fare/seat availability.

- `resvn.php`  
  Authenticates a user during booking, then creates a booking form for passenger names, ages, and genders.

- `new_png.php`  
  Performs fare calculation, inserts a row into `resv`, inserts passenger rows into `pd`, and shows booking confirmation.

- `cancel.php`  
  Cancels the reservation by updating `resv.status` to `CANCELLED` for the current user and PNR.

- `db.php`  
  Shared MySQL connection file. It establishes `mysqli` connection using localhost credentials and the `railway` database.

- `show_trains.php`, `show_users.php`, `insert_into_stations.php`  
  Admin listing and management pages.

- `insert_into_train_1.php` to `insert_into_train_4.php` and `insert_into_classseats_1.php` to `insert_into_classseats_4.php`  
  Multi-step forms used to add new train and class-seat data.

- `schedule.php`, `seat_plan.php`  
  Displays schedule details and seat availability for a train segment.

- `booked.php`, `cancelled.php`  
  Reads reservations by status for admin dashboards.

- `logout.php`  
  Destroys the PHP session and redirects to the homepage.

### Architectural characteristics

- No framework or service layer.
- Business logic is embedded directly in PHP pages.
- Database access is repeated across pages using raw SQL strings.
- HTML and CSS are embedded in the same files.
- Session state is used to pass data like `id`, `tno`, `class`, `nos`, `doj`, `sp`, `dp`.
- Flow is stateful and page-driven; many steps depend on prior session variables being set correctly.

## 2. Current authentication flow

### User authentication

1. User submits phone number and password from login form.
2. `user_login.php` reads `$_POST["phone"]` and `$_POST["password"]`.
3. It performs a query against `user` using the phone number.
4. If the user is not found, it prints `Wrong Combination!!!`.
5. If the password is incorrect, it prints `Wrong Combination!!!`.
6. On success, it stores `$_SESSION["id"]` and loads the user’s booking records from a join of `user` and `resv`.
7. The user can then cancel a reservation by entering a PNR.

Important limitation: passwords are compared in plain text as stored values and are not hashed or salted.

### Admin authentication

1. `admin_login.php` checks if `POST` contains `uid` and `password`.
2. It accepts only:
   - user id: `admin`
   - password: `admin`
3. If valid, it stores `$_SESSION["admin_login"] = true`.
4. The admin dashboard is displayed with links to train, station, and user management features.

This is a hard-coded authentication mechanism with no database-backed user management or role model.

## 3. Booking flow

1. User searches routes in `enquiry.php`.
2. `enquiry_result.php` queries `train`, `classseats`, `schedule` to find valid train segments for the selected stations and date.
3. User selects a train, class, and number of seats from the route results.
4. `resvn.php` verifies the person using phone + password, then creates a passenger form.
5. For each passenger, the script requests name, age, and gender.
6. `new_png.php`:
   - reads `$_SESSION` values such as `tno`, `doj`, `sp`, `dp`, `class`, `nos`, `id`
   - reads the fare from `classseats` for the selected train/segment/class/date
   - calculates fare by passenger age category
   - inserts the reservation into `resv`
   - inserts passenger details into `pd`
   - sets the reservation status to `BOOKED` via a DB trigger
   - decrements `classseats.seatsleft` through an `AFTER INSERT` trigger on `resv`
7. Confirmation is displayed, followed by a link to `process_payment.php`.

## 4. Cancellation flow

1. User enters a PNR on the login dashboard after authenticating.
2. `cancel.php` reads `$_POST["cancpnr"]` and `$_SESSION["id"]`.
3. It runs an update query:
   - `UPDATE resv SET status='CANCELLED' WHERE pnr=? AND id=?`
4. `resv` triggers enforce cancellation logic:
   - cancellation is not allowed if the journey date has passed
   - if cancellation is allowed, `classseats.seatsleft` is restored
   - refund is inserted into `canc` table based on days remaining before travel
5. The page returns a confirmation message and a home link.

## 5. Admin flow

1. Admin logs in using fixed credentials in `admin_login.php`.
2. Once authenticated, the dashboard provides links to:
   - show all stations
   - show all trains
   - show all users
   - add a new train
   - add train schedule/class-seat inventory
   - view booked tickets
   - view cancelled tickets
   - logout
3. `insert_into_train_*.php` and `insert_into_classseats_*.php` create train and inventory records using multi-step forms and session variables.
4. `show_users.php`, `booked.php`, and `cancelled.php` read from the database and print HTML tables.

## 6. Known limitations

- Hard-coded admin credentials.
- Passwords stored and compared in plain text.
- No email verification or account activation.
- No robust authorization checks beyond a single session flag.
- No CSRF protection.
- No input sanitization beyond a few ad hoc checks.
- Direct use of `$_GET` and `$_POST` values in SQL queries.
- No transaction boundaries around multi-step financial and booking actions.
- No API layer; all logic is tightly bound to HTML output.
- No modern error handling or logging.
- Limited seat logic: inventory is updated using database triggers, not service logic.
- The code is difficult to extend because routes are procedural and unrelated pages share session keys without a common contract.
- Date and time validation is inconsistent and spread across triggers and page logic.

## 7. Summary

This project works as a teaching project, not a production-grade reservation system. It demonstrates DBMS concepts, triggers, and page-centric PHP flow, but it lacks the security, modularity, and maintainability required for real-world deployment.
