$(function () {
    const feedbackModal = new bootstrap.Modal(document.getElementById('feedback-modal'));
    const serverUrl = 'core/server.php';

    if (message) {
        showMessage(message.title, message.type, message.text);
    }

    $('.loadable').on('click', function (e) {
        e.preventDefault();

        const targetUrl = $(this).attr('href');

        $("#app-loading-overlay").addClass("is-active");

        setTimeout(function () {
            location.href = targetUrl;
        }, 500);
    });

    $('#logoutBtn').on('click', function (e) {
        $("#app-loading-overlay").addClass("is-active");

        var formData = new FormData();

        formData.append('action', 'logout');

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
                        location.href = 'login.php';
                    } else {
                        $("#app-loading-overlay").removeClass("is-active");

                        showMessage('Logout Failed', 'danger', 'Unable to logout. Please try again.');
                    }
                }, 500);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    });

    // Preview selected profile image.
    $('#profile-image').on('change', function () {
        const file = this.files[0];

        if (!file) return;

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {
            showMessage(
                'Invalid Image',
                'danger',
                'Please select a JPG, PNG, or WEBP image.'
            );

            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            showMessage(
                'Image Too Large',
                'warning',
                'Your profile picture must not exceed 2 MB.'
            );

            this.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            $('#edit-profile-preview')
                .attr('src', e.target.result)
                .show();

            $('#edit-profile-initials').hide();
        };

        reader.readAsDataURL(file);

        $('#profile-image-name').text(file.name);
    });

    // Submit profile update.
    $('#edit-profile-form').on('submit', function (e) {
        e.preventDefault();

        $("#app-loading-overlay").addClass("is-active");

        const id = $("#edit-id").val();
        const first_name = $("#edit-first-name").val();
        const middle_name = $("#edit-middle-name").val();
        const last_name = $("#edit-last-name").val();
        const date_of_birth = $("#edit-date-of-birth").val();
        const sex = $("#edit-sex").val();
        const imageFile = $('#profile-image')[0].files[0];

        const formData = new FormData(this);

        formData.append('id', id);
        formData.append('first_name', first_name);
        formData.append('middle_name', middle_name);
        formData.append('last_name', last_name);
        formData.append('date_of_birth', date_of_birth);
        formData.append('sex', sex);
        if (imageFile) {
            formData.set('image', imageFile);
        }

        // Add action.
        formData.append('action', 'update_profile');

        $.ajax({
            url: serverUrl,
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,

            success: function (response) {
                setTimeout(function () {
                    $("#app-loading-overlay").removeClass("is-active");

                    if (response.success) {
                        location.reload();
                    } else {
                        showMessage('Server Error', 'danger', response.message);
                    }
                }, 500);
            },

            error: function (xhr, status, error) {
                console.error(error);
                console.error(xhr.responseText);
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