<?php
// Test database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'info';

echo "<h2>اختبار الاتصال بقاعدة البيانات</h2>";

// Test connection without database first
$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
    die("فشل الاتصال بـ MySQL: " . $conn->connect_error);
}
echo "✅ الاتصال بـ MySQL نجح<br>";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "✅ قاعدة البيانات 'info' موجودة أو تم إنشاؤها<br>";
} else {
    echo "❌ خطأ في إنشاء قاعدة البيانات: " . $conn->error . "<br>";
}

$conn->close();

// Now connect to the specific database
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات 'info': " . $conn->connect_error);
}
echo "✅ الاتصال بقاعدة البيانات 'info' نجح<br>";

// Create table
$createTable = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        age INT NOT NULL,
        status TINYINT DEFAULT 0
    )
";

if ($conn->query($createTable) === TRUE) {
    echo "✅ جدول 'users' موجود أو تم إنشاؤه<br>";
} else {
    echo "❌ خطأ في إنشاء الجدول: " . $conn->error . "<br>";
}

// Check if table has data
$result = $conn->query("SELECT COUNT(*) as count FROM users");
$row = $result->fetch_assoc();
echo "📊 عدد المستخدمين الحاليين: " . $row['count'] . "<br>";

// Add sample data if empty
if ($row['count'] == 0) {
   
    
    
    if ($conn->query($sampleData) === TRUE) {
        echo "✅ تم إضافة البيانات التجريبية<br>";
    } else {
        echo "❌ خطأ في إضافة البيانات التجريبية: " . $conn->error . "<br>";
    }
}

// Show all users
echo "<h3>المستخدمون الحاليون:</h3>";
$result = $conn->query("SELECT * FROM users");
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Status</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "لا توجد بيانات";
}

$conn->close();
echo "<br><br><a href='index.html'>العودة للصفحة الرئيسية</a>";
?>
