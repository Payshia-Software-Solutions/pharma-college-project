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
            url: 'lib/quiz/index.php',
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


function OpenQuiz(quizId) {
    showOverlay()
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/quiz/quiz-page.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                quizId: quizId
            },
            success: function(data) {
                $('#root').html(data)
                hideOverlay()
            }
        })
    }
    fetch_data()
}

function OpenQuestion(quizId, questionId) {
    showOverlay()
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/quiz/question-page.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                quizId: quizId,
                questionId: questionId
            },
            success: function(data) {
                $('#root').html(data)
                hideOverlay()
            }
        })
    }
    fetch_data()
}


function ValidateAnswer(quizId, questionId) {
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
            url: 'lib/quiz/validate-answer.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                defaultCourseCode: defaultCourseCode,
                company_id: company_id,
                quizId: quizId,
                questionId: questionId,
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
                    goBack(quizId)
                } else {
                    showNotification(displayMessage, 'error', 'Oops!')
                }
                hideOverlay()
            }
        })
    }
}

function AddTopics() {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/add-topics.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode
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

function CreateTopics(topicId = 0) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/edit-topic.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                topicId: topicId
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

function SaveTopic(topicId = 0) {
    var topicName = $('#topicName').val()

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/requests/save-topic.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                topicId: topicId,
                topicName: topicName
            },
            success: function(data) {
                var response = JSON.parse(data)
                var result = response.message
                if (response.status === 'success') {
                    showNotification(result, 'success', 'Done!')
                    AddTopics()
                } else {
                    showNotification(displayMessage, 'error', 'Oops!')
                }
                hideOverlay()
            }
        })
    }
    if (topicName != "") {
        fetch_data()
    } else {
        var result = "Please add Topic Name!"
        showNotification(result, 'error', 'Oops!')
    }

}

function TopicContent(topicId) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/topic-content.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                topicId: topicId
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

function QuestionContent(topicId, questionId = 0) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/question-content.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                questionId: questionId,
                topicId: topicId
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

function UpdateQuestionStatus(topicId, questionId, questionStatus) {
    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/requests/delete-question.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                questionId: questionId,
                topicId: topicId,
                questionStatus: questionStatus
            },
            success: function(data) {
                TopicContent(topicId)
                OpenIndex()
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function SaveQuestion(topicId, questionId) {

    var question = tinymce.get("question").getContent();
    var form = document.getElementById('submit-form')

    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form)
        formData.append('LoggedUser', LoggedUser)
        formData.append('UserLevel', UserLevel)
        formData.append('company_id', company_id)
        formData.append('defaultCourseCode', defaultCourseCode)
        formData.append('questionId', questionId)
        formData.append('topicId', topicId)
        formData.append('question', question)

        function fetch_data() {
            $.ajax({
                url: 'lib/quiz/requests/save-question.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        TopicContent(topicId)
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

function SetupQuiz(courseCode = defaultCourseCode) {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/setup_quiz/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                courseCode: courseCode
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

function SaveOrRemoveTopicByCourse(topicId, courseCode = defaultCourseCode) {
    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/setup_quiz/save-or-update-quiz.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode,
                courseCode: courseCode,
                topicId: topicId
            },
            success: function(data) {
                var response = JSON.parse(data)
                if (response.status === 'success') {
                    var result = response.message
                    showNotification(result, 'success', 'Done!')
                    SetupQuiz(courseCode)
                    OpenIndex()
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


function OpenSetting() {
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/quiz/settings/index.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                defaultCourseCode: defaultCourseCode
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