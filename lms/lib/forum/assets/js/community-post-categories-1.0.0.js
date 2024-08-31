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
        $.ajax({
            url: 'lib/forum/categories.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}


function OpenNewCategoryForm(categoryId = 0) {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/forum/views/add-category.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                categoryId: categoryId
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}


function SaveCategory(categoryId) {
    var form = document.getElementById("category_form");
    // Get form data
    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form);

        // Append drugs to form data
        formData.append('loggedUser', LoggedUser)
        formData.append('courseCode', CourseCode)
        formData.append('userLevel', UserLevel)
        formData.append('categoryId', categoryId)

        function fetch_data() {
            $.ajax({
                url: 'lib/forum/controllers/save-category.php',
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
                        AttemptValue += 1
                        document.getElementById('AttemptCount').value = AttemptValue
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