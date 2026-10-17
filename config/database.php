<?php
declare(strict_types=1);

$host = 'localhost';
$dbname = 'smart_reviewer_db';
$dbUsername = 'root';
$dbPassword = '';

// $host = 'sql211.infinityfree.com';
// $dbname = 'if0_43193599_smart_reviewer_db';
// $dbUsername = 'if0_43193599';
// $dbPassword = '0PGFOKkaU0v9N';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $dbUsername,
        $dbPassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log('Smart Reviewer database connection failed: ' . $e->getMessage());

    http_response_code(500);
    exit('Unable to connect to the database. Please try again later.');
}