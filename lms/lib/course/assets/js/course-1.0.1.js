var UserLevel = document.getElementById('UserLevel').value
var LoggedUser = document.getElementById('LoggedUser').value
var company_id = document.getElementById('company_id').value
var defaultCourseCode = document.getElementById('defaultCourseCode').value


$(document).ready(function() {
    OpenIndex()
})

// Prevent Refresh or Back Unexpectedly
// window.onbeforeunload = function () {
//   return 'Are you sure you want to leave?'
// }

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
            url: 'lib/course/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}


function OpenCourseView(CourseCode = defaultCourseCode) {
    $('#index-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/course/course-view.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                base_url: base_url,
                access_token: access_token,
                defaultCourseCode: defaultCourseCode,
                base_url: base_url
            },
            success: function(data) {
                $('#index-content').html(data)
            }
        })
    }
    fetch_data()
}

function OpenCoursePlayer(CourseCode = defaultCourseCode, TopicID) {
    $('#index-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/course/course-player.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                TopicID: TopicID
            },
            success: function(data) {
                $('#index-content').html(data)
            }
        })
    }
    fetch_data()
}