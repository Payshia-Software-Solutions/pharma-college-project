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
            url: 'lib/d-pad/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                CourseCode: CourseCode,
                company_id: company_id
            },
            success: function(data) {
                $('#root').html(data)
                loadCounter()
            }
        })
    }
    fetch_data()
}

function OpenPrescription(prescriptionID, imageID) {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/d-pad/patient-prescription.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID,
                imageID: imageID
            },
            success: function(data) {
                $('#root').html(data)
                LoadPrescription(prescriptionID)
            }
        })
    }
    fetch_data()
}

function AddAnswers(answerID) {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/d-pad/admin-add-answer.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                answerID: answerID
            },
            success: function(data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}

function LoadPrescription(prescriptionID) {
    $('#prescription').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/d-pad/requests/prescription.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID
            },
            success: function(data) {
                $('#prescription').html(data)
            }
        })
    }
    fetch_data()
}

function GetPatient(prescriptionID) {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/d-pad/get-patient.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID
            },
            success: function(data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}

function OpenEnvelope(prescriptionID, coverID) {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/d-pad/fill-envelope.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID,
                coverID: coverID
            },
            success: function(data) {
                $('#root').html(data)
                LoadPrescription(prescriptionID)
            }
        })
    }
    fetch_data()
}

function SelectEnvelopeContent(contentType) {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/envelope/envelope-content.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                contentType: contentType
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function ViewPrescription(prescriptionID) {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/requests/prescription.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function SetElementValue(targetID, Value) {
    document.getElementById(targetID).value = Value
    hideOverlay()
    ClosePopUP()
}

function SaveEnvelopAnswerAdmin(prescriptionID) {
    var form = document.getElementById('envelope-form')

    if (form.checkValidity()) {
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)


        function fetch_data() {
            showOverlay()
            $.ajax({
                url: 'lib/d-pad/requests/save-envelop-admin.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        GetPatient(prescriptionID)
                        showNotification(result, 'success', 'Done!')
                    } else {
                        var result = response.message
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

function SaveEnvelopAnswer(prescriptionID) {
    var form = document.getElementById('envelope-form')

    if (form.checkValidity()) {
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)


        function fetch_data() {
            showOverlay()
            $.ajax({
                url: 'lib/d-pad/requests/save-envelope-answer.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        var incorrect_values = response.incorrect_values
                        var answer_status = response.answer_status
                    } else {
                        var result = response.message
                        var incorrect_values = response.incorrect_values
                        var answer_status = response.answer_status
                    }
                    if (answer_status == 'Correct') {
                        GetPatient(prescriptionID)
                        showNotification(answer_status, 'success', 'Done!')
                    } else {
                        FinishEnvelop(incorrect_values)
                        showNotification(answer_status, 'error', 'Oops!')
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

function FinishEnvelop(incorrect_values) {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/envelope/envelop-finish.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                incorrect_values: incorrect_values
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function SaveInstructions(prescriptionID, coverID) {
    // Initialize the addedInstructions array
    var addedInstructions = [];

    // Iterate through each row in the table
    $('#instructionTable tbody tr').each(function() {
        // Find the first td (ID) in the current row
        var instructionId = $(this).find('td:first').text();

        // Add the ID to the addedInstructions array
        addedInstructions.push(instructionId);
    });

    $.ajax({
        url: 'lib/d-pad/requests/save-counselling.php',
        method: 'POST',
        data: {
            LoggedUser: LoggedUser,
            prescriptionID: prescriptionID,
            coverID: coverID,
            addedInstructions: addedInstructions
        },
        success: function(data) {
            var response = JSON.parse(data)
            if (response.status === 'success') {
                var result = response.message
                showNotification(result, 'success', 'Done!')
                GetPatient(prescriptionID)
            } else {
                var result = response.message
                showNotification(result, 'error', 'Oops!')
            }
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}

function SaveAnswerAdmin(answerID) {
    var form = document.getElementById('answer-form')

    if (form.checkValidity()) {
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)
        formData.append('answerID', answerID)


        function fetch_data() {
            showOverlay()
            $.ajax({
                url: 'lib/d-pad/requests/save-answer-admin.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        AddAnswers()
                    } else {
                        var result = response.message
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

function createBubble(parentElement, xPos, yPos, widthVal) {
    const bubble = document.createElement("div");
    bubble.className = "bubble";
    bubble.style.width = widthVal;
    bubble.style.height = bubble.style.width;


    bubble.style.left = xPos;
    bubble.style.top = yPos;

    parentElement.appendChild(bubble);
}

function NewPrescription(prescriptionID = 0) {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/prescription/new-prescription.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function GeneratePrescription(prescriptionID = 0) {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/prescription/prescription-generator.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                prescriptionID: prescriptionID
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function savePrescription(prescriptionID = 0, prescriptionStatus = "Active") {
    showOverlay()
    var drugDescription = tinymce.get("drugDescription").getContent();

    var form = document.getElementById("prescriptionForm");
    // Get form data
    if (form.checkValidity()) {
        var formData = new FormData(form);

        // Get drugList items
        var drugListItems = document.querySelectorAll(".drugList h5");
        var drugs = Array.from(drugListItems).map(item => item.textContent);

        // Append drugs to form data
        formData.append("drugsList", JSON.stringify(drugs));
        formData.append('prescriptionID', prescriptionID)
        formData.append('prescriptionStatus', prescriptionStatus)
        formData.append('drugDescription', drugDescription)

        function fetch_data() {
            $.ajax({
                url: 'lib/d-pad/prescription/save-prescription.php',
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

function OpenControlPanel() {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function OpenSubmissionSetting() {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/user-submission-setting.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function GetUserSubmissions(studentNumber) {
    $('#submission-list').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/settings/submission-list.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                studentNumber: studentNumber
            },
            success: function(data) {
                $('#submission-list').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function DeleteSubmission(entryId, studentNumber) {

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/settings/delete-submission-entry.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                studentNumber: studentNumber,
                entryId: entryId
            },
            success: function(data) {
                GetUserSubmissions(studentNumber)
                var response = JSON.parse(data)
                if (response.status === 'success') {
                    var result = response.message
                    showNotification(result, 'success', 'Done!')
                    OpenIndex()
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

function OpenPosProductPage() {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/products/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function LinkNewProducts() {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/products/link-new.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}


function SetProductLink(posProductId) {
    $('#pop-content').html(InnerLoader)

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/d-pad/control-panel/products/set-link-product.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                posProductId: posProductId
            },
            success: function(data) {
                $('#pop-content').html(data)
                OpenPopup()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function saveProductLink(posProductId = 0, isActive = 1) {
    showOverlay()
    var form = document.getElementById("product-form");
    // Get form data
    if (form.checkValidity()) {
        var formData = new FormData(form);

        // Get Methods
        var methodListItems = document.querySelectorAll(".methodList h5");
        var methods = Array.from(methodListItems).map(item => item.textContent);

        // Get Age List
        var ageListItems = document.querySelectorAll(".ageList h5");
        var ageGroups = Array.from(ageListItems).map(item => item.textContent);


        // Get Instructions
        var instructionListItems = document.querySelectorAll(".instructionList h5");
        var instructions = Array.from(instructionListItems).map(item => item.textContent);

        // Append drugs to form data
        formData.append("methodList", JSON.stringify(methods));
        formData.append("ageList", JSON.stringify(ageGroups));
        formData.append("instructionList", JSON.stringify(instructions));
        formData.append("isActive", isActive);
        formData.append("LoggedUser", LoggedUser);
        formData.append("isActive", isActive);
        formData.append("posProductId", posProductId);

        function fetch_data() {
            $.ajax({
                url: 'lib/d-pad/control-panel/products/save-product-link.php',
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