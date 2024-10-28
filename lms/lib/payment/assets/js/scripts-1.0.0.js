var UserLevel = document.getElementById('UserLevel').value
var LoggedUser = document.getElementById('LoggedUser').value
var UserLevel = document.getElementById('UserLevel').value
var company_id = document.getElementById('company_id').value
var CourseCode = document.getElementById('defaultCourseCode').value
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
            url: 'lib/payment/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id
            },
            success: function (data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}

function openSlipUpload() {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/payment/views/slip-upload.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                CourseCode: CourseCode,
            },
            success: function (data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}