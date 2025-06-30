# Examination Application Processing System

## Overview

The **Examination Application Processing System** is a web-based platform designed to manage the registration, payment, and approval processes for students applying to exams in various departments and halls. The system provides seamless interaction between students, departments, and halls, ensuring that all the steps from application submission to final approval are tracked and processed efficiently.

## Features

* **Student Registration**: Students can register their personal and academic details, including hall and department assignments.
* **Department Approval**: Departments can approve or reject applications based on departmental requirements.
* **Hall Approval**: Halls can review and approve student applications based on hall-specific criteria.
* **Payment Integration**: Students' payments for applications are tracked, and their status is updated accordingly.
* **Admin Panel**: Admins can oversee all operations, including approvals, student data management, and report generation.
* **User Authentication**: Secure login for both students and administrative users.

## Database Structure

### Tables

* **student**: Contains student personal information and academic details.
* **department**: Holds department details, including department name and password for authentication.
* **department\_approval**: Stores the approval status for student applications at the departmental level.
* **hall**: Contains hall names and authentication details.
* **hall\_approval**: Holds approval status for student applications at the hall level.

### Example Data

The database has been populated with example data, including a few students, departments, halls, and approvals.

* **Departments**: iit, cse, pharmacy, mathematics, statistics, physics, chemistry.
* **Halls**: Shaheed Tazudiin Ahmed Hall, Sheikh Rassel Hall, Mowlana Bhashani Hall, Fazilatunnesa Hall, Prtilata Hall, Sheikh Hasina Hall, Khaleda Zia Hall.

### Example Query (SQL)

```sql
-- Insert a new department
INSERT INTO `department` (`id`, `name`, `password`) VALUES (8, 'new_department', 'password123');
```

## Technologies Used

* **Frontend**: HTML, CSS, JavaScript (React/Vue.js)
* **Backend**: PHP, MySQL/MariaDB
* **Authentication**: Secure login mechanism for both students and admin.
* **Database**: MySQL/MariaDB for storing student, department, and hall data.
* **Payment Gateway**: Handles payment processing for exam applications.

## Installation

### Prerequisites

* **PHP** (version 8.0 or higher)
* **MySQL** or **MariaDB** (version 10.4 or higher)
* **Apache** or **Nginx** for serving the application

### Steps to Run Locally

1. **Clone the repository**:

   ```bash
   git clone https://github.com/salman1237/Examination-Application-Processing-System.git
   cd Examination-Application-Processing-System
   ```

2. **Set up the database**:

   * Import the SQL file `exampayment.sql` into your MySQL/MariaDB database using phpMyAdmin or the MySQL command line.

   ```bash
   mysql -u username -p database_name < exampayment.sql
   ```

3. **Configure Database Connection**:

   * Edit the database configuration file (e.g., `dbconfig.php`) to set your MySQL/MariaDB credentials.

4. **Start the Apache server** (if using Apache):

   ```bash
   sudo systemctl start apache2
   ```

5. **Access the Application**:

   * Open your browser and navigate to `http://localhost/examination-app`.

## Usage

* **Students**:

  * Register, log in, and submit applications for exams.
  * Check the status of applications and make payments.

* **Departments**:

  * View and approve or reject student applications.

* **Halls**:

  * Review and approve student applications based on hall criteria.

## Contribution

We welcome contributions! To contribute, follow these steps:

1. Fork the repository.
2. Create a new branch.
3. Implement your changes.
4. Commit and push your changes.
5. Create a pull request with a description of your changes.
