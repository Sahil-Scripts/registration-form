<?php
header('Content-Type: application/json');

require_once 'db_config.php';

try {
    // Connect to MySQL Database directly
    // This supports cloud providers that give you a specific database name
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. Auto-create table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        dob DATE NOT NULL,
        course VARCHAR(50) NOT NULL,
        gender VARCHAR(10) NOT NULL,
        address TEXT,
        interests TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    
    // Validate request method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Helper function for sanitization
        function s($k) { 
            return isset($_POST[$k]) ? trim($_POST[$k]) : ''; 
        }

        $fullName = s('fullName');
        $email = s('email');
        $phone = s('phone');
        $dob = s('dob');
        $course = s('course');
        $gender = s('gender');
        $address = s('address');
        
        // Handle interests array
        $interests = isset($_POST['interests']) ? implode(', ', $_POST['interests']) : '';

        // Prepare SQL and insert
        $stmt = $pdo->prepare("INSERT INTO students (full_name, email, phone, dob, course, gender, address, interests) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([$fullName, $email, $phone, $dob, $course, $gender, $address, $interests]);

        echo json_encode([
            "status" => "success", 
            "message" => "Registration saved to database successfully!",
            "data" => [
                "fullName" => $fullName,
                "email" => $email,
                "course" => $course
            ]
        ]);
        
    } else {
        throw new Exception("Invalid request method.");
    }

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
} catch(Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>