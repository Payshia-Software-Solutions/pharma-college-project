var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var company_id = document.getElementById("company_id").value;
var default_location = document.getElementById("default_location").value;
var default_location_name = document.getElementById(
  "default_location_name"
).value;

$(document).ready(function () {
  OpenIndex();
});

function OpenIndex() {
  function fetch_data() {
    document.getElementById("index-content").innerHTML = InnerLoader;
    $.ajax({
      url: "assets/content/lms-management/certificate center/index.php",
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

function PrintDialogOpen(studentNumber, studentBatch) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/print-dialogue.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        studentBatch: studentBatch,
        studentNumber: studentNumber,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function OpenTranscriptDataEntry(studentNumber, selectedCourse) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/transcript-data-entry.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        studentNumber: studentNumber,
        selectedCourse: selectedCourse,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function OpenEditProfileDialogue(studentNumber, selectedCourse) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/profile/view-profile.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        studentNumber: studentNumber,
        selectedCourse: selectedCourse,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function PrintCertificate(studentNumber, selectedCourse) {
  var form = document.getElementById("print-certificate-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    var issuedDate = formData.get("issuedDate");
    var certificateTemplate = formData.get("certificateTemplate");
    var backImageStatus = formData.get("backImageStatus");

    var url =
      "assets/content/lms-management/certificate center/print-view/certificate.php?" +
      "studentNumber=" +
      encodeURIComponent(studentNumber) +
      "&selectedCourse=" +
      encodeURIComponent(selectedCourse) +
      "&certificateTemplate=" +
      encodeURIComponent(certificateTemplate) +
      "&PrintedId=" +
      encodeURIComponent(LoggedUser) +
      "&issuedDate=" +
      encodeURIComponent(issuedDate) +
      "&orientationStatus=" +
      encodeURIComponent("Portrait") +
      "&backImageStatus=" +
      encodeURIComponent(backImageStatus);

    var win = window.open(url, "_blank");
    if (win) {
      win.focus();
      GetCertificationPage(selectedCourse);
      PrintDialogOpen(selectedCourse, studentNumber);
    } else {
      // If pop-up was blocked or not allowed.
      alert("Please allow pop-ups for this site to open the certificate.");
    }
  } else {
    form.reportValidity();
    result = "Please fill out all fields.";
    OpenAlert("error", "Oops!", result);
  }
}
