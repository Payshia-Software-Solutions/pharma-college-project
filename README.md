Ceylon Pharma College Project
Table of Contents
Introduction
Features
Installation
Usage
Folder Structure
API Integration
Contributing
License
Contact
Introduction
The Ceylon Pharma College project is a web-based platform developed by Payshia Software Solutions for managing courses, assignments, and student information at Ceylon Pharma College. This project aims to provide a user-friendly interface for students and instructors to interact with course materials, assignments, and other resources.

Features
Course Management: Create, update, and delete courses with detailed information.
Assignment Management: Manage assignments, including uploading files, setting due dates, and tracking submissions.
User Authentication: Secure login system for students and instructors.
API Integration: Seamless integration with external APIs for enhanced functionalities.
Responsive Design: Optimized for both desktop and mobile devices.
Installation
Prerequisites
XAMPP (or any other PHP and MySQL server)
Composer (for managing PHP dependencies)
Git (for version control)
Steps
Clone the Repository:

bash
Copy code
git clone https://github.com/Payshia-Software-Solutions/pharma-college-project.git
Navigate to the Project Directory:

bash
Copy code
cd pharma-college-project
Install Dependencies:

bash
Copy code
composer install
Set Up the Database:

Create a MySQL database and import the SQL schema from the database folder.
Update the database configuration in config/database.php.
Run the Application:

Start your XAMPP server and navigate to http://localhost/pharma-college-project in your browser.
Usage
Adding a Course
Navigate to the "Courses" section from the dashboard.
Click "Add New Course" and fill in the required details.
Save the course, and it will be listed in the courses section.
Managing Assignments
Go to the "Assignments" section.
Upload files, set due dates, and provide descriptions for each assignment.
Students can submit their assignments, and instructors can track submissions.
Folder Structure
php
Copy code
pharma-college-project/
│
├── config/                 # Configuration files, including database settings
├── public/                 # Publicly accessible files (e.g., index.php)
├── routes/                 # Route definitions for the application
├── app/                    # Core application files (controllers, models, etc.)
├── resources/              # Views and templates
├── database/               # Database migrations and SQL files
├── storage/                # Uploaded files and cache
└── README.md               # Project documentation (this file)
API Integration
This project integrates with several APIs to extend its functionality:

To configure these APIs, update the respective configuration files in the config/ folder.

Contributing
We welcome contributions to the Ceylon Pharma College project! Please follow these steps to contribute:

Fork the repository.
Create a new branch with your feature or bugfix.
Submit a pull request with a detailed explanation of your changes.
License
This project is licensed under the MIT License. See the LICENSE file for more details.

Contact
For any questions or support, please contact the development team at:

Email: support@payshia.com
Phone: +94 77 0 481 363
