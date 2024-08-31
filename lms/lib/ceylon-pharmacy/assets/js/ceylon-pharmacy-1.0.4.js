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
      url: "lib/ceylon-pharmacy/index.php",
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

function OpenPrescription(prescriptionID, imageID) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/patient-prescription.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
        imageID: imageID,
      },
      success: function (data) {
        $("#index-content").html(data);
        LoadPrescription(prescriptionID);
      },
    });
  }
  fetch_data();
}

function AddAnswers(answerID) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/admin-add-answer.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        answerID: answerID,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function LoadPrescription(prescriptionID) {
  $("#prescription").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/requests/prescription.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
      },
      success: function (data) {
        $("#prescription").html(data);
      },
    });
  }
  fetch_data();
}

function GetPatient(prescriptionID) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/get-patient.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function OpenEnvelope(prescriptionID, coverID) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/fill-envelope.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
        coverID: coverID,
      },
      success: function (data) {
        $("#index-content").html(data);
        LoadPrescription(prescriptionID);
      },
    });
  }
  fetch_data();
}

function SelectEnvelopeContent(contentType) {
  OpenPopup();
  document.getElementById("pop-content").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/envelope/envelope-content.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        contentType: contentType,
      },
      success: function (data) {
        $("#pop-content").html(data);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function ViewPrescription(prescriptionID) {
  OpenPopup();
  document.getElementById("pop-content").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/requests/prescription.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
      },
      success: function (data) {
        $("#pop-content").html(data);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function SetElementValue(targetID, Value) {
  document.getElementById(targetID).value = Value;
  hideOverlay();
  ClosePopUP();
}

function SaveEnvelopAnswerAdmin(prescriptionID) {
  var form = document.getElementById("envelope-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);

    function fetch_data() {
      showOverlay();
      $.ajax({
        url: "lib/ceylon-pharmacy/requests/save-envelop-admin.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            GetPatient(prescriptionID);
            showNotification(result, "success", "Done!");
          } else {
            var result = response.message;
            showNotification(result, "error", "Oops!");
          }
          hideOverlay();
        },
      });
    }
    fetch_data();
  } else {
    result = "Please Filled out All * marked Fields.";
    showNotification(result, "error", "Oops!");
  }
}

function SaveEnvelopAnswer(prescriptionID) {
  var form = document.getElementById("envelope-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);

    function fetch_data() {
      showOverlay();
      $.ajax({
        url: "lib/ceylon-pharmacy/requests/save-envelope-answer.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            var incorrect_values = response.incorrect_values;
            var answer_status = response.answer_status;
          } else {
            var result = response.message;
            var incorrect_values = response.incorrect_values;
            var answer_status = response.answer_status;
          }
          if (answer_status == "Correct") {
            GetPatient(prescriptionID);
            showNotification(answer_status, "success", "Done!");
          } else {
            FinishEnvelop(incorrect_values);
            showNotification(answer_status, "error", "Oops!");
          }
          hideOverlay();
        },
      });
    }
    fetch_data();
  } else {
    result = "Please Filled out All * marked Fields.";
    showNotification(result, "error", "Oops!");
  }
}

function FinishEnvelop(incorrect_values) {
  OpenPopup();
  document.getElementById("pop-content").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/envelope/envelop-finish.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        incorrect_values: incorrect_values,
      },
      success: function (data) {
        $("#pop-content").html(data);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function OpenCounselling(prescriptionID, coverID) {
  $("#index-content").html(InnerLoader);

  addedInstructions = [];

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/counselling-unit.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
        coverID: coverID,
      },
      success: function (data) {
        $("#index-content").html(data);
        LoadPrescription(prescriptionID);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function ClearInstructions(prescriptionID, coverID) {
  $.ajax({
    url: "lib/ceylon-pharmacy/requests/clear-saved.php",
    method: "POST",
    data: {
      LoggedUser: LoggedUser,
      prescriptionID: prescriptionID,
      coverID: coverID,
    },
    success: function (data) {
      var response = JSON.parse(data);
      if (response.status === "success") {
        var result = response.message;
        showNotification(result, "success", "Done!");
        OpenCounselling(prescriptionID, coverID);
      } else {
        var result = response.message;
        showNotification(result, "error", "Oops!");
      }
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
}

function addInstructionAdmin() {
  var error_msg;
  var selectedOption = $("#instructionSelect option:selected");
  var selectedInstructionId = selectedOption.val();
  var selectedInstructionText = selectedOption.text();

  // Extract text after the hyphen
  var textAfterHyphen = selectedInstructionText.split("-")[1].trim();

  // Check if the instruction is not already added and the limit is not reached
  if (selectedInstructionId && textAfterHyphen) {
    // Add the instruction ID to the list
    addedInstructions.push(selectedInstructionId);

    // Add a new row to the table with separate columns for ID and Instructions, highlighting if it's correct
    var newRow =
      "<tr><td>" +
      selectedInstructionId +
      '</td><td style="color: green;">' +
      textAfterHyphen +
      "</td></tr>";
    $("#instructionTable tbody").append(newRow);
  } else {
    error_msg = "Instruction already added or not selected.";
  }
}

function ValidateInstructions(prescriptionID, coverID) {
  // Initialize the addedInstructions array
  var addedInstructions = [];

  // Iterate through each row in the table
  $("#instructionTable tbody tr").each(function () {
    // Find the first td (ID) in the current row
    var instructionId = $(this).find("td:first").text();

    // Add the ID to the addedInstructions array
    addedInstructions.push(instructionId);
  });
  if (addedInstructions.length == maxInstructionsCount) {
    $.ajax({
      url: "lib/ceylon-pharmacy/requests/validate-counselling.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        prescriptionID: prescriptionID,
        coverID: coverID,
        addedInstructions: addedInstructions,
      },
      success: function (data) {
        var response = JSON.parse(data);
        if (response.status === "success") {
          var result = response.message;
          showNotification(result, "success", "Done!");
          GetPatient(prescriptionID);
        } else {
          var result = response.message;
          showNotification(result, "error", "Oops!");
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  } else {
    var result = maxInstructionsCount + " Instruction(s) must be given!";
    showNotification(result, "error", "Oops!");
  }
}

function SaveInstructions(prescriptionID, coverID) {
  // Initialize the addedInstructions array
  var addedInstructions = [];

  // Iterate through each row in the table
  $("#instructionTable tbody tr").each(function () {
    // Find the first td (ID) in the current row
    var instructionId = $(this).find("td:first").text();

    // Add the ID to the addedInstructions array
    addedInstructions.push(instructionId);
  });

  $.ajax({
    url: "lib/ceylon-pharmacy/requests/save-counselling.php",
    method: "POST",
    data: {
      LoggedUser: LoggedUser,
      prescriptionID: prescriptionID,
      coverID: coverID,
      addedInstructions: addedInstructions,
    },
    success: function (data) {
      var response = JSON.parse(data);
      if (response.status === "success") {
        var result = response.message;
        showNotification(result, "success", "Done!");
        GetPatient(prescriptionID);
      } else {
        var result = response.message;
        showNotification(result, "error", "Oops!");
      }
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
}

function SaveAnswerAdmin(answerID) {
  var form = document.getElementById("answer-form");

  if (form.checkValidity()) {
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("answerID", answerID);

    function fetch_data() {
      showOverlay();
      $.ajax({
        url: "lib/ceylon-pharmacy/requests/save-answer-admin.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            showNotification(result, "success", "Done!");
            AddAnswers();
          } else {
            var result = response.message;
            showNotification(result, "error", "Oops!");
          }
          hideOverlay();
        },
      });
    }
    fetch_data();
  } else {
    result = "Please Filled out All * marked Fields.";
    showNotification(result, "error", "Oops!");
  }
}

function OpenPayment(prescriptionID) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/get-payment.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
      },
      success: function (data) {
        $("#index-content").html(data);
        LoadPrescription(prescriptionID);
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function FinishPatient(prescriptionID) {
  var paymentValue = document.getElementById("payment-value").value;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/requests/finish-patient.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
        paymentValue: paymentValue,
      },
      success: function (data) {
        var response = JSON.parse(data);
        if (response.status === "success") {
          var result = response.message;
          showNotification(result, "success", "Done!");
          OpenIndex();
        } else {
          var result = response.message;
          showNotification(result, "error", "Oops!");
        }
        hideOverlay();
      },
    });
  }

  fetch_data();
}

function NewPatient(prescriptionID) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/new-patient.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function RecoverPatients(courseCode) {
  $("#index-content").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ceylon-pharmacy/recover-patient.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        courseCode: courseCode,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function DeletePatientEntry(prescriptionID) {
  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ceylon-pharmacy/requests/recover-patient.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
        prescriptionID: prescriptionID,
      },
      success: function (data) {
        var response = JSON.parse(data);
        if (response.status === "success") {
          var result = response.message;
          showNotification(result, "success", "Done!");
          OpenIndex();
        } else {
          var result = response.message;
          showNotification(result, "success", "Done!");
        }
        hideOverlay();
      },
    });
  }

  Swal.fire({
    title: "Are you sure?",
    text: "Do You want to Recover!",
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
