<?php
// Include database configuration
require_once 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle different actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle form submission (Add new user)
    if (isset($_POST['name']) && isset($_POST['age'])) {
        addUser($_POST['name'], $_POST['age']);
        exit; // Important: exit after handling
    }

    // Handle toggle status
    elseif (isset($_POST['action']) && $_POST['action'] === 'toggle' && isset($_POST['user_id'])) {
        toggleUserStatus($_POST['user_id']);
        exit; // Important: exit after handling
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Handle fetch users request
    if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
        fetchUsers();
    }
}

// Function to add a new user
function addUser($name, $age) {
    header('Content-Type: application/json');

    try {
        // Validate input first
        $name = trim($name);
        $age = intval($age);

        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'الاسم مطلوب']);
            return;
        }

        if ($age <= 0 || $age > 120) {
            echo json_encode(['success' => false, 'message' => 'العمر يجب أن يكون بين 1 و 120']);
            return;
        }

        // Get database connection
        $conn = getDBConnection();

        if (!$conn) {
            echo json_encode(['success' => false, 'message' => 'فشل الاتصال بقاعدة البيانات']);
            return;
        }

        // Prepare and execute insert statement
        $stmt = $conn->prepare("INSERT INTO users (name, age, status) VALUES (?, ?, 0)");

        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'خطأ في إعداد الاستعلام: ' . $conn->error]);
            $conn->close();
            return;
        }

        $stmt->bind_param("si", $name, $age);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'تم إضافة المستخدم بنجاح']);
        } else {
            echo json_encode(['success' => false, 'message' => 'خطأ في إضافة المستخدم: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'خطأ في قاعدة البيانات: ' . $e->getMessage()]);
    }
}

// Function to toggle user status
function toggleUserStatus($userId) {
    header('Content-Type: application/json');
    try {
        $conn = getDBConnection();
        
        $userId = intval($userId);
        
        // First, get current status
        $stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $newStatus = $row['status'] == 1 ? 0 : 1;
            
            // Update status
            $updateStmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
            $updateStmt->bind_param("ii", $newStatus, $userId);
            
            if ($updateStmt->execute()) {
                echo json_encode(['success' => true, 'new_status' => $newStatus]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating status']);
            }
            
            $updateStmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

// Function to fetch and display all users
function fetchUsers() {
    try {
        $conn = getDBConnection();
        
        $sql = "SELECT id, name, age, status FROM users ORDER BY id ASC";
        $result = $conn->query($sql);
        
        // Set content type to HTML for this response
        header('Content-Type: text/html');
        
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Age</th>';
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            while ($row = $result->fetch_assoc()) {
                $statusText = $row['status'] == 1 ? '1' : '0';
                $statusClass = $row['status'] == 1 ? 'status-active' : 'status-inactive';
                $buttonClass = $row['status'] == 1 ? 'toggle-btn active' : 'toggle-btn';
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['age']) . '</td>';
                echo '<td class="' . $statusClass . '">' . $statusText . '</td>';
                echo '<td>';
                echo '<button class="' . $buttonClass . '" onclick="toggleStatus(' . $row['id'] . ')">Toggle</button>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="loading">No users found. Add some users using the form above.</div>';
        }
        
        $conn->close();
        
    } catch (Exception $e) {
        echo '<div class="error">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
