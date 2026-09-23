# Result Management System

A web-based academic result management system with separate workflows for students, administrators, and university users.

## Overview

Resultify provides authentication, role-based dashboards, student records, academic result management, notices, result charts, and PDF marksheet downloads. It is implemented in plain PHP with a MySQL database; it does not use Laravel or another PHP framework.

## Features

- Registration and login with password hashing and role-based redirects
- Dedicated student, administrator, and university dashboards
- Student creation, profile updates, search, editing, and removal
- Result entry, viewing, and management
- Result visualization with charts
- Downloadable PDF marksheets generated with TCPDF
- Notice publishing and viewing
- Contact-form submission storage

## Tech Stack

- PHP
- MySQL
- HTML and CSS
- JavaScript
- Bootstrap
- TCPDF

## Project Structure

```text
.
|-- includes/
|   |-- auth.php              # Session and role checks
|   `-- db.php                # MySQL connection settings
|-- TCPDF/                    # Bundled PDF generation library
|-- admin_dashboard.php       # Administrator dashboard
|-- student_dashboard.php     # Student dashboard
|-- university_dashboard.php  # University dashboard
|-- manage_results.php        # Result management
|-- result_chart.php          # Result visualization
|-- download_marksheet.php    # PDF marksheet generation
|-- post_notice.php           # Notice publishing
|-- login.php                 # Authentication
|-- register.php              # User registration
`-- ss (1).sql                # Database schema and sample data
```

## Run Locally

### Prerequisites

- PHP with the `mysqli` extension
- MySQL or MariaDB
- A local web server such as PHP's built-in server, XAMPP, or Laragon

### Setup

1. Clone the repository and enter the project directory.

   ```bash
   git clone https://github.com/sharmilashahi752/groupprojectResultify.git
   cd groupprojectResultify
   ```

2. Create a MySQL database named `ss` and import the included dump.

   ```bash
   mysql -u root -p -e "CREATE DATABASE ss CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   mysql -u root -p ss < "ss (1).sql"
   ```

3. Update the local database connection values in `includes/db.php` if your MySQL host, username, password, or database name differs.

4. Start the application from the repository root.

   ```bash
   php -S localhost:8000
   ```

5. Open `http://localhost:8000`.

> The SQL dump contains sample records. Review and sanitize it before using the project outside a local development environment.

## Author

**Sharmila Shahi**<br>
Full-Stack Developer

- [Portfolio](https://www.sharmilashahi1.com.np/)
- [LinkedIn](https://www.linkedin.com/in/sharmila-shahi-a3a572218/)
