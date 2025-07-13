# User Management System 👥

A simple and elegant web-based User Management System built with HTML, CSS, and PHP. This application allows you to manage users with real-time data operations and a clean, responsive interface.


## 📁 Project Structure

```
├── index.html          # Main HTML page with form and table
├── dp.php             # PHP handler for all backend operations
├── config.php         # Database configuration and connection
├── style.css          # CSS styling for responsive design
├── test_connection.php # Database connection testing utility
└── README.md          # Project documentation
```

## 🛠️ Technologies Used

- **Frontend**: HTML5, CSS3
- **Backend**: PHP
- **Database**: MySQL
- **Server**: Apache (XAMPP)

## ⚡ Quick Start

### Prerequisites

- XAMPP server
- PHP 
- MySQL
- Web browser (Chrome, Firefox, Safari, Edge)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/user-management-system.git
   cd user-management-system
   ```

2. **Setup your web server**
   - Place the project folder in your web server directory
   - For XAMPP: `C:\xampp\htdocs\user-management-system\`
    
3. **Start your services**
   - Start Apache and MySQL services
   - Open phpMyAdmin or MySQL command line

4. **Create the database** ⭐
   ```sql
   CREATE DATABASE info;
   USE info;
   
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       age INT NOT NULL,
       status TINYINT DEFAULT 0
   );
   ```

<img width="1919" height="802" alt="image" src="https://github.com/user-attachments/assets/cf2db636-2ec2-43b5-bcbd-02290c658f93" />


<img width="1432" height="810" alt="image" src="https://github.com/user-attachments/assets/68018fba-cfeb-45f2-9b8d-3c49a7b9060c" />


<img width="1407" height="767" alt="image" src="https://github.com/user-attachments/assets/ea14885b-a0b4-4329-9b35-ca3ccc011c37" />



<img width="1422" height="872" alt="image" src="https://github.com/user-attachments/assets/80bbbc5b-2162-4c16-a483-f706fb8157a0" />


<img width="1396" height="841" alt="image" src="https://github.com/user-attachments/assets/3488472f-5399-485d-bbf4-d91208b714d9" />

<img width="1839" height="884" alt="image" src="https://github.com/user-attachments/assets/1fc5bba9-0132-4d0d-9dc5-edad205ddf7e" />


