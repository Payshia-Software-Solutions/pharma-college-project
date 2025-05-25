var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var UserLevel = document.getElementById("UserLevel").value;
var company_id = document.getElementById("company_id").value;
var defaultCourseCode = document.getElementById("defaultCourseCode").value;
var addedInstructions = [];

$(document).ready(async function () {
  try {
    const response = await fetch("env.json");
    const envData = await response.json();
    SERVER_URL = envData.SERVER_URL;

    OpenIndex(); // Call only after SERVER_URL is ready
  } catch (error) {
    console.error("Error reading JSON file:", error);
  }
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
      url: "lib/word-pallet/index.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultCourseCode: defaultCourseCode,
        company_id: company_id,
      },
      success: function (data) {
        $("#root").html(data);
      },
    });
  }
  fetch_data();
}

function SubmitWordAnswer(wordId, attemptValue) {
  const studentNumber = LoggedUser;

  if (!studentNumber || !attemptValue) {
    showNotification(
      "Please enter your answer and student number.",
      "error",
      "Validation Error!"
    );
    return;
  }

  const formData = new FormData();
  formData.append("word_id", wordId);
  formData.append("student_number", studentNumber);
  formData.append("attempt_value", attemptValue);
  formData.append("created_by", "frontend"); // adjust as needed

  fetch(SERVER_URL + "/en-word-submissions", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((response) => {
      if (response.status === "success") {
        showNotification(
          "Answer Saved!",
          response.correct_status === "Correct" ? "success" : "error",
          response.correct_status === "Correct" ? "Correct!" : "Wrong!"
        );

        OpenIndex();
      } else {
        showNotification(response.message, "error", "Error!");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showNotification("Something went wrong!", "error", "Server Error");
    });
}
