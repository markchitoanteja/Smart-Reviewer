<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';

require 'includes/app_header.php';

$lessons = [
    [
        'title' => 'Computer Systems',
        'category' => 'Computer Basics',
        'description' => 'Learn the major components of a computer and how they work together.',
        'icon' => 'fa-desktop',
        'color' => 'icon-blue',
        'duration' => '8 min read'
    ],
    [
        'title' => 'Computer Networks',
        'category' => 'Networking',
        'description' => 'Understand network types, devices, connections, and basic terminology.',
        'icon' => 'fa-network-wired',
        'color' => 'icon-purple',
        'duration' => '10 min read'
    ],
    [
        'title' => 'Internet Safety',
        'category' => 'Digital Literacy',
        'description' => 'Review online privacy, secure passwords, and responsible internet use.',
        'icon' => 'fa-shield-halved',
        'color' => 'icon-green',
        'duration' => '6 min read'
    ]
];
?>

<section class="welcome-banner">
    <div class="welcome-content">
        <div class="welcome-eyebrow">
            <i class="fa-solid fa-sparkles"></i>
            YOUR LEARNING SPACE
        </div>
        <h2>Welcome back, <?= htmlspecialchars($_SESSION['user']['first_name'] ?? 'Student') ?>!</h2>
        <p>
            Ready to learn something new today? Review your lessons, test your
            knowledge, and build better study habits one step at a time.
        </p>
        <a href="reviewer.php" class="btn">
            <i class="fa-solid fa-book-open me-2"></i> Start studying
        </a>
    </div>
</section>

<div class="page-heading">
    <div>
        <h1>Your learning overview</h1>
        <p>Everything you need to continue your study session.</p>
    </div>
    <span class="topic-tag"><i class="fa-solid fa-graduation-cap me-1"></i> Grade 11 · TVL-ICT</span>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="icon-box icon-blue"><i class="fa-solid fa-book-open"></i></div>
                <span class="small-label">Available</span>
            </div>
            <div class="stat-value">6</div>
            <div class="stat-label">Study materials</div>
            <div class="stat-foot"><i class="fa-solid fa-circle-check text-primary me-1"></i> Ready to review</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="icon-box icon-purple"><i class="fa-solid fa-clipboard-question"></i></div>
                <span class="small-label">Practice</span>
            </div>
            <div class="stat-value">5</div>
            <div class="stat-label">Quiz questions</div>
            <div class="stat-foot"><i class="fa-solid fa-bullseye text-primary me-1"></i> Test your knowledge</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="icon-box icon-green"><i class="fa-solid fa-check-double"></i></div>
                <span class="small-label">This session</span>
            </div>
            <div class="stat-value">0</div>
            <div class="stat-label">Saved quiz attempts</div>
            <div class="stat-foot">Results are not saved yet</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="icon-box icon-orange"><i class="fa-solid fa-bullseye"></i></div>
                <span class="small-label">Daily goal</span>
            </div>
            <div class="stat-value">0/3</div>
            <div class="stat-label">Study activities</div>
            <div class="progress mt-3">
                <div class="progress-bar" style="width:0%;background:#F79009"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title">Continue learning</h2>
                <div class="section-subtitle">Explore these recommended lessons.</div>
            </div>
            <a href="reviewer.php" class="btn-light-blue">
                View all <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 mb-4">
            <?php foreach ($lessons as $lesson): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="lesson-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="icon-box <?= $lesson['color'] ?>">
                                <i class="fa-solid <?= $lesson['icon'] ?>"></i>
                            </div>
                            <span class="topic-tag"><?= htmlspecialchars($lesson['category']) ?></span>
                        </div>
                        <h3><?= htmlspecialchars($lesson['title']) ?></h3>
                        <p><?= htmlspecialchars($lesson['description']) ?></p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="lesson-meta">
                                <i class="fa-regular fa-clock me-1"></i>
                                <?= htmlspecialchars($lesson['duration']) ?>
                            </span>
                            <a href="reviewer.php" class="btn btn-sm btn-light-blue" aria-label="Open study materials">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="section-title">Your daily study goal</h2>
                    <div class="section-subtitle">Small steps make a difference.</div>
                </div>
                <div class="icon-box icon-orange"><i class="fa-solid fa-flag-checkered"></i></div>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span class="fw-bold">Today's activities</span>
                <span class="muted">0 of 3 completed</span>
            </div>
            <div class="progress mb-3">
                <div class="progress-bar" style="width:0%;background:#155EEF"></div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="icon-box icon-blue" style="width:35px;height:35px">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Read a lesson</div>
                            <div class="small-label">5–10 minutes</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="icon-box icon-purple" style="width:35px;height:35px">
                            <i class="fa-solid fa-brain"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Take a quiz</div>
                            <div class="small-label">Test your recall</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="icon-box icon-green" style="width:35px;height:35px">
                            <i class="fa-solid fa-rotate"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Review key points</div>
                            <div class="small-label">Strengthen memory</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="section-title">Quick access</h2>
                    <div class="section-subtitle">Jump into your next activity.</div>
                </div>
                <i class="fa-solid fa-bolt text-warning fs-5"></i>
            </div>

            <a href="reviewer.php" class="activity-item text-dark">
                <div class="icon-box icon-blue"><i class="fa-solid fa-book"></i></div>
                <div class="flex-grow-1">
                    <div class="fw-bold">Study materials</div>
                    <p>Read lessons and key concepts.</p>
                </div>
                <i class="fa-solid fa-chevron-right muted mt-2"></i>
            </a>

            <a href="quizzes.php" class="activity-item text-dark">
                <div class="icon-box icon-purple"><i class="fa-solid fa-brain"></i></div>
                <div class="flex-grow-1">
                    <div class="fw-bold">Practice quiz</div>
                    <p>Answer questions to check your understanding.</p>
                </div>
                <i class="fa-solid fa-chevron-right muted mt-2"></i>
            </a>

            <a href="progress.php" class="activity-item text-dark">
                <div class="icon-box icon-green"><i class="fa-solid fa-chart-simple"></i></div>
                <div class="flex-grow-1">
                    <div class="fw-bold">My progress</div>
                    <p>View the progress summary page.</p>
                </div>
                <i class="fa-solid fa-chevron-right muted mt-2"></i>
            </a>
        </div>

        <div class="panel">
            <div class="icon-box icon-orange mb-3">
                <i class="fa-solid fa-lightbulb"></i>
            </div>
            <h2 class="section-title">Today's study tip</h2>
            <p class="muted mt-2 mb-3" style="line-height:1.8">
                After reading a lesson, try explaining the main idea in your own
                words before looking back at the material.
            </p>
            <div class="topic-tag"><i class="fa-solid fa-star me-1"></i> Active recall</div>
        </div>
    </div>
</div>

<?php require 'includes/app_footer.php'; ?>