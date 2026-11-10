<?php

require_once __DIR__ . '/core/utils.php';

// Restore the admin session using the Remember Me cookie.
if (!isset($_SESSION['user_id'])) {
    restoreRememberedLogin();
}

// Redirect authenticated users to the dashboard.
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#075bea">
    <meta name="description" content="Smart Reviewer — the learning and practice portal of Dolores National High School.">

    <title>Smart Reviewer | Dolores National High School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css?v=<?= env("APP_VERSION") ?>">
</head>

<body>
    <main class="app-shell" aria-label="Smart Reviewer sign in">
        <div class="hero-bg" aria-hidden="true"></div>

        <header class="hero pt-3">
            <div class="logo-ring"><img class="school-logo" src="assets/img/school-logo-transparent.png" alt="Dolores National High School logo" onerror="this.style.display='none';this.parentElement.classList.add('logo-missing');this.parentElement.innerHTML='<span class=&quot;fallback-logo&quot;><i class=&quot;bi bi-mortarboard-fill&quot;></i></span>'"></div>
            <h1 class="app-title">Smart Reviewer</h1>
            <p class="school-name">Dolores National High School</p>
            <div class="school-badge"><i class="bi bi-book-half"></i><span>GRADE 11</span><span aria-hidden="true">•</span><span>TVL–ICT</span></div>
        </header>
        <section class="main-panel" aria-labelledby="welcome-heading">
            <span class="panel-handle" aria-hidden="true"></span>
            <div class="welcome-row">
                <div class="welcome-symbol"><i class="bi bi-person-check-fill" aria-hidden="true"></i></div>
                <div>
                    <h2 class="welcome-title" id="welcome-heading">Welcome back!</h2>
                    <p class="welcome-copy">Sign in to continue your learning journey.</p>
                </div>
            </div>
            <div id="form-message" class="d-none" role="status" aria-live="polite"></div>
            <form id="login-form">
                <div><label class="field-label" for="student-id"><i class="bi bi-person" aria-hidden="true"></i> Student ID</label>
                    <div class="input-wrap"><i class="bi bi-person-fill input-icon" aria-hidden="true"></i><input class="form-control" type="text" id="student-id" placeholder="Enter your student ID" autocomplete="student-id" autocapitalize="none" spellcheck="false" required></div>
                </div>
                <div><label class="field-label" for="password"><i class="bi bi-shield-lock" aria-hidden="true"></i> Password</label>
                    <div class="input-wrap"><i class="bi bi-key-fill input-icon" aria-hidden="true"></i><input class="form-control" type="password" id="password" placeholder="Enter your password" autocomplete="current-password" required><button class="toggle-password" type="button" id="toggle-password" aria-label="Show password" title="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button></div>
                </div>
                <div class="form-options">
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="remember" name="remember"><label class="form-check-label" for="remember">Remember Me</label></div>
                    <a href="#" class="forgot-link" id="forgot-password">Forgot password?</a>
                </div>
                <button class="btn btn-signin" type="submit" id="sign-in-button"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i><span>Sign In</span></button>
                <p class="secure-note"><i class="bi bi-shield-check" aria-hidden="true"></i> Your learning account is protected</p>
            </form>
            <div class="bottom-area">
                <button type="button" class="help-card" id="help-signing-in" aria-label="Get help signing in" style="width: 100%; text-align: left; cursor: pointer;">
                    <div class="help-icon">
                        <i class="bi bi-headset"></i>
                    </div>

                    <div>
                        <p class="help-title">Need help signing in?</p>
                        <p class="help-copy">
                            Get assistance with your student account.
                        </p>
                    </div>

                    <i class="bi bi-chevron-right ms-auto text-secondary small" aria-hidden="true"></i>
                </button>

                <footer class="footer"><span class="footer-mark"><i class="bi bi-journal-bookmark-fill" aria-hidden="true"></i></span>
                    <p class="footer-line">A smarter way to review, practice, and learn.</p>
                    <p class="copyright">© 2026 Dolores National High School</p>
                </footer>
            </div>
        </section>
    </main>

    <!-- Reusable Loading Overlay -->
    <div id="app-loading-overlay" class="app-loading-overlay" role="status" aria-live="polite" aria-label="Loading" aria-hidden="true">

        <div class="loading-card">

            <!-- School Branding -->
            <div class="loading-logo-wrap">
                <img src="assets/img/school-logo-transparent.png" alt="Dolores National High School" class="loading-logo" onerror="this.style.display='none';">
            </div>

            <h5 class="loading-app-name">Smart Reviewer</h5>

            <p class="loading-school-name">
                Dolores National High School
            </p>

            <!-- Animated Loader -->
            <div class="loading-animation" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <!-- Loading Text -->
            <h6 id="loading-title" class="loading-title">
                Please wait
            </h6>

            <p id="loading-message" class="loading-message">
                Preparing your request...
            </p>

            <!-- Progress Indicator -->
            <div class="loading-progress">
                <div class="loading-progress-bar"></div>
            </div>

            <div class="loading-footer">
                <i class="bi bi-shield-check"></i>
                <span>Dolores NHS Learning Portal</span>
            </div>

        </div>
    </div>

    <!-- Branded feedback modal -->
    <div class="modal fade school-feedback-modal" id="feedback-modal" tabindex="-1" aria-labelledby="feedback-modal-title" aria-describedby="feedback-modal-message" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="feedback-modal-top">
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="feedback-brand">
                        <div class="feedback-logo-wrap">
                            <img src="assets/img/school-logo-transparent.png" alt="Dolores National High School logo" class="feedback-logo" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                            <span class="feedback-logo-fallback" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
                        </div>
                        <div class="feedback-school">DOLORES NATIONAL<br>NATIONAL HIGH SCHOOL</div>
                        <div class="feedback-app">SMART REVIEWER</div>
                    </div>
                    <div class="feedback-orb feedback-orb-one"></div>
                    <div class="feedback-orb feedback-orb-two"></div>
                </div>
                <div class="modal-body text-center">
                    <div class="py-4"></div>
                    <div class="feedback-status-icon" id="feedback-status-icon"><i class="bi bi-info-lg"></i></div>
                    <h2 class="feedback-title" id="feedback-modal-title">A quick note</h2>
                    <p class="feedback-message" id="feedback-modal-message"></p>
                    <button type="button" class="btn feedback-confirm-btn" data-bs-dismiss="modal">
                        <span>Got it</span><i class="bi bi-arrow-right"></i>
                    </button>
                    <p class="feedback-secure"><i class="bi bi-shield-check"></i> Dolores NHS • Learning Portal</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const message = <?= json_encode(getFlashMessage('login_message')) ?>;
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/login.js?v=<?= env("APP_VERSION") ?>"></script>

    <style>
        .logo-ring.logo-missing {
            display: grid;
            place-items: center
        }

        .fallback-logo {
            display: grid;
            place-items: center;
            width: 100%;
            height: 100%;
            border-radius: 22px;
            background: #fff;
            color: #075bea;
            font-size: 34px
        }
    </style>
</body>

</html>