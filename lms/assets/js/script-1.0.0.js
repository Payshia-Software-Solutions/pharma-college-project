function redirectToURL(url) {
    window.location.href = url
}

function showNotification(result, type, title) {
    Swal.fire({
        icon: type,
        title: title,
        text: result,
    });
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