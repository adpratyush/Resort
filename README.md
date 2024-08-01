Hotel Booking System Setup
This guide will help you set up the Hotel Booking System on your local machine using XAMPP.

Prerequisites
XAMPP (Apache, MySQL, PHP)
Steps
1. Download and Install XAMPP
Download XAMPP from https://www.apachefriends.org/index.html.
Install XAMPP on your machine by following the installation instructions.
2. Start Apache and MySQL
Open the XAMPP Control Panel.
Start the Apache and MySQL services by clicking on the "Start" buttons next to them.
3. Set Up the Project
Save your project folder (containing the project files) in the following directory:
javascript
Copy code
C:/xampp/htdocs/folder
4. Create the Database
Open your web browser and go to:
arduino
Copy code
http://localhost/phpmyadmin/
Create a new database named hotel.
5. Import the Database
In phpMyAdmin, select the hotel database.
Click on the "Import" tab.
Click "Choose File" and select the queries.sql file from your project folder.
Click "Go" to import the SQL queries and set up the database tables.
6. Access the Project
Open your web browser and go to:
arduino
Copy code
http://localhost/folder
This will open the Hotel Booking System.
Additional Notes
Ensure that the queries.sql file contains the necessary SQL commands to create and populate the hotel database.
Make sure the project files in the folder are properly configured to connect to the MySQL database. Typically, this involves setting the correct database credentials in a configuration file (e.g., config.php).
By following these steps, you should be able to set up and run the Hotel Booking System on your local machine. If you encounter any issues, check the XAMPP Control Panel for error messages and ensure all services are running correctly.
