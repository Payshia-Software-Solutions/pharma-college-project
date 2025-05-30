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
      url: "lib/convocation/index.php",
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
