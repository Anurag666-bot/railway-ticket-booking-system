# Security audit

## 1. Executive summary

The current application is a functional academic project, but it does not satisfy the baseline requirements for a secure web application. The most serious issues are plaintext credential handling, missing authorization checks, unsafe SQL construction, and lack of CSRF and session hardening.

## 2. Highest-risk issues

### 2.1 Plaintext passwords

The application stores and compares passwords directly as strings in the `user` table. In `user_login.php`, login logic checks:

- `SELECT * FROM user WHERE phone = ?`
- `if ($row['password'] !== $password)`

This means the actual password is effectively stored in the database without hashing or salting. Any database compromise exposes user credentials immediately.

Recommended fix:
- Use `password_hash()` at registration.
- Use `password_verify()` during authentication.
- Remove direct password equality checks in application logic.

### 2.2 Hard-coded admin credentials

`admin_login.php` accepts only:

- user id: `admin`
- password: `admin`

These values are embedded in the application logic and not stored in a secure credential store. This is a major security flaw and a maintenance hazard.

Recommended fix:
- Use a proper admin user record with role assignment.
- Store hashed passwords in the database.
- Restrict admin dashboard access behind centralized authorization checks.

### 2.3 SQL injection risk

Several files build SQL statements directly from request data, including `$_POST` and `$_GET` variables. Examples include:

- booking logic in `new_png.php`
- cancellation logic in `cancel.php`
- train and schedule inserts in `insert_into_train_*.php`
- admin and user management pages

The app does not consistently use prepared statements across all paths.

Recommended fix:
- Convert all SQL queries to prepared statements.
- Validate and sanitize input before using it in queries.
- Use parameterized bound values throughout the application.

### 2.4 Missing CSRF protection

The application sends state-changing requests through HTML forms without CSRF tokens. This allows attackers to force users into booking or cancelling reservations using malicious pages.

Recommended fix:
- Generate CSRF tokens on sensitive forms.
- Validate token on each action.
- Use SameSite and secure cookie settings.

### 2.5 Weak authorization model

The app relies on a simple session variable:

- `$_SESSION["admin_login"] = true`

This is insufficient for production-grade authorization. There is no role-based access control, no route guard, and no server-side enforcement beyond a single flag.

Recommended fix:
- Add explicit user roles and policy checks.
- Restrict admin endpoints with server-side authorization.
- Verify the current user’s identity on each protected action.

### 2.6 Session handling weakness

The application uses PHP sessions but does not demonstrate strong session hygiene. There is no session rotation, no regeneration after login, no secure cookie flags, and no idle timeout strategy.

Recommended fix:
- Use `session_regenerate_id(true)` after login.
- Set secure, HttpOnly, and SameSite cookie settings.
- Destroy session state on logout and failed login attempts.

## 3. Additional risks

### 3.1 User enumeration and inconsistent messaging

Some flows distinguish between “wrong combination,” “phone number does not exist,” or “incorrect password” in ways that can expose valid user records or patterns.

### 3.2 Unvalidated and inconsistent input

Inputs such as age, passenger gender, station names, train numbers, and dates are used without consistent validation rules. This increases the chance of invalid or malicious data entering the database.

### 3.3 Race conditions around seat availability

Seat availability is managed with database triggers, but the application does not lock transactions or use optimistic concurrency patterns for simultaneous bookings. This can produce overselling under burst traffic.

### 3.4 Information leakage

The app often echoes SQL errors or raw database failure strings directly to the user. This can leak schema details and internal implementation information.

### 3.5 No audit logging

Adverse actions like cancellations, admin edits, or booking modifications are not logged for compliance or investigation.

### 3.6 Insecure direct file structure and assumptions

The app uses absolute URLs such as `http://localhost/railway/...` in many places, which is brittle and tightly couples the UI to a local deployment structure. This also creates risks when deployed outside a local environment.

## 4. Data integrity concerns

- Trigger-based enforcement is hidden in the database and hard to reason about.
- Business rules are spread between application code and SQL triggers.
- There are no broad transaction boundaries around multi-step reservation work.
- `resv` and `pd` inserts may partially succeed or fail without a clean rollback strategy.

## 5. Known limitations

- No OWASP-baseline protections for authentication or session handling
- No enforced authorization policy
- No CSRF or XSS hardening
- No rate limiting or brute-force protection
- No secure secret management
- No encrypted transport or secret configuration management
- No production-ready deployment profile

## 6. Prioritized remediation plan

1. Replace plaintext password storage with hashing.
2. Add hardened authentication and session management.
3. Secure all SQL access with prepared statements and validation.
4. Add CSRF protection to all form actions.
5. Add authorization guards for admin operations.
6. Centralize booking logic in transaction-safe service methods.
7. Add logging, monitoring, and policy-based access control.
8. Retire legacy absolute URLs and local path assumptions.

## 7. Final assessment

The application demonstrates core database and PHP concepts, but it is not suitable for production use without a major security remediation effort. The highest-priority issue is credential handling, followed by SQL injection protections and access control. In its current form, the system would be vulnerable to common web attacks and difficult to secure without a structured refactor.
