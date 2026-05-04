# Milestone 3 Audit — Todo List
> Compared against project files as of May 3, 2026

---

## ✅ CRITICAL — Completed

- [x] **Convert `db_connect.php` from `mysqli` to PDO**
  - Fixed typo `mtsql:` → `mysql:` in DSN string
  - Now uses `new PDO(...)` with try/catch and `ERRMODE_EXCEPTION`

- [x] **Remove all `mysqli` usage from `pages/movies/index.php`**
  - Replaced `mysqli_query` + `mysqli_real_escape_string` with PDO prepared statement + `:search` binding
  - Replaced `while/mysqli_fetch_assoc` loop with `fetchAll/foreach`

- [x] **Remove all `mysqli` usage from `pages/reviews/index.php`**
  - Replaced `mysqli_query` with PDO `prepare/execute`
  - Replaced `while/mysqli_fetch_assoc` with `fetchAll/foreach`

- [x] **Remove all `mysqli` usage from `index.php` (root)**
  - Was missed in original audit — also converted to PDO `prepare/execute/fcan youetchAll/foreach`

---

## ✅ Query Form — `pages/forms/index.php`

- [x] Connect search form to DB using PDO
  - Added PDO `prepare/execute/fetchAll` with `:search` LIKE binding
  - Wrapped in try/catch with user-friendly error message
- [x] Display search results in a clear, readable format below the form
  - 5-column movie card grid with poster, title, director, year, IMDb rating
  - "No movies found" message when search returns no results
- [x] "Coming Soon" placeholder text removed

---

## ✅ Insert Form — `pages/forms/index.php`

- [x] Connect "Add User" form to DB using PDO
  - Added PDO `prepare/execute` with bound parameters for all 4 fields + `CURDATE()` for `join_date`
  - Wrapped in try/catch — duplicate email caught from UNIQUE constraint
- [x] Display confirmation message showing what was added
  - Success message now shows user's name + auto-assigned ID from `lastInsertId()`

---

## ✅ Update Form — `pages/forms/index.php`

- [x] Connect "Update User" form to DB using PDO
  - Added PDO `prepare/execute` UPDATE with bound parameters for all 5 fields
  - Wrapped in try/catch — duplicate email caught from UNIQUE constraint
- [x] Display confirmation message showing what was updated
  - Success message shows user ID + name that was updated
  - `rowCount()` check catches non-existent user IDs and shows a field error

---

## 📊 Individual Reports — `pages/reports/`

Each report is a separate file. Each person implements their own.

- [x] **Justin's Report: "Top-Rated Action Movies"** — `pages/reports/justin.php`
  - PDO prepared statement with `WHERE g.genre_name = :genre` and two JOINs (`movies` → `movie_genres` → `genres`)
  - Ranked by IMDb rating descending, numbered rank badge on each card
  - `// Justin McNeal` comment at top of file
  - Linked from reports index with a "View Report" button

- [ ] **Jayse's Report: "Most Watchlisted Movies This Month"** — `pages/reports/jayse.php`
  - Jayse needs to create this file
  - Must use PDO + prepared statement
  - Must include a `WHERE` clause and at least one `JOIN`
  - Must add their name as a PHP comment at the top
  - Reports index already has a placeholder entry — just needs the link updated when the file is ready

- [x] **Link all reports from the main Reports page** (`pages/reports/index.php`)
  - Justin's report linked with "View Report" button
  - Jayse's shows "Coming Soon" until their file is ready
  - Quincie removed from group

---

## 🔒 Technical Requirements ✅

- [x] All database connections use PDO exclusively — no mysqli anywhere
- [x] All SQL statements use prepared statements with bound parameters
- [x] Proper error handling — all DB operations wrapped in try/catch
- [x] Input sanitization and XSS prevention
  - `htmlspecialchars()` on all DB output in HTML
  - `formatName()` outputs in success messages wrapped in `htmlspecialchars()`
  - `sanitize()` applied to search input before use
  - Prepared statements prevent SQL injection throughout

---

## 🎨 Final Product / Cohesion

- [x] All navigation links work — nav.php covers Home, Movies, Reviews, Watchlist, Reports, Forms
- [x] Reports page links to `justin.php` with working button
- [x] Consistent styling across all pages (Tailwind + `style.css`)
- [x] "Coming Soon" placeholder removed from forms page
- [ ] Jayse links their report in `pages/reports/index.php` once `jayse.php` is created

---

## Summary of Current State

| Requirement | Status |
|---|---|
| db_connect uses PDO | ✅ Converted |
| Query form hits DB | ✅ PDO prepared statement, try/catch, results grid |
| Insert form hits DB | ✅ PDO INSERT with prepared statement, try/catch, shows new ID |
| Update form hits DB | ✅ PDO UPDATE with prepared statement, rowCount check, try/catch |
| Prepared statements | ✅ All forms + movies, reviews, index — complete |
| Error handling | ✅ All DB operations have try/catch |
| Justin's report | ✅ `pages/reports/justin.php` — complete |
| Quincie's report | ❌ Removed from group |
| Jayse's report | ❌ Jayse needs to create `pages/reports/jayse.php` |
| Reports linked | ⚠️ Justin linked — Jayse pending |
| Consistent styling | ✅ Tailwind throughout |
| Navigation works | ✅ All 6 nav links present in nav.php |
| XSS prevention | ✅ htmlspecialchars on all user-derived output |
