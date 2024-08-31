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
            url: 'lib/delivery/index.php',
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

function CreateNewDelivery(CourseCode, selectedId) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/delivery/create-new.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                CourseCode: CourseCode,
                selectedId: selectedId
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
                OpenPopup()
            }
        })
    }

    fetch_data()
}

function SaveDelivery(isActive, selectedId) {
    var form = document.getElementById('submit-form')

    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('defaultCourseCode', defaultCourseCode)
        formData.append('company_id', company_id)
        formData.append('isActive', isActive)
        formData.append('selectedId', selectedId)

        function fetch_data() {
            $.ajax({
                url: 'lib/delivery/save-delivery.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    var result = response.message
                    if (response.status === 'success') {
                        showNotification(result, 'success', 'Done!')
                        OpenIndex()
                        ClosePopUP()
                    } else {

                        showNotification(result, 'error', 'Oops!')
                    }
                    hideOverlay()
                }
            })
        }
        fetch_data()
    } else {
        result = 'Please Filled out All * marked Fields.'
        showNotification(result, 'error', 'Oops!')
    }
}

function OrderConfirmation(selectedId) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/delivery/confirmation.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                selectedId: selectedId
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
                OpenPopup()
            }
        })
    }

    fetch_data()
}

function PlaceOrder() {
    var form = document.getElementById('submit-form')

    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('defaultCourseCode', defaultCourseCode)
        formData.append('company_id', company_id)

        function fetch_data() {
            $.ajax({
                url: 'lib/delivery/place-order.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    var result = response.message
                    if (response.status === 'success') {
                        showNotification(result, 'success', 'Done!')
                        OpenIndex()
                        ClosePopUP()
                    } else {

                        showNotification(result, 'error', 'Oops!')
                    }
                    hideOverlay()
                }
            })
        }
        fetch_data()
    } else {
        result = 'Please Filled out All * marked Fields.'
        showNotification(result, 'error', 'Oops!')
    }
}