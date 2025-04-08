var UserLevel = document.getElementById('UserLevel').value
var LoggedUser = document.getElementById('LoggedUser').value
var UserLevel = document.getElementById('UserLevel').value
var company_id = document.getElementById('company_id').value
var defaultCourseCode = document.getElementById('defaultCourseCode').value
var addedInstructions = [];

$(document).ready(function () {
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
            success: function (data) {
                $('#root').html(data)
                SetDefaultCourse(0)
                GetGradeComponent()
            }
        })
    }
    fetch_data()
}

function GetGradeComponent() {
    $('#grade_values').html('Grades Loading..')

    function fetch_data() {
        $.ajax({
            url: 'lib/home/components/grade-values.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id
            },
            success: function (data) {
                $('#grade_values').html(data)
            }
        })
    }
    fetch_data()
}

function UpdateOrderReceivedStatus(OrderId, OrderStatus) {
    // Prepare the data to send as JSON
    var requestData = {
        id: OrderId,
        OrderStatus: OrderStatus
    };

    // Define a function to make the API request
    function fetch_data() {
        showOverlay(); // Show loading overlay

        $.ajax({
            url: 'https://qa-api.pharmacollege.lk/delivery_orders/update-status/' + OrderId + '/', // API endpoint
            method: 'PUT',
            data: JSON.stringify(requestData), // Send data as JSON
            contentType: 'application/json',  // Set content type to JSON
            success: function (response) {
                // var response = JSON.parse(data);
                if (response.status === 'success') {
                    var result = response.message;
                    showNotification(result, 'success', 'Done!')
                    OpenIndex()
                } else {
                    var result = response.message;
                    showNotification(result, 'error', 'Error!')
                }
                hideOverlay();
            },
            error: function (xhr, status, error) {
                hideOverlay();
                OpenAlert('error', 'Error!', 'Failed to update order status. Please try again.');
            }
        });
    }

    // Show confirmation before making the API request
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch_data(); // Call the fetch_data function if confirmed
        }
    });
}
