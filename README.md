# Examination Application Processing System

## Overview

The **Examination Application Processing System** is a comprehensive web-based platform designed for university students to apply for examinations, make fee payments, and track application status. The system streamlines the entire process from application submission to approval by department and hall authorities, and finally to fee payment and admit card generation.

## Features

* **Student Dashboard**: Students can view their profile, submit new applications, and track application status.
* **Profile Management**: Students can view and edit their personal and academic information.
* **Application Submission**: Students can select courses, specify fee details, and submit applications for examinations.
* **Department Approval**: Department authorities can review and approve/reject student applications.
* **Hall Approval**: Hall authorities can review and approve/reject student applications.
* **Payment Processing**: Secure payment gateway integration for fee collection.
* **Admit Card Generation**: HTML-based admit cards with print functionality after successful payment.
* **Application Status Tracking**: Real-time tracking of application status (Pending, Approved, Declined, Paid).

## Database Structure

### Key Tables

* **student**: Stores student personal information, academic details, and authentication credentials.
* **applications**: Contains examination application details including fees, approval status, and payment information.
* **application_courses**: Links applications to selected courses for each examination.
* **courses**: Stores course information organized by department, year, and semester.
* **department**: Contains department information and authentication credentials.
* **hall**: Stores hall information and authentication credentials.

### Relationships

* Students submit applications for examinations
* Each application can have multiple courses
* Department and hall authorities approve applications
* Approved applications can proceed to payment
* Paid applications generate admit cards

### Sample Data

The system includes sample data for testing:

* **Departments**: IIT, CSE, Pharmacy, Mathematics, Statistics, Physics, Chemistry
* **Halls**: Shaheed Tazudiin Ahmed Hall, Sheikh Rassel Hall, Mowlana Bhashani Hall, Fazilatunnesa Hall, Prtilata Hall, Sheikh Hasina Hall, Khaleda Zia Hall
* **Fee Types**: Student fee, Hall rent, Admission fee, Library deposit, Sports fee, etc.

## Technologies Used

* **Frontend**: HTML, CSS, Bootstrap 4.5, jQuery, JavaScript
* **Backend**: PHP 8.0+
* **Database**: MySQL/MariaDB
* **Authentication**: Session-based authentication for students, departments, and halls
* **Payment Gateway**: Integration with payment processing services
* **Admit Card Generation**: HTML-based admit cards with browser print functionality

## Installation

### Prerequisites

* **XAMPP** (or similar package with PHP 8.0+, MySQL, Apache)
* **Web Browser** (Chrome, Firefox, Edge, etc.)
* **Internet Connection** (for Bootstrap and jQuery CDN)

### Steps to Run Locally

1. **Clone or download the project**:
   ```bash
   git clone https://github.com/salman1237/Examination-Application-Processing-System

   ```
   Or download and extract the ZIP file.

2. **Set up the environment**:
   * Place the project folder in your XAMPP's htdocs directory
   * Start Apache and MySQL services from XAMPP control panel

3. **Import the database**:
   * Open phpMyAdmin (http://localhost/phpmyadmin)
   * Create a new database named 'exampayment'
   * Import the `exampayment.sql` file

4. **Configure database connection**:
   * Edit the `connect.php` file with your database credentials if needed

5. **Access the application**:
   * Open your browser and navigate to `http://localhost/payment`

## User Guide

### For Students

* **Login**: Use your registration number and password
* **Profile Management**: View and edit your personal information
* **Application Submission**: Select year, semester, courses, and specify fees
* **Application Tracking**: Monitor application status (Pending, Approved, Declined, Paid)
* **Payment**: Make payments for approved applications
* **Admit Card**: View and print admit cards for paid applications

### For Department Authorities

* **Login**: Use department credentials
* **Application Review**: View student applications and their details
* **Approval/Rejection**: Approve or reject applications based on department criteria

### For Hall Authorities

* **Login**: Use hall credentials
* **Application Review**: View student applications and their details
* **Approval/Rejection**: Approve or reject applications based on hall criteria

## Contribution

We welcome contributions! To contribute, follow these steps:

1. Fork the repository.
2. Create a new branch.
3. Implement your changes.
4. Commit and push your changes.
5. Create a pull request with a description of your changes.
