var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var company_id = document.getElementById("company_id").value;
var default_location = document.getElementById("default_location").value;
var default_location_name = document.getElementById(
  "default_location_name"
).value;

function redirectToURL(url) {
  window.location.href = url;
}

function showNotification(result, type, title) {
  Swal.fire({
    icon: type,
    title: title,
    text: result,
  });
}

$(document).ready(function () {
  OpenIndex();
});

function OpenIndex() {
  function fetch_data() {
    document.getElementById("index-content").innerHTML = InnerLoader;
    $.ajax({
      url: "assets/content/lms-management/student-account-center/index.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function OpenStudentDetails(LoggedUser) {
  var form = document.getElementById("username-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);

    function fetch_data() {
      $.ajax({
        url: "assets/content/lms-management/student-account-center/student-details.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          $("#student-details").html(data);
        },
      });
    }
    fetch_data();
  } else {
    result = "Please Filled out All * marked Fields.";
    OpenAlert("error", "Oops!", result);
  }
}

function OpenPopupRight() {
  document.getElementById("loading-popup-right").style.display = "flex";
}

function ClosePopUPRight() {
  document.getElementById("loading-popup-right").style.display = "none";
}

function OpenPaymentHistory(selectedUsername) {
  OpenPopupRight();
  $("#loading-popup-right").html("Loading..."); // Placeholder content while loading
  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/student-account-center/paymentHistory.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        selectedUsername: selectedUsername,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        $("#loading-popup-right").html("Failed to load content.");
      },
    });
  }

  fetch_data();
}

function OpenOrders(selectedUsername) {
  OpenPopupRight();
  $("#loading-popup-right").html("Loading..."); // Placeholder content while loading
  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/student-account-center/viewOrders.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        selectedUsername: selectedUsername,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        $("#loading-popup-right").html("Failed to load content.");
      },
    });
  }

  fetch_data();
}

function OpenEnrollements(selectedUsername) {
  OpenPopupRight();
  $("#loading-popup-right").html("Loading..."); // Placeholder content while loading
  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/student-account-center/viewEnrollements.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        selectedUsername: selectedUsername,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        $("#loading-popup-right").html("Failed to load content.");
      },
    });
  }

  fetch_data();
}

function OpenGameDetails(selectedUsername) {
  OpenPopupRight();
  $("#loading-popup-right").html("Loading..."); // Placeholder content while loading
  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/student-account-center/gameResultByDefualtCode.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        selectedUsername: selectedUsername,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        $("#loading-popup-right").html("Failed to load content.");
      },
    });
  }

  fetch_data();
}

function OpenGameDetailsByCourseCode(LoggedUser, selectedUsername) {
  var form = document.getElementById("courseCode-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("selectedUsername", selectedUsername);

    function fetch_data() {
      $.ajax({
        url: "assets/content/lms-management/student-account-center/gameResultByCourseCode.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          $("#student-courseCode").html(data);
        },
      });
    }
    fetch_data();
  } else {
    result = "Please Filled out All * marked Fields.";
    OpenAlert("error", "Oops!", result);
  }
}

function OpenpasswordReset(selectedUsername) {
  OpenPopupRight();
  $("#loading-popup-right").html("Loading..."); // Placeholder content while loading
  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/student-account-center/passwordReset.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        selectedUsername: selectedUsername,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        $("#loading-popup-right").html("Failed to load content.");
      },
    });
  }

  fetch_data();
}

// Function to display validation messages
function showValidationMessage(elementId, message) {
  var element = document.getElementById(elementId + "-error");
  if (element) {
    element.innerHTML = message;
    element.style.display = "block";
  }
}

// function SubmitCertificateUpdateForm() {
//   const form = document.getElementById("password-form");
//   const formData = new FormData(form);

//   fetch(
//     "assets/content/lms-management/student-account-center/updatePassword.php",
//     {
//       method: "POST",
//       body: formData,
//     }
//   )
//     .then((response) => response.json())
//     .then((data) => {
//       if (data.success) {
//         OpenAlert("success", "Success!", data.message);
//         ViewCertificate(); // Reload the page to reflect changes
//       } else {
//         OpenAlert("error", "Error!", data.message);
//       }
//     })
//     .catch((error) => console.error("Error:", error));
// }
// function SubmitPasswordUpdateForm() {
//   const selectedUsername = document.getElementById("username").value;
//   const newPassword = document.getElementById("newPassword").value;
//   const retypePassword = document.getElementById("retypePassword").value;

//   if (newPassword !== retypePassword) {
//     showNotification("Passwords do not match!", "error", "Error");
//     return;
//   }

//   const formData = new FormData(document.getElementById("password-form"));

//   fetch(
//     "assets/content/lms-management/student-account-center/updatePassword.php",
//     {
//       method: "POST",
//       body: formData,
//     }
//   )
//     .then((response) => response.json())
//     .then((data) => {
//       const type = data.success ? "success" : "error"; // Set notification type
//       const title = data.success ? "Success" : "Error"; // Set notification title
//       showNotification(data.message, type, title);

//       // Reset form and close the popup if successful
//       if (data.success) {
//         setTimeout(() => {
//           ClosePopUP(); // Close popup logic if applicable
//           document.getElementById("password-form").reset();
//         }, 3000);
//       }
//     })
//     .catch((error) => {
//       console.error("Error:", error);
//       showNotification(
//         "Failed to update password. Please try again.",
//         "error",
//         "Error"
//       );
//     });
// }

function SubmitPasswordUpdateForm() {
  const selectedUsername = document.getElementById("username").value;
  const newPassword = document.getElementById("newPassword").value;
  const retypePassword = document.getElementById("retypePassword").value;

  // Password validation
  if (newPassword !== retypePassword) {
    showNotification("Passwords do not match!", "error", "Error");
    return;
  }

  const formData = new FormData();
  formData.append("selectedUserName", selectedUsername);
  formData.append("new_password", newPassword);
  formData.append("retype_password", retypePassword);

  fetch(
    "assets/content/lms-management/student-account-center/updatePassword.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => response.json())
    .then((data) => {
      const type = data.success ? "success" : "error";
      const title = data.success ? "Success" : "Error";
      showNotification(data.message, type, title);

      if (data.success) {
        setTimeout(() => {
          ClosePopUP();
          document.getElementById("password-form").reset();
        }, 3000);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showNotification(
        "Failed to update password. Please try again.",
        "error",
        "Error"
      );
    });
}
