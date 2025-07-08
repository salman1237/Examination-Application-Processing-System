# XAMPP Setup Guide for Examination Application Processing System

## What is XAMPP?

XAMPP is a free and open-source cross-platform web server solution stack package, consisting mainly of the Apache HTTP Server, MySQL database, and interpreters for scripts written in PHP and Perl. It provides a local server environment for testing and development.

## Installation

1. Download XAMPP from the official website: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
2. Choose the version compatible with your operating system (Windows, macOS, or Linux)
3. Run the installer and follow the installation wizard
4. Install XAMPP to the default location (`C:\xampp` on Windows)

## Starting XAMPP Services

1. Open the XAMPP Control Panel
   - On Windows: Start Menu → XAMPP → XAMPP Control Panel
   - On macOS: Open Applications → XAMPP → XAMPP Control Panel
   - On Linux: Run `sudo /opt/lampp/lampp start` in terminal

2. Start the required services by clicking the "Start" buttons:
   - Apache (Web Server)
   - MySQL (Database Server)

3. Verify services are running by checking for green status indicators

## Project Setup

1. Place the Examination Application Processing System in the XAMPP htdocs folder:
   - Windows: `C:\xampp\htdocs\Examination-Application-Processing-System`
   - macOS: `/Applications/XAMPP/htdocs/Examination-Application-Processing-System`
   - Linux: `/opt/lampp/htdocs/Examination-Application-Processing-System`

2. Ensure proper folder permissions:
   - The web server needs read and write access to the project folder
   - On Windows, this is usually not an issue
   - On macOS/Linux, you may need to set permissions: `chmod -R 755 /path/to/htdocs/Examination-Application-Processing-System`

## Database Configuration

1. Open phpMyAdmin:
   - Start XAMPP services (Apache and MySQL)
   - Open your browser and navigate to: `http://localhost/phpmyadmin`

2. Create a new database (if not using the automatic setup):
   - Click on "New" in the left sidebar
   - Enter database name: `exampayment`
   - Select collation: `utf8mb4_general_ci`
   - Click "Create"

3. Import database structure (if not using the automatic setup):
   - Select the `exampayment` database from the left sidebar
   - Click on the "Import" tab
   - Click "Browse" and select the SQL file (`exampayment.sql`)
   - Click "Go" to import

## Accessing the Application

1. Open your web browser
2. Navigate to: `http://localhost/Examination-Application-Processing-System`
3. The application homepage should appear

## Automatic Database Setup

For convenience, the system includes an automatic database setup script:

1. Navigate to: `http://localhost/Examination-Application-Processing-System/setup_database.php`
2. This will automatically create all necessary database tables

## PHP Configuration

If you encounter issues with PHP settings:

1. Open the XAMPP Control Panel
2. Click on "Config" button for Apache
3. Select "PHP (php.ini)"
4. Make the following changes if needed:
   - Increase `upload_max_filesize` and `post_max_size` for file uploads
   - Set `session.gc_maxlifetime` to control session timeout
   - Enable required extensions (mysqli, gd, etc.)
5. Save the file and restart Apache

## Session Management

The application uses PHP sessions for user authentication and state management:

1. Sessions are stored in the default PHP session directory
2. Session cookies are used to track user sessions
3. Session timeout is controlled by PHP's `session.gc_maxlifetime` setting

## Troubleshooting XAMPP

### Apache Won't Start

- Check if another web server is using port 80 (like IIS or Skype)
- Try changing Apache's port in `httpd.conf`
- Check Windows Services for conflicting services

### MySQL Won't Start

- Check if another MySQL instance is running
- Verify the data directory permissions
- Check the MySQL error log in XAMPP logs directory

### PHP Errors

- Enable error display in php.ini for development
- Check the Apache error log for PHP errors
- Verify required PHP extensions are enabled

## Security Notes

This setup is intended for development and testing. For production:

- Change default MySQL credentials
- Secure the phpMyAdmin access
- Configure proper firewall settings
- Use HTTPS instead of HTTP

## Additional Resources

- [XAMPP Documentation](https://www.apachefriends.org/docs/)
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)