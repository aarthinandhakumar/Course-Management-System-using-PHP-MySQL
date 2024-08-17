# Course Management System

## Overview
This web application allows users to manage a list of courses and the students enrolled in each course. It is designed to demonstrate proficiency with PHP Data Objects (PDO) for database interaction, as well as form handling, CRUD operations, and dynamic web page generation.

## Technologies Used
- PHP (with PDO)
- HTML
- CSS (Bootstrap for styling)
- Apache Server (for running PHP scripts)
- MySQL (for data persistence)

## Prerequisites
Before you begin, ensure you have the following installed:
- [XAMPP](https://www.apachefriends.org/index.html), [WAMP](http://www.wampserver.com/en/), or [MAMP](https://www.mamp.info/en/) (for running a local Apache server with PHP support)
- A web browser (e.g., Chrome, Firefox)

## Installation Steps
1. **Download and Install XAMPP/WAMP/MAMP:**
   - Download XAMPP from [here](https://www.apachefriends.org/index.html) or choose WAMP/MAMP as per your OS.
   - Install the server environment by following the installation instructions on the website.

2. **Setup the Project Folder:**
   - Create and name the project folder.
   - Download or clone the project repository.

3. **Move the Project Folder to the Server Directory:**
   - For XAMPP, move the folder to the `htdocs` directory.
   - For WAMP, move the folder to the `www` directory.

4. **Configure the Database:**
   - Create a MySQL database named `course_student_db`.
   - Import the provided SQL file (`database.sql`) which contains the required tables and sample data.

5. **Update Database Configuration:**
   - In the `database.php` file, update the database credentials (`host`, `username`, `password`, `dbname`) as per your local setup.

6. **Start the Server:**
   - Open the XAMPP/WAMP/MAMP control panel.
   - Start the Apache server.
   - Start MySQL server

7. **Access the Application in a Web Browser:**
   - Open a web browser and navigate to `http://localhost/*project folder name/index.php
  
## Implementation:
In this part, the following functionalities are implemented:
1. **Home Page (`index.php`)**: Displays a list of courses and students enrolled in the first course.
2. **Add Course (`add_course.php`)**: Allows adding a new course to the database.
3. **Add Student (`add_student.php`)**: Allows adding a new student to a selected course.
4. **Delete Student (`delete_student.php`)**: Deletes a student from the selected course.

## Database Schema
The database structure is as follows:
- **Courses Table**: Contains course ID and course name.
- **Students Table**: Contains student ID, first name, last name, email, and the course they are enrolled in.

## License
This project is licensed under the MIT License - see the [LICENSE](License.txt) file for details.
