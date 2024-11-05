var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var UserLevel = document.getElementById("UserLevel").value;
var company_id = document.getElementById("company_id").value;
var CourseCode = document.getElementById("defaultCourseCode").value;
var addedInstructions = [];

$(document).ready(function () {
    OpenIndex();
});

function OpenPopup() {
    document.getElementById("loading-popup").style.display = "flex";
}

function ClosePopUP() {
    document.getElementById("loading-popup").style.display = "none";
}

// JavaScript to show the overlay
function showOverlay() {
    var overlay = document.querySelector(".overlay");
    overlay.style.display = "block";
}

// JavaScript to hide the overlay
function hideOverlay() {
    var overlay = document.querySelector(".overlay");
    overlay.style.display = "none";
}



const InnerLoader = document.getElementById(
    "inner-preloader-content"
).innerHTML;

function OpenIndex() {
    $("#root").html(InnerLoader);

    function fetch_data() {
        $.ajax({
            url: "lib/certificate-center/index.php",
            method: "POST",
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id,
            },
            success: function (data) {
                $("#root").html(data);
            },
        });
    }
    fetch_data();
}

function statusView() {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/certificate-center/views/status-view.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
            },
            success: function (data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}
function pickupOptionOpen() {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/certificate-center/views/pickup-option.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
            },
            success: function (data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function PickupOption(option) {
    $("#root").html(InnerLoader);

    let goTo = '';

    if (option == 1) {
        goTo = 'graduate.php';
    } else {
        goTo = 'delivery-form.php';
    }


    function fetch_data() {
        $.ajax({
            url: 'lib/certificate-center/views/' + goTo,
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
            },
            success: function (data) {
                ClosePopUP()
                $("#root").html(data);
            }
        })
    }

    fetch_data()
}





