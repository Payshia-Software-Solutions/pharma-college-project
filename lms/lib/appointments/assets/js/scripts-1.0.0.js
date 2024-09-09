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

function createBubble(parentElement, xPos, yPos, widthVal) {
  const bubble = document.createElement("div");
  bubble.className = "bubble";
  bubble.style.width = widthVal;
  bubble.style.height = bubble.style.width;

  bubble.style.left = xPos;
  bubble.style.top = yPos;

  parentElement.appendChild(bubble);
}

const InnerLoader = document.getElementById(
  "inner-preloader-content"
).innerHTML;

function OpenIndex() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/appointments/index.php",
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

function GetStared() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/appointments/views/appointment-page.php",
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

function GetAppointment() {
  $("#root").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "lib/appointments/views/appointment-details.php",
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

function submitAppointment() {
  var form = document.getElementById("appointmentForm");

  if (form.checkValidity()) {
    var formData = new FormData(form);

    $.ajax({
      url: "lib/appointments/views/appointment-description.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        document.getElementById("responseContainer").innerHTML = data;
      },
      error: function (xhr, status, error) {
        showNotification("An error occurred: " + error, "error", "Ops!");
      },
    });
  } else {
    form.reportValidity();
    showNotification("Please fill out all required fields.", "error", "Ops!");
  }
}


// function SucceedMessage(formData) {
//   // Parse the JSON data
//   var data = JSON.parse(formData);

//   // Use the data as needed
//   console.log("Date: " + data.date);
//   console.log("Time: " + data.time);
//   console.log("Selected Option: " + data.selection);
//   console.log("Description: " + data.description);

//   // You can display a success message or perform other actions
//   alert("Booking successful! Date: " + data.date + ", Time: " + data.time);
// }




function SucceedMessage(formData) {
  var data1 = JSON.parse(formData);
  console.log(data1.date);
  console.log(data1.time);

  // Fetch all appointments to get the current count
  fetch('http://localhost/pharma-college-project/server/appointments/')
    .then(response => response.json())
    .then(appointments => {
      // Calculate the new appointment_id based on the count of existing records
      var newAppointmentId = (appointments.length + 1).toString();
      console.log("New appointment_id:", newAppointmentId);

      const offset = 5.5 * 60 * 60 * 1000; // Offset for UTC+5:30 in milliseconds
      const sriLankaTime = new Date(Date.now() + offset).toISOString().slice(0, 19).replace('T', ' ');

      // Prepare the data object to send
      var data = {
        appointment_id: newAppointmentId,
        student_number: LoggedUser, // Assuming LoggedUser is defined globally
        booking_date: data1.date,
        booked_time: data1.time,
        reason: data1.description,
        category: data1.selection,
        created_at: sriLankaTime,
        status: "1",
        comment: "First appointment of the semester",
        is_active: true,
      };

      // Convert data object to JSON
      var jsonData = JSON.stringify(data);

      // Send the POST request using fetch
      fetch('http://localhost/pharma-college-project/server/appointments/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: jsonData,
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(responseData => {
          $("#root").html(InnerLoader);

          function fetch_data() {
            $.ajax({
              url: "lib/appointments/views/succeedmassage.php",
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
        })
        .catch(error => {
          document.getElementById("responseContainer").innerHTML = '<p class="alert alert-danger">Failed to create appointment: ' + error.message + '</p>';
        });
    })
    .catch(error => {
      document.getElementById("responseContainer").innerHTML = '<p class="alert alert-danger">Failed to fetch appointments: ' + error.message + '</p>';
    });
}

function selectCategory() {
  OpenPopup()
  document.getElementById('pop-content').innerHTML = InnerLoader

  function fetch_data() {
    showOverlay()
    $.ajax({
      url: 'lib/appointments/views/category.php',
      method: 'POST',
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        company_id: company_id,
      },
      success: function (data) {
        $('#pop-content').html(data)
        hideOverlay()
      }
    })
  }

  fetch_data()
}




