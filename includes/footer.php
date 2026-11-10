</div><!-- /.app-shell -->

<!-- Mobile-first fixed bottom navigation -->
<nav class="bottom-nav" aria-label="Main navigation">
    <a href="dashboard.php" class="loadable <?= $activePage === 'dashboard' ? 'active' : '' ?>" <?= $activePage === 'dashboard' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-house-door"></i><span>Home</span>
    </a>
    <a href="reviewers.php" class="loadable <?= $activePage === 'reviewers' ? 'active' : '' ?>" <?= $activePage === 'reviewers' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-journal-bookmark"></i><span>Reviewers</span>
    </a>
    <a href="quizzes.php" class="loadable <?= $activePage === 'quizzes' ? 'active' : '' ?>" <?= $activePage === 'quizzes' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-clipboard-check"></i><span>Quizzes</span>
    </a>
    <a href="profile.php" class="loadable <?= $activePage === 'profile' ? 'active' : '' ?>" <?= $activePage === 'profile' ? 'aria-current="page"' : '' ?>>
        <i class="bi bi-person"></i><span>Profile</span>
    </a>
    <a href="javascript:void(0)" id="logoutBtn" class="bottom-nav-item logout-nav-item">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </a>
</nav>

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

<?php if ($activePage == "profile"): ?>
    <!-- Edit Profile Modal -->
    <div class="modal fade profile-edit-modal" id="edit-profile-modal" tabindex="-1" aria-labelledby="edit-profile-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="edit-profile-title">
                            Edit Profile
                        </h5>
                        <p>Update your personal information.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="edit-profile-form" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Profile Picture -->
                        <div class="edit-photo-section">
                            <div class="edit-photo-preview">
                                <img id="edit-profile-preview" src="<?= !empty($profileImage) ? escape($profileImage) : '' ?>" alt="Profile picture" style="<?= empty($profileImage) ? 'display:none;' : '' ?>">

                                <span id="edit-profile-initials" style="<?= !empty($profileImage) ? 'display:none;' : '' ?>">
                                    <?= escape($initials) ?>
                                </span>
                            </div>

                            <div class="edit-photo-controls">
                                <strong>Profile Picture</strong>
                                <small>JPG, PNG or WEBP. Maximum 2 MB.</small>

                                <label for="profile-image" class="edit-photo-btn">
                                    <i class="bi bi-camera"></i>
                                    Change Photo
                                </label>

                                <input type="file" name="profile_image" id="profile-image" accept="image/jpeg,image/png,image/webp" hidden>

                                <small id="profile-image-name"></small>
                            </div>

                        </div>

                        <div class="edit-form-divider"></div>

                        <!-- Personal Details -->
                        <div class="edit-form-heading">
                            <i class="bi bi-person-lines-fill"></i>
                            Personal Details
                        </div>

                        <div class="mb-3">
                            <label for="edit-first-name" class="form-label">
                                First Name <span>*</span>
                            </label>
                            <input type="text" class="form-control" id="edit-first-name" name="first_name" maxlength="60" required value="<?= escape($student['first_name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="edit-middle-name" class="form-label">
                                Middle Name
                            </label>
                            <input type="text" class="form-control" id="edit-middle-name" name="middle_name" maxlength="60" value="<?= escape($student['middle_name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="edit-last-name" class="form-label">
                                Last Name <span>*</span>
                            </label>
                            <input type="text" class="form-control" id="edit-last-name" name="last_name" maxlength="60" required value="<?= escape($student['last_name'] ?? '') ?>">
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="edit-date-of-birth" class="form-label">
                                    Date of Birth
                                </label>
                                <input type="date" class="form-control" id="edit-date-of-birth" name="date_of_birth" value="<?= escape($student['date_of_birth'] ?? '') ?>">
                            </div>

                            <div class="col-6 mb-3">
                                <label for="edit-sex" class="form-label">
                                    Sex
                                </label>
                                <select class="form-select" id="edit-sex" name="sex">
                                    <option value="" disabled selected>-- Select One --</option>

                                    <option value="Male" <?= ($student['sex'] ?? '') === 'Male' ? 'selected' : '' ?>>
                                        Male
                                    </option>

                                    <option value="Female" <?= ($student['sex'] ?? '') === 'Female' ? 'selected' : '' ?>>
                                        Female
                                    </option>

                                    <option value="Prefer not to say" <?= ($student['sex'] ?? '') === 'Prefer not to say' ? 'selected' : '' ?>>
                                        Prefer not to say
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="edit-form-note">
                            <i class="bi bi-info-circle"></i>
                            Your academic information and student ID are
                            managed by the school administrator.
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" id="edit-id" value="<?= escape($student['id']) ?>">

                        <button type="button" class="btn edit-cancel-btn" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn edit-save-btn" id="save-profile-btn">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php endif ?>

<script>
    const message = <?= json_encode(getFlashMessage('main_message')) ?>;
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js?v=<?= env("APP_VERSION") ?>"></script>
</body>

</html>