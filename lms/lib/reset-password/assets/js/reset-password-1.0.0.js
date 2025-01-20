$(document).ready(function () {
  OpenIndex();
});

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

// Prevent Refresh or Back Unexpectedly
// window.onbeforeunload = function () {
//   return 'Are you sure you want to leave?'
// }

const InnerLoader = document.getElementById(
  "inner-preloader-content"
).innerHTML;

function OpenIndex() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/reset-password/index.php",
      method: "POST",
      data: {},
      success: function (data) {
        $("#root").html(data);
      },
    });
  }
  fetch_data();
}

function getUserDetails(studentNumber) {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/reset-password/get-user-details.php",
      method: "POST",
      data: {
        studentNumber: studentNumber,
      },
      success: function (data) {
        $("#root").html(data);
      },
    });
  }
  fetch_data();
}
function sentResetLink() {
  var studentNumber = document.getElementById("studentNumber").value;
  var phoneNumber = document.getElementById("phoneNumber").value;
  $("#root").html(InnerLoader); // Show the loader

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/student-account-center/reset-password/requests/send-link.php",
      method: "POST",
      data: {
        studentNumber: studentNumber,
        phoneNumber: phoneNumber,
      },
      success: function (data) {
        try {
          var response = JSON.parse(data);
          var result = response.message;

          // Check the response status and show appropriate message
          if (response.status === "success") {
            showNotification(result, "success", "Done!");
            $("#root").html(""); // Hide the loader
            GoToGetOTP(studentNumber, phoneNumber);
          } else {
            showNotification(result, "error", "Oops!");
            $("#root").html(""); // Hide the loader
            getUserDetails(studentNumber);
          }
        } catch (e) {
          // Handle any JSON parsing errors
          showNotification(
            "There was an error processing the request.",
            "error",
            "Oops!"
          );
          $("#root").html(""); // Hide the loader
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX request errors
        showNotification(
          "There was an issue with the request.",
          "error",
          "Oops!"
        );
        $("#root").html(""); // Hide the loader
      },
    });
  }

  fetch_data();
}

function GoToGetOTP(studentNumber, phoneNumber) {
  function fetch_data() {
    $.ajax({
      url: "lib/reset-password/enter-otp.php",
      method: "POST",
      data: {
        studentNumber: studentNumber,
        phoneNumber: phoneNumber,
      },
      success: function (data) {
        $("#root").html(data);
      },
    });
  }
  fetch_data();
}

function validateOTP() {
  var studentNumber = document.getElementById("studentNumber").value;
  var otpNumber = document.getElementById("otpNumber").value;
  var phoneNumber = document.getElementById("phoneNumber").value;

  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/reset-password/requests/validate-otp.php",
      method: "POST",
      data: {
        studentNumber: studentNumber,
        phoneNumber: phoneNumber,
        otpNumber: otpNumber,
      },
      success: function (data) {
        var response = JSON.parse(data);
        var result = response.message;
        var token = response.token;
        if (response.status === "success") {
          showNotification(result, "success", "Done!");
          redirectToURL(
            "reset-password-return?token=" +
              token +
              "&phoneNumber=" +
              phoneNumber +
              "&studentNumber=" +
              studentNumber
          );
        } else {
          showNotification(result, "error", "Oops!");
          GoToGetOTP(studentNumber, phoneNumber);
        }
      },
    });
  }

  if (otpNumber != "") {
    fetch_data();
  } else {
    result = "Please Enter OTP!";
    showNotification(result, "error", "Oops!");
  }
}
