<script type="text/javascript">
$(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            // Clear previous errors
            clearErrors();
            // Gather form data
            var formData = {
                email: $('#email').val().trim(),
                password: $('#password').val().trim(),
                remember: $('#remember').is(':checked') ? 1 : '',
                _token: '{{ csrf_token() }}'
            };
            // Validate form data
            var hasErrors = false;
            
            // Email validation
            if (!formData.email) {
                $('#emailError').text('Email is required.');
                hasErrors = true;
            } else if (!validateEmail(formData.email)) {
                $('#emailError').text('Invalid email format.');
                hasErrors = true;
            }

            // Password validation
            if (!formData.password) {
                $('#passwordError').text('Password is required.');
                hasErrors = true;
            }

            if (hasErrors) return;

            // Submit form via AJAX
            $.ajax({
                url: "{{ route('admin.login') }}",
                method: 'POST',
                data: formData,
                success: function(response, textStatus, xhr) {
                     if(xhr.status == 200 && textStatus=='success') {
                        // Handle success response
                        window.location.href = response.redirect_url;
                    }
                    else {
                        // Handle failed response
                        var errors = response.message;
                        displayErrors(errors);    
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    var errors = xhr.responseJSON;
                    displayErrors(errors);
                }
            });
        });

        $('#forgotPasswordForm').on('submit', function(e) {
            e.preventDefault();
            // Clear previous errors
            clearErrors();
            // Gather form data
            var formData = {
                email: $('#email').val().trim(),
                _token: '{{ csrf_token() }}'
            };
            // Validate form data
            var hasErrors = false;
            
            // Email validation
            if (!formData.email) {
                $('#emailError').text('Email is required.');
                hasErrors = true;
            } else if (!validateEmail(formData.email)) {
                $('#emailError').text('Invalid email format.');
                hasErrors = true;
            }

            if (hasErrors) return;

            // Submit form via AJAX
            $.ajax({
                url: "{{ route('admin.forgot-password.sendemail') }}",
                method: 'POST',
                data: formData,
                success: function(response, textStatus, xhr) {
                     if(xhr.status == 200 && textStatus=='success') {
                        // Handle success response
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: true,
                        }).then(() => {
                            // Ensure redirection in case the user clicks 'OK'
                            window.location.href = response.redirect_url;
                        });
                    }
                    else {
                        // Handle failed response
                        var errors = response.message;
                        displayErrors(errors);    
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    var errors = xhr.responseJSON;
                    displayErrors(errors);
                }
            });
        });

        $('#resetPasswordForm').on('submit', function(e) {
            e.preventDefault();
            // Clear previous errors
            clearErrors();
            // Gather form data
            var formData = {
                email: $('#email').val().trim(),
                password: $('#password').val().trim(),
                password_confirmation: $('#password_confirmation').val().trim(),
                token: $('#token').val().trim(),
                _token: '{{ csrf_token() }}'
            };
            // Validate form data
            var hasErrors = false;
            if (!formData.password) {
                $('#passwordError').text('password is required.');
                hasErrors = true;
            }
            if (!formData.password_confirmation) {
                $('#password_confirmationError').text('confirm password is required.');
                hasErrors = true;
            }else{
                if (formData.password!== formData.password_confirmation) {
                    $('#password_confirmationError').text('passwords do not match.');
                    hasErrors = true;
                }
            }

            if (hasErrors) return;

            // Submit form via AJAX
            $.ajax({
                url: "{{ route('admin.reset-password.change') }}",
                method: 'POST',
                data: formData,
                success: function(response, textStatus, xhr) {
                     if(xhr.status == 200 && textStatus=='success') {
                        // Handle success response
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: true,
                        }).then(() => {
                            // Ensure redirection in case the user clicks 'OK'
                            window.location.href = response.redirect_url;
                        });
                    }
                    else {
                        // Handle failed response
                        var errors = response.message;
                        displayErrors(errors);    
                    }
                },
                error: function(xhr) {
                    // Handle error response
                    var errors = xhr.responseJSON;
                    displayErrors(errors);
                }
            });
        });
        // Function to clear previous errors
        function clearErrors() {
            $('#emailError').text('');
            $('#passwordError').text('');
            $('#generalError').text('');
        }
        // Function to display form errors
        function displayErrors(errors) {
            Swal.fire({
                title: 'Error!',
                text: 'Please correct the errors and try again.',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
            });
            // Clear previous errors
            clearErrors();
            // Check if errors have email and password
            if (errors.message.hasOwnProperty('email')) {
                $('#emailError').text(errors.message.email);
            }

            if (errors.message.hasOwnProperty('password')) {
                $('#passwordError').text(errors.message.password);
            }
            if (errors.message.hasOwnProperty('remember')) {
                $('#rememberError').text(errors.message.remember);
            }
            // If neither email nor password errors exist, show the general message
            if (!errors.message.hasOwnProperty('email') && !errors.message.hasOwnProperty('password') && !errors.message.hasOwnProperty('remember') && errors.hasOwnProperty('message')) {
                $('#generalError').text(errors.message);
            }
        }

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
