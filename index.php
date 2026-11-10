<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#075bea">
    <meta name="description" content="Smart Reviewer — Dolores National High School learning and practice portal.">
    
    <title>Smart Reviewer | Dolores National High School</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --blue: #075bea;
            --blue-dark: #0648c7;
            --navy: #102342;
            --muted: #71819a;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100svh;
            display: grid;
            place-items: center;
            overflow: hidden;
            padding: 0;
            color: var(--navy);
            background: #eaf1fb;
            font-family: 'DM Sans', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .splash-screen {
            position: relative;
            isolation: isolate;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: min(100%, 440px);
            min-height: 100svh;
            overflow: hidden;
            padding: 32px 28px max(28px, env(safe-area-inset-bottom));
            color: #fff;
            text-align: center;
            background: linear-gradient(150deg, #0649c9 0%, #075bea 42%, #1685ff 76%, #2aa5ff 100%);
        }

        .splash-screen::before,
        .splash-screen::after {
            position: absolute;
            z-index: -1;
            content: "";
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 50%;
            pointer-events: none;
        }

        .splash-screen::before {
            width: 360px;
            height: 360px;
            top: -155px;
            right: -155px;
            box-shadow: 0 0 0 28px rgba(255, 255, 255, .035),
                0 0 0 60px rgba(255, 255, 255, .025),
                0 0 0 95px rgba(255, 255, 255, .018);
        }

        .splash-screen::after {
            width: 270px;
            height: 270px;
            bottom: -115px;
            left: -130px;
            background: rgba(255, 255, 255, .035);
            box-shadow: 0 0 0 30px rgba(255, 255, 255, .025);
        }

        .splash-content {
            width: 100%;
            max-width: 330px;
            animation: appear .75s ease both;
        }

        .logo-halo {
            position: relative;
            display: grid;
            place-items: center;
            width: 124px;
            height: 124px;
            margin: 0 auto 25px;
            padding: 7px;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 36px;
            background: rgba(255, 255, 255, .17);
            box-shadow: 0 18px 42px rgba(0, 30, 105, .25);
            backdrop-filter: blur(10px);
            animation: float 3s ease-in-out infinite;
        }

        .school-logo {
            display: block;
            width: 100%;
            height: 100%;
            padding: 5px;
            border-radius: 29px;
            object-fit: contain;
            background: #fff;
        }

        .logo-fallback {
            display: none;
            place-items: center;
            width: 100%;
            height: 100%;
            border-radius: 29px;
            color: var(--blue);
            background: #fff;
            font-size: 54px;
        }

        .eyebrow {
            margin: 0 0 8px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2.4px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .82);
        }

        .app-name {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(31px, 8vw, 38px);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.12;
        }

        .school-name {
            margin: 12px 0 0;
            color: rgba(255, 255, 255, .92);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .2px;
        }

        .divider {
            width: 42px;
            height: 3px;
            margin: 23px auto 20px;
            border-radius: 99px;
            background: rgba(255, 255, 255, .72);
        }

        .loading-copy {
            margin: 0;
            color: rgba(255, 255, 255, .86);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: .2px;
        }

        .loading-track {
            width: 158px;
            height: 4px;
            margin: 18px auto 0;
            overflow: hidden;
            border-radius: 99px;
            background: rgba(255, 255, 255, .24);
        }

        .loading-bar {
            width: 42%;
            height: 100%;
            border-radius: inherit;
            background: #fff;
            animation: loading 1.15s ease-in-out infinite;
        }

        .splash-footer {
            position: absolute;
            right: 20px;
            bottom: max(22px, env(safe-area-inset-bottom));
            left: 20px;
            color: rgba(255, 255, 255, .7);
            font-size: 10px;
            letter-spacing: .2px;
        }

        .splash-footer i {
            margin-right: 5px;
        }

        @keyframes loading {
            0% {
                transform: translateX(-120%);
            }

            100% {
                transform: translateX(380%);
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

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (min-width: 441px) {
            .splash-screen {
                min-height: min(850px, 96svh);
                border-radius: 28px;
                box-shadow: 0 24px 70px rgba(28, 65, 123, .18);
            }
        }

        @media (max-height: 600px) {
            .logo-halo {
                width: 88px;
                height: 88px;
                margin-bottom: 15px;
                border-radius: 27px;
            }

            .school-logo,
            .logo-fallback {
                border-radius: 21px;
            }

            .logo-fallback {
                font-size: 39px;
            }

            .school-name {
                margin-top: 7px;
            }

            .divider {
                margin: 14px auto 12px;
            }

            .loading-track {
                margin-top: 12px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>
    <main class="splash-screen" aria-label="Smart Reviewer loading screen">
        <section class="splash-content">
            <div class="logo-halo">
                <img src="assets/img/school-logo.png" alt="Dolores National High School logo" class="school-logo" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                <span class="logo-fallback" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
            </div>

            <p class="eyebrow">Your learning companion</p>
            <h1 class="app-name">Smart Reviewer</h1>
            <p class="school-name">Dolores National High School</p>

            <div class="divider" aria-hidden="true"></div>

            <p class="loading-copy" role="status" aria-live="polite">Preparing your learning space…</p>
            <div class="loading-track" role="progressbar" aria-label="Loading" aria-valuemin="0" aria-valuemax="100">
                <div class="loading-bar"></div>
            </div>
        </section>

        <footer class="splash-footer">
            <i class="bi bi-shield-check" aria-hidden="true"></i>
            A safe space to review, practice, and learn
        </footer>
    </main>

    <script>
        (function () {
            // Briefly show the branded splash screen, then open the login page.
            // Keep this file and login.php in the same directory.
            window.setTimeout(function () {
                window.location.replace('login.php');
            }, 2200);
        })();
    </script>
</body>

</html>