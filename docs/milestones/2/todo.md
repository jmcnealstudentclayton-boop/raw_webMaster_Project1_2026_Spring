# Milestone 2 TODO — Form Validation & Input Processing

**Due:** Sunday, April 12, 2026
**Current Status:** Not started — forms exist but have zero validation or processing logic.

---

## Pre-Work / Fixes

- [x] Fix duplicate HTML `id` attributes on forms page (both forms use `id="edit-user-id"`, `id="edit-first"`, etc.)
- [x] Fix review form rating range: form says 1–10 but DB schema enforces 1.0–5.0
- [x] Remove broken `action="submit_review.php"` — process forms on the same page instead
- [x] Add `<?php include '../../pageInserts/db_connect.php'; ?>` to `pages/forms/index.php` (currently missing)

### Milestone 1 Feedback Fixes
- [x] Fix logo path in `nav.php` — change absolute path (`/rawProject/assets/logo/logo.png`) to relative path
- [x] Fix all navigation links in `nav.php` — change absolute paths (`/rawProject/...`) to relative paths so the project works regardless of deployment location

---

## 1. Create Reusable Validation Functions (4 pts)

- [x] Create `pageInserts/validation.php` with shared validation helpers:
  - `sanitize($input)` — trim + htmlspecialchars
  - `validateRequired($value, $fieldName)` — check non-empty
  - `validateEmail($email)` — filter_var check
  - `validateRating($rating, $min, $max)` — numeric + range check
  - `validateLength($value, $min, $max, $fieldName)` — string length check
  - `validateInt($value, $fieldName)` — integer check

---

## 2. Query/Search Form — `pages/forms/index.php` & `pages/movies/index.php`

### Form accepts user input for search criteria (4 pts)
- [x] Search form already exists — verify it submits correctly via GET

### Validate all input fields (7 pts)
- [x] Add PHP processing at top of page: check `$_GET['search']`
- [x] Validate search input is not empty
- [x] Validate search input length (e.g., min 2 chars)
- [x] Sanitize search input with `htmlspecialchars()` and `trim()`

### Display appropriate error messages for invalid input (4 pts)
- [x] Show error if search field is submitted empty
- [x] Show error if search is too short
- [x] Style error messages visibly (red text/border)

### Show confirmation message when valid input is received (3 pts)
- [x] Display success message like "Showing results for: [search term]"

---

## 3. Insert Form — `pages/forms/index.php` (Add User)

### Form accepts user input for new records (4 pts)
- [x] Insert form already exists — verify fields match DB schema (first_name, last_name, email, subscription_type)

### Validate all input fields (7 pts)
- [x] Add PHP processing at top of page: check `isset($_POST['add_user'])`
- [x] Validate first_name: required, max 50 chars
- [x] Validate last_name: required, max 50 chars
- [x] Validate email: required, valid email format, max 100 chars
- [x] Validate subscription_type: must be one of free/basic/premium
- [x] Add HTML5 `required` attributes to all fields
- [x] Add `type="email"` on email field (already has it — verify)

### Display appropriate error messages for invalid input (4 pts)
- [x] Show per-field error messages next to each input
- [x] Highlight invalid fields (red border)

### Show confirmation message when valid input is received (3 pts)
- [x] Display success message: "User [name] added successfully!" (no DB insert yet)

---

## 4. Update Form — `pages/forms/index.php` (Update User)

### Form accepts user input for record updates (4 pts)
- [x] Fix duplicate IDs — give update form unique IDs (e.g., `id="update-user-id"`, `id="update-first"`, etc.)
- [x] Verify form fields match DB schema

### Validate all input fields (7 pts)
- [x] Add PHP processing: check `isset($_POST['update_user'])`
- [x] Validate user_id: required, must be integer
- [x] Validate first_name: required, max 50 chars
- [x] Validate last_name: required, max 50 chars
- [x] Validate email: required, valid email format
- [x] Validate subscription_type: must be one of free/basic/premium
- [x] Add HTML5 `required` attributes

### Display appropriate error messages for invalid input (4 pts)
- [x] Show per-field error messages
- [x] Highlight invalid fields

### Show confirmation message when valid input is received (3 pts)
- [x] Display success message: "User [name] updated successfully!" (no DB update yet)

---

## 5. PHP Implementation

### Use PHP to process form submissions (8 pts)
- [x] Add `<?php` processing block at top of `pages/forms/index.php`
- [x] Handle `$_POST['add_user']` for insert form
- [x] Handle `$_POST['update_user']` for update form
- [x] Handle `$_GET['search']` for query form
- [x] Handle review form submission on `pages/reviews/index.php`

### Implement server-side validation using PHP functions (8 pts)
- [x] Use `filter_var()` for email validation
- [x] Use `is_numeric()` / `intval()` for numeric fields
- [x] Use `in_array()` for enum fields (subscription_type)
- [x] Use `strlen()` for length validation
- [x] Use `empty()` for required field checks

### Properly sanitize user input (7 pts)
- [x] Apply `trim()` to all text inputs
- [x] Apply `htmlspecialchars()` to all output (prevents XSS)
- [x] Fix existing XSS issues: escape output on `index.php` (movie titles, director, poster_url)
- [x] Fix existing XSS issues: escape output on `pages/reviews/index.php` (review text, names)

### Keep valid input in form fields after submission (5 pts)
- [x] Add `value="<?php echo htmlspecialchars($firstName ?? ''); ?>"` to all text inputs
- [x] Preserve selected `<option>` in dropdowns after submission
- [x] Preserve textarea content on review form

---

## 6. User Experience

### Clear instructions and labels for all form fields (4 pts)
- [x] Add `<label>` elements to all form fields (some are missing)
- [x] Ensure labels use `for` attribute matching input `id`
- [x] Add helper text where needed (e.g., "Rating must be between 1.0 and 5.0")

### Error messages are clearly visible and helpful (4 pts)
- [x] Use red/danger color for error messages
- [x] Place errors near the relevant field, not just at the top
- [x] Use specific messages ("Email is required" not just "Invalid input")

### Maintain consistent styling across all pages (4 pts)
- [x] Ensure error/success message styling matches site theme (slate/indigo palette)
- [x] Use same form input classes across all pages

### Forms provide immediate, relevant feedback (4 pts)
- [x] Show success/error messages after form submission
- [ ] Scroll to or highlight the message area after submission

---

## 7. Code Quality & Organization

### PHP code is well-organized and commented (4 pts)
- [x] Add comments to PHP processing blocks explaining validation logic
- [x] Group related validation checks together

### Clear separation between HTML and PHP processing (4 pts)
- [x] Put all PHP form processing logic at the TOP of each file, before any HTML
- [x] Store errors in an `$errors` array, success in a `$success` variable
- [x] Only output HTML below the processing block

### Create reusable validation functions (4 pts)
- [x] `pageInserts/validation.php` — covered in section 1 above
- [x] Include it on all form pages

---

## Points Summary

| Category                       | Points | Status  |
|--------------------------------|--------|---------|
| Query Form                     | 18     | Done |
| Update Form                    | 18     | Done |
| Insert Form                    | 18     | Done |
| PHP Implementation             | 28     | Done |
| User Experience                | 16     | Done |
| Code Quality & Organization    | 12     | Done |
| **Total**                      | **110**| **~110/110** |
