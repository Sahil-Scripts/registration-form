<?php
// Database configuration
// Priority: Cloud Environment Variable (Railway/Etc) -> Custom Env Var -> Local Fallback

$host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'localhost';
$username = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASS') ?: '12345';
$dbname = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'registration_db';
$port = getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: 3306;
?>
