<?php
// test_db.php
// A simple script to debug Database Connection on Cloud

header('Content-Type: text/plain');

require_once 'db_config.php';

echo "--- CONNECTION DEBUGGER ---\n";
echo "Host: " . $host . "\n";
echo "User: " . $username . "\n";
echo "Port: " . $port . "\n";
echo "Database: " . $dbname . "\n";
// Do not print password!
echo "Password Length: " . strlen($password) . "\n";

echo "\n--- ATTEMPTING CONNECTION ---\n";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ SUCCESS: Connected to MySQL successfully!\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'students'");
    if ($stmt->rowCount() > 0) {
        echo "✅ SUCCESS: Table 'students' exists.\n";
        
        // Count rows
        $count = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
        echo "ℹ️ INFO: Current number of rows in 'students': $count\n";
    } else {
        echo "❌ ERROR: Table 'students' DOES NOT exist. Did you run the SQL?\n";
    }

} catch (PDOException $e) {
    echo "❌ CONNECTION FAILED: " . $e->getMessage() . "\n";
}
?>
