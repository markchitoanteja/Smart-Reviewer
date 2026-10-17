<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/database.php';

function jsonResponse($data, $statusCode = 200)
{
    header('Content-Type: application/json');
    http_response_code($statusCode);

    return json_encode($data);
}

$isError = false;
$message = '';
$data = [];
$studentProfile = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // LOGIN
    if ($_POST['action'] === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $rememberMe = isset($_POST['remember_me']);

        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $isError = true;
            $message = 'Invalid username or password.';
        } else {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user'] = $user;

            $studentProfileStmt = $pdo->prepare('SELECT * FROM student_profiles WHERE user_id = :user_id');
            $studentProfileStmt->execute(['user_id' => $user['user_id']]);
            $studentProfile = $studentProfileStmt->fetch(PDO::FETCH_ASSOC);

            $updateLastLogin = $pdo->prepare('UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE user_id = :user_id');
            $updateLastLogin->execute(['user_id' => $user['user_id']]);

            $_SESSION['student_profile'] = $studentProfile;
        }

        $data = [
            'isError' => $isError,
            'message' => $message,
            'studentProfile' => $studentProfile,
        ];

        echo jsonResponse($data);
    }
}