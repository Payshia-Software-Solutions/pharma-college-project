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

window.onbeforeunload = function() {
    // Your custom code here
    // This message will be displayed in a confirmation dialog
    return "Are you sure you want to leave?";
};

const InnerLoader = document.getElementById('inner-preloader-content').innerHTML

function OpenIndex() {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/ticket/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
                GetMailBox(1)
            }
        })
    }
    fetch_data()
}

function GetMailBox(boxType) {
    $('#mailList').html(InnerLoader)
    $('#mainBody').html('')

    function fetch_data() {
        $.ajax({
            url: 'lib/ticket/components/mail-list.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                boxType: boxType
            },
            success: function(data) {
                $('#mailList').html(data)
            }
        })
    }
    fetch_data()
}


function GetMailBody(mailId) {
    $('#mainBody').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/ticket/components/mail-body.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                mailId: mailId
            },
            success: function(data) {
                $('#mainBody').html(data)
            }
        })
    }
    fetch_data()
}


function RateValue(parentId, ticketId, RateValue) {

    function fetch_data() {
        $.ajax({
            url: 'lib/ticket/request_helper/rate-reply.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                ticketId: ticketId,
                RateValue: RateValue
            },
            success: function(data) {
                var response = JSON.parse(data)
                if (response.status === 'success') {
                    var result = response.message
                    showNotification(result, 'success', 'Done!')
                    GetMailBody(parentId)
                    ClosePopUP()
                } else {
                    var result = response.message
                    showNotification(result, 'error', 'Ops!')
                }
                hideOverlay()
            }
        })
    }
    fetch_data()
}


function createBubbleAuto(parentElement) {
    const bubble = document.createElement("div");
    bubble.className = "bubble";
    bubble.style.width = Math.random() * 60 + "px";
    bubble.style.height = bubble.style.width;


    const xPos = Math.random() * 100 + "%";
    const yPos = Math.random() * 100 + "%";
    bubble.style.left = xPos;
    bubble.style.top = yPos;

    parentElement.appendChild(bubble);
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


function CreateSupportTicket() {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/ticket/components/new-ticket.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id
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

function SaveTicket(ticketId = 0, isActive = 1) {

    var ticketText = tinymce.get("ticketText").getContent();
    var form = document.getElementById('ticket-form')

    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)
        formData.append('defaultCourseCode', defaultCourseCode)
        formData.append('ticketId', ticketId)
        formData.append('isActive', isActive)
        formData.append('ticketText', ticketText)

        function fetch_data() {
            $.ajax({
                url: 'lib/ticket/request_helper/save-ticket.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        GetMailBox(1)
                        ClosePopUP()
                    } else {
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

function CreateSupportTicketReplyBox(ticketId) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/ticket/components/ticket-reply.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                ticketId: ticketId
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

function SendReply(ticketId = 0, replyId = 0, isActive = 1) {

    var ticketText = tinymce.get("ticketReply").getContent();
    var form = document.getElementById('ticket-reply-form')

    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)
        formData.append('defaultCourseCode', defaultCourseCode)
        formData.append('ticketId', ticketId)
        formData.append('isActive', isActive)
        formData.append('ticketText', ticketText)
        formData.append('replyId', replyId)

        function fetch_data() {
            $.ajax({
                url: 'lib/ticket/request_helper/save-reply.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        GetMailBox(1)
                        ClosePopUP()
                    } else {
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

function ChangeTicketStatus(ticketId, ticketStatus) {
    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/ticket/request_helper/change-ticket-status.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                ticketId: ticketId,
                ticketStatus: ticketStatus
            },
            success: function(data) {
                var response = JSON.parse(data)
                if (response.status === 'success') {
                    var result = response.message
                    showNotification(result, 'success', 'Done!')
                    GetMailBox(1)
                    ClosePopUP()
                } else {
                    var result = response.message
                    showNotification(result, 'error', 'Ops!')
                }
                hideOverlay()
            }
        })
    }


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
            fetch_data()
        }
    });
}