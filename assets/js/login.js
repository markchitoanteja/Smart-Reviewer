$(function () {
    // Show or hide password.
    $('#togglePassword').on('click', function () {
        const input = $('#password');
        const icon = $(this).find('i');
        const show = input.attr('type') === 'password';

        input.attr('type', show ? 'text' : 'password');

        icon.toggleClass('fa-eye fa-eye-slash');

        $(this)
            .attr('aria-pressed', String(show))
            .attr(
                'aria-label',
                show ? 'Hide password' : 'Show password'
            );
    });

    // Show loader when submitting the login form.
    $('#loginForm').on('submit', function (event) {
        showLoader(true);

        const username = $('#username').val();
        const password = $('#password').val();
        const rememberMe = $('#rememberMe').is(':checked');

        var formData = new FormData();

        formData.append('username', username);
        formData.append('password', password);
        formData.append('remember_me', rememberMe);
        formData.append('action', 'login');

        $.ajax({
            url: 'server.php',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                setTimeout(function () {
                    if (response.isError) {
                        showLoader(false);

                        showNotification('Login Failed', response.message, 'error');
                    } else {
                        location.reload();
                    }
                }, 500);
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    });

    function showLoader(show) {
        if (show) {
            $('#pageLoader').css('display', 'flex');
        } else {
            $('#pageLoader').css('display', 'none');
        }
    }

    function showNotification(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon
        });
    }
});