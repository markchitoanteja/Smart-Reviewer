<?php
$currentPage = $activePage ?? 'dashboard';
?>

<link rel="stylesheet" href="assets/css/app_footer.css?v=1.0">

<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content profile-modal">

            <form id="updateProfileForm" action="update_profile.php" method="POST">

                <!-- Header -->
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="profile-modal-icon">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>

                        <div>
                            <h5 class="modal-title" id="updateProfileModalLabel">
                                Edit Profile
                            </h5>
                            <small class="text-secondary">
                                Update your account details
                            </small>
                        </div>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Personal Information -->
                    <div class="profile-section">
                        <div class="profile-section-title">
                            <i class="fa-solid fa-user me-2"></i>
                            Personal Information
                        </div>

                        <div class="mb-3">
                            <label for="profileFullName" class="form-label">
                                Full Name
                            </label>

                            <input type="text" class="form-control" id="profileFullName" name="full_name" placeholder="Enter your full name" maxlength="100" autocomplete="name" required>
                        </div>

                        <div>
                            <label for="profileUsername" class="form-label">
                                Username
                            </label>

                            <input type="text" class="form-control" id="profileUsername" name="username" placeholder="Choose a username" minlength="3" maxlength="50" autocomplete="username" required>
                        </div>
                    </div>

                    <div class="profile-divider"></div>

                    <!-- Password -->
                    <div class="profile-section">
                        <div class="profile-section-title">
                            <i class="fa-solid fa-lock me-2"></i>
                            Change Password
                            <span class="optional-label">Optional</span>
                        </div>

                        <p class="profile-help">
                            Enter your current password to save changes.
                            Leave the new password blank if you don't want to change it.
                        </p>

                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">
                                Current Password
                            </label>

                            <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Enter current password" autocomplete="current-password" required>
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label">
                                New Password
                            </label>

                            <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="At least 8 characters" minlength="8" autocomplete="new-password">
                        </div>

                        <div>
                            <label for="confirmPassword" class="form-label">
                                Confirm New Password
                            </label>

                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Repeat new password" autocomplete="new-password">
                        </div>
                    </div>

                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(
                        $_SESSION['csrf_token'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>">

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary" id="saveProfileButton">
                        <i class="fa-solid fa-check me-1"></i>
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .profile-modal {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
    }

    .profile-modal .modal-header {
        padding: 18px;
        border-bottom: 1px solid #EAECF0;
    }

    .profile-modal-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #EAF1FF;
        color: #155EEF;
        font-size: 17px;
    }

    .profile-modal .modal-title {
        margin-bottom: 3px;
        font-size: 17px;
        font-weight: 800;
    }

    .profile-modal .modal-header small {
        font-size: 12px;
    }

    .profile-modal .modal-body {
        padding: 18px;
    }

    .profile-section-title {
        display: flex;
        align-items: center;
        margin-bottom: 14px;
        color: #182230;
        font-size: 13px;
        font-weight: 800;
    }

    .profile-section-title>i {
        color: #155EEF;
    }

    .optional-label {
        margin-left: auto;
        color: #667085;
        font-size: 11px;
        font-weight: 500;
    }

    .profile-modal .form-label {
        margin-bottom: 6px;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .profile-modal .form-control {
        min-height: 44px;
        padding: 10px 12px;
        border-color: #D0D5DD;
        border-radius: 10px;
        font-size: 13px;
    }

    .profile-modal .form-control:focus {
        border-color: #84ADFF;
        box-shadow: 0 0 0 3px rgba(21, 94, 239, 0.10);
    }

    .profile-help {
        margin: -5px 0 15px;
        color: #667085;
        font-size: 12px;
        line-height: 1.6;
    }

    .profile-divider {
        height: 1px;
        margin: 20px 0;
        background: #EAECF0;
    }

    .profile-modal .modal-footer {
        gap: 8px;
        padding: 13px 18px;
        border-top: 1px solid #EAECF0;
        background: #FCFCFD;
    }

    .profile-modal .modal-footer .btn {
        min-height: 42px;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
    }

    .profile-modal .btn-light {
        border: 1px solid #D0D5DD;
        background: #FFFFFF;
        color: #344054;
    }

    @media (max-width: 575.98px) {
        .profile-modal {
            border-radius: 16px;
        }

        .profile-modal .modal-header {
            padding: 15px 16px;
        }

        .profile-modal .modal-body {
            padding: 16px;
        }

        .profile-divider {
            margin: 17px 0;
        }

        .profile-modal .modal-footer {
            padding: 12px 16px;
        }

        .profile-modal .modal-footer .btn {
            flex: 1;
        }
    }
</style>


<nav class="mobile-bottom-nav" aria-label="Main navigation">

    <a href="dashboard.php" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?> loadable">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <a href="reviewer.php" class="<?= $currentPage === 'reviewer' ? 'active' : '' ?> loadable">
        <i class="fa-solid fa-book-open"></i>
        <span>Lessons</span>
    </a>

    <a href="quizzes.php" class="<?= $currentPage === 'quizzes' ? 'active' : '' ?> loadable">
        <i class="fa-solid fa-circle-question"></i>
        <span>Quizzes</span>
    </a>

    <a href="progress.php" class="<?= $currentPage === 'progress' ? 'active' : '' ?> loadable">
        <i class="fa-solid fa-chart-simple"></i>
        <span>Progress</span>
    </a>

    <a href="profile.php" class="<?= $currentPage === 'profile' ? 'active' : '' ?> loadable">
        <i class="fa-solid fa-user"></i>
        <span>Profile</span>
    </a>

    <a href="logout.php" class="sign-out" id="mobileSignOutButton">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Sign Out</span>
    </a>

</nav>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const loader = $('#pageLoader');

    // Show loader
    window.showLoader = function () {
        loader
            .stop(true, true)
            .css('display', 'flex')
            .removeClass('is-hidden')
            .attr('aria-hidden', 'false');
    };

    // Hide loader
    window.hideLoader = function () {
        loader
            .addClass('is-hidden')
            .attr('aria-hidden', 'true');

        setTimeout(function () {
            if (loader.hasClass('is-hidden')) {
                loader.css('display', 'none');
            }
        }, 400); // Match the CSS transition duration
    };

    hideLoader();

    $(document).on('click', '#mobileSignOutButton', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Sign out?',
            text: 'Are you sure you want to sign out?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, sign out',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#155EEF',
            cancelButtonColor: '#7B879B',
            reverseButtons: true
        }).then(function (result) {
            if (result.isConfirmed) {
                showLoader();
                window.location.href = 'logout.php';
            }
        });
    });

    // Show loader during internal page transitions
    $(document).on('click', 'a.loadable', function (event) {
        // Ignore modified clicks, such as opening a new tab
        if (
            event.ctrlKey ||
            event.metaKey ||
            event.shiftKey ||
            event.altKey ||
            event.which !== 1
        ) {
            return;
        }

        const link = this;
        const href = link.getAttribute('href');

        // Ignore invalid links and links that open in another tab
        if (
            !href ||
            href.startsWith('#') ||
            link.target === '_blank' ||
            link.hasAttribute('download')
        ) {
            return;
        }

        const destination = new URL(href, window.location.href);

        // Ignore external websites
        if (destination.origin !== window.location.origin) {
            return;
        }

        // Ignore links to the current page
        if (
            destination.pathname === window.location.pathname &&
            destination.search === window.location.search &&
            destination.hash === window.location.hash
        ) {
            return;
        }

        showLoader();
    });
</script>

</body>

</html>