$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        const email = $('#loginEmail').val();
        const password = $('#loginPassword').val();

        $.ajax({
            url: '../api/v1/login.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email: email, password: password }),
            success: function(response) {
                if (response.token) {
                    localStorage.setItem('jwt', response.token);
                    window.location.href = 'dashboard.php';
                } else {
                    $('#message').html('<div class="alert alert-danger">Login failed: ' + (response.message || 'Unknown ') + '</div>');
                }
            },
            error: function(xhr) {
                $('#message').html('<div class="alert alert-danger">Login failed: ' + (xhr.responseJSON.message || 'Unknown error') + '</div>');
            }
        });
    });

    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        const username = $('#registerUsername').val();
        const email = $('#registerEmail').val();
        const password = $('#registerPassword').val();

        $.ajax({
            url: '../api/v1/register.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ username: username, email: email, password: password }),
            success: function(response) {
                $('#message').html('<div class="alert alert-success">' + (response.message || 'Registration successful') + '</div>');
                $('#registerForm')[0].reset();
            },
            error: function(xhr) {
                $('#message').html('<div class="alert alert-danger">Registration failed. ' + (xhr.responseJSON.message || 'Unknown error') + '</div>');
            }
        });
    });
});
