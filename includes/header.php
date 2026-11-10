<?php

require_once __DIR__ . '/../core/utils.php';

// Restore remembered login if no active session exists.
if (!isset($_SESSION['user_id'])) {
    restoreRememberedLogin();
}

// Protect the dashboard.
if (!isset($_SESSION['user_id'])) {
    setFlashMessage('login_message', [
        'title' => 'Oops!',
        'type' => 'danger',
        'text' => 'You need to log in to access the dashboard.'
    ]);

    header('Location: login.php');
    exit;
}

if (!isset($pageTitle)) {
    $pageTitle = 'Smart Reviewer';
}

if (!isset($activePage)) {
    $activePage = 'dashboard';
}

/*
|--------------------------------------------------------------------------
| PROFILE DATA
|--------------------------------------------------------------------------
*/

$userProfile = $_SESSION['userProfile'] ?? [];

$student = $userProfile['student'] ?? [];
$user = $userProfile['user'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#155EEF">
    <title><?= htmlspecialchars($pageTitle) ?> | Smart Reviewer</title>

    <!-- Bootstrap and Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Shared app styles -->
    <link rel="stylesheet" href="assets/css/main.css?v=<?= env("APP_VERSION") ?>">
</head>

<body>
    <div class="app-shell">
        <header class="app-topbar">
            <a href="dashboard.php" class="brand-lockup" aria-label="Smart Reviewer home">
                <span class="brand-logo">
                    <img src="assets/img/school-logo-transparent.png" alt="" onerror="this.style.display='none';">
                    <i class="bi bi-mortarboard-fill brand-fallback"></i>
                </span>
                <span class="brand-copy">
                    <strong>Smart Reviewer</strong>
                    <small>Dolores National High School</small>
                </span>
            </a>
            <button class="topbar-action" type="button" aria-label="Settings" title="Settings">
                <i class="bi bi-gear"></i>
            </button>
        </header>