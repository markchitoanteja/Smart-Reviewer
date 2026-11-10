<?php
declare(strict_types=1);

// Allowed origins
$allowedOrigins = ["http://localhost", "https://smart-reviewer.site.je"];

// Get the request origin
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Allow requests from trusted origins only
if (in_array($origin, $allowedOrigins, true)) {
    header("Access-Control-Allow-Origin: $origin");
}

// Allow HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow request headers
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// define('REMEMBER_ME_DURATION', 1 * 60); // 1 minute for testing
define('REMEMBER_ME_DURATION', 30 * 86400); // 30 days

/**
 * Load environment variables from a .env file.
 */
function loadEnv(string $path): void
{
    if (!is_readable($path)) {
        throw new RuntimeException(
            "Environment file not found or unreadable: {$path}"
        );
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // Ignore comments.
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        // Ignore lines without a key-value separator.
        if (!str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        // Ignore empty keys.
        if ($key === '') {
            continue;
        }

        // Remove matching surrounding quotes.
        if (
            strlen($value) >= 2 &&
            (
                ($value[0] === '"' && str_ends_with($value, '"')) ||
                ($value[0] === "'" && str_ends_with($value, "'"))
            )
        ) {
            $value = substr($value, 1, -1);
        }

        // Do not overwrite existing environment variables.
        if (getenv($key) !== false || isset($_ENV[$key]) || isset($_SERVER[$key])) {
            continue;
        }

        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;

        putenv("$key=$value");
    }
}

/**
 * Retrieve an environment variable.
 */
function env(string $key, mixed $default = null): mixed
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    return $value !== false && $value !== null ? $value : $default;
}

/**
 * Get the application base URL.
 */
function base_url(): string
{
    $host = $_SERVER['HTTP_HOST'] ?? '';

    // Local development: localhost
    if ($host === 'localhost' || str_starts_with($host, 'localhost:')) {
        return 'http://localhost/Smart-Reviewer';
    }

    // Local network: 192.168.1.8
    if ($host === '192.168.1.8' || str_starts_with($host, '192.168.1.8:')) {
        return 'http://192.168.1.8/Smart-Reviewer';
    }

    // Production: use APP_URL from .env
    return rtrim((string) env('APP_URL', 'https://smart-reviewer.site.je'), '/');
}

/**
 * Send a JSON response and terminate the script.
 */
function jsonResponse($data, $statusCode = 200)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function setFlashMessage(string $key, string|array $message): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['flash_messages'][$key] = $message;
}

function getFlashMessage(string $key): string|array|null
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $message = $_SESSION['flash_messages'][$key] ?? null;

    unset($_SESSION['flash_messages'][$key]);

    if (empty($_SESSION['flash_messages'])) {
        unset($_SESSION['flash_messages']);
    }

    return $message;
}

// ==========================================
// REMEMBER ME AUTHENTICATION
// ==========================================

/**
 * Get the shared database instance.
 */
function rememberDatabase(): Database
{
    static $db = null;

    if ($db === null) {
        $db = new Database();
    }

    return $db;
}

/**
 * Set the Remember Me cookie.
 */
function setRememberCookie(string $value, int $expires): void
{
    setcookie('remember_me', $value, [
        'expires' => $expires,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) &&
            $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

/**
 * Clear the Remember Me cookie.
 */
function clearRememberCookie(): void
{
    setRememberCookie('', time() - 3600);
}

/**
 * Create a Remember Me token.
 *
 * @param int $userId Admin user ID.
 */
function createRememberToken(int $userId): void
{
    $db = rememberDatabase();

    $selector = bin2hex(random_bytes(12));
    $validator = bin2hex(random_bytes(32));

    $tokenHash = hash('sha256', $validator);

    $expiresAt = date('Y-m-d H:i:s', time() + REMEMBER_ME_DURATION);

    // Single-device policy.
    $db->deleteUserRememberTokens($userId);

    // Save token in database.
    $db->createRememberToken($userId, $selector, $tokenHash, $expiresAt);

    // Save cookie in browser.
    setRememberCookie($selector . ':' . $validator, time() + REMEMBER_ME_DURATION);
}

/**
 * Restore admin session using Remember Me.
 */
function restoreRememberedLogin(): bool
{
    if (!empty($_SESSION['user_id'])) {
        return true;
    }

    if (empty($_COOKIE['remember_me'])) {
        return false;
    }

    $parts = explode(':', $_COOKIE['remember_me'], 2);

    if (count($parts) !== 2) {
        clearRememberCookie();
        return false;
    }

    [$selector, $validator] = $parts;

    // Validate token format.
    if (!preg_match('/^[a-f0-9]{24}$/', $selector) || !preg_match('/^[a-f0-9]{64}$/', $validator)) {
        clearRememberCookie();
        return false;
    }

    $db = rememberDatabase();

    // Find token.
    $token = $db->findRememberToken($selector);

    // Token does not exist.
    if (!$token) {
        clearRememberCookie();
        return false;
    }

    // Check token expiration.
    if (strtotime($token['expires_at']) <= time()) {

        $db->deleteExpiredRememberTokens();
        clearRememberCookie();

        return false;
    }

    // Verify token hash.
    if (
        !hash_equals(
            $token['token_hash'],
            hash('sha256', $validator)
        )
    ) {
        $db->deleteRememberToken($selector);
        clearRememberCookie();

        return false;
    }

    // Verify admin account.
    $user = $db->table('users')
        ->where('id', (int) $token['user_id'])
        ->where('status', 'active')
        ->first();

    if (!$user) {
        $db->deleteRememberToken($selector);
        clearRememberCookie();

        return false;
    }

    // Restore session.
    session_regenerate_id(true);

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Rotate token after successful restoration.
    createRememberToken((int) $user['id']);

    return true;
}

/**
 * Revoke Remember Me tokens.
 *
 * @param int|null $userId Specific user or current browser token.
 */
function revokeRememberTokens(?int $userId = null): void
{
    $db = rememberDatabase();

    if ($userId !== null) {
        $db->deleteUserRememberTokens($userId);
    } elseif (!empty($_COOKIE['remember_me'])) {
        $parts = explode(':', $_COOKIE['remember_me'], 2);

        if (count($parts) === 2 && preg_match('/^[a-f0-9]{24}$/', $parts[0])) {
            $db->deleteRememberToken($parts[0]);
        }
    }

    clearRememberCookie();
}

/**
 * Escape HTML output to prevent XSS attacks.
 */
function escape($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function formatDate($date, $format = 'F d, Y'): string
{
    if (empty($date) || $date === '0000-00-00') {
        return 'Not provided';
    }

    try {
        $dateTime = new DateTime($date);

        return $dateTime->format($format);
    } catch (Exception $e) {
        return 'Not provided';
    }
}

/**
 * Upload an image to assets/img/uploads.
 *
 * @param string $inputName The FormData key.
 * @param int $maxSize Maximum file size in bytes (default: 2 MB).
 *
 * @return string|null Random filename, or null if no image was uploaded.
 *
 * @throws RuntimeException If the upload fails or validation fails.
 */
function uploadImage(string $inputName, int $maxSize = 2097152): ?string
{
    // Check if an image was uploaded.
    if (!isset($_FILES[$inputName])) {
        return null;
    }

    $file = $_FILES[$inputName];

    // No image selected.
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    // Check upload errors.
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Image upload failed.');
    }

    // Validate file size.
    if ($file['size'] > $maxSize) {
        throw new RuntimeException('Image must not exceed 2 MB.');
    }

    // Verify uploaded file.
    if (!is_uploaded_file($file['tmp_name'])) {
        throw new RuntimeException('Invalid uploaded file.');
    }

    // Detect actual MIME type.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($allowedTypes[$mimeType])) {
        throw new RuntimeException(
            'Only JPG, PNG, and WEBP images are allowed.'
        );
    }

    // Verify image structure.
    if (getimagesize($file['tmp_name']) === false) {
        throw new RuntimeException('Invalid image file.');
    }

    // Upload directory.
    $uploadDir = dirname(__DIR__) . '/assets/img/uploads/';

    // Create directory if necessary.
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            throw new RuntimeException('Unable to create upload directory.');
        }
    }

    // Generate random filename.
    $extension = $allowedTypes[$mimeType];

    $fileName = bin2hex(random_bytes(16)) . '.' . $extension;

    // Save image.
    $destination = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Unable to save uploaded image.');
    }

    // Return filename only.
    return $fileName;
}

// Load environment variables automatically.
loadEnv(dirname(__DIR__) . '/.env');