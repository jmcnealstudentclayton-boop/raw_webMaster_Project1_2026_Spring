# Movie Database Management System — Project Roadmap

> **Course:** Weird Web Class Spring 2026  
> **Repo:** `raw_webMaster_Project1_2026_Spring`  
> **Stack:** PHP · HTML · CSS · MySQL (via XAMPP/phpMyAdmin + DBeaver) · GitHub Pages  

---

## Project Overview

A movie database management system that lets users browse movies, manage a watchlist, and write reviews. Built progressively across three milestones.

---

## Milestone 1 — Basic Structure & Layout

**Due: March 15, 2026**  
**Focus:** HTML structure and basic PHP files (no functionality yet)

| # | Task | Status | Notes |
|---|------|--------|-------|
| 1.1 | Import `moviedb.sql` into phpMyAdmin / DBeaver | ⬜ Not Started | Review schema; note NOT NULL fields |
| 1.2 | Create project folder structure | ⬜ Not Started | `/css`, `/includes`, `/pages`, `/images` |
| 1.3 | Build shared header/nav (`includes/header.php`) | ⬜ Not Started | Consistent nav across pages |
| 1.4 | Build shared footer (`includes/footer.php`) | ⬜ Not Started | |
| 1.5 | Create main stylesheet (`css/styles.css`) | ⬜ Not Started | One person maintains for cohesion |
| 1.6 | Build Homepage (`index.php`) | ⬜ Not Started | Welcome, featured movies, navigation |
| 1.7 | Build Forms pages (Add Movie, Add Review, Manage Watchlist, etc.) | ⬜ Not Started | Divide among group members |
| 1.8 | Build Reports page framework | ⬜ Not Started | Placeholder layout — no DB queries yet |
| 1.9 | Cross-browser / basic layout QA | ⬜ Not Started | |
| 1.10 | **Submit Milestone 1 (ZIP)** | ⬜ Not Started | One person submits for the group |

---

## Milestone 2 — User Input & Validation

**Due: April 5, 2026**  
**Focus:** Form validation and user-input handling (no database connection yet)

| # | Task | Status | Notes |
|---|------|--------|-------|
| 2.1 | Add client-side validation (HTML5 `required`, `pattern`, etc.) | ⬜ Not Started | |
| 2.2 | Add server-side PHP validation for each form | ⬜ Not Started | Sanitize & validate all inputs |
| 2.3 | Display user-friendly error messages | ⬜ Not Started | Inline / summary errors |
| 2.4 | Preserve form input on validation failure ("sticky forms") | ⬜ Not Started | |
| 2.5 | Create shared validation functions (`includes/validation.php`) | ⬜ Not Started | Reuse across forms |
| 2.6 | Handle NOT NULL constraints in validation | ⬜ Not Started | Match DB schema requirements |
| 2.7 | Test edge cases (empty fields, bad types, SQL-injection strings) | ⬜ Not Started | |
| 2.8 | **Submit Milestone 2 (ZIP)** | ⬜ Not Started | One person submits for the group |

---

## Milestone 3 — Database Integration

**Due: May 4, 2026**  
**Focus:** Connect validated forms to MySQL and create functional reports

| # | Task | Status | Notes |
|---|------|--------|-------|
| 3.1 | Create DB connection file (`includes/db_connect.php`) | ⬜ Not Started | PDO or mysqli; shared by team |
| 3.2 | Wire "Add Movie" form → INSERT query | ⬜ Not Started | |
| 3.3 | Wire "Add Review" form → INSERT query | ⬜ Not Started | |
| 3.4 | Wire "Manage Watchlist" form → INSERT/DELETE | ⬜ Not Started | |
| 3.5 | Build Report 1 (unique per member) | ⬜ Not Started | Coordinate to avoid duplicates |
| 3.6 | Build Report 2 (unique per member) | ⬜ Not Started | |
| 3.7 | Build Report 3 (unique per member) | ⬜ Not Started | |
| 3.8 | Browse movies page — SELECT with pagination/filtering | ⬜ Not Started | |
| 3.9 | Security review (prepared statements, XSS prevention) | ⬜ Not Started | |
| 3.10 | Final integration testing on XAMPP | ⬜ Not Started | |
| 3.11 | **Submit Milestone 3 (ZIP)** | ⬜ Not Started | One person submits for the group |

---

## Suggested Folder Structure

```
rawProject/
├── index.php                 # Homepage
├── css/
│   └── styles.css            # Single cohesive stylesheet
├── includes/
│   ├── header.php            # Shared header/nav
│   ├── footer.php            # Shared footer
│   ├── db_connect.php        # DB connection (Milestone 3)
│   └── validation.php        # Shared validation helpers (Milestone 2)
├── pages/
│   ├── add_movie.php         # Add Movie form
│   ├── add_review.php        # Add Review form
│   ├── watchlist.php         # Manage Watchlist
│   ├── browse.php            # Browse movies
│   └── reports.php           # Reports page
├── images/                   # Movie posters / assets
├── moviedb.sql               # Database schema & seed data
├── projectProgress.md        # ← This file
└── README.md
```

---

## Tools & Environment

| Tool | Purpose |
|------|---------|
| **XAMPP** | Local Apache + MySQL server; runs PHP pages at `localhost` |
| **phpMyAdmin** | Web GUI for MySQL (bundled with XAMPP) |
| **DBeaver** | Desktop SQL client for deeper DB work |
| **VS Code** | Code editor |
| **GitHub Pages** | Static hosting / project showcase |
| **GitHub (`gh` CLI)** | Version control & collaboration |

---

## Team Coordination Checklist

- [ ] Group chat created (Discord / Teams / text)
- [ ] Roles assigned (homepage, forms, stylesheet owner, reports)
- [ ] Internal deadlines set (before each milestone due date)
- [ ] Submitter designated
- [ ] DB schema reviewed together — NOT NULL fields documented

---

## Status Key

| Icon | Meaning |
|------|---------|
| ⬜ | Not Started |
| 🔧 | In Progress |
| ✅ | Complete |
| ❌ | Blocked |

---

*Last updated: March 3, 2026*
