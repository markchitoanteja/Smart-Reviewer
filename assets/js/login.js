$(function () {
    const feedbackModal = new bootstrap.Modal(document.getElementById('feedback-modal'));
    const serverUrl = 'core/server.php';

    if (message) {
        showMessage(message.title, message.type, message.text);
    }

    $('#toggle-password').on('click', function () {
        const show = $('#password').attr('type') === 'password';

        $('#password').attr('type', show ? 'text' : 'password');

        $(this).attr({ 'aria-label': show ? 'Hide password' : 'Show password', 'title': show ? 'Hide password' : 'Show password' }).find('i').toggleClass('bi-eye', !show).toggleClass('bi-eye-slash', show);
    });

    $('#student-id').on('input', function () {
        $(this).css('border-color', '');
    });

    $('#password').on('input', function () {
        $(this).css('border-color', '');
    });

    $('#forgot-password').on('click', function (e) {
        showMessage('Forgot Password?', 'warning', 'For account security, please contact your teacher or school administrator to reset your password.');
    });

    $('#help-signing-in').on('click', function () {
        showMessage('Need Help Signing In?', 'warning', 'Having trouble signing in? If you forgot your password, contact your teacher or school administrator to request a password reset. If you forgot your Student ID, ask your class adviser for assistance.');
    });

    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        const studentId = $('#student-id').val().trim();
        const password = $('#password').val();
        const remember = $('#remember').is(':checked');

        $("#app-loading-overlay").addClass("is-active");

        var formData = new FormData();

        formData.append('student_id', studentId);
        formData.append('password', password);
        formData.append('remember', remember);
        formData.append('action', 'login');

        $.ajax({
            url: serverUrl,
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                setTimeout(function () {
                    if (response.success) {
                        location.reload();
                    } else {
                        $("#app-loading-overlay").removeClass("is-active");

                        showMessage('Login Failed', 'danger', 'Invalid Student ID or password. Please try again.');
                    }
                }, 500);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    });

    function showMessage(title, type, text) {
        const config = {
            danger: {
                icon: 'bi-exclamation-circle-fill',
                style: 'is-error',
                button: 'Try Again'
            },
            warning: {
                icon: 'bi-info-circle-fill',
                style: 'is-warning',
                button: 'Got It'
            },
            success: {
                icon: 'bi-check-circle-fill',
                style: 'is-success',
                button: 'Continue'
            }
        };
        const state = config[type] || config.warning;

        $('#feedback-modal-title').text(title);
        $('#feedback-modal-message').text(text);
        $('#feedback-status-icon').attr('class', 'feedback-status-icon ' + state.style).html('<i class="bi ' + state.icon + '" aria-hidden="true"></i>');
        $('#feedback-modal .feedback-confirm-btn span').text(state.button);

        feedbackModal.show();
    }
});