<?php
session_start();

$destination = !empty($_SESSION['user_id'])
    ? 'dashboard.php'
    : 'login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#155EEF">

    <title>Smart Reviewer</title>

    <style>
        :root {
            --primary: #155EEF;
            --primary-dark: #1248BD;
            --accent: #EAF1FF;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            overflow: hidden;
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--primary);
        }

        .splash-screen {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            min-height: 100dvh;
            overflow: hidden;
            isolation: isolate;
            color: #fff;
            background:
                radial-gradient(circle at 15% 15%,
                    rgba(255, 255, 255, .13),
                    transparent 32%),
                linear-gradient(145deg,
                    #155EEF 0%,
                    #1248BD 55%,
                    #0C328A 100%);
        }

        /* Decorative background shapes */
        .orb {
            position: absolute;
            z-index: -1;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 50%;
            pointer-events: none;
        }

        .orb-one {
            width: 360px;
            height: 360px;
            top: -170px;
            right: -120px;
            background: rgba(255, 255, 255, .045);
            animation: drift 9s ease-in-out infinite alternate;
        }

        .orb-two {
            width: 280px;
            height: 280px;
            bottom: -145px;
            left: -100px;
            background: rgba(255, 255, 255, .055);
            animation: drift 7s ease-in-out infinite alternate-reverse;
        }

        .orb-three {
            width: 150px;
            height: 150px;
            right: 12%;
            bottom: 15%;
            border-style: dashed;
            opacity: .5;
            animation: rotate 30s linear infinite;
        }

        .content {
            width: min(100% - 40px, 360px);
            text-align: center;
            animation: enter .8s cubic-bezier(.2, .8, .2, 1) both;
        }

        .brand-mark {
            position: relative;
            display: grid;
            place-items: center;
            width: 124px;
            height: 124px;
            margin: 0 auto 34px;
        }

        .brand-ring {
            position: absolute;
            inset: 0;
            border: 1px solid rgba(255, 255, 255, .4);
            border-radius: 34px;
            transform: rotate(45deg) scale(.86);
            animation: ring-pulse 2.8s ease-in-out infinite;
        }

        .logo-card {
            display: grid;
            place-items: center;
            width: 102px;
            height: 102px;
            padding: 13px;
            border: 1px solid rgba(255, 255, 255, .65);
            border-radius: 28px;
            background: #fff;
            box-shadow:
                0 20px 45px rgba(4, 25, 83, .24),
                0 0 0 8px rgba(255, 255, 255, .08);
            animation: float 3s ease-in-out infinite;
        }

        .logo-card img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: #D9E5FF;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .app-title {
            margin: 0;
            font-size: clamp(32px, 8vw, 42px);
            font-weight: 850;
            letter-spacing: -1.8px;
            line-height: 1.1;
        }

        .app-title span {
            display: block;
            color: #DCE8FF;
        }

        .school-name {
            margin: 17px 0 0;
            color: rgba(255, 255, 255, .8);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: .2px;
        }

        .loading-area {
            width: 190px;
            margin: 52px auto 0;
            text-align: left;
        }

        .loading-label {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 11px;
            color: #EAF1FF;
            font-size: 10px;
            font-weight: 650;
        }

        .loading-label span:last-child {
            font-variant-numeric: tabular-nums;
        }

        .progress-track {
            width: 100%;
            height: 4px;
            overflow: hidden;
            border-radius: 10px;
            background: rgba(255, 255, 255, .2);
        }

        .progress-bar {
            width: 0;
            height: 100%;
            border-radius: inherit;
            background: #fff;
            box-shadow: 0 0 12px rgba(255, 255, 255, .5);
            animation: progress 1.45s cubic-bezier(.45, 0, .25, 1) forwards;
        }

        .footer {
            position: absolute;
            right: 20px;
            bottom: 22px;
            left: 20px;
            color: rgba(255, 255, 255, .55);
            font-size: 10px;
            text-align: center;
            letter-spacing: .4px;
        }

        @keyframes enter {
            from {
                opacity: 0;
                transform: translateY(18px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-7px);
            }
        }

        @keyframes ring-pulse {

            0%,
            100% {
                transform: rotate(45deg) scale(.86);
                opacity: .45;
            }

            50% {
                transform: rotate(45deg) scale(1.06);
                opacity: 1;
            }
        }

        @keyframes drift {
            to {
                transform: translate(20px, -15px);
            }
        }

        @keyframes rotate {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes progress {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @media (max-height: 600px) {
            .content {
                transform: scale(.82);
            }

            .brand-mark {
                margin-bottom: 20px;
            }

            .loading-area {
                margin-top: 28px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body>
    <main class="splash-screen">
        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
        <div class="orb orb-three"></div>

        <section class="content">
            <div class="brand-mark">
                <div class="brand-ring"></div>

                <div class="logo-card">
                    <img src="assets/img/official-logo.png" alt="School logo">
                </div>
            </div>

            <p class="eyebrow">Your learning companion</p>

            <h1 class="app-title">
                Smart
                <span>Reviewer.</span>
            </h1>

            <p class="school-name">
                Dolores National High School
            </p>

            <div class="loading-area">
                <div class="loading-label">
                    <span>Preparing workspace</span>
                    <span>...</span>
                </div>

                <div class="progress-track">
                    <div class="progress-bar"></div>
                </div>
            </div>
        </section>

        <footer class="footer">
            SMART REVIEWER &copy; <?= date('Y') ?>
        </footer>
    </main>

    <script>
        const destination = <?= json_encode($destination) ?>;

        window.setTimeout(function () {
            window.location.replace(destination);
        }, 1550);
    </script>
</body>

</html>