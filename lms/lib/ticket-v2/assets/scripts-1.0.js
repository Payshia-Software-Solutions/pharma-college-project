var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var UserLevel = document.getElementById("UserLevel").value;
var company_id = document.getElementById("company_id").value;
var defaultCourseCode = document.getElementById("defaultCourseCode").value;
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

// window.onbeforeunload = function () {
//   // Your custom code here
//   // This message will be displayed in a confirmation dialog
//   return "Are you sure you want to leave?";
// };

const InnerLoader = document.getElementById(
  "inner-preloader-content"
).innerHTML;

function OpenIndex() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/ticket-v2/index.php",
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

function OpenNewChat() {
  document.getElementById("pop-content").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ticket-v2/new-ticket.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultCourseCode: defaultCourseCode,
        company_id: company_id,
      },
      success: function (data) {
        $("#pop-content").html(data);
        hideOverlay();
        OpenPopup();
      },
    });
  }
  fetch_data();
}

function OpenTicket(ticketId) {
  document.getElementById("pop-content").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ticket-v2/open-ticket.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultCourseCode: defaultCourseCode,
        company_id: company_id,
        ticketId: ticketId,
      },
      success: function (data) {
        $("#pop-content").html(data);
        hideOverlay();
        OpenPopup();
      },
    });
  }
  fetch_data();
}

function OpenTicketReply(ticketId) {
  document.getElementById("pop-content").innerHTML = InnerLoader;

  function fetch_data() {
    showOverlay();
    $.ajax({
      url: "lib/ticket-v2/ticket-reply.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        defaultCourseCode: defaultCourseCode,
        company_id: company_id,
        ticketId: ticketId,
      },
      success: function (data) {
        $("#pop-content").html(data);
        hideOverlay();
        OpenPopup();
      },
    });
  }
  fetch_data();
}

function SaveTicket(ticketId = 0, isActive = 1) {
  var ticketText = tinymce.get("ticketText").getContent();
  var form = document.getElementById("ticket-form");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("defaultCourseCode", defaultCourseCode);
    formData.append("ticketId", ticketId);
    formData.append("isActive", isActive);
    formData.append("ticketText", ticketText);

    function fetch_data() {
      $.ajax({
        url: "lib/ticket-v2/requests/save-ticket.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            OpenIndex();
            ClosePopUP();
          } else {
            var result = response.message;
            showNotification(result, "error", "Ops!");
          }
          hideOverlay();
        },
      });
    }

    fetch_data();
  } else {
    form.reportValidity();
    result = "Please Filled out All * marked Fields.";
    showNotification(result, "error", "Ops!");
    hideOverlay();
  }
}

function SendReply(ticketId = 0, replyId = 0, isActive = 1) {
  var ticketText = tinymce.get("ticketReply").getContent();
  var form = document.getElementById("ticket-reply-form");

  if (form.checkValidity()) {
    showOverlay();
    var formData = new FormData(form);
    formData.append("LoggedUser", LoggedUser);
    formData.append("UserLevel", UserLevel);
    formData.append("company_id", company_id);
    formData.append("defaultCourseCode", defaultCourseCode);
    formData.append("ticketId", ticketId);
    formData.append("isActive", isActive);
    formData.append("ticketText", ticketText);
    formData.append("replyId", replyId);

    function fetch_data() {
      $.ajax({
        url: "lib/ticket-v2/requests/save-reply.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          var response = JSON.parse(data);
          if (response.status === "success") {
            var result = response.message;
            // showNotification(result, "success", "Done!");
            OpenTicket(ticketId);
          } else {
            var result = response.message;
            showNotification(result, "error", "Ops!");
            hideOverlay();
          }
        },
      });
    }

    fetch_data();
  } else {
    form.reportValidity();
    result = "Please Filled out All * marked Fields.";
    showNotification(result, "error", "Ops!");
    hideOverlay();
  }
}
