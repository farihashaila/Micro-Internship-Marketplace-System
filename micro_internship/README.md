# Micro Internship Marketplace

A web-based platform that connects students with companies through short-term micro-internships and task-based opportunities. Students can browse available tasks, apply for internships, submit completed work, and receive feedback, while companies can post tasks, manage applications, review submissions, and track progress.

## Features

### Student Module

* Student registration and login
* Profile management
* Browse available tasks
* Apply for micro-internships
* Track application status
* Submit completed work
* View assigned tasks and submissions

### Company Module

* Company registration and login
* Company profile management
* Post internship tasks
* View and manage applications
* Accept or reject applicants
* Review submitted work
* Approve, reject, or request revisions
* Provide feedback and reviews

### Admin Module

* Administrative dashboard
* Monitor platform activities
* Manage users and internships

---

## Project Structure

```text
micro_internship/
│
├── admin/
│   └── dashboard.php
│
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── company/
│   ├── dashboard.php
│   ├── profile.php
│   ├── post_task.php
│   ├── applications.php
│   ├── submissions.php
│   └── ...
│
├── student/
│   ├── dashboard.php
│   ├── profile.php
│   ├── tasks.php
│   ├── apply.php
│   └── submit_work.php
│
├── config/
│   ├── db.php
│   └── check_deadlines.php
│
├── assets/
│   ├── style.css
│   └── image/
│
├── index.php
└── about.php
```

---

## Technology Stack

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL

### Server

* Apache (XAMPP/WAMP/LAMP)

---

## Installation Guide

### 1. Clone the Repository

```bash
git clone <repository-url>
cd micro_internship
```

### 2. Move Project to Web Server

For XAMPP:

```text
C:\xampp\htdocs\micro_internship
```

For Linux Apache:

```text
/var/www/html/micro_internship
```

### 3. Create Database

Open phpMyAdmin and create:

```sql
CREATE DATABASE micro_internship_db;
```

### 4. Import Database

Import the provided SQL file into:

```text
micro_internship_db
```

### 5. Configure Database Connection

File:

```php
config/db.php
```

Default configuration:

```php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "micro_internship_db"
);
```

Update credentials if necessary.

### 6. Start Server

Start:

* Apache
* MySQL

### 7. Access Application

```text
http://localhost/micro_internship
```

---

## Workflow

### Student Flow

1. Register/Login
2. Complete profile
3. Browse available internships
4. Apply for a task
5. Get selected by company
6. Complete assigned work
7. Submit deliverables
8. Receive feedback/review

### Company Flow

1. Register/Login
2. Create company profile
3. Post internship task
4. Review applications
5. Accept suitable candidates
6. Review submissions
7. Approve or request revisions
8. Provide ratings and feedback

---

## Future Improvements

* Email notifications
* Resume upload support
* Real-time messaging
* File storage integration
* Internship recommendation system
* Admin analytics dashboard
* JWT authentication
* REST API support
* Mobile responsive enhancements

---

## Security Recommendations

* Use password hashing (`password_hash`)
* Validate all user inputs
* Use prepared statements to prevent SQL Injection
* Implement CSRF protection
* Restrict file upload types
* Enable HTTPS in production

---

## Contributors

Feel free to contribute through pull requests and issue reports.

---

## License

This project is intended for educational and academic purposes.
