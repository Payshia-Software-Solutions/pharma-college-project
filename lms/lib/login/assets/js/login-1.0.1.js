$(document).ready(function() {
    OpenIndex()
})

// Prevent Refresh or Back Unexpectedly
// window.onbeforeunload = function () {
//   return 'Are you sure you want to leave?'
// }

const InnerLoader = document.getElementById('inner-preloader-content').innerHTML

function OpenIndex() {
    const getUsername = $('#getUsername').val();
    const getPassword = $('#getPassword').val();
    $('#root').html(InnerLoader); // Show loading spinner or message

    $.ajax({
        url: 'lib/login/index.php',
        method: 'POST',
        data: {
            getUsername: getUsername,
            getPassword: getPassword
        },
        success: function(response) {
            $('#root').html(response);
        },
        error: function(xhr, status, error) {
            $('#root').html('<p style="color:red;">Login failed. Please try again.</p>');
            console.error('Login error:', error);
        }
    });
}
