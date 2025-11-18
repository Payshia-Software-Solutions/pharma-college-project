function GetCourse(UserID) {
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function() {
        document.getElementById('search-result').innerHTML = this.responseText
        adjustBoxHeight()
    }
    xhttp.open('GET', 'requests/enrolled.php?q=' + UserID)
    xhttp.send()
}

function GetResult(CourseCode, UserID) {
    const xhttp = new XMLHttpRequest()
    xhttp.onload = function() {
        document.getElementById('search-result').innerHTML = this.responseText
        adjustBoxHeight()
    }
    xhttp.open('GET', 'requests/result.php?CourseCode=' + CourseCode + '&UserID=' + UserID)
    xhttp.send()
}

function adjustBoxHeight() {
    var itemHeight = $('.results-out').outerHeight()
    $('#search-result').css('height', itemHeight)
}



function OpenAlert(status, Title, Text) {
    Swal.fire({
        icon: status,
        title: Title,
        text: Text,
        html: Text
    })
}

function JoinNow() {
    var form = document.getElementById('new-user-form')

    if (form.checkValidity()) {

        document.getElementById('register-form').style.display = "none"
        document.getElementById('register-form-message').innerHTML = "Please Wait..."

        OpenAlert("info", "Wait!", "Sending Request..")

        var formData = new FormData(form)

        function fetch_data() {
            $.ajax({
                url: 'requests/register-user.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        var username = response.username
                        $('#register-form-message').html('<div class="alert alert-danger">' + result + '</div>')
                        form.reset();
                        document.getElementById('register-form').style.display = "block"
                        OpenAlert("success", "Done!", "User Registered Successfully")
                    } else {
                        $('#register-form-message').html(result)
                    }

                }
            })
        }

        fetch_data()
    } else {
        form.reportValidity();
        result = 'Please Filled out All  Fields.'
        OpenAlert('error', 'Oops!', result)
    }
}