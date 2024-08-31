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
            url: 'lib/win-pharma/index.php',
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



function GetLevelContent(CourseCode, CurrentTopLevel, Count) {
    $('#level-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/win-pharma/level-content.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                CurrentTopLevel: CurrentTopLevel,
                Count: Count
            },
            success: function(data) {
                $('#level-content').html(data)
            }
        })
    }
    fetch_data()
}


function GetTaskInfo(TaskID, LevelCode, CourseCode) {
    $('#level-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/win-pharma/task-info.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                TaskID: TaskID,
                LevelCode: LevelCode,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                $('#level-content').html(data)
            }
        })
    }
    fetch_data()
}



function StartGrading(CourseCode) {
    $('#index-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'content/grade/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                $('#index-content').html(data)
                GetButtonSet(CourseCode)
                GetSubmissionList(CourseCode, 'Pending')
            }
        })
    }
    fetch_data()
}

function GetSubmissionList(CourseCode, LoadStatus) {
    $('#submission-list').html('Loading List..')

    function fetch_data() {
        $.ajax({
            url: 'content/grade/submission-list.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                LoadStatus: LoadStatus,
                CourseCode: CourseCode
            },
            success: function(data) {
                $('#submission-list').html(data)
            }
        })
    }
    fetch_data()
}

function GetButtonSet(CourseCode) {
    function fetch_data() {
        $.ajax({
            url: 'content/grade/button-set.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                $('#button-set').html(data)
            }
        })
    }
    fetch_data()
}

function SubmissionInfo(CourseCode, SubmissionID) {
    $('#inner-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'content/grade/submission-info.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                SubmissionID: SubmissionID,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                $('#inner-content').html(data)

                const targetDiv = document.getElementById('level-content')
                targetDiv.scrollIntoView({ behavior: 'smooth' })
            }
        })
    }
    fetch_data()
}

function ReCorrection(SubmissionID, LoggedUser, CourseCode, LevelCode, ResourceID) {
    var Message = 'Please Wait until submission processing..!'
    showNotification(Message, 'success', 'Please Wait!')

    function fetch_data() {
        $.ajax({
            url: 'lib/win-pharma/re-correction.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                SubmissionID: SubmissionID,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                GetTaskInfo(ResourceID, LevelCode, CourseCode)
            }
        })
    }
    fetch_data()
}

function AddSubmission(LevelCode, ResourceID, CourseCode) {
    var SubmitButton = document.getElementById('addSubmission')
    var Message = 'Please Wait your submission Uploading..!. It will take few seconds depend on your internet speed'
    document.getElementById('SubmitionInfo').innerHTML = '<div class="alert my-2 mb-3 alert-info" role="alert">' + Message + '</div>'
    var form = document.getElementById('submission-form')
    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('LevelCode', LevelCode)
        formData.append('ResourceID', ResourceID)
        formData.append('defaultCourseCode', defaultCourseCode)

        function fetch_data() {
            $.ajax({
                url: 'lib/win-pharma/add-submission.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        GetTaskInfo(ResourceID, LevelCode, CourseCode)
                        showNotification(result, 'success', "Done!")
                    } else {
                        var result = response.message

                        showNotification(result, 'error', "Oops!")
                    }
                    hideOverlay()

                }
            })
        }
        fetch_data()
    } else {
        log = 'Submission Needed. Select a Image file'
        showNotification(log, 'error', "Oops!")
        SubmitButton.style.display = 'inline-block'
        document.getElementById('SubmitionInfo').innerHTML = log
            // console.log(log)
    }
}

function SaveGrade(SubmissionID, IndexNumber, CourseCode) {
    var form = document.getElementById('grade-form')
    if (form.checkValidity()) {
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('IndexNumber', IndexNumber)
        formData.append('SubmissionID', SubmissionID)

        function fetch_data() {
            $.ajax({
                url: 'content/grade/save-grade.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        SubmissionInfo(CourseCode, SubmissionID)
                        GetButtonSet(CourseCode)
                        GetSubmissionList(CourseCode, 'Pending')
                    } else {
                        var result = response.message
                    }

                    AddScriptResult(result) // Display the Output Result
                }
            })
        }
        fetch_data()
    } else {
        log = 'Please Filled out All * marked Fields.'
        AddScriptResult(log)
            // console.log(log)
    }
}

function setPopup(Content) {
    var popUpHeader = '<img src="../common/images/info.png" width="20%">'
    var Content = '<h4 class="card-title">' + Content + '</h4>'
    $('#popup-content').html(popUpHeader + Content)
    showSwal('help-popup')
}

// Report
function OpenReports(CourseCode) {

    $('#index-content').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'content/report/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode
            },
            success: function(data) {
                $('#index-content').html(data)
            }
        })
    }
    fetch_data()
}