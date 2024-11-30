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

const InnerLoader = document.getElementById(
  "inner-preloader-content"
).innerHTML;

function OpenIndex() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/certificate-center/index.php",
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

function OpenCertificate(certificateId) {
  $("#pageContent").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/certificate-center/certificate-criteria.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        CourseCode: CourseCode,
        company_id: company_id,
        certificateId: certificateId,
      },
      success: function (data) {
        $("#pageContent").html(data);
      },
    });
  }
  fetch_data();
}

function OpenCertificateForm(loggedUser, certificateId) {
  $("#pageContent").html(InnerLoader); // Show a loading animation or placeholder.

  function fetch_data() {
    $.ajax({
      url: "lib/certificate-center/order-certificate-form.php", // The PHP script to retrieve the form.
      method: "POST", // The HTTP method used for the request.
      data: {
        LoggedUser: loggedUser, // Pass the LoggedUser to the server.
        UserLevel: UserLevel,
        CourseCode: CourseCode,
        company_id: company_id,
        certificateId: certificateId, // Ensure this is correctly set
      },

      success: function (data) {
        // On success, replace the content of the element with id 'pageContent' with the form data.
        $("#pageContent").html(data);
      },
    });
  }
  fetch_data(); // Execute the AJAX request.
}

function CloseCertificateForm(loggedUser, certificateId) {
  $("#pageContent").html(InnerLoader); // Show a loading animation or placeholder.

  function fetch_data() {
    $.ajax({
      url: "lib/certificate-center/certificate-criteria.php", // The PHP script to retrieve the form.
      method: "POST", // The HTTP method used for the request.
      data: {
        LoggedUser: loggedUser, // Pass the LoggedUser to the server.
        UserLevel: UserLevel,
        CourseCode: CourseCode,
        company_id: company_id,
        certificateId: certificateId, // Ensure this is correctly set
      },

      success: function (data) {
        // On success, replace the content of the element with id 'pageContent' with the form data.
        $("#pageContent").html(data);
      },
    });
  }
  fetch_data(); // Execute the AJAX request.
}

function submitOrder(certificateId) {
  var form = document.getElementById("order_form");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);

    formData.append("LoggedUser", LoggedUser);
    formData.append("CourseCode", CourseCode);
    formData.append("certificateId", certificateId);

    $.ajax({
      url: "lib/certificate-center/certificate-order-submit.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        var response = JSON.parse(data);
        if (response.status === "success") {
          var result = response.message;
          showNotification(result, "success", "Done!");
          OpenIndex();
        } else {
          var result = response.message;
          showNotification(result, "error", "Done!");
        }
        hideOverlay();
      },
    });
  } else {
    form.reportValidity();
    showNotification("Please fill out all required fields.", "error", "Ops!");
  }
}
