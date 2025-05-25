let SERVER_URL = "";

var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var company_id = document.getElementById("company_id").value;
var default_location = document.getElementById("default_location").value;
var default_location_name = document.getElementById(
  "default_location_name"
).value;

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

function OpenIndex() {
  function fetch_data() {
    document.getElementById("index-content").innerHTML = InnerLoader;
    $.ajax({
      url: "./assets/content/lms-management/word-pallet/index.php", // Use SERVER_URL here if needed
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

function AddWord(wordId) {
  var userTheme = $("#userTheme").val();
  OpenPopup();
  $("#loading-popup").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "./assets/content/lms-management/word-pallet/add-word-modal.php", // Use SERVER_URL here too
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        wordId: wordId,
        userTheme: userTheme,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function SaveWord(wordId) {
  showOverlay();
  const form = document.forms["word-form"];
  const formData = new FormData(form);

  const status = document.getElementById("word_status").checked
    ? "Active"
    : "In-Active";
  formData.set("word_status", status);

  formData.append("created_by", LoggedUser);
  formData.append(
    "created_at",
    new Date().toISOString().slice(0, 19).replace("T", " ")
  );

  const isUpdate = wordId && wordId !== "null" && wordId !== "";

  fetch(SERVER_URL + "/word-list" + (isUpdate ? "/" + wordId : ""), {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        OpenAlert("success", "Done!", data.message);
        OpenIndex();
        ClosePopUP(0);
      } else {
        OpenAlert("error", "Error!", data.message || "Something went wrong!");
      }
      hideOverlay();
      if (!isUpdate) form.reset();
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert("error", "Error!", "Request failed");
      hideOverlay();
    });
}

function DeleteWord(wordId) {
  if (!confirm("Are you sure you want to delete this word?")) return;

  fetch(`${SERVER_URL}/word-list/${wordId}`, {
    method: "DELETE",
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        OpenAlert("success", "Deleted!", data.message);
        OpenIndex(); // Refresh the list after deletion
      } else {
        OpenAlert("error", "Error!", data.message || "Failed to delete!");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      OpenAlert("error", "Error!", "Request failed");
    });
}
