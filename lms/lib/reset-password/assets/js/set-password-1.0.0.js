function ResetPassword() {
    var form = document.getElementById('reset-form');

    if (form.checkValidity()) {
        var formData = new FormData(form);

        function fetch_data() {
            $.ajax({
                url: 'lib/reset-password/requests/reset-password.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    try {
                        var response = JSON.parse(data);

                        if (response.hasOwnProperty('status')) {
                            if (response.status === 'success') {
                                // If there is a success status, show success notification and perform actions
                                showNotification(response.message, 'success', 'Done!');
                                redirectToURL('login')
                            } else if (response.status === 'error') {
                                // If there is an error status, show error notification
                                // showNotification(response.message, 'error', 'Oops!');

                                // Display validation errors if available
                                if (response.hasOwnProperty('new_password_err')) {
                                    showValidationMessage('password', response.new_password_err);
                                }
                                if (response.hasOwnProperty('confirm_password_err')) {
                                    showValidationMessage('cPassword', response.confirm_password_err);
                                }
                            } else {
                                // Handle unexpected status
                                showNotification('Unexpected response from the server', 'error', 'Oops!');
                            }
                        } else {
                            // Handle unexpected response format
                            showNotification('Unexpected response format from the server', 'error', 'Oops!');
                        }
                    } catch (error) {
                        // Handle JSON parsing error
                        showNotification('Error parsing JSON response', 'error', 'Oops!');
                    }
                },
                error: function() {
                    // Handle AJAX error
                    showNotification('Error in AJAX request', 'error', 'Oops!');
                }
            });
        }

        fetch_data();
    } else {
        var result = 'Please fill out all * marked fields.';
        showNotification(result, 'error', 'Oops!');
    }
}

// Function to display validation messages
function showValidationMessage(elementId, message) {
    var element = document.getElementById(elementId + '-error');
    if (element) {
        element.innerHTML = message;
        element.style.display = 'block';
    }
}