<?php
require_once 'db_config.php';

echo "<body style='font-family: sans-serif; padding: 2rem;'>";

try {
    // Connect to MySQL Database
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div>Attempting to connect to MySQL... <span style='color:green'>Connected!</span></div>";

    // Create Database - SKIP implementation for cloud compatibility (Cloud usually pre-provisions DB)
    // $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    
    // Select Database - Already selected in DSN
    // $pdo->exec("USE `$dbname`");
    
    // Create Table
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
    echo "<div>Attempting to create table 'students'... <span style='color:green'>Done!</span></div>";

    echo "<h1 style='color:green'>✅ SETUP COMPLETE</h1>";
    echo "<p>Your database is ready. You can now use the form.</p>";
    echo "<p><a href='index.html' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Registration Form</a></p>";

} catch (PDOException $e) {
    echo "<h1 style='color:red'>❌ SETUP FAILED</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please ensure XAMPP MySQL is running.</p>";
}

echo "</body>";
?>
