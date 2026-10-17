<?php
$pageTitle = 'My Profile';
$activePage = 'profile';

require 'includes/app_header.php';
?>

<link rel="stylesheet" href="assets/css/profile.css?v=1.0">

<div class="profile-page">

    <div class="page-heading">
        <div>
            <h1>My Profile</h1>
            <p>Manage your account settings and personal information.</p>
        </div>

        <div class="icon-box icon-purple d-none d-sm-grid">
            <i class="fa-solid fa-user-pen"></i>
        </div>
    </div>

    <div class="profile-hero">
        <?php
        $nameParts = preg_split('/\s+/', trim($fullName), -1, PREG_SPLIT_NO_EMPTY);
        $avatarInitials = '';
        if (!empty($nameParts)) {
            $avatarInitials = strtoupper(substr($nameParts[0], 0, 1));
            if (count($nameParts) > 1) {
                $avatarInitials .= strtoupper(substr($nameParts[count($nameParts) - 1], 0, 1));
            }
        }
        ?>
        <div class="profile-avatar" id="profileAvatar"><?= htmlspecialchars($avatarInitials, ENT_QUOTES, 'UTF-8') ?></div>
        <div>
            <h2 id="profileDisplayName"><?= $fullName ?></h2>
            <p id="profileDisplayEmail"><?= $_SESSION['user']['email'] ?></p>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <span class="badge bg-light text-primary"><?= $_SESSION['user']['role'] ?></span>
                <span class="badge bg-light text-dark"><?= $_SESSION['user']['username'] ?></span>
            </div>
        </div>
    </div>

    <form id="profileForm" class="profile-form">

        <div class="panel mb-4">

            <div class="profile-section-title">
                <i class="fa-solid fa-address-card"></i>
                Personal Information
            </div>

            <p class="profile-section-subtitle">
                Update the personal details associated with your account.
            </p>

            <div class="row g-3">

                <div class="col-md-4">
                    <label for="firstName" class="form-label">
                        First Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="firstName" name="first_name" value="<?= isset($_SESSION['user']['first_name']) ? htmlspecialchars($_SESSION['user']['first_name'], ENT_QUOTES, 'UTF-8') : '' ?>" maxlength="100" autocomplete="given-name" required>
                </div>

                <div class="col-md-4">
                    <label for="middleName" class="form-label">
                        Middle Name
                    </label>
                    <input type="text" class="form-control" id="middleName" name="middle_name" value="<?= isset($_SESSION['user']['middle_name']) ? htmlspecialchars($_SESSION['user']['middle_name'], ENT_QUOTES, 'UTF-8') : '' ?>" maxlength="100" autocomplete="additional-name">
                    <div class="form-text">Optional</div>
                </div>

                <div class="col-md-4">
                    <label for="lastName" class="form-label">
                        Last Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="lastName" name="last_name" value="<?= isset($_SESSION['user']['last_name']) ? htmlspecialchars($_SESSION['user']['last_name'], ENT_QUOTES, 'UTF-8') : '' ?>" maxlength="100" autocomplete="family-name" required>
                </div>

                <div class="col-12">
                    <label for="email" class="form-label">
                        Email Address <span class="text-danger">*</span>
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8') : '' ?>" maxlength="255" autocomplete="email" required>
                </div>

                <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" value="<?= isset($_SESSION['user']['username']) ? htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') : '' ?>" readonly>
                    <div class="form-text">Your username cannot be changed.</div>
                </div>

                <div class="col-md-6">
                    <label for="accountStatus" class="form-label">
                        Account Status
                    </label>
                    <input type="text" class="form-control" id="accountStatus" value="<?= isset($_SESSION['user']['account_status']) ? htmlspecialchars($_SESSION['user']['account_status'], ENT_QUOTES, 'UTF-8') : '' ?>" readonly>
                </div>

            </div>

            <hr class="profile-divider">

            <div class="profile-section-title">
                <i class="fa-solid fa-graduation-cap"></i>
                Academic Information
            </div>

            <p class="profile-section-subtitle">
                Your current student details. These fields are editable in
                this design preview.
            </p>

            <div class="row g-3">

                <div class="col-md-6">
                    <label for="studentNumber" class="form-label">
                        Student Number
                    </label>
                    <input type="text" class="form-control" id="studentNumber" name="student_number" value="<?= isset($_SESSION['student_profile']['student_number']) ? htmlspecialchars($_SESSION['student_profile']['student_number'], ENT_QUOTES, 'UTF-8') : '' ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="gradeLevel" class="form-label">
                        Grade Level
                    </label>
                    <select class="form-select" id="gradeLevel" name="grade_level">
                        <option value="11" <?= isset($_SESSION['student_profile']['grade_level']) && $_SESSION['student_profile']['grade_level'] === 11 ? 'selected' : '' ?>>Grade 11</option>
                        <option value="12" <?= isset($_SESSION['student_profile']['grade_level']) && $_SESSION['student_profile']['grade_level'] === 12 ? 'selected' : '' ?>>Grade 12</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="strand" class="form-label">Strand</label>
                    <select class="form-select" id="strand" name="strand">
                        <option value="STEM" <?= isset($_SESSION['student_profile']['strand']) && $_SESSION['student_profile']['strand'] === 'STEM' ? 'selected' : '' ?>>STEM</option>
                        <option value="ABM" <?= isset($_SESSION['student_profile']['strand']) && $_SESSION['student_profile']['strand'] === 'ABM' ? 'selected' : '' ?>>ABM</option>
                        <option value="HUMSS" <?= isset($_SESSION['student_profile']['strand']) && $_SESSION['student_profile']['strand'] === 'HUMSS' ? 'selected' : '' ?>>HUMSS</option>
                        <option value="GAS" <?= isset($_SESSION['student_profile']['strand']) && $_SESSION['student_profile']['strand'] === 'GAS' ? 'selected' : '' ?>>GAS</option>
                        <option value="TVL-ICT" <?= isset($_SESSION['student_profile']['strand']) && $_SESSION['student_profile']['strand'] === 'TVL-ICT' ? 'selected' : '' ?>>TVL - ICT</option>
                        <option value="TVL-HE" <?= isset($_SESSION['student_profile']['strand']) && $_SESSION['student_profile']['strand'] === 'TVL-HE' ? 'selected' : '' ?>>TVL - Home Economics</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="section" class="form-label">Section</label>
                    <input type="text" class="form-control" id="section" name="section" value="<?= isset($_SESSION['student_profile']['section']) ? htmlspecialchars($_SESSION['student_profile']['section'], ENT_QUOTES, 'UTF-8') : 'ICT - A' ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="schoolYear" class="form-label">School Year</label>
                    <select class="form-select" id="schoolYear" name="school_year">
                        <option value="2025-2026" <?= isset($_SESSION['student_profile']['school_year']) && $_SESSION['student_profile']['school_year'] === '2025-2026' ? 'selected' : '' ?>>2025-2026</option>
                        <option value="2026-2027" <?= isset($_SESSION['student_profile']['school_year']) && $_SESSION['student_profile']['school_year'] === '2026-2027' ? 'selected' : '' ?>>2026-2027</option>
                        <option value="2027-2028" <?= isset($_SESSION['student_profile']['school_year']) && $_SESSION['student_profile']['school_year'] === '2027-2028' ? 'selected' : '' ?>>2027-2028</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="enrollmentStatus" class="form-label">
                        Enrollment Status
                    </label>
                    <select class="form-select" id="enrollmentStatus" name="enrollment_status">
                        <option value="Enrolled" <?= isset($_SESSION['student_profile']['enrollment_status']) && $_SESSION['student_profile']['enrollment_status'] === 'Enrolled' ? 'selected' : '' ?>>Enrolled</option>
                        <option value="Transferred" <?= isset($_SESSION['student_profile']['enrollment_status']) && $_SESSION['student_profile']['enrollment_status'] === 'Transferred' ? 'selected' : '' ?>>Transferred</option>
                        <option value="Graduated" <?= isset($_SESSION['student_profile']['enrollment_status']) && $_SESSION['student_profile']['enrollment_status'] === 'Graduated' ? 'selected' : '' ?>>Graduated</option>
                        <option value="Inactive" <?= isset($_SESSION['student_profile']['enrollment_status']) && $_SESSION['student_profile']['enrollment_status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

            </div>

            <div class="profile-note mt-3">
                <i class="fa-solid fa-circle-info"></i>
                <div>
                    <strong>Academic records</strong>
                    <div>
                        This is a design preview. Academic changes will not
                        update official school records.
                    </div>
                </div>
            </div>

            <hr class="profile-divider">

            <div class="profile-section-title">
                <i class="fa-solid fa-shield-halved"></i>
                Change Password
            </div>

            <p class="profile-section-subtitle">
                Leave these fields blank if you do not want to change your password.
            </p>

            <div class="row g-3">

                <div class="col-12">
                    <label for="currentPassword" class="form-label">
                        Current Password
                    </label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="currentPassword" name="current_password" autocomplete="current-password">
                        <button type="button" class="toggle-password" data-target="currentPassword" aria-label="Show current password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="newPassword" class="form-label">
                        New Password
                    </label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="newPassword" name="new_password" minlength="8" autocomplete="new-password">
                        <button type="button" class="toggle-password" data-target="newPassword" aria-label="Show new password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">At least 8 characters.</div>
                </div>

                <div class="col-md-6">
                    <label for="confirmPassword" class="form-label">
                        Confirm New Password
                    </label>
                    <div class="password-toggle">
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" minlength="8" autocomplete="new-password">
                        <button type="button" class="toggle-password" data-target="confirmPassword" aria-label="Show password confirmation">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div class="profile-actions">
                <button type="reset" class="btn btn-light-blue">
                    <i class="fa-solid fa-rotate-left me-2"></i>
                    Reset
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Save Changes
                </button>
            </div>

        </div>
    </form>

</div>

<script>
    const profileForm = document.getElementById('profileForm');
    const profileMessage = document.getElementById('profileMessage');

    const firstName = document.getElementById('firstName');
    const middleName = document.getElementById('middleName');
    const lastName = document.getElementById('lastName');
    const email = document.getElementById('email');

    function updateProfilePreview() {
        const first = firstName.value.trim();
        const middle = middleName.value.trim();
        const last = lastName.value.trim();

        document.getElementById('profileDisplayName').textContent =
            [first, middle, last].filter(Boolean).join(' ') || 'Your Name';

        document.getElementById('profileDisplayEmail').textContent =
            email.value.trim() || 'No email address';

        document.getElementById('profileAvatar').textContent =
            ((first.charAt(0) || '') + (last.charAt(0) || '')).toUpperCase() || '?';
    }

    [firstName, middleName, lastName, email].forEach(input => {
        input.addEventListener('input', updateProfilePreview);
    });

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');
            const showPassword = input.type === 'password';

            input.type = showPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !showPassword);
            icon.classList.toggle('fa-eye-slash', showPassword);

            this.setAttribute(
                'aria-label',
                showPassword ? 'Hide password' : 'Show password'
            );
        });
    });

    document.getElementById('newPassword').addEventListener('input', validatePasswords);
    document.getElementById('confirmPassword').addEventListener('input', validatePasswords);

    function validatePasswords() {
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');

        confirmPassword.setCustomValidity(
            confirmPassword.value !== '' &&
                confirmPassword.value !== newPassword.value
                ? 'The passwords do not match.'
                : ''
        );
    }

    profileForm.addEventListener('submit', function (event) {
        event.preventDefault();
        validatePasswords();

        if (!profileForm.reportValidity()) {
            return;
        }

        profileMessage.classList.remove('d-none');
        profileMessage.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    });

    profileForm.addEventListener('reset', function () {
        setTimeout(() => {
            profileMessage.classList.add('d-none');
            document.querySelectorAll('.password-toggle input').forEach(input => {
                input.type = 'password';
            });
            document.querySelectorAll('.toggle-password i').forEach(icon => {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            });
            updateProfilePreview();
        }, 0);
    });
</script>

<?php require 'includes/app_footer.php'; ?>