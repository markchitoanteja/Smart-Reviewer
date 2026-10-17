<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Temporary demo credentials.
    if (
        hash_equals('mark', $username) &&
        hash_equals('1234', $password)
    ) {
        session_regenerate_id(true);

        $_SESSION['reviewer_logged_in'] = true;
        $_SESSION['reviewer_username'] = $username;

        header('Location: dashboard.php');
        exit;
    }

    $error = 'Invalid username or password.';
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

    <style>
        :root {
            --primary: #155EEF;
            --primary-dark: #1248BD;
            --accent: #EAF1FF;
            --text: #182230;
            --muted: #667085;
            --border: #D0D5DD;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 10%, #E1EAFF, transparent 35%),
                radial-gradient(circle at 90% 90%, #EAF1FF, transparent 35%),
                #F7F9FE;
        }

        .login-card {
            position: relative;
            width: 100%;
            max-width: 380px;
            padding: 30px 26px 22px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #E6ECF7;
            border-radius: 20px;
            box-shadow: 0 16px 45px rgba(18, 72, 189, .10);
            animation: appear .35s ease-out;
        }

        .top-accent {
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg,
                    var(--primary-dark),
                    var(--primary),
                    #83A9FF);
        }

        .logo-container {
            display: grid;
            place-items: center;
            width: 76px;
            height: 76px;
            margin: 0 auto 13px;
            background: var(--accent);
            border: 1px solid #D9E5FF;
            border-radius: 20px;
        }

        .school-logo {
            width: 62px;
            height: 62px;
            object-fit: contain;
        }

        .app-title {
            margin: 0;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .app-title span {
            color: var(--primary);
        }

        .school-name {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .student-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 13px;
            padding: 7px 12px;
            color: var(--primary-dark);
            background: var(--accent);
            border: 1px solid #D9E5FF;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
        }

        .form-section {
            margin-top: 27px;
        }

        .welcome-heading {
            margin: 0;
            font-size: 19px;
            font-weight: 750;
            letter-spacing: -.4px;
        }

        .welcome-text {
            margin: 5px 0 20px;
            color: var(--muted);
            font-size: 12px;
        }

        .form-label {
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 700;
        }

        .input-group {
            border-radius: 10px;
        }

        .input-group-text {
            padding: 0 13px;
            color: var(--primary);
            background: #F5F8FF;
            border-color: var(--border);
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            min-width: 0;
            min-height: 46px;
            padding: 10px 12px;
            border-color: var(--border);
            font-size: 13px;
        }

        .form-control::placeholder {
            color: #98A2B3;
        }

        .form-control:focus {
            position: relative;
            z-index: 3;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(21, 94, 239, .10);
        }

        .password-field {
            border-radius: 0;
        }

        .toggle-password {
            min-width: 44px;
            color: var(--muted);
            background: #fff;
            border: 1px solid var(--border);
            border-left: 0;
            border-radius: 0 10px 10px 0;
        }

        .toggle-password:hover {
            color: var(--primary);
            background: var(--accent);
        }

        .btn-login {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            min-height: 47px;
            margin-top: 22px;
            color: #fff;
            background: var(--primary);
            border: 0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(21, 94, 239, .18);
            transition: background .2s, transform .2s, box-shadow .2s;
        }

        .btn-login:hover {
            color: #fff;
            background: var(--primary-dark);
            box-shadow: 0 6px 15px rgba(21, 94, 239, .23);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:focus-visible,
        .toggle-password:focus-visible {
            outline: 3px solid #A9C4FF;
            outline-offset: 3px;
        }

        .footer {
            margin-top: 22px;
            padding-top: 15px;
            border-top: 1px solid #EAECF0;
            color: #98A2B3;
            font-size: 10px;
            text-align: center;
        }

        .footer i {
            margin-right: 4px;
            color: var(--primary);
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 380px) {
            body {
                padding: 14px;
            }

            .login-card {
                padding: 27px 20px 20px;
            }

            .app-title {
                font-size: 23px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }
        }

        .page-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(245, 247, 252, 0.82);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .loader-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .loader-logo-wrapper {
            position: relative;
            display: grid;
            place-items: center;
            width: 90px;
            height: 90px;
            margin-bottom: 20px;
        }

        .loader-spinner {
            position: absolute;
            inset: 0;
            border: 3px solid #DCE8FF;
            border-top-color: #155EEF;
            border-right-color: #155EEF;
            border-radius: 50%;
            animation: loader-spin 1s linear infinite;
        }

        .loader-logo {
            display: grid;
            place-items: center;
            width: 66px;
            height: 66px;
            padding: 6px;
            background: #fff;
            border-radius: 18px;
        }

        .loader-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .loader-school-name {
            margin: 0;
            color: #182230;
            font-size: 16px;
            font-weight: 800;
        }

        .loader-app-name {
            margin-top: 8px;
            color: #1248BD;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .loader-status {
            margin-top: 22px;
            color: #667085;
            font-size: 12px;
        }

        .loader-dots {
            display: flex;
            gap: 5px;
            margin-top: 12px;
        }

        .loader-dots span {
            width: 6px;
            height: 6px;
            background: #155EEF;
            border-radius: 50%;
            animation: loader-pulse 1.1s infinite ease-in-out;
        }

        .loader-dots span:nth-child(2) {
            animation-delay: .15s;
        }

        .loader-dots span:nth-child(3) {
            animation-delay: .3s;
        }

        @keyframes loader-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes loader-pulse {

            0%,
            60%,
            100% {
                opacity: .3;
                transform: translateY(0);
            }

            30% {
                opacity: 1;
                transform: translateY(-4px);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .loader-spinner,
            .loader-dots span {
                animation-duration: 2.5s;
            }
        }
    </style>
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

            <form method="POST" action="login.php" id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">
                        Username
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-user"></i>
                        </span>

                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autocomplete="username" autocapitalize="none" spellcheck="false" required value="<?= htmlspecialchars(
                            $_POST['username'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>">
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

                        <input type="password" class="form-control password-field" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required value="<?= htmlspecialchars(
                            $_POST['password'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>">

                        <button type="button" class="btn toggle-password" id="togglePassword" aria-label="Show password" aria-pressed="false">
                            <i class="fa-regular fa-eye"></i>
                        </button>
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
            Smart Reviewer &copy; <?= date('Y') ?>
        </footer>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function () {
            // Show or hide password.
            $('#togglePassword').on('click', function () {
                const input = $('#password');
                const icon = $(this).find('i');
                const show = input.attr('type') === 'password';

                input.attr('type', show ? 'text' : 'password');

                icon.toggleClass('fa-eye fa-eye-slash');

                $(this)
                    .attr('aria-pressed', String(show))
                    .attr(
                        'aria-label',
                        show ? 'Hide password' : 'Show password'
                    );
            });

            // Show loader when submitting the login form.
            $('#loginForm').on('submit', function (event) {
                const form = this;

                // Allow native HTML validation to run first.
                if (!form.checkValidity()) {
                    return;
                }

                // Prevent repeated submissions.
                if ($(form).data('submitting')) {
                    event.preventDefault();
                    return;
                }

                $(form).data('submitting', true);

                $('#loginButton')
                    .prop('disabled', true)
                    .html(`
            <span>Signing In...</span>
            <i class="fa-solid fa-spinner fa-spin"></i>
        `);

                $('#pageLoader').css('display', 'flex');
            });

            // Login error.
            <?php if ($error !== ''): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: <?= json_encode($error) ?>,
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#155EEF',
                    customClass: {
                        popup: 'rounded-4'
                    }
                }).then(() => {
                    $('#password').trigger('focus');
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>