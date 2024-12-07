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

function PrintDialogOpen(studentNumber, studentBatch, certificateId) {
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
        certificateId: certificateId,
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

function PrintTranscript(studentNumber, selectedCourse) {
  var form = document.getElementById("print-certificate-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    var issuedDate = formData.get("issuedDate");
    var certificateTemplate = formData.get("certificateTemplate");
    var backImageStatus = formData.get("backImageStatus");

    var url =
      "assets/content/lms-management/certificate center/print-view/transcript.php?" +
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

function PrintWorkshop(studentNumber, selectedCourse) {
  var form = document.getElementById("print-certificate-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    var issuedDate = formData.get("issuedDate");
    var certificateTemplate = formData.get("certificateTemplate");
    var backImageStatus = formData.get("backImageStatus");

    var url =
      "assets/content/lms-management/certificate center/print-view/workshop-certificate.php?" +
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

function OpenEditProfile(studentNumber, selectedCourse) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/profile/edit-profile.php",
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

function SaveProfileInfo(studentNumber, selectedCourse) {
  var form = document.getElementById("submit-form");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("studentNumber", studentNumber);

    function fetch_data() {
      $.ajax({
        url: "assets/content/lms-management/profile/save-user-data.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            OpenAlert("success", "Done!", result);
            OpenEditProfileDialogue(studentNumber, selectedCourse);
            OpenIndex();
          } else {
            var result = response.message;
            OpenAlert("error", "Oops.. Something Wrong!", result);
          }
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

function SaveCertificate(CourseCode, indexNo) {
  var LoopCount = document.getElementById("LoopCount").value;
  var TitleIDs = [];
  var OptionValues = [];

  // Collect all TitleIDs and OptionValues
  for (var i = 1; i <= LoopCount; i++) {
    var TitleID = document.getElementById("optionID-" + i).value;
    var OptionValue = document.getElementById("option-" + i).value;
    TitleIDs.push(TitleID);
    OptionValues.push(OptionValue);
  }

  // showOverlay() should be called only once before AJAX request
  showOverlay();

  // AJAX request to save transcript entry
  $.ajax({
    url: "assets/content/lms-management/certificate center/requests/save-transcript-entry.php",
    method: "POST",
    data: {
      LoggedUser: LoggedUser,
      UserLevel: UserLevel,
      CourseCode: CourseCode,
      indexNo: indexNo,
      TitleIDs: TitleIDs, // Send all TitleIDs
      OptionValues: OptionValues, // Send all OptionValues
    },
    success: function (data) {
      OpenAlert("success", "Done!", data);
      hideOverlay();
    },
  });
}

function SaveCertificateConfiguration(selectedCourse) {
  var form = document.getElementById("config-form");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("selectedCourse", selectedCourse);

    function fetch_data() {
      $.ajax({
        url: "assets/content/lms-management/certification/requests/save-configuration.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            OpenAlert("success", "Done!", result);
            GetCertificationPage(selectedCourse);
          } else {
            var result = response.message;
            OpenAlert("error", "Oops.. Something Wrong!", result);
          }
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

//Certificate

//Criteria_Group

function ViewCriteriaGroups(LoggedUser) {
  showOverlay();
  document.getElementById("index-content").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria_group/criteria_group.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
      },
      success: function (data) {
        $("#index-content").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

//Criteria

function ViewCriteriaList(LoggedUser) {
  showOverlay();
  document.getElementById("index-content").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria/criteria_list.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
      },
      success: function (data) {
        $("#index-content").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function AddNewCriteria(LoggedUser) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;
  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria/new_criteria.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
      },
      success: function (data) {
        $("#loading-popup").html(data);
        ViewCriteriaList();
      },
    });
  }
  fetch_data();
}

//insert and save criteria
function InsertCriteria() {
  var form = document.getElementById("order_form");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);

    // Append the logged user
    formData.append("LoggedUser", LoggedUser);

    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria/insert_criteria.php", // Ensure the URL is correct
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        try {
          var response = JSON.parse(data);
          console.log("Response:", response); // For debugging

          // Check the response status
          if (response.status === "success") {
            OpenAlert("success", "Done!", response.message); // Replace showNotification with OpenAlert
            ViewCriteriaList();
          } else {
            OpenAlert(
              "error",
              "Failed!",
              response.message || "Failed to submit criteria."
            );
          }
        } catch (e) {
          console.error("Error parsing response:", e);
          OpenAlert("error", "Error!", "An unexpected error occurred.");
        }
        hideOverlay();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        OpenAlert("error", "Ops!", "Server error occurred.");
        hideOverlay();
      },
    });
  } else {
    form.reportValidity();
    OpenAlert("error", "Ops!", "Please fill out all required fields.");
  }
}

//open criteria
function OpenEditCriteria(loggedUser, criteriaId) {
  OpenPopup(); // Open the popup
  document.getElementById("loading-popup").innerHTML = InnerLoader; // Show loading animation

  $.ajax({
    url: "assets/content/lms-management/certificate center/criteria/edit_criteria.php",
    method: "POST",
    data: {
      LoggedUser: loggedUser,
      criteriaId: criteriaId, // Pass the criteria ID
    },
    success: function (data) {
      $("#loading-popup").html(data); // Load the HTML from the response
    },
    error: function (xhr, status, error) {
      console.error("Error loading edit-criteria.php:", status, error);
      $("#loading-popup").html(
        `<div class="error-message">Failed to load the criteria editor. Please try again later.</div>`
      );
    },
  });
}

//update criteria and save
function UpdateCriteria(criteriaId) {
  console.log("Criteria ID:", criteriaId); // Log the ID to check if it's correct

  var form = document.getElementById("update-form");
  // Check form validity
  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);

    // Append the logged user and criteria ID
    formData.append("LoggedUser", LoggedUser);
    formData.append("criteria_id", criteriaId); // Ensure the criteria ID is included

    // Perform the AJAX request to update the criteria
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria/update_criteria.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        try {
          var response = JSON.parse(data);
          console.log("Response:", response); // For debugging

          // Check the response status
          if (response.status === "success") {
            OpenAlert("success", "Done!", response.message);
            ViewCriteriaList();
          } else {
            OpenAlert(
              "error",
              "Failed!",
              response.message || "Failed to update criteria."
            );
          }
        } catch (e) {
          console.error("Error parsing response:", e);
          OpenAlert("error", "Error!", "An unexpected error occurred.");
        }
        hideOverlay();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        OpenAlert("error", "Ops!", "Server error occurred.");
        hideOverlay();
      },
    });
  } else {
    form.reportValidity();
    OpenAlert("error", "Ops!", "Please fill out all required fields.");
  }
}

function ViewCertificate(LoggedUser) {
  showOverlay();
  document.getElementById("index-content").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/certificate/certificate.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
      },
      success: function (data) {
        $("#index-content").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function changeCertificateStatus(certificateId, status) {
  fetch(
    "assets/content/lms-management/certificate center/certificate/update_certificate_status.php",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: certificateId, is_active: status }),
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        OpenAlert("success", "Success!", data.message); // Show success popup
        ViewCertificate(); // Reload the list to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message); // Show error popup
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert("error", "Error!", "An unexpected error occurred.");
    });
}

function openCertificateInsertForm(LoggedUser) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;
  $.ajax({
    url: "assets/content/lms-management/certificate center/certificate/insert_certificate_form.php",
    method: "POST",
    data: {
      LoggedUser: LoggedUser,
    },
    success: function (data) {
      $("#loading-popup").html(data); // Render form inside container
    },
    error: function (xhr, status, error) {
      alert("Failed to load the insert form. Please try again.");
    },
  });
}

function submitInsertForm() {
  const form = document.getElementById("insertCertificateForm");
  const formData = new FormData(form);

  fetch(
    "assets/content/lms-management/certificate center/certificate/save_certificate.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        OpenAlert("success", "Success!", data.message);
        ViewCertificate(); // Reload the page to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message);
      }
    })
    .catch((error) => console.error("Error:", error));
}

function OpenEditCertificate(LoggedUser, certificateId) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader; // Show loading animation

  $.ajax({
    url: "assets/content/lms-management/certificate center/certificate/update_certificate_form.php",
    method: "POST",
    data: {
      LoggedUser: LoggedUser,
      certificateId: certificateId, // Pass the criteria ID
    },
    success: function (data) {
      $("#loading-popup").html(data); // Render form inside container
    },
    error: function (xhr, status, error) {
      console.error("Error loading edit-criteria.php:", status, error);
      $("#loading-popup").html(
        `<div class="error-message">Failed to load the criteria editor. Please try again later.</div>`
      );
    },
  });
}

function SubmitCertificateUpdateForm() {
  const form = document.getElementById("UpdateCertificateForm");
  const formData = new FormData(form);

  fetch(
    "assets/content/lms-management/certificate center/certificate/update_certificate.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        OpenAlert("success", "Success!", data.message);
        ViewCertificate(); // Reload the page to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message);
      }
    })
    .catch((error) => console.error("Error:", error));
}

function AddNewCriteriaGroup(LoggedUser) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria_group/add_new_criteria_group.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
      },
      success: function (data) {
        $("#loading-popup").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function submitCriteriaGroupInsertForm() {
  const form = document.getElementById("criteriaGroupInsertForm");
  const formData = new FormData(form);

  fetch(
    "assets/content/lms-management/certificate center/criteria_group/save_new_criteria_group.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => response.json())
    .then((data) => {
      console.log(data); // Log the response to inspect the structure
      if (data.success) {
        OpenAlert("success", "Success!", data.message);
        alert();
        ViewCriteriaGroups(); // Reload the page to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function OpenEditCriteriaGroup(LoggedUser, criteriaGroupId) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria_group/edit_criteria_group.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        criteriaGroupId: criteriaGroupId,
      },
      success: function (data) {
        $("#loading-popup").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function updateCriteriaGroupInfo() {
  const form = document.getElementById("UpdateCriteriaGroupForm");
  const formData = new FormData(form);
  const updateButton = document.getElementById("UpdateButton");

  // Disable the update button to prevent multiple submissions
  updateButton.disabled = true;
  updateButton.textContent = "Updating...";

  fetch(
    "assets/content/lms-management/certificate center/criteria_group/update_criteria_group.php",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          `Network response was not ok. Status: ${response.status}`
        );
      }
      return response.text(); // Handle possible mixed content (HTML + JSON)
    })
    .then((text) => {
      try {
        const data = JSON.parse(text); // Parse JSON from response text
        updateButton.disabled = false;
        updateButton.textContent = "Update";

        if (data.status === "success") {
          OpenAlert("success", "Success!", data.message);
          ViewCriteriaGroups(); // Reload content
        } else {
          const errorMessage = `Error: ${
            data.message || "Unknown error occurred."
          } [Error Code: ${data.error_code || "E999"}]`;
          OpenAlert("error", "Error!", errorMessage);
          console.error(errorMessage);
        }
      } catch (error) {
        // JSON parsing failed (likely due to PHP notice in response)
        updateButton.disabled = false;
        updateButton.textContent = "Update";

        OpenAlert(
          "error",
          "Error!",
          "A server error occurred. Please contact support. [Error Code: E004]"
        );
        console.error("Invalid server response:", text);
      }
    })
    .catch((error) => {
      // Handle network errors or other unexpected issues
      updateButton.disabled = false;
      updateButton.textContent = "Update";

      OpenAlert(
        "error",
        "Error!",
        "A network error occurred. Please try again later. [Error Code: E003]"
      );
      console.error("Network error:", error);
    });
}

function viewCriteriaGroupDetails(LoggedUser, criteriaGroupId) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/certificate center/criteria_group/open_criteria_group.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        criteriaGroupId: criteriaGroupId,
      },
      success: function (data) {
        $("#loading-popup").html(data);
        hideOverlay();
      },
    });
  }
  fetch_data();
}

function changeCriteriaStatus(certificateId, status) {
  fetch(
    "assets/content/lms-management/certificate center/certificate/update_certificate_status.php",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: certificateId, is_active: status }),
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        OpenAlert("success", "Success!", data.message); // Show success popup
        ViewCertificate(); // Reload the list to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message); // Show error popup
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert("error", "Error!", "An unexpected error occurred.");
    });
}

function changeCriteriaGroupStatus(criteriaGroupId, status) {
  fetch(
    "assets/content/lms-management/certificate center/criteria_group/update_criteria_group_status.php",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: criteriaGroupId, is_active: status }),
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        OpenAlert("success", "Success!", data.message); // Show success popup
        ViewCriteriaGroups(); // Reload the list to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message); // Show error popup
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert("error", "Error!", "An unexpected error occurred.");
    });
}

function changeCriteriaStatus(criteriaId, status) {
  fetch(
    "assets/content/lms-management/certificate center/criteria/update_criteria_status.php",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id: criteriaId, is_active: status }),
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        OpenAlert("success", "Success!", data.message); // Show success popup
        ViewCriteriaList(); // Reload the list to reflect changes
      } else {
        OpenAlert("error", "Error!", data.message); // Show error popup
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert("error", "Error!", "An unexpected error occurred.");
    });
}
