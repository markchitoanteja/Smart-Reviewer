<?php

$pageTitle = 'My Profile';
$activePage = 'profile';

require_once __DIR__ . '/includes/header.php';

// Student full name.
$middleName = trim($student['middle_name'] ?? '');
$middleInitials = '';

if ($middleName !== '') {
    $middleNameParts = preg_split('/\s+/', $middleName);
    $middleInitials = implode('.', array_map(function ($part) {
        return strtoupper(substr($part, 0, 1));
    }, $middleNameParts)) . '.';
}

$fullName = trim(implode(' ', array_filter([
    $student['first_name'] ?? '',
    $middleInitials,
    $student['last_name'] ?? ''
])));

// Student initials.
$initials = strtoupper(
    substr($student['first_name'] ?? 'S', 0, 1) .
    substr($student['last_name'] ?? '', 0, 1)
);

// Profile image.
$profileImage = $student['image'] ? base_url() . "/assets/img/uploads/" . $student['image'] : null;

// Enrollment status.
$enrollmentStatus = $student['enrollment_status'] ?? 'enrolled';

// Account information.
$username = $user['username'] ?? 'Not available';
$email = $user['email'] ?? 'Not available';
?>

<main class="app-main profile-page pb-0">
    <!-- Page Heading -->
    <div class="profile-page-heading">
        <div>
            <p class="eyebrow">STUDENT ACCOUNT</p>
            <h1>My Profile</h1>
            <p class="profile-page-subtitle">
                View your personal and academic information.
            </p>
        </div>

        <div class="profile-heading-icon">
            <i class="bi bi-person-circle"></i>
        </div>
    </div>

    <!-- Student Profile Card -->
    <section class="profile-hero-card">

        <div class="profile-hero-decoration profile-decoration-one"></div>
        <div class="profile-hero-decoration profile-decoration-two"></div>

        <div class="profile-hero-content">

            <div class="profile-picture-wrapper">

                <?php if (!empty($profileImage)): ?>

                    <img src="<?= escape($profileImage) ?>" alt="<?= escape($fullName) ?>" class="profile-picture" onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">

                    <div class="profile-picture-fallback" style="display:none;">
                        <?= escape($initials) ?>
                    </div>

                <?php else: ?>

                    <div class="profile-picture-fallback">
                        <?= escape($initials) ?>
                    </div>

                <?php endif; ?>

            </div>

            <div class="profile-hero-info">

                <span class="profile-role-label">
                    <i class="bi bi-mortarboard-fill"></i>
                    STUDENT
                </span>

                <h2><?= escape($fullName ?: 'Student Name') ?></h2>

                <p class="profile-student-number">
                    <i class="bi bi-person-vcard"></i>
                    <?= escape($student['student_id'] ?? 'No Student ID') ?>
                </p>

                <span class="enrollment-badge status-<?= escape($enrollmentStatus) ?>">
                    <span></span>
                    <?= escape(ucfirst($enrollmentStatus)) ?>
                </span>

            </div>

        </div>

        <div class="profile-hero-actions">
            <button type="button" class="btn profile-edit-btn" data-bs-toggle="modal" data-bs-target="#edit-profile-modal">
                <i class="bi bi-pencil-square"></i>
                Edit Profile
            </button>
        </div>

        <div class="profile-hero-footer">
            <div>
                <i class="bi bi-calendar3"></i>
                School Year <?= escape($student['school_year'] ?? 'Not available') ?>
            </div>

            <div>
                <i class="bi bi-book"></i>
                Grade <?= escape($student['grade_level'] ?? '11') ?>
            </div>
        </div>
    </section>

    <!-- Academic Overview -->
    <section class="profile-section">

        <div class="profile-section-heading">
            <div>
                <h2>Academic Information</h2>
                <p>Your current school enrollment details.</p>
            </div>

            <div class="profile-section-icon academic-icon">
                <i class="bi bi-mortarboard"></i>
            </div>
        </div>

        <div class="profile-information-card">

            <div class="profile-info-item">
                <div class="profile-info-icon blue">
                    <i class="bi bi-layers"></i>
                </div>

                <div>
                    <small>Grade Level</small>
                    <strong>
                        Grade <?= escape($student['grade_level'] ?? '11') ?>
                    </strong>
                </div>
            </div>

            <div class="profile-info-item">
                <div class="profile-info-icon green">
                    <i class="bi bi-code-slash"></i>
                </div>

                <div>
                    <small>Strand</small>
                    <strong>
                        <?= escape($student['strand'] ?? 'Not available') ?>
                    </strong>
                </div>
            </div>

            <div class="profile-info-item">
                <div class="profile-info-icon orange">
                    <i class="bi bi-people"></i>
                </div>

                <div>
                    <small>Section</small>
                    <strong>
                        <?= escape($student['section'] ?? 'Not available') ?>
                    </strong>
                </div>
            </div>

            <div class="profile-info-item">
                <div class="profile-info-icon purple">
                    <i class="bi bi-calendar-range"></i>
                </div>

                <div>
                    <small>School Year</small>
                    <strong>
                        <?= escape($student['school_year'] ?? 'Not available') ?>
                    </strong>
                </div>
            </div>

        </div>

    </section>

    <!-- Personal Information -->
    <section class="profile-section">

        <div class="profile-section-heading">
            <div>
                <h2>Personal Information</h2>
                <p>Your registered personal details.</p>
            </div>

            <div class="profile-section-icon personal-icon">
                <i class="bi bi-person-lines-fill"></i>
            </div>
        </div>

        <div class="profile-information-card">

            <div class="profile-detail-row">
                <div>
                    <small>First Name</small>
                    <strong><?= escape($student['first_name'] ?? 'Not provided') ?></strong>
                </div>
                <i class="bi bi-person"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Middle Name</small>
                    <strong><?= escape($student['middle_name'] ?? 'Not provided') ?></strong>
                </div>
                <i class="bi bi-person"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Last Name</small>
                    <strong><?= escape($student['last_name'] ?? 'Not provided') ?></strong>
                </div>
                <i class="bi bi-person"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Date of Birth</small>
                    <strong>
                        <?= escape(formatDate($student['date_of_birth'] ?? null)) ?>
                    </strong>
                </div>
                <i class="bi bi-calendar-event"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Sex</small>
                    <strong><?= escape($student['sex'] ?? 'Not provided') ?></strong>
                </div>
                <i class="bi bi-gender-ambiguous"></i>
            </div>

        </div>

    </section>

    <!-- Account Information -->
    <section class="profile-section">

        <div class="profile-section-heading">
            <div>
                <h2>Account Information</h2>
                <p>Your Smart Reviewer login details.</p>
            </div>

            <div class="profile-section-icon account-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>

        <div class="profile-information-card">

            <div class="profile-detail-row">
                <div>
                    <small>Username</small>
                    <strong><?= escape($username) ?></strong>
                </div>
                <i class="bi bi-person-badge"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Email Address</small>
                    <strong><?= escape($email) ?></strong>
                </div>
                <i class="bi bi-envelope"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Student ID</small>
                    <strong>
                        <?= escape($student['student_id'] ?? 'Not available') ?>
                    </strong>
                </div>
                <i class="bi bi-card-text"></i>
            </div>

            <div class="profile-detail-row">
                <div>
                    <small>Account Created</small>
                    <strong>
                        <?= escape(formatDate($user['created_at'] ?? $student['created_at'] ?? null)) ?>
                    </strong>
                </div>
                <i class="bi bi-clock-history"></i>
            </div>

        </div>

    </section>

    <!-- School Information -->
    <section class="profile-school-note">
        <div class="profile-school-logo">
            <img src="assets/img/school-logo-transparent.png" alt="Dolores National High School" onerror="this.style.display='none';">
        </div>

        <div>
            <strong>Dolores National High School</strong>
            <p>Smart Reviewer Learning Portal</p>
            <small>Empowering students through digital learning.</small>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>