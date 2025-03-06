<script>
    function submitLogin() {

        let formData = new FormData($('#loginForm')[0]);  // Get form element using jQuery and pass to FormData

        $.ajax({
            url: "{{ route('login') }}",
            type: "POST",
            data: formData,
            processData: false, // Required for FormData
            contentType: false, // Required for FormData
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Set CSRF token
            },
            success: function(response) {
                let messageDiv = $('#loginMessage');
                if (response.success) {
                    messageDiv.html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(function() {
                        window.location.href = response.url;  // Redirect to profile page
                    }, 1000);
                } else {
                    messageDiv.html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(xhr) {
                // Handle validation errors (optional)
                let errors = xhr.responseJSON?.errors || {};
                handleValidationErrors(errors);
            }
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

</script>
