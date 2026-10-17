<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$fullName = trim(($_SESSION['user']['first_name'] ?? '') . ' ' . (!empty($_SESSION['user']['middle_name']) ? strtoupper(substr($_SESSION['user']['middle_name'], 0, 1)) . '. ' : '') . ($_SESSION['user']['last_name'] ?? '')) ?: 'Student';

$pageTitle = $pageTitle ?? 'Smart Reviewer';
$activePage = $activePage ?? 'dashboard';

$allowedPages = ['dashboard', 'reviewer', 'quizzes', 'progress', 'profile'];

if (!in_array($activePage, $allowedPages, true)) {
    $activePage = 'dashboard';
}

$schoolLogo = __DIR__ . '/../assets/img/official-logo.png';
$logoUrl = 'assets/img/official-logo.png';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <meta name="theme-color" content="#155EEF">
    <meta name="mobile-web-app-capable" content="yes">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | Smart Reviewer</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/main.css?v=1.4" rel="stylesheet">
</head>

<body>
    <!-- Application Loading Overlay -->
    <div class="page-loader" id="pageLoader" role="status" aria-label="Loading Smart Reviewer">
        <div class="loader-content">

            <div class="loader-logo-wrapper">
                <div class="loader-spinner"></div>

                <div class="loader-logo">
                    <?php if (file_exists($schoolLogo)): ?>
                        <img src="<?= htmlspecialchars(
                            $logoUrl,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>" alt="">
                    <?php else: ?>
                        <i class="fa-solid fa-book-open-reader" style="font-size:30px;color:#155EEF;"></i>
                    <?php endif; ?>
                </div>
            </div>

            <h1 class="loader-school-name">
                Dolores National High School
            </h1>

            <div class="loader-divider"></div>

            <div class="loader-app-name">
                Smart Reviewer
            </div>

            <div class="loader-status" aria-hidden="true">
                Preparing your learning space
            </div>

            <div class="loader-dots" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
    </div>

    <div class="app-main">

        <header class="topbar">
            <a href="dashboard.php" class="topbar-brand text-decoration-none" aria-label="Go to dashboard">

                <div class="topbar-logo">
                    <?php if (file_exists($schoolLogo)): ?>
                        <img src="<?= htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') ?>" alt="School logo">
                    <?php else: ?>
                        <i class="fa-solid fa-book-open-reader"></i>
                    <?php endif; ?>
                </div>

                <div class="topbar-heading">
                    <div class="topbar-label">Smart Reviewer</div>
                    <h2 class="topbar-title">
                        <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
                    </h2>
                </div>
            </a>

            <button type="button" class="profile profile-button" data-bs-toggle="modal" data-bs-target="#updateProfileModal" aria-label="Update your profile">
                <div class="profile-info">
                    <div class="profile-name">
                        <?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div class="profile-role"><?= htmlspecialchars(ucfirst(strtolower($_SESSION['user']['role'] ?? 'Student')), ENT_QUOTES, 'UTF-8') ?></div>
                </div>

                <div class="profile-avatar" aria-hidden="true">
                    <?= htmlspecialchars(strtoupper(substr($fullName, 0, 1)), ENT_QUOTES, 'UTF-8') ?>
                </div>
            </button>
        </header>

        <main class="page-content">