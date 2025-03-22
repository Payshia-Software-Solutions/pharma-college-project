var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var company_id = document.getElementById("company_id").value;
var defaultLocation = document.getElementById("default_location").value;
var defaultLocationName = document.getElementById(
  "default_location_name"
).value;

let config = {}; // Define a global variable

fetch("config.json")
  .then((response) => response.json())
  .then((data) => {
    config = data;
  })
  .catch((error) => console.error("Error loading config:", error));

$(document).ready(function () {
  OpenIndex();
});

function OpenIndex(studentBatch = 0, orderType = 0) {
  function fetch_data() {
    document.getElementById("index-content").innerHTML = InnerLoader;
    $.ajax({
      url: "assets/content/lms-management/course/index.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        studentBatch: studentBatch,
        orderType: orderType,
        defaultLocation: defaultLocation,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function EditGradesByCourse(studentBatch = 0) {
  function fetch_data() {
    document.getElementById("index-content").innerHTML = InnerLoader;
    $.ajax({
      url: "assets/content/lms-management/course/grade/edit-grades.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        studentBatch: studentBatch,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function ViewGradesByCourse(studentBatch = 0) {
  function fetch_data() {
    document.getElementById("index-content").innerHTML = InnerLoader;
    $.ajax({
      url: "assets/content/lms-management/course/grade/view-saved-grades.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        studentBatch: studentBatch,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function ChangeGradeValue(assignmentId, studentNumber, gradeValue) {
  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "assets/content/lms-management/course/grade/save-edited-grade.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        assignmentId: assignmentId,
        studentNumber: studentNumber,
        gradeValue: gradeValue,
      },
      success: function (data) {
        var response = JSON.parse(data);
        if (response.status === "success") {
          var result = response.message;
          OpenAlert("success", "Done!", result);
        } else {
          var result = response.message;
          OpenAlert("error", "Error!", result);
        }
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function setupCourse(courseCode) {
  var userTheme = $("#userTheme").val();
  OpenPopupRight();
  $("#loading-popup-right").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/setup-course.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        courseCode: courseCode,
        defaultLocation: defaultLocation,
        userTheme: userTheme,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
    });
  }
  fetch_data();
}

function AddNewCourse(courseCode = 0) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/update-course.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultLocation: defaultLocation,
        defaultLocationName: defaultLocationName,
        courseCode: courseCode,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function OpenGrading(studentBatch = 0) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/grade/index.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        studentBatch: studentBatch,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function GetTemplateExcel(studentBatch = 0) {
  OpenPopup();
  document.getElementById("templateExcel").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "assets/content/lms-management/course/grade/get-template.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        studentBatch: studentBatch,
      },
      success: function (data) {
        $("#templateExcel").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function SaveGradeData() {
  var studentBatch = document.getElementById("batchId").value;
  var form = document.getElementById("excelUploadForm");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("studentBatch", studentBatch);

    function fetch_data() {
      $.ajax({
        url: "assets/content/lms-management/course/grade/view-grading.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          $("#loading-popup").html(data);
          hideOverlay();
        },
      });
    }

    fetch_data();
  } else {
    form.reportValidity();
    result = "Please Filled out All  Fields.";
    OpenAlert("error", "Oops!", result);
  }
}

function CommitChanges() {
  var form = document.getElementById("commitForm");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);

    function fetch_data() {
      $.ajax({
        url: "assets/content/lms-management/course/grade/save-grading.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          OpenAlert("success", "Done!", data);
          hideOverlay();
        },
      });
    }

    fetch_data();
  } else {
    form.reportValidity();
    result = "Please Filled out All  Fields.";
    OpenAlert("error", "Oops!", result);
  }
}

function PrintGameReport(gameTitle, studentBatch, userName, locationId) {
  // Open a new tab with the printPage.html and pass the po_number as a query parameter
  var printWindow = window.open(
    "report-viewer/lms-reports/game-reports/" +
      gameTitle +
      "?studentBatch=" +
      encodeURIComponent(studentBatch) +
      "&userId=" +
      encodeURIComponent(userName) +
      "&locationId=" +
      encodeURIComponent(locationId),
    "_blank"
  );

  // Focus on the new tab
  if (printWindow) {
    printWindow.focus();
  }
}

// Game Functions
function OpenGames() {
  var userTheme = $("#userTheme").val();
  OpenPopupRight();
  $("#loading-popup-right").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/open-games.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        defaultLocation: defaultLocation,
        userTheme: userTheme,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
    });
  }
  fetch_data();
}

function OpenAddGame() {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/add-game.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultLocation: defaultLocation,
        defaultLocationName: defaultLocationName,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function saveGame() {
  if (Object.keys(config).length === 0) {
    console.error("Config not loaded yet!");
    return;
  }

  const form = document.getElementById("gameForm");

  if (form.checkValidity()) {
    showOverlay();
    const gameTitle = document.getElementById("gameTitle").value;
    const gameDescription = document.getElementById("gameDescription").value;

    const data = {
      game_title: gameTitle,
      game_description: gameDescription,
    };

    fetch(`${config.MS_COURSE_SRL}/api/${config.API_VERSION}/games`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + config.API_KEY,
      },
      body: JSON.stringify(data),
    })
      .then((response) => {
        if (response.status === 201) {
          return response.json(); // Convert response to JSON if status is 201
        } else {
          throw new Error(`Failed with status: ${response.status}`);
        }
      })
      .then((data) => {
        OpenAlert("success", "Done!", "Game saved successfully!");
        OpenGames();
        hideOverlay();
        ClosePopUP();
      })
      .catch((error) => {
        console.error("Error:", error);
        OpenAlert("error", "Oops!", "An error occurred while saving the game.");
        hideOverlay();
      });
  } else {
    form.reportValidity();
    OpenAlert("error", "Oops!", "Please fill out all required fields.");
  }
}

function AssignGamesToCourse(courseCode) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/add-game-to-course.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultLocation: defaultLocation,
        courseCode: courseCode,
        defaultLocationName: defaultLocationName,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function customShowMoqPopup(gameId, courseCode) {
  // Set game and course IDs in hidden inputs
  document.getElementById("custom-selectedGameId").value = gameId;
  document.getElementById("custom-selectedCourseCode").value = courseCode;

  // Show modal
  document.getElementById("custom-moqModal").style.display = "block";
}

function customCloseMoqPopup() {
  document.getElementById("custom-moqModal").style.display = "none";
}

function customSubmitMoq() {
  let gameId = document.getElementById("custom-selectedGameId").value;
  let courseCode = document.getElementById("custom-selectedCourseCode").value;
  let moq = document.getElementById("custom-moqInput").value;

  if (moq.trim() === "" || isNaN(moq) || parseInt(moq) <= 0) {
    alert("Please enter a valid MOQ.");
    return;
  }

  customCloseMoqPopup(); // Close modal

  // Call the function to add the game with MOQ
  addGameToCourse(courseCode, gameId, parseInt(moq));
}

function addGameToCourse(courseCode, gameId, minQuantity) {
  if (Object.keys(config).length === 0) {
    console.error("Config not loaded yet!");
    return;
  }

  showOverlay();
  const data = {
    courseId: courseCode,
    gameId: gameId,
    minQuantity: minQuantity,
  };

  fetch(`${config.MS_COURSE_SRL}/api/${config.API_VERSION}/courses/add-game`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + config.API_KEY,
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (response.status === 201 || response.status === 200) {
        return response.json(); // Convert response to JSON if status is 201
      } else {
        throw new Error(`Failed with status: ${response.status}`);
      }
    })
    .then((data) => {
      OpenAlert("success", "Done!", "Game added to course successfully!");
      setupCourse(courseCode);
      AssignGamesToCourse(courseCode);
      hideOverlay();
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert(
        "error",
        "Oops!",
        "An error occurred while adding the game to the course."
      );
      hideOverlay();
    });
}

function removeGameToCourse(courseCode, gameId) {
  if (Object.keys(config).length === 0) {
    console.error("Config not loaded yet!");
    return;
  }

  showOverlay();
  const data = {
    courseId: courseCode,
    gameId: gameId,
  };

  fetch(
    `${config.MS_COURSE_SRL}/api/${config.API_VERSION}/courses/remove-game`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + config.API_KEY,
      },
      body: JSON.stringify(data),
    }
  )
    .then((response) => {
      if (response.status === 200) {
        return response.json(); // Convert response to JSON if status is 200
      } else {
        throw new Error(`Failed with status: ${response.status}`);
      }
    })
    .then((data) => {
      OpenAlert("success", "Done!", "Game removed from course successfully!");
      setupCourse(courseCode);
      AssignGamesToCourse(courseCode);
      hideOverlay();
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert(
        "error",
        "Oops!",
        "An error occurred while removing the game from the course."
      );
      hideOverlay();
    });
}

function AddEvaluationsToCourse(courseCode) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/course/add-evaluations-to-course.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultLocation: defaultLocation,
        courseCode: courseCode,
        defaultLocationName: defaultLocationName,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function DeleteEvaluation(evaluationId, courseCode) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Close it!",
  }).then((result) => {
    if (result.isConfirmed) {
      showOverlay();
      fetch(
        `${config.MS_COURSE_SRL}/api/${config.API_VERSION}/evaluations/${evaluationId}`,
        {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
            Authorization: "Bearer " + config.API_KEY,
          },
        }
      )
        .then((response) => {
          if (response.status === 204) {
            OpenAlert(
              "success",
              "Done!",
              "Evaluation removed from course successfully!"
            );
            setupCourse(courseCode);
            hideOverlay();
          } else {
            throw new Error(`Failed with status: ${response.status}`);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          OpenAlert(
            "error",
            "Oops!",
            "An error occurred while removing the game from the course."
          );
          hideOverlay();
        });
    }
  });
}

function SaveEvaluationToCourse(courseCode) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Close it!",
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById("evaluationForm");

      if (form.checkValidity()) {
        showOverlay();
        var formData = new FormData(form);
        const data = {
          courseId: formData.get("courseId"),
          criteria_type: formData.get("criteria_type"),
          criteria_value: formData.get("criteria_value"),
          weight: formData.get("weight"),
        };

        fetch(`${config.MS_COURSE_SRL}/api/${config.API_VERSION}/evaluations`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => {
            if (response.status === 201) {
              OpenAlert(
                "success",
                "Done!",
                "Evaluation added to course successfully!"
              );
              setupCourse(courseCode);
              hideOverlay();
              ClosePopUP();
            } else {
              throw new Error(`Failed with status: ${response.status}`);
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred while creating the evaluation.");
          });
      } else {
        form.reportValidity();
        result = "Please Filled out All  Fields.";
        OpenAlert("error", "Oops!", result);
      }
    }
  });
}
