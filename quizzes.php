<?php
$pageTitle = 'Practice Quizzes';
$activePage = 'quizzes';
require 'includes/app_header.php';

$questions = [
    [
        'question' => 'Which component is commonly called the brain of the computer?',
        'options' => ['RAM', 'CPU', 'Hard drive', 'Monitor'],
        'answer' => 1,
        'explanation' => 'The Central Processing Unit (CPU) executes instructions and performs calculations.'
    ],
    [
        'question' => 'Which of the following is an input device?',
        'options' => ['Monitor', 'Printer', 'Keyboard', 'Speaker'],
        'answer' => 2,
        'explanation' => 'A keyboard sends text and commands to the computer, making it an input device.'
    ],
    [
        'question' => 'What does LAN stand for?',
        'options' => [
            'Large Access Network',
            'Local Area Network',
            'Linked Application Node',
            'Long Access Number'
        ],
        'answer' => 1,
        'explanation' => 'LAN means Local Area Network, which connects devices within a limited area.'
    ],
    [
        'question' => 'Which language is primarily used to structure webpages?',
        'options' => ['HTML', 'SQL', 'Python', 'C++'],
        'answer' => 0,
        'explanation' => 'HTML defines webpage structure and content using elements and tags.'
    ],
    [
        'question' => 'What is the safest response to a suspicious link in an unexpected message?',
        'options' => [
            'Open it immediately',
            'Send your password to verify your account',
            'Forward it to all your friends',
            'Avoid opening it and verify the sender'
        ],
        'answer' => 3,
        'explanation' => 'Unexpected links can lead to phishing or malicious websites. Verify the sender through a trusted channel.'
    ]
];
?>

<div class="page-heading">
    <div>
        <h1>Practice Quizzes</h1>
        <p>Check what you know, learn from mistakes, and build confidence.</p>
    </div>
    <div class="icon-box icon-purple d-none d-sm-grid">
        <i class="fa-solid fa-brain"></i>
    </div>
</div>

<div class="welcome-banner mb-4" style="padding:22px 25px">
    <div class="welcome-content">
        <div class="welcome-eyebrow"><i class="fa-solid fa-bullseye"></i> TEST YOUR KNOWLEDGE</div>
        <h2 style="font-size:23px">Practice makes progress.</h2>
        <p class="mb-0">Read each question carefully. After selecting an answer, review the explanation before moving on.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel" id="quizPanel">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <span class="topic-tag"><i class="fa-solid fa-laptop-code me-1"></i> ICT Fundamentals</span>
                    <h2 class="section-title mt-3">Knowledge Check</h2>
                    <div class="section-subtitle">One question at a time · Multiple choice</div>
                </div>
                <div class="icon-box icon-purple">
                    <i class="fa-solid fa-clipboard-question"></i>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                <span class="fw-bold" id="questionCounter">Question 1 of 5</span>
                <span class="small-label" id="answeredCounter">0 answered</span>
            </div>
            <div class="progress mb-4">
                <div class="progress-bar" id="quizProgress" style="width:20%;background:#155EEF"></div>
            </div>

            <div id="questionArea">
                <h3 id="questionText" class="fs-5 fw-bold mb-4" style="line-height:1.6"></h3>
                <div id="answerOptions"></div>
                <div id="answerFeedback" aria-live="polite"></div>
            </div>

            <div id="quizResult" class="text-center py-4 d-none" aria-live="polite">
                <div class="score-circle" id="finalScore">0%</div>
                <h2 class="section-title fs-4" id="resultTitle">Quiz complete!</h2>
                <p class="muted mt-2" id="resultMessage"></p>
                <div class="row g-3 justify-content-center my-4">
                    <div class="col-6 col-sm-4">
                        <div class="stat-card">
                            <div class="stat-value text-success" id="correctCount">0</div>
                            <div class="stat-label">Correct answers</div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <div class="stat-card">
                            <div class="stat-value text-danger" id="incorrectCount">0</div>
                            <div class="stat-label">Incorrect answers</div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="retryQuiz">
                    <i class="fa-solid fa-rotate-right me-2"></i> Try again
                </button>
                <a href="reviewer.php" class="btn btn-light-blue ms-2">
                    Review lessons
                </a>
            </div>

            <div class="d-flex justify-content-between align-items-center gap-2 mt-4 pt-3 border-top" id="quizControls">
                <button type="button" class="btn btn-light-blue" id="previousQuestion" disabled>
                    <i class="fa-solid fa-arrow-left me-1"></i> Previous
                </button>
                <button type="button" class="btn btn-primary" id="nextQuestion" disabled>
                    Next question <i class="fa-solid fa-arrow-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel mb-4">
            <div class="icon-box icon-blue mb-3"><i class="fa-solid fa-list-check"></i></div>
            <h2 class="section-title">Quiz guide</h2>
            <div class="activity-item mt-3">
                <div class="icon-box icon-blue" style="width:35px;height:35px"><i class="fa-solid fa-eye"></i></div>
                <div>
                    <div class="fw-bold">Read carefully</div>
                    <p>Look at every option before choosing.</p>
                </div>
            </div>
            <div class="activity-item">
                <div class="icon-box icon-purple" style="width:35px;height:35px"><i class="fa-solid fa-check"></i></div>
                <div>
                    <div class="fw-bold">Choose one answer</div>
                    <p>You can select one answer for each question.</p>
                </div>
            </div>
            <div class="activity-item">
                <div class="icon-box icon-green" style="width:35px;height:35px"><i class="fa-solid fa-lightbulb"></i></div>
                <div>
                    <div class="fw-bold">Learn from feedback</div>
                    <p>Read the explanation after each answer.</p>
                </div>
            </div>
        </div>

        <div class="recommendation">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-info text-primary fs-5"></i>
                <strong>Remember</strong>
            </div>
            <p>This is a practice activity. Your score is shown at the end but is not saved to a database.</p>
        </div>
    </div>
</div>

<script>
    const quizQuestions = <?= json_encode($questions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

    let currentQuestion = 0;
    let selectedAnswers = Array(quizQuestions.length).fill(null);
    let quizFinished = false;

    function renderQuestion() {
        const question = quizQuestions[currentQuestion];
        const selected = selectedAnswers[currentQuestion];

        $('#questionCounter').text(`Question ${currentQuestion + 1} of ${quizQuestions.length}`);
        $('#answeredCounter').text(`${selectedAnswers.filter(answer => answer !== null).length} answered`);
        $('#quizProgress').css('width', `${((currentQuestion + 1) / quizQuestions.length) * 100}%`);
        $('#questionText').text(question.question);
        $('#answerOptions').empty();
        $('#answerFeedback').empty();

        question.options.forEach((option, index) => {
            const letter = String.fromCharCode(65 + index);
            const button = $('<button type="button" class="quiz-choice">');
            const letterBox = $('<span class="choice-letter">').text(letter);
            const label = $('<span class="flex-grow-1">').text(option);

            button.append(letterBox, label);

            if (selected !== null) {
                button.prop('disabled', true);

                if (index === question.answer) {
                    button.addClass('correct');
                    button.append($('<i class="fa-solid fa-check">'));
                } else if (index === selected) {
                    button.addClass('incorrect');
                    button.append($('<i class="fa-solid fa-xmark">'));
                }
            }

            button.on('click', function () {
                if (selectedAnswers[currentQuestion] !== null || quizFinished) return;

                selectedAnswers[currentQuestion] = index;
                renderQuestion();
            });

            $('#answerOptions').append(button);
        });

        if (selected !== null) {
            const isCorrect = selected === question.answer;
            const feedback = $('<div class="feedback-box">')
                .addClass(isCorrect ? 'feedback-good' : 'feedback-bad');

            const heading = $('<div class="fw-bold mb-1">').text(
                isCorrect ? 'Correct answer!' : 'Not quite. Keep learning!'
            );

            const explanation = $('<div>').text(question.explanation);
            feedback.append(heading, explanation);
            $('#answerFeedback').append(feedback);
        }

        $('#previousQuestion').prop('disabled', currentQuestion === 0);

        const isLast = currentQuestion === quizQuestions.length - 1;
        $('#nextQuestion')
            .prop('disabled', selected === null)
            .html(isLast
                ? 'View results <i class="fa-solid fa-flag-checkered ms-1"></i>'
                : 'Next question <i class="fa-solid fa-arrow-right ms-1"></i>');
    }

    function finishQuiz() {
        quizFinished = true;

        const correct = selectedAnswers.reduce((total, answer, index) => {
            return total + (answer === quizQuestions[index].answer ? 1 : 0);
        }, 0);

        const incorrect = quizQuestions.length - correct;
        const percentage = Math.round((correct / quizQuestions.length) * 100);

        $('#questionArea, #quizControls').addClass('d-none');
        $('#quizResult').removeClass('d-none');
        $('#finalScore').text(`${percentage}%`);
        $('#correctCount').text(correct);
        $('#incorrectCount').text(incorrect);

        let title = 'Keep practicing!';
        let message = 'Review the lessons and try the quiz again. Every attempt is a chance to learn.';

        if (percentage >= 80) {
            title = 'Excellent work!';
            message = 'You demonstrated a strong understanding of these topics. Keep it up!';
        } else if (percentage >= 60) {
            title = 'Good effort!';
            message = 'You are making progress. Review the explanations and practice again.';
        }

        $('#resultTitle').text(title);
        $('#resultMessage').text(message);
    }

    $('#previousQuestion').on('click', function () {
        if (currentQuestion > 0) {
            currentQuestion--;
            renderQuestion();
        }
    });

    $('#nextQuestion').on('click', function () {
        if (selectedAnswers[currentQuestion] === null) return;

        if (currentQuestion < quizQuestions.length - 1) {
            currentQuestion++;
            renderQuestion();
        } else {
            finishQuiz();
        }
    });

    $('#retryQuiz').on('click', function () {
        currentQuestion = 0;
        selectedAnswers = Array(quizQuestions.length).fill(null);
        quizFinished = false;

        $('#quizResult').addClass('d-none');
        $('#questionArea, #quizControls').removeClass('d-none');

        renderQuestion();
    });

    renderQuestion();
</script>

<?php require 'includes/app_footer.php'; ?>