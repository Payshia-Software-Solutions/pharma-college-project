var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var company_id = document.getElementById("company_id").value;
var default_location = document.getElementById("default_location").value;
var default_location_name = document.getElementById(
    "default_location_name"
).value;

$(document).ready(function () {
    OpenIndex();
});


function OpenIndex() {
    function fetch_data() {
        document.getElementById("index-content").innerHTML = InnerLoader;
        $.ajax({
            url: "./assets/content/lms-management/lms-payments/index.php",
            method: "POST",
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
            },
            success: function (data) {
                $("#index-content").html(data);
                GetMailBox();
            },
        });
    }
    fetch_data();
}
function GetCoursePayments(courseCode) {
    function fetch_data() {
        document.getElementById("index-content").innerHTML = InnerLoader;
        $.ajax({
            url: "./assets/content/lms-management/lms-payments/views/course-payments.php",
            method: "POST",
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                courseCode: courseCode,
            },
            success: function (data) {
                $("#index-content").html(data);
                GetMailBox();
            },
        });
    }
    fetch_data();
}

function OpenPaymentView(paymentId, courseCode) {
    OpenPopupRight()
    $('#loading-popup-right').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: './assets/content/lms-management/lms-payments/views/single-payment.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                paymentId: paymentId,
                courseCode: courseCode
            },
            success: function (data) {
                $('#loading-popup-right').html(data)
            }
        })
    }
    fetch_data()
}


function SavePayment(paymentId, courseCode) {

    const form = document.getElementById("approvePaymentForm");

    if (form.checkValidity()) {

        // OpenPopup()
        // document.getElementById('loading-popup').innerHTML = InnerLoader
        var formData = new FormData(form);

        // formData.append("CourseCode", CourseCode);
        formData.append("payment_request_id", paymentId);
        formData.append("LoggedUser", LoggedUser);
        formData.append("courseCode", courseCode);
        $.ajax({
            url: "./assets/content/lms-management/lms-payments/controllers/submit-payment.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                // $('#loading-popup').html(data)
                var response = JSON.parse(data);
                console.log(response)
                if (response.status === "success") {
                    var result = response.message;
                    OpenAlert('success', 'Done!', result)
                    ClosePopUP();
                    OpenIndex();
                } else {
                    var result = response.message;
                    showNotification(result, "error", "Done!");
                }
            }
        });
    } else {
        form.reportValidity()
        result = 'Please Filled out All * marked Fields.'
        OpenAlert('error', 'Error!', result)
        hideOverlay()
    }
}

