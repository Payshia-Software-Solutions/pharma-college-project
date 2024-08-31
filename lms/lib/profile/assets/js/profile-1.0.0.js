var UserLevel = document.getElementById('UserLevel').value
var LoggedUser = document.getElementById('LoggedUser').value
var UserLevel = document.getElementById('UserLevel').value
var company_id = document.getElementById('company_id').value
var CourseCode = document.getElementById('defaultCourseCode').value
var addedInstructions = [];

$(document).ready(function() {
    OpenIndex()
})

function OpenPopup() {
    document.getElementById('loading-popup').style.display = 'flex'
}

function ClosePopUP() {
    document.getElementById('loading-popup').style.display = 'none'
}

// JavaScript to show the overlay
function showOverlay() {
    var overlay = document.querySelector('.overlay')
    overlay.style.display = 'block'
}

// JavaScript to hide the overlay
function hideOverlay() {
    var overlay = document.querySelector('.overlay')
    overlay.style.display = 'none'
}



const InnerLoader = document.getElementById('inner-preloader-content').innerHTML

function OpenIndex() {
    $('#root').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/profile/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
                hideOverlay()
            }
        })
    }
    fetch_data()
}

function EditProfilePopup() {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/profile/edit-profile.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function saveProfileEditRequest() {
    var form = document.getElementById("user-details-form");
    // Get form data
    if (form.checkValidity()) {
        var formData = new FormData(form);

        // Append drugs to form data
        formData.append('UserLevel', UserLevel)
        formData.append('loggedUser', LoggedUser)
        formData.append('courseCode', CourseCode)
        formData.append('userLevel', UserLevel)

        function fetch_data() {
            $.ajax({
                url: 'lib/profile/save-profile-edit.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        OpenIndex()
                        ClosePopUP()
                    } else {
                        var result = response.message
                        showNotification(result, 'error', 'Ops!')
                    }
                    hideOverlay()
                }
            })
        }
        fetch_data()
    } else {
        form.reportValidity()
        result = 'Please Filled out All * marked Fields.'
        showNotification(result, 'error', 'Ops!')
        hideOverlay()
    }
}