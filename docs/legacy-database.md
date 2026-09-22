# Legacy database reference

## 1. Current database tables

The application uses a MySQL database named `railway`. The schema is implemented in `railway.sql` and includes both table definitions and several trigger-based validations.

### `user`

Purpose: customer account information.

Columns:
- `id` — integer, auto increment, primary key
- `fullname` — varchar(50)
- `email` — varchar(50), unique
- `username` — varchar(50), unique
- `phone` — varchar(10), unique
- `password` — varchar(50)
- `gender` — enum('male','female')
- `dob` — date

Notes:
- User age check is enforced by a trigger: minimum age is 18.
- Login checks are performed by phone number and password.
- Passwords are stored and compared in plain text.

### `train`

Purpose: train master data.

Columns:
- `trainno` — integer, auto increment, primary key
- `tname` — varchar(50)
- `sp` — varchar(50), start station
- `st` — time
- `dp` — varchar(50), destination station
- `dt` — time
- `dd` — varchar(10), day label
- `distance` — integer

Notes:
- Trigger validates that start and destination are not the same;
- Some time logic also checks `dt < st` when `dd = 'Day 1'`.

### `station`

Purpose: station list and lookup values.

Columns:
- `id` — integer, auto increment, key
- `sname` — varchar(50), primary key

Notes:
- Used as a master list for train routes and availability queries.
- There are formatting inconsistencies in some station names, such as leading spaces in values like `' Kurtha'` and `' Dubarikot'`.

### `schedule`

Purpose: route schedule entries for each train at each station.

Columns:
- `id` — integer, auto increment, primary key
- `trainno` — integer
- `sname` — varchar(50)
- `arrival_time` — time
- `departure_time` — time
- `distance` — integer

Notes:
- Each train has multiple schedule records ordered by distance.
- The application uses this table to calculate travel segments between stations.

### `class`

Purpose: static class reference table.

Columns:
- `cname` — varchar(10), primary key

Values in sample data:
- `AC1`
- `AC2`
- `AC3`
- `CC`
- `EC`
- `SL`

### `classseats`

Purpose: inventory and fare data for a train, segment, date, and class.

Columns:
- `trainno` — integer, part of composite primary key
- `sp` — varchar(50), segment start station
- `dp` — varchar(50), segment destination station
- `doj` — date
- `class` — varchar(10)
- `fare` — decimal(10,2)
- `seatsleft` — integer

Notes:
- Composite key: `(trainno, sp, dp, doj, class)`
- `seatsleft` is reduced when reservations are booked.
- `fare` and `seatsleft` are validated by triggers.
- It is used to answer queries such as “what is the fare and availability for this route/date/class?”

### `resv`

Purpose: booking record for each reservation.

Columns:
- `pnr` — integer, auto increment, primary key
- `id` — integer, user id
- `trainno` — integer
- `sp` — varchar(50)
- `dp` — varchar(50)
- `doj` — date
- `tfare` — integer
- `class` — varchar(50)
- `nos` — integer
- `status` — varchar(50)

Notes:
- Current statuses include `BOOKED` and `CANCELLED`.
- Unique indexes exist over combinations including user, train, date, and status.
- An insert trigger enforces seat availability and sets `status = 'BOOKED'` automatically.
- An update trigger restores seats when status becomes `CANCELLED`, and populates `canc`.

### `pd`

Purpose: passenger detail rows for each reservation.

Columns:
- `pnr` — integer
- `pname` — varchar(50)
- `page` — int
- `pgender` — varchar(10)

Notes:
- Composite primary key: `(pnr, pname, page, pgender)`
- Validation trigger allows only `M` or `F` values for `pgender`.

### `canc`

Purpose: cancellation accounting or refund ledger.

Columns:
- `pnr` — integer, primary key
- `rfare` — integer, default 0

Notes:
- Values are populated by triggers when a reservation is cancelled.
- Refund amount logic is based on days remaining before journey:
  - >= 30 days: full fare
  - < 30 days: 50% fare

## 2. Important relationships

- `user.id` → `resv.id`
- `train.trainno` → `resv.trainno`
- `train.trainno` → `classseats.trainno`
- `station.sname` → `classseats.sp`
- `station.sname` → `classseats.dp`
- `station.sname` → `resv.sp`
- `station.sname` → `resv.dp`
- `resv.pnr` → `pd.pnr`

## 3. Trigger logic in the schema

The database uses several triggers to police data quality:

- `before_insert_on_classseats`/`before_update_on_classseats`
  - rejects past dates
  - rejects non-positive fare
  - rejects non-positive seats

- `before_insert_on_pd`/`before_update_on_pd`
  - restricts `pgender` to `M` or `F`

- `before_insert_on_resv`/`before_update_on_resv`
  - rejects negative fare
  - rejects zero/negative seat counts
  - rejects insufficient available seats
  - rejects bookings made in the past
  - sets status to `BOOKED`

- `after_insert_on_resv`
  - reduces available seats for the specific segment/class/date

- `after_update_on_resv`
  - restores seats on cancellation
  - inserts refund values into `canc`
  - disallows cancellation after the travel date has passed

## 4. Data quality issues in the current schema

- Station names include inconsistent whitespace values such as `' Kurtha'` and `' Dubarikot'`.
- Some route and schedule entries appear to have duplicated or poorly normalized data.
- The schema stores status, fare, and seat logic across application and database triggers instead of one consistent domain layer.
- The use of multiple unique indexes and composite keys makes the table design more complex than necessary.
- There are names and station values that imply manual data entry without canonical normalization.

## 5. Summary

The database is a classic academic-project relational schema: normalized enough for a course assignment, but not hardened for production. It is strongly tied to PHP page logic and relies heavily on triggers to enforce business rules. That makes the app easier to understand as a demonstration, but harder to scale or modernize safely.
