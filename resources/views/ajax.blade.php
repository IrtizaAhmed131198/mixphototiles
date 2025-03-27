<script>

    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function submitLogin() {
        let formData = new FormData($('.loginForm')[0]);  // Get form element using jQuery and pass to FormData

        $.ajax({
            url: "{{ route('login') }}",
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Set CSRF token
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = "{{ route('profile') }}"; // Redirect to profile route
                } else {
                    $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors || {};
                handleValidationErrors(errors);
            }
        });
    }

    function sendOtp() {
        let email = document.getElementById("emailInputPass").value.trim();
        let emailError = document.getElementById("emailError");
        let forgotPasswordMessage = document.getElementById("forgotPasswordMessage");

        emailError.innerText = "";
        forgotPasswordMessage.innerHTML = "";

        if (email === "") {
            emailError.innerText = "Email is required.";
            return;
        }

        fetch("{{ route('password.sendOtp') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                forgotPasswordMessage.innerHTML = `<span class="text-success">${data.message}</span>`;

                // Close the Forgot Password modal
                let forgotPasswordModal = new bootstrap.Modal(document.getElementById("exampleModalToggle3"));
                forgotPasswordModal.hide();

                // Open the Verify OTP modal
                let verifyOtpModal = new bootstrap.Modal(document.getElementById("exampleModalToggleOtp"));
                verifyOtpModal.show();
            } else {
                forgotPasswordMessage.innerHTML = `<span class="text-danger">${data.message}</span>`;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function verifyOtp() {
        let email = document.getElementById("emailInputPass").value.trim();
        let otp = document.getElementById("otpInputEdit").value.trim();
        let otpError = document.getElementById("otpError");
        let otpMessage = document.getElementById("otpMessage");

        otpError.innerText = "";
        otpMessage.innerHTML = "";

        console.log(otp);
        if (otp === "") {
            otpError.innerText = "OTP is required.";
            return;
        }

        fetch("{{ route('password.verifyOtp') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ email: email, otp: otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                otpMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;

                document.getElementById("get_email").value = email;

                // Close OTP modal
                let otpModal = new bootstrap.Modal(document.getElementById('exampleModalToggleOtp'));
                otpModal.hide();

                // Open Reset Password modal
                let resetPasswordModal = new bootstrap.Modal(document.getElementById('exampleModalToggleReset'));
                resetPasswordModal.show();
            } else {
                otpError.textContent = data.message;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    function resetPassword() {
        let email = document.getElementById('get_email').value;
        let newPassword = document.getElementById('newPassword').value;
        let confirmPassword = document.getElementById('confirmPassword').value;
        let resetPasswordMessage = document.getElementById('resetPasswordMessage');

        resetPasswordMessage.innerHTML = '';

        if (newPassword.length < 6) {
            resetPasswordMessage.innerHTML = `<div class="alert alert-danger">Password must be at least 6 characters.</div>`;
            return;
        }

        if (newPassword !== confirmPassword) {
            resetPasswordMessage.innerHTML = `<div class="alert alert-danger">Passwords do not match.</div>`;
            return;
        }

        fetch("{{ route('password.resetPassword') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: email, password: newPassword, password_confirmation: confirmPassword })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                resetPasswordMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;

                // Close Reset Password modal after success
                setTimeout(() => {
                    let resetPasswordModal = new bootstrap.Modal(document.getElementById('exampleModalToggleReset'));
                    resetPasswordModal.hide();

                    // Redirect to login or profile page after password reset
                    window.location.href = "{{ route('home') }}";  // Change URL based on your app flow
                }, 2000);
            } else {
                resetPasswordMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            resetPasswordMessage.innerHTML = `<div class="alert alert-danger">Something went wrong. Please try again.</div>`;
        });
    }

    // Optional function to highlight errors
    function handleValidationErrors(errors) {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        for (let field in errors) {
            let input = $('[name="' + field + '"]');
            input.addClass('is-invalid');

            let errorMessage = $('<div class="invalid-feedback">' + errors[field][0] + '</div>');
            input.after(errorMessage);
        }
    }

    $(document).ready(function () {
        $('#signupForm').submit(function (e) {
            e.preventDefault();
            $('.error-message').remove();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('register.post') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#signupBtn').prop('disabled', true).text('Processing...');
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message
                        }).then(() => {
                            window.location.href = "{{ route('login') }}";
                        });
                    }
                },
                error: function (xhr) {
                    $('#signupBtn').prop('disabled', false).text('Sign Up');
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            var input = $('input[name="' + key + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="error-message text-danger">' + value[0] + '</div>');
                        });
                    }
                }
            });
        });
    });

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            let passwordField = this.previousElementSibling;
            let icon = this.querySelector('i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });

</script>
