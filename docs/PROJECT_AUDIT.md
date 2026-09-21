# Railway Management System - Project Audit

## Current Architecture

The project follows a traditional LAMP stack architecture:
- **Backend**: PHP 5.5 (procedural MySQLi)
- **Database**: MySQL 5.5 (via phpMyAdmin)
- **Frontend**: HTML5, CSS3, JavaScript (minimal)
- **Web Server**: Apache/XAMPP
- **Architecture Pattern**: Monolithic, procedural PHP with embedded HTML

The application consists of standalone PHP files that handle both presentation and business logic. There is no MVC separation or framework usage.

## Existing Features

Based on code inspection, the system provides:

1. **User Management**
   - User registration (`new_user_form.php`, `new_user_form.html`)
   - User login (`user_login.php`, `user_login.htm`)
   - User profile/reservation viewing (after login)

2. **Authentication**
   - User authentication (phone/password)
   - Admin authentication (hardcoded credentials)

3. **Train & Station Management**
   - Train information (`train` table)
   - Station information (`station` table)
   - Train schedules (`schedule` table)
   - Train routes (starting point, destination point)

4. **Booking System**
   - Train search/enquiry (`enquiry.php`, `enquiry_result.php`)
   - Seat availability checking (`classseats` table)
   - Reservation creation (`resvn.php` → `new_png.php` → likely database insertion)
   - Booking confirmation

5. **Cancellation System**
   - Ticket cancellation (`cancel.php`)
   - Cancellation refund calculation (triggers in database)
   - Cancellation history (`cancelled.php`)

6. **Seat Management**
   - Seat allocation (`classseats` table with seatsleft)
   - Seat selection (implied via class and number of seats)

7. **Payment System**
   - Payment processing (`process_payment.php`)
   - Payment status tracking

8. **Admin Functions**
   - Admin dashboard (`admin_login.php`)
   - View all users (`show_users.php`)
   - View all trains (`show_trains.php`)
   - View booked tickets (`booked.php`)
   - View cancelled tickets (`cancelled.php`)
   - Add new stations (`insert_into_stations.php`)
   - Add new trains (series of insert_into_train_*.php)
   - Add train schedules (series of insert_into_classseats_*.php)

9. **Enquiry System**
   - General enquiry (`enquiry.php`)
   - Enquiry results (`enquiry_result.php`)

10. **Logout**
    - User/logout (`logout.php`)

## File Responsibility Map

| File/Pattern | Responsibility | Notes |
|--------------|----------------|-------|
| `index.htm` | Homepage with navigation | Entry point |
| `user_login.htm` / `user_login.php` | User login and reservation viewing | Combines auth and display |
| `admin_login.php` | Admin login and dashboard | Hardcoded credentials |
| `enquiry.php` | Train search form | GET/POST to enquiry_result.php |
| `enquiry_result.php` | Search results and booking form | Displays trains, collects booking info |
| `resvn.php` | User validation for booking | Validates user, collects passenger info |
| `new_png.php` | Likely passenger data insertion | Not reviewed but implied |
| `process_payment.php` | Payment processing | Not reviewed |
| `cancel.php` | Cancellation handling | PNR-based cancellation |
| `cancelled.php` | View cancelled tickets | Admin/user? |
| `booked.php` | View booked tickets | Admin/user? |
| `seat_plan.php` | Seat visualization | Not reviewed |
| `show_trains.php` | Display all trains | Admin function |
| `show_users.php` | Display all users | Admin function |
| `insert_into_station*.php` | Add station data | Admin functions |
| `insert_into_train*.php` | Add train data | Admin functions |
| `insert_into_classseats*.php` | Add class/seat/schedule data | Admin functions |
| `enquiry_result.php` | Search results |  |
| `db.php` | Database connection | Shared include |
| `logout.php` | Session destruction |  |
| `style.css` | Basic styling | Used across multiple pages |
| Various image files | UI assets | Backgrounds, icons |

## Database Schema Overview

### Tables

1. **`user`**
   - Stores user credentials and profile
   - Columns: id, fullname, email, username, phone, password, gender, dob
   - Constraints: Unique email, username, phone; Age >= 18 trigger

2. **`train`**
   - Train master data
   - Columns: trainno, tname, sp, st, dp, dt, dd, distance
   - Constraints: Proper timings, different sp/dp

3. **`station`**
   - Station list
   - Columns: id, sname

4. **`schedule`**
   - Train schedule details
   - Columns: id, trainno, sname, arrival_time, departure_time, distance

5. **`class`**
   - Travel classes (AC1, AC2, AC3, CC, EC, SL)

6. **`classseats`**
   - Seat inventory per train/journey/class
   - Columns: trainno, sp, dp, doj, class, fare, seatsleft
   - Constraints: Foreign keys to train, station; Triggers for validation

7. **`resv`** (reservations)
   - Booking records
   - Columns: pnr, id, trainno, sp, dp, doj, tfare, class, nos, status
   - Constraints: Foreign keys to train; Triggers for seat updates/cancellation

8. **`pd`** (passenger details)
   - Passenger information per booking
   - Columns: pnr, pname, page, pgender
   - Constraints: Gender M/F only

9. **`canc`** (cancellations)
   - Refund details for cancelled tickets
   - Columns: pnr, rfare

### Relationships

- `user` 1:N `resv` (via `id`)
- `train` 1:N `classseats` (via `trainno`)
- `train` 1:N `schedule` (via `trainno`)
- `train` 1:N `resv` (via `trainno`)
- `station` 1:N `classseats` (via `sp`, `dp`)
- `station` 1:N `schedule` (via `sname`)
- `resv` 1:N `pd` (via `pnr`)
- `resv` 1:N `canc` (via `pnr`) (on cancellation)

### Important Constraints

- Triggers enforce business rules:
  - No past date bookings/journeys
  - Positive fare and seats
  - Valid gender (M/F)
  - Age >= 18 for users
  - Proper train timings (arrival < departure)
  - Different source and destination
  - Seat availability checks
  - Automatic seat updates on booking/cancellation
  - Cancellation refund rules (full if >30 days, half if <30 days)

## Authentication Flow

### User Login
1. User submits phone and password via `user_login.php` form
2. `user_login.php`:
   - Starts session
   - Includes `db.php`
   - Queries: `SELECT * FROM user WHERE user.phone='$phone' AND user.password='$password'`
   - **Security Issue**: Direct string concatenation → SQL injection vulnerability
   - **Security Issue**: Plaintext password storage and comparison
   - If credentials match:
     - Sets `$_SESSION["id"]` = user id
     - Fetches and displays user's reservations
     - Shows cancellation form (Pnr input)
   - If fails: Shows error

### Admin Login
1. User submits uid and password via `admin_login.php` form
2. `admin_login.php`:
   - Starts session
   - If POST:
     - Validates non-empty uid/password
     - Checks if uid == 'admin' AND password == 'admin' (hardcoded)
   - If valid:
     - Sets `$_SESSION["admin_login"]` = true
     - Shows admin dashboard with links to management functions
   - If invalid: Shows error
   - If not logged in: Shows login form

### Session Management
- Sessions started with `session_start()` in relevant files
- User session stores `id` (from user table)
- Admin session stores `admin_login` boolean
- No session timeout or regeneration observed
- `logout.php` likely destroys session (not reviewed)

## Booking Flow

1. **Search**: User visits `enquiry.php` → selects source, destination, date → submits to `enquiry_result.php`
2. **Results**: `enquiry_result.php`:
   - Stores search params in session (`doj`, `sp`, `dp`)
   - Queries trains with available seats via join of train, classseats, schedule
   - Displays results in table
   - Shows booking form (phone, password, train no, class, nos)
3. **User Validation**: Form submits to `resvn.php`:
   - Validates user credentials (phone/password) using prepared statement (safer)
   - Stores user id, train no, class, nos in session
   - Redirects to `new_png.php` (passenger details form)
4. **Passenger Details**: `new_png.php` (not reviewed) likely:
   - Collects passenger names, ages, genders
   - Inserts into `pd` table
   - Calculates total fare
   - Inserts into `resv` table (trigger updates `classseats.seatsleft`)
   - Proceeds to payment
5. **Payment**: `process_payment.php` (not reviewed) likely:
   - Processes payment
   - Updates booking status
   - Shows confirmation

*Note: The exact insertion logic for reservations is not visible in the reviewed files but is implied by triggers and flow.*

## Cancellation Flow

1. User logs in via `user_login.php` (or accesses cancellation directly?)
2. Sees list of reservations with PNR
3. Enters PNR in cancellation form on `user_login.php` → submits to `cancel.php`
4. `cancel.php` (not reviewed) likely:
   - Validates PNR belongs to user (session check)
   - Updates `resv` status to 'CANCELLED'
   - Trigger `after_update_on_resv`:
     - If journey date > today and status = CANCELLED:
       - Adds seats back to `classseats.seatsleft`
       - If days until journey >= 30: inserts full fare into `canc`
       - If days until journey < 30: inserts half fare into `canc`
     - If journey date <= today: prevents cancellation
5. User sees cancellation result (not reviewed)

## Admin Flow

1. User accesses `admin_login.php`
2. Enters hardcoded credentials: uid='admin', password='admin'
3. If valid:
   - Sees admin dashboard with links to:
     - Show All Stations (`insert_into_stations.php`)
     - Show All Trains (`show_trains.php`)
     - Show All Users (`show_users.php`)
     - Enter New Train (`insert_into_train_3.php`)
     - Enter Train Schedule (`insert_into_classseats_3.php`)
     - View all booked tickets (`booked.php`)
     - View all cancelled tickets (`cancelled.php`)
4. Each admin function performs CRUD operations on respective tables
   - Example: `show_users.php` likely selects all from `user` table
   - Insert forms likely insert data after validation

## Security Findings

**Critical:**
1. **SQL Injection in User Login**: `user_login.php` uses string concatenation in SQL query:
   ```php
   $query = mysqli_query($conn, "SELECT * FROM user WHERE user.phone='$phone' AND user.password='$password'")
   ```
2. **Plaintext Passwords**: Passwords stored and compared in plaintext (visible in `user` table dump)
3. **Hardcoded Admin Credentials**: Admin login uses fixed username/password = 'admin'/'admin'
4. **Missing Input Validation**: Many forms lack proper validation (e.g., age format, phone format)
5. **Missing Output Escaping**: Echoing user data directly in HTML (e.g., in `user_login.php` when displaying email)
6. **Session Fixation Risk**: No session regeneration after login
7. **No HTTPS**: All links use HTTP (localhost) - in production would transmit credentials in plaintext
8. **Directory Listing**: Potential exposure of .git, .env, etc. if server misconfigured

**Medium:**
1. **Weak Password Policy**: No enforcement of strong passwords
2. **No Prepared Statements in All Queries**: Only `resvn.php` uses prepared statements; others use string concatenation
3. **Error Messages Revealing Information**: MySQL errors displayed via `die(mysqli_error($conn))`
4. **Missing CSRF Tokens**: Forms lack CSRF protection
5. **Insecure Direct Object References**: Cancellation uses PNR without verifying ownership in all contexts (need to check)

**Low:**
1. **Password Length**: Passwords appear to be short (e.g., 'anurag123')
2. **No Password Hashing**: Uses plaintext instead of `password_hash()`/`password_verify()`

## UI/UX Problems

1. **Inconsistent Styling**: Each page has its own CSS; no unified design system
2. **Poor Mobile Responsiveness**: Some pages use fixed widths; viewport meta tag present but not consistently implemented
3. **Confusing Navigation**: Multiple entry points (index.htm, user_login.htm, admin_login.php)
4. **Lack of User Feedback**: Limited use of success/error messages; reliance on browser alerts or plain text
5. **Poor Form Design**: Forms lack proper labeling, placeholders, validation hints
6. **Inconsistent Terminology**: Mix of "Enquiry", "Reservation", "Booking"
7. **No Loading States**: Submit buttons give no feedback during processing
8. **No Accessibility Features**: Missing ARIA labels, poor color contrast in some areas, no keyboard navigation focus
9. **Blurry Background Images**: Low-quality background images affect readability
10. **No Clear Hierarchy**: Important actions not visually prioritized

## Code-Quality Problems

1. **Duplication**: 
   - Database connection code repeated in every file (`require "db.php";` + connection check)
   - Station dropdown code duplicated in `enquiry.php`
   - Similar HTML/CSS structure across pages
2. **Mixed Concerns**: Presentation (HTML/CSS), business logic, and data access all mixed in PHP files
3. **Inconsistent Naming**: 
   - Files: `insert_into_station.php` vs `insert_into_stations.php`
   - Variables: mixedCase, snake_case
   - Database: table names abbreviated (`canc`, `pd`, `resv`)
4. **Magic Strings/Numbers**: Hardcoded values like 'admin', status strings ('BOOKED', 'CANCELLED')
5. **Deep Nesting**: Some logic nested deeply (e.g., triggers with multiple IFs)
6. **Lack of Comments**: Minimal code documentation
7. **Inconsistent Indentation**: Mix of tabs and spaces
8. **Global State**: Heavy reliance on `$_SESSION` and `$_POST` without sanitization
9. **Error Handling**: Primarily `die()` statements; no graceful degradation
10. **Hardcoded URLs**: Links use `http://localhost/railway/` making deployment inflexible

## Recommended Improvements

### Security (Priority High)
1. **Implement Prepared Statements Everywhere**: Replace all string concatenation queries with parameterized queries
2. **Hash Passwords**: Use `password_hash()` on registration and `password_verify()` on login
3. **Remove Hardcoded Credentials**: Store admin credentials in database with hashed password
4. **Input Validation & Sanitization**: Validate all inputs (type, length, format, range)
5. **Output Escaping**: Use `htmlspecialchars()` when outputting user data to HTML
6. **Implement CSRF Tokens**: Add tokens to all forms and validate on submission
7. **Secure Session Management**: Regenerate session ID after login, set reasonable timeout
8. **Error Handling**: Log errors internally; show generic messages to users
9. **File Permissions**: Ensure sensitive files are not web accessible

### Code Quality (Priority Medium)
1. **Create Common Functions**: 
   - Database query wrapper
   - Input validation library
   - Output escaping helpers
   - Session management
   - Redirect functions
2. **Separate Concerns**: 
   - Extract database logic into separate files
   - Consider template system for HTML (even simple PHP includes for header/footer)
   - Keep PHP at top of files, HTML below
3. **Eliminate Duplication**: 
   - Create reusable form elements (dropdowns, inputs)
   - Create common layout files
4. **Improve Naming**: 
   - Use consistent naming convention (e.g., snake_case for files/variables)
   - Use descriptive table/column names
5. **Add Comments**: Document complex logic, especially triggers and stored procedures
6. **Consistent Formatting**: Adopt PSR-12 or similar coding standard
7. **Configuration File**: Move database credentials and site URL to config file

### UI/UX (Priority Medium)
1. **Implement Design System**: 
   - Consistent color palette, typography, spacing
   - Reusable components (buttons, forms, cards, tables)
2. **Mobile-First Responsive Design**: 
   - Flexible layouts, touch-friendly controls
   - Test on various screen sizes
3. **Improve Navigation**: 
   - Consistent header/menu across all pages
   - Clear breadcrumbs and page titles
4. **Enhance Forms**: 
   - Proper labeling, placeholders, inline validation
   - Clear call-to-action buttons
5. **Add Feedback Mechanisms**: 
   - Success/error messages (using sessions or GET parameters)
   - Loading states for asynchronous actions
6. **Improve Accessibility**: 
   - Semantic HTML, ARIA labels, sufficient color contrast
   - Keyboard navigable, focus visible
7. **Optimize Assets**: 
   - Compress images, use appropriate formats
   - Consider CSS gradients instead of image backgrounds where possible

### Database (Priority Low)
1. **Consider Enum for Status**: Use ENUM('BOOKED', 'CANCELLED', ...) for `resv.status`
2. **Add Indexes**: Review query performance and add missing indexes
3. **Document Triggers**: Add comments explaining business rules in triggers
4. **Consider Soft Deletes**: For audit trail (though current triggers already move data to `canc` table)

### Files That Must NOT Be Changed
1. `railway.sql` - Source of truth for database schema (changes require migration scripts)
2. `db.php` - Critical database connection (can be refactored but must maintain interface)
3. Any file that is the sole implementation of a critical feature (to be determined after full review)

### Files Safe to Refactor
1. All HTML/CSS files (can be consolidated into templates)
2. PHP files with duplicated code (can extract common functions)
3. Files with inline CSS (can move to stylesheet)
4. Files with mixed PHP/HTML (can separate logic and presentation)

## Conclusion

The Railway Management System is a functional but outdated PHP/MySQL application that requires significant improvements in security, code quality, and user experience while preserving all existing functionality. The database schema is well-designed with appropriate constraints and triggers enforcing business rules. The primary risks are SQL injection, plaintext passwords, and hardcoded credentials. Refactoring should focus on extracting common logic, implementing security best practices, and creating a consistent UI/UX without altering the underlying data model or removing features.