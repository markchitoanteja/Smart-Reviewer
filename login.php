
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['user_id'] ?? null) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#155EEF">

    <title>Login | Smart Reviewer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="assets/css/login.css?v=1.0" rel="stylesheet">
</head>

<body>
    <div class="page-loader" id="pageLoader" role="status" aria-label="Signing in">

        <div class="loader-content">
            <div class="loader-logo-wrapper">
                <div class="loader-spinner"></div>

                <div class="loader-logo">
                    <img src="assets/img/official-logo.png" alt="">
                </div>
            </div>

            <h2 class="loader-school-name">
                Dolores National High School
            </h2>

            <div class="loader-app-name">
                Smart Reviewer
            </div>

            <div class="loader-status">
                Signing you in...
            </div>

            <div class="loader-dots" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <main class="login-card">
        <div class="top-accent"></div>

        <header class="text-center">
            <div class="logo-container">
                <img src="assets/img/official-logo.png" alt="Dolores National High School logo" class="school-logo">
            </div>

            <h1 class="app-title">
                Smart <span>Reviewer</span>
            </h1>

            <p class="school-name">
                Dolores National High School
            </p>

            <span class="student-badge">
                <i class="fa-solid fa-graduation-cap"></i>
                GRADE 11 · TVL-ICT
            </span>
        </header>

        <section class="form-section">
            <h2 class="welcome-heading">Welcome back!</h2>
            <p class="welcome-text">Sign in to continue learning.</p>

            <form action="javascript:void(0)" id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">
                        Username
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-user"></i>
                        </span>

                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autocomplete="username" autocapitalize="none" spellcheck="false" required>
                    </div>
                </div>

                <div>
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-lock"></i>
                        </span>

                        <input type="password" class="form-control password-field" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

                        <button type="button" class="btn toggle-password" id="togglePassword" aria-label="Show password" aria-pressed="false">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>


                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe" value="1" <?= isset($_POST['remember_me']) ? 'checked' : '' ?>>

                            <label class="form-check-label small" for="rememberMe">
                                Remember me
                            </label>
                        </div>

                        <span class="text-muted small">
                            <i class="fa-solid fa-shield-halved me-1"></i>
                            Stay signed in
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-login" id="loginButton">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </section>

        <footer class="footer">
            <i class="fa-solid fa-shield-halved"></i>
            Smart Reviewer &copy;
            <?= date('Y') ?>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/login.js?v=1.1"></script>
</body>

</html>