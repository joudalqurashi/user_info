<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'info');

// Function to get database connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }



    // Add sample data if table is empty
    $checkData = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $checkData->fetch_assoc();
    
    

    return $conn;
}
?>
