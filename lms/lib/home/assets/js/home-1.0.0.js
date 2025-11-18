var UserLevel = document.getElementById('UserLevel').value
var LoggedUser = document.getElementById('LoggedUser').value
var UserLevel = document.getElementById('UserLevel').value
var company_id = document.getElementById('company_id').value
var defaultCourseCode = document.getElementById('defaultCourseCode').value
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
        $.ajax({
            url: 'lib/home/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
                SetDefaultCourse(0)
            }
        })
    }
    fetch_data()
}


function SetDefaultCourse(forceChange) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/home/set-default-course.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
                OpenPopup()
            }
        })
    }
    if (defaultCourseCode == "" || forceChange == 1) {
        fetch_data()
    }
}



function SaveDefaultCourse(setCourse) {
    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/home/save-default-course.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                setCourse: setCourse
            },
            success: function(data) {
                var response = JSON.parse(data)
                var result = response.message
                if (response.status === 'success') {
                    showNotification(result, 'success', 'Done!')
                    OpenIndex()
                    ClosePopUP()
                    location.reload()
                } else {

                    showNotification(result, 'error', 'Oops!')
                }
                hideOverlay()
            }
        })
    }

    fetch_data()
}