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

function createBubble(parentElement, xPos, yPos, widthVal) {
  const bubble = document.createElement("div");
  bubble.className = "bubble";
  bubble.style.width = widthVal;
  bubble.style.height = bubble.style.width;

  bubble.style.left = xPos;
  bubble.style.top = yPos;

  parentElement.appendChild(bubble);
}

const InnerLoader = document.getElementById(
  "inner-preloader-content"
).innerHTML;

function OpenIndex() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/assignments/index.php",
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

function ViewAssignment(assignmentId = 0) {
  document.getElementById("root").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/assignments/views/view-assignment.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        assignmentId: assignmentId,
      },
      success: function (data) {
        $("#root").html(data);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function ViewHomeContent() {
  document.getElementById("root").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/assignments/views/home-content.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
      },
      success: function (data) {
        $("#root").html(data);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function SaveSubmission(assignmentId) {
  var form = document.getElementById("submit-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("CourseCode", CourseCode);
    formData.append("assignmentId", assignmentId);

    function fetch_data() {
      showOverlay();
      $.ajax({
        url: "./lib/assignments/controllers/save-submission.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            showNotification(result, "success", "Done!");
            ViewAssignment(assignmentId);
          } else {
            var result = response.message;
            showNotification(result, "error", "Done!");
          }
          hideOverlay();
        },
      });
    }
  } else {
    form.reportValidity();
    result = "Please Filled out All  Fields.";
    OpenAlert("error", "Oops!", result);
  }

  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Save it!",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch_data();
    }
  });
}
