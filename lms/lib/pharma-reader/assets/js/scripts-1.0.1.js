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
            url: 'lib/pharma-reader/index.php',
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

function NewPrescription() {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/pharma-reader/prescription-list.php',
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

function EditPrescription(prescriptionId = 0) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/pharma-reader/prescription-content.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                prescriptionId: prescriptionId
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

function AddOption() {
    document.getElementById("correct_answer").innerHTML = '<option value="">Select the Correct Answer</option>';

    var select = document.getElementById("correct_answer");

    var Answer1 = document.getElementById("answer1").value;
    var option1 = document.createElement("option");
    option1.text = "1) " + Answer1;
    option1.value = Answer1;
    select.appendChild(option1);

    var Answer2 = document.getElementById("answer2").value;
    var option2 = document.createElement("option");
    option2.text = "2) " + Answer2;
    option2.value = Answer2;
    select.appendChild(option2);

    var Answer3 = document.getElementById("answer3").value;
    var option3 = document.createElement("option");
    option3.text = "3) " + Answer3;
    option3.value = Answer3;
    select.appendChild(option3);

    var Answer4 = document.getElementById("answer4").value;
    var option4 = document.createElement("option");
    option4.text = "4) " + Answer4;
    option4.value = Answer3;
    select.appendChild(option4);
}

function SavePrescription(prescriptionId = 0, active_status = 'Active') {

    var helpText = tinymce.get("helpText").getContent();
    var questionContent = tinymce.get("question").getContent();
    var form = document.getElementById('submit-form')

    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)
        formData.append('defaultCourseCode', defaultCourseCode)
        formData.append('prescriptionId', prescriptionId)
        formData.append('helpText', helpText)
        formData.append('questionContent', questionContent)
        formData.append('activeStatus', active_status)

        function fetch_data() {
            $.ajax({
                url: 'lib/pharma-reader/save-prescription.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        NewPrescription()
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

function SaveReaderAnswer(prescriptionId) {
    var selectedRadioButton = document.querySelector('input[name="answerId"]:checked');

    if (selectedRadioButton) {
        var selectedAnswer = selectedRadioButton.value;
        fetch_data()
    } else {
        resultMessage = "Please select an Answer to Validate"
        showNotification(resultMessage, 'error', 'Ops!')
    }

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/pharma-reader/validate-answer.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                prescriptionId: prescriptionId,
                selectedAnswer: selectedAnswer
            },
            success: function(data) {
                var response = JSON.parse(data)
                var result = response.message
                var answerStatus = response.answerStatus
                var answerGrade = response.answerGrade
                var displayMessage = 'Your Answer is ' + answerStatus

                if (response.status === 'success') {
                    showNotification(displayMessage, 'success', 'Done!')
                    OpenIndex()
                } else {
                    showNotification(displayMessage, 'error', 'Oops!')
                }
                hideOverlay()
            }
        })
    }
}

function GetHelp(prescriptionId) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/pharma-reader/get-help.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                prescriptionId: prescriptionId
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