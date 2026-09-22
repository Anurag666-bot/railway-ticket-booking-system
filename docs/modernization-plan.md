# Modernization plan

## 1. Objective

Modernize the railway booking application from a page-centric procedural PHP application into a maintainable, secure, and scalable system while preserving the current business behavior.

## 2. Recommended architecture target

### Short-term target

- Keep the same business domain but move to a structured PHP application or framework.
- Split logic into:
  - controllers
  - services
  - domain models
  - repositories
  - views/templates

Suggested direction:
- PHP framework: Laravel or Symfony
- Or, for a minimal path, a conventional MVC layout using plain PHP and classes

### Medium-term target

- Replace direct SQL and session state orchestration with repository/service layers.
- Centralize validation and authorization logic.
- Move business rules from MySQL triggers into application services.
- Add API endpoints for reservation and admin management.

### Long-term target

- Multi-user role-based access control.
- Frontend in a modern SPA or server-rendered framework.
- Proper observability and logs.
- Payment integration and audit trail.
- Admin dashboards with analytics and reporting.

## 3. Functional modernization priorities

### A. Authentication and authorization

- Replace plain-text password checking with `password_hash()` and `password_verify()`.
- Add a dedicated `users` auth table and roles: `customer`, `admin`, maybe `staff`.
- Use session regeneration and secure cookies.
- Add backend checks for admin-only routes.
- Move admin credentials out of source code.

### B. Booking and reservation domain

- Create explicit domain objects for:
  - `Train`
  - `Station`
  - `SeatInventory`
  - `Reservation`
  - `Passenger`
  - `Cancellation`
- Introduce a reservation service that validates:
  - route validity
  - seat availability
  - age rules
  - fare calculation
  - cancellation eligibility

### C. Database modernization

- Normalize inconsistent station names and duplicate route entries.
- Replace trigger-heavy logic with application-layer validation.
- Introduce proper schema constraints and indexes.
- Add migration-based database management instead of importing a monolithic SQL dump.
- Split the schema into migration files with versioning.

## 4. Security and reliability upgrades

- Prevent SQL injection by using prepared statements everywhere.
- Validate and sanitize all inputs.
- Add CSRF tokens for all state-changing forms.
- Use HTTPS in all environments.
- Add proper session management and idle timeout.
- Add rate limiting for login attempts.
- Log errors without exposing SQL internals to end users.
- Add transaction handling around booking and cancellation updates.

## 5. UX and frontend modernization

- Replace inline styling and ad hoc HTML with a consistent design system.
- Use modern forms with validation and user feedback.
- Make train search and booking flows responsive and accessible.
- Add better booking confirmation, PNR lookup, and cancellation screens.
- Add admin dashboard widgets for bookings, cancellations, and seat utilization.

## 6. Recommended migration phases

### Phase 1 — stabilize and document

- Freeze the legacy schema and document the business rules.
- Copy data into a staging database.
- Identify high-risk routes and operations.

### Phase 2 — secure the foundation

- Hash passwords.
- Add role-based access control.
- Add CSRF protection.
- Introduce transaction-safe booking logic.

### Phase 3 — refactor the codebase

- Move scripts into controllers/services.
- Create repositories for data access.
- Add unit and integration tests.

### Phase 4 — modern frontend and APIs

- Create a REST or GraphQL API.
- Build a cleaner UI for user flows and admin flows.
- Add dashboards and operational tooling.

### Phase 5 — operational hardening

- Add monitoring, backups, testing pipelines, and deployment automation.
- Add audit logs for cancellation and pricing decisions.
- Build a production-ready environment for staging and production.

## 7. Implementation priority order

1. Fix auth and password handling
2. Add input validation and CSRF protection
3. Move business rules out of triggers into services
4. Standardize station and train data
5. Refactor file-based scripts into modular PHP
6. Improve admin access control
7. Add automated tests and deployment workflow

## 8. Expected outcome

The legacy project can be modernized into a safer, maintainable booking system without losing the original educational functionality. The result would be easier to extend, easier to test, and far less brittle when changes are needed.
