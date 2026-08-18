# Employee Management System

A simple web-based Employee Management System built with PHP, MySQL, Bootstrap, and native PHP sessions.

This project demonstrates basic employee data management through a clean and responsive admin dashboard.

## Features

- Admin authentication
- Session-based access protection
- Dynamic dashboard
- Employee management
- Add employee
- Edit employee
- Delete employee
- Employee search
- Email validation
- Duplicate Employee ID validation
- Responsive interface
- MySQL database integration
- Prepared statements for database operations

## Technologies

- PHP
- MySQL
- HTML5
- CSS3
- Bootstrap 5
- Bootstrap Icons
- XAMPP

## Screenshots

Screenshots will be added soon.

## Installation

1. Clone or download this repository.

2. Move the project folder to:

```text
C:\xampp\htdocs\
```

3. Start Apache and MySQL from XAMPP.

4. Open phpMyAdmin.

5. Create a database named:

```text
db_pegawai
```

6. Import:

```text
db_pegawai.sql
```

7. Make sure the database configuration in:

```text
config/database.php
```

matches your local MySQL configuration.

8. Open the application:

```text
http://localhost/employee-management/
```

## Demo Account

```text
Username: admin
Password: password
```

The demo credentials and employee records included in this repository are for demonstration purposes only.

## Project Structure

```text
employee-management/
├── admin/
│   ├── partials/
│   │   ├── sidebar.php
│   │   └── topbar.php
│   ├── index.php
│   ├── pegawai.php
│   ├── tambah.php
│   ├── edit.php
│   └── hapus.php
├── assets/
├── config/
│   └── database.php
├── db_pegawai.sql
├── index.php
├── login.php
├── logout.php
└── README.md
```

## Purpose

This project was developed as a portfolio project to demonstrate fundamental web development skills using PHP and MySQL.

It covers authentication, CRUD operations, database interaction, input validation, search functionality, reusable PHP components, and responsive interface development.

## Author

Developed as a personal web development portfolio project.