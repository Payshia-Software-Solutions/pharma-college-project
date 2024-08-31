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

function createBubble(parentElement, xPos, yPos, widthVal) {
    const bubble = document.createElement("div");
    bubble.className = "bubble";
    bubble.style.width = widthVal;
    bubble.style.height = bubble.style.width;


    bubble.style.left = xPos;
    bubble.style.top = yPos;

    parentElement.appendChild(bubble);
}

const InnerLoader = document.getElementById('inner-preloader-content').innerHTML

function OpenIndex() {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/pharma-hunter/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
                $('#AttemptCount').val(1)
            }
        })
    }
    fetch_data()
}

function fillDataValue(sourceType) {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/pharma-hunter/requests/fill-input.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                sourceType: sourceType
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function SetDataValue(sourceType, dataValue, dataId) {
    $('#' + sourceType).val(dataValue)
    $('#' + sourceType + 'Id').val(dataId)
    ClosePopUP()
}

function ValidateAnswer(medicineId) {
    var form = document.getElementById("store-form");
    var AttemptValue = parseInt(document.getElementById('AttemptCount').value)
        // Get form data
    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form);

        // Append drugs to form data
        formData.append('loggedUser', LoggedUser)
        formData.append('courseCode', CourseCode)
        formData.append('userLevel', UserLevel)
        formData.append('medicineId', medicineId)
        formData.append('AttemptValue', AttemptValue)

        function fetch_data() {
            $.ajax({
                url: 'lib/pharma-hunter/requests/validate-answer.php',
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