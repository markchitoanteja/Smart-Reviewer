<?php
$pageTitle = 'My Progress';
$activePage = 'progress';
require 'includes/app_header.php';

$sampleResults = [
    ['title' => 'Computer Systems Quiz', 'date' => 'Sample record', 'score' => 90, 'correct' => '9/10'],
    ['title' => 'Networking Basics', 'date' => 'Sample record', 'score' => 70, 'correct' => '7/10'],
    ['title' => 'Internet Safety Quiz', 'date' => 'Sample record', 'score' => 80, 'correct' => '8/10']
];

$average = array_sum(array_column($sampleResults, 'score')) / count($sampleResults);
$best = max(array_column($sampleResults, 'score'));

function scoreClass(int $score): string
{
    if ($score >= 80)
        return 'score-high';
    if ($score >= 60)
        return 'score-mid';
    return 'score-low';
}
?>

<div class="page-heading">
    <div>
        <h1>My Progress</h1>
        <p>Review your practice performance and identify topics to study next.</p>
    </div>
    <div class="icon-box icon-green d-none d-sm-grid">
        <i class="fa-solid fa-chart-line"></i>
    </div>
</div>

<div class="recommendation mb-4">
    <div class="d-flex gap-3 align-items-start">
        <div class="icon-box icon-orange"><i class="fa-solid fa-circle-info"></i></div>
        <div>
            <div class="fw-bold">Demonstration data</div>
            <p>
                The scores on this page are sample records for layout demonstration.
                They are not your actual results and are not connected to your quiz attempts.
            </p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-box icon-blue"><i class="fa-solid fa-clipboard-check"></i></div>
            <div class="stat-value"><?= count($sampleResults) ?></div>
            <div class="stat-label">Sample quiz attempts</div>
            <div class="stat-foot">Demonstration only</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-box icon-purple"><i class="fa-solid fa-chart-simple"></i></div>
            <div class="stat-value"><?= number_format($average, 0) ?>%</div>
            <div class="stat-label">Sample average score</div>
            <div class="stat-foot">Across sample records</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-box icon-green"><i class="fa-solid fa-trophy"></i></div>
            <div class="stat-value"><?= $best ?>%</div>
            <div class="stat-label">Sample best score</div>
            <div class="stat-foot"><i class="fa-solid fa-star text-warning me-1"></i> Highest sample result</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-box icon-orange"><i class="fa-solid fa-book-open"></i></div>
            <div class="stat-value">6</div>
            <div class="stat-label">Available lessons</div>
            <div class="stat-foot">Explore the study library</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="panel h-100">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="section-title">Sample quiz performance</h2>
                    <div class="section-subtitle">Scores shown here are illustrative, not actual saved attempts.</div>
                </div>
                <span class="topic-tag">Sample</span>
            </div>

            <div class="d-flex flex-column gap-4">
                <?php foreach ($sampleResults as $result): ?>
                    <div>
                        <div class="d-flex justify-content-between gap-3 mb-2">
                            <div class="fw-bold"><?= htmlspecialchars($result['title']) ?></div>
                            <div class="fw-bold"><?= (int) $result['score'] ?>%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar <?= $result['score'] >= 80 ? 'bg-success' : ($result['score'] >= 60 ? 'bg-warning' : 'bg-danger') ?>" style="width:<?= (int) $result['score'] ?>%"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="small-label"><?= htmlspecialchars($result['date']) ?></span>
                            <span class="small-label"><?= htmlspecialchars($result['correct']) ?> correct</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="small-label mt-4 pt-3 border-top">
                <i class="fa-solid fa-circle-info me-1"></i>
                Scores are hard-coded examples and do not reflect performance in the interactive quiz.
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="panel h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="section-title">Study recommendations</h2>
                    <div class="section-subtitle">Suggested next steps for your review.</div>
                </div>
                <div class="icon-box icon-orange"><i class="fa-solid fa-lightbulb"></i></div>
            </div>

            <div class="recommendation mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-network-wired text-primary"></i>
                    <strong>Review networking basics</strong>
                </div>
                <p>Practice identifying the roles of routers, switches, modems, and access points.</p>
                <a href="reviewer.php" class="btn btn-sm btn-light-blue mt-3">Review lessons</a>
            </div>

            <div class="recommendation mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-success"></i>
                    <strong>Strengthen online safety</strong>
                </div>
                <p>Revisit phishing, secure passwords, and ways to protect personal information.</p>
                <a href="reviewer.php" class="btn btn-sm btn-light-blue mt-3">Study safety</a>
            </div>

            <div class="recommendation">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-brain text-warning"></i>
                    <strong>Test your understanding</strong>
                </div>
                <p>Take the practice quiz and read the explanation for every answer.</p>
                <a href="quizzes.php" class="btn btn-sm btn-primary mt-3">Start a quiz</a>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="section-title">Quiz history</h2>
            <div class="section-subtitle">Example records to demonstrate the history layout.</div>
        </div>
        <i class="fa-solid fa-clock-rotate-left text-primary fs-5"></i>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Quiz</th>
                    <th>Record type</th>
                    <th>Correct answers</th>
                    <th>Score</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sampleResults as $result): ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($result['title']) ?></td>
                        <td><span class="topic-tag">Sample data</span></td>
                        <td><?= htmlspecialchars($result['correct']) ?></td>
                        <td class="fw-bold"><?= (int) $result['score'] ?>%</td>
                        <td>
                            <span class="score-pill <?= scoreClass((int) $result['score']) ?>">
                                <?= $result['score'] >= 80 ? 'Strong' : ($result['score'] >= 60 ? 'Developing' : 'Review needed') ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'includes/app_footer.php'; ?>