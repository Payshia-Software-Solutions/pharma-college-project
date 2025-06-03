var UserLevel = document.getElementById("UserLevel").value;
var LoggedUser = document.getElementById("LoggedUser").value;
var company_id = document.getElementById("company_id").value;

$(document).ready(function () {
  OpenIndex();
});

function OpenIndex() {
  var userTheme = $("#userTheme").val();
  document.getElementById("index-content").innerHTML = InnerLoader;
  ClosePopUP();

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/graduation/index.php",
      method: "POST",
      data: {
        userTheme: userTheme,
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function OpenDownloadFile() {
  var userTheme = $("#userTheme").val();
  document.getElementById("index-content").innerHTML = InnerLoader;
  ClosePopUP();

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/graduation/convocation-order-download.php",
      method: "POST",
      data: {
        userTheme: userTheme,
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
      },
      success: function (data) {
        $("#index-content").html(data);
      },
    });
  }
  fetch_data();
}

function OpenPackageModal() {
  var userTheme = $("#userTheme").val();
  OpenPopupRight();
  $("#loading-popup-right").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/graduation/side-modals/package-modal.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        userTheme: userTheme,
        company_id: company_id,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
    });
  }
  fetch_data();
}

function OpenInactivePackageModal() {
  var userTheme = $("#userTheme").val();
  OpenPopupRight();
  $("#loading-popup-right").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/graduation/side-modals/inactive-packages-modal.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        userTheme: userTheme,
        company_id: company_id,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
    });
  }
  fetch_data();
}

function OpenPackageForm(packageId = 0) {
  OpenPopup();
  document.getElementById("loading-popup").innerHTML = InnerLoader;

  function fetch_data() {
    $.ajax({
      url: "./assets/content/lms-management/graduation/popup-modals/package-form.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        packageId: packageId,
      },
      success: function (data) {
        $("#loading-popup").html(data);
      },
    });
  }
  fetch_data();
}

function SavePackage(packageId) {
  const packageName = document.getElementById("package_name").value.trim();
  const price = document.getElementById("price").value;
  const parentSeatCount = document.getElementById("parent_seat_count").value;
  const garland = document.getElementById("garland").checked ? 1 : 0;
  const graduationCloth = document.getElementById("graduation_cloth").checked
    ? 1
    : 0;
  const photoPackage = document.getElementById("photo_package").value;
  const coverImageInput = document.getElementById("cover_image"); // NEW
  const selectedCourses = Array.from(
    document.querySelectorAll("input[name='courses[]']:checked")
  )
    .map((input) => input.value)
    .join(",");

  const validateField = (value, message) => {
    if (!value || isNaN(value) || parseFloat(value) <= 0) {
      OpenAlert("error", message, "");
      return false;
    }
    return true;
  };

  if (!packageName) {
    OpenAlert("error", "Package Name is required", "");
    return;
  }
  if (!validateField(price, "Please enter a valid price")) return;
  if (!validateField(parentSeatCount, "Please enter a valid parent seat count"))
    return;

  showOverlay();

  // 📦 Prepare FormData for file + fields
  const formData = new FormData();
  formData.append("package_name", packageName);
  formData.append("price", parseFloat(price));
  formData.append("parent_seat_count", parseInt(parentSeatCount));
  formData.append("garland", garland);
  formData.append("graduation_cloth", graduationCloth);
  formData.append("photo_package", parseInt(photoPackage));
  formData.append("courses", selectedCourses);

  // 📸 Append cover image if selected
  if (coverImageInput.files.length > 0) {
    formData.append("cover_image", coverImageInput.files[0]);
  }

  const method = packageId === 0 ? "POST" : "POST"; // Use POST even for update when using FormData
  const url =
    packageId === 0
      ? "https://qa-api.pharmacollege.lk/packages"
      : `https://qa-api.pharmacollege.lk/packages/${packageId}`;

  fetch(url, {
    method: method,
    body: formData,
  })
    .then((response) => {
      if (response.status === 200 || response.status === 201) {
        return response.json();
      } else {
        throw new Error(`Failed to save package. Status: ${response.status}`);
      }
    })
    .then((result) => {
      hideOverlay();
      OpenPackageModal();
      ClosePopUP();
      OpenAlert(
        "success",
        "Done!",
        result.message || "Package saved successfully!"
      );
    })
    .catch((error) => {
      hideOverlay();
      OpenAlert("error", "Error saving package", error.message);
    });
}

function DeletePackage(packageId) {
  // Confirm deletion with SweetAlert
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      showOverlay(); // Optionally show a loading spinner

      // Send DELETE request to API
      fetch(`https://qa-api.pharmacollege.lk/packages/${packageId}`, {
        method: "DELETE",
      })
        .then((response) => {
          if (response.status === 200) {
            // Successfully deleted
            Swal.fire("Deleted!", "Your package has been deleted.", "success");

            OpenPackageModal();
            // You can refresh the package list or update the UI here
            // Optionally hide any relevant modal or refresh the package list
          } else {
            // If deletion fails
            throw new Error(
              `Failed to delete package. Status: ${response.status}`
            );
          }
        })
        .catch((error) => {
          Swal.fire("Error!", `An error occurred: ${error.message}`, "error");
        })
        .finally(() => {
          hideOverlay(); // Hide loading spinner (if any)
        });
    } else {
      // Action canceled
      Swal.fire("Cancelled", "Your package is safe :)", "info");
    }
  });
}

function ChangePackageStatus(packageId, packageStatus = 1) {
  var statusText = "inactive";
  if (packageStatus === 1) {
    statusText = "active";
  }

  Swal.fire({
    title: "Are you sure?",
    text:
      "This will mark the package as " +
      statusText +
      ". You can reactivate it later.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, mark as " + statusText + "!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      showOverlay();

      // 📦 Prepare FormData instead of JSON
      const formData = new FormData();
      formData.append("is_active", packageStatus);

      fetch(`https://qa-api.pharmacollege.lk/packages/${packageId}`, {
        method: "POST", // 🔥 Changed to POST
        body: formData,
      })
        .then((response) => {
          if (response.status === 200 || response.status === 201) {
            Swal.fire(
              "Done!",
              "Your package has been marked as " + statusText + ".",
              "success"
            );
            OpenPackageModal();
          } else {
            throw new Error(
              `Failed to update package. Status: ${response.status}`
            );
          }
        })
        .catch((error) => {
          Swal.fire("Error!", `An error occurred: ${error.message}`, "error");
        })
        .finally(() => {
          hideOverlay();
        });
    } else {
      Swal.fire("Cancelled", "Your package is still active :)", "info");
    }
  });
}

function OpenBooking(referenceNumber) {
  var userTheme = $("#userTheme").val();
  OpenPopupRight();
  $("#loading-popup-right").html(InnerLoader);

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/graduation/side-modals/booking-modal.php",
      method: "POST",
      data: {
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
        userTheme: userTheme,
        company_id: company_id,
        referenceNumber: referenceNumber,
      },
      success: function (data) {
        $("#loading-popup-right").html(data);
      },
    });
  }
  fetch_data();
}

function UpdateConvocationPayment(referenceNumber) {
  const paymentAmountInput = document.getElementById("paid_amount");
  const paymentAmount = Number(paymentAmountInput.value);
  const paymentStatus = "Paid";

  // ✅ Input Validation
  if (!paymentStatus || paymentStatus.trim() === "") {
    Swal.fire("Validation Error", "Payment status cannot be empty.", "warning");
    return;
  }

  if (!paymentAmount || isNaN(paymentAmount) || Number(paymentAmount) <= 0) {
    Swal.fire(
      "Validation Error",
      "Payment amount must be a number greater than 0.",
      "warning"
    );
    return;
  }
  Swal.fire({
    title: "Are you sure?",
    text: `This will mark the payment as ${paymentStatus}.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, update it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      showOverlay();

      const payload = {
        payment_status: paymentStatus,
        payment_amount: paymentAmount,
        created_by: LoggedUser,
      };

      fetch(
        `https://qa-api.pharmacollege.lk/convocation-registrations/payment/${referenceNumber}`,
        {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(payload),
        }
      )
        .then((response) => {
          if (response.ok) {
            Swal.fire(
              "Updated!",
              "The payment information has been successfully updated.",
              "success"
            );
            // You can add a callback function here, e.g., refresh list
          } else {
            throw new Error(
              `Failed to update payment. Status: ${response.status}`
            );
          }
        })
        .catch((error) => {
          Swal.fire("Error!", `An error occurred: ${error.message}`, "error");
        })
        .finally(() => {
          hideOverlay();
        });
    } else {
      Swal.fire("Cancelled", "The payment update was cancelled.", "info");
    }
  });
}

function OpenCourierList() {
  var userTheme = $("#userTheme").val();
  document.getElementById("page-table").innerHTML = InnerLoader;
  ClosePopUP();

  function fetch_data() {
    $.ajax({
      url: "assets/content/lms-management/graduation/courier-list.php",
      method: "POST",
      data: {
        userTheme: userTheme,
        LoggedUser: LoggedUser,
        UserLevel: UserLevel,
      },
      success: function (data) {
        $("#page-table").html(data);
      },
    });
  }
  fetch_data();
}

function changeBookingSession(bookingId, newSession) {
  let sessionText = newSession === 1 ? "Session 1" : "Session 2";

  Swal.fire({
    title: "Are you sure?",
    text: `You are about to change the session to ${sessionText}.`,
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Yes, change it!",
    cancelButtonText: "No, keep current",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      showOverlay(); // Optional: your custom loading overlay

      const formData = new FormData();
      formData.append("session", newSession);

      fetch(
        `https://qa-api.pharmacollege.lk/convocation-registrations/${bookingId}/update-session`,
        {
          method: "POST", // or PUT if your API expects that
          body: formData,
        }
      )
        .then((response) => {
          if (response.ok) {
            Swal.fire(
              "Updated!",
              `The session has been changed to ${sessionText}.`,
              "success"
            );
            // Optional: reload or refresh data
            // location.reload();
          } else {
            throw new Error(
              `Failed to update session. Status: ${response.status}`
            );
          }
        })
        .catch((error) => {
          Swal.fire("Error!", `An error occurred: ${error.message}`, "error");
        })
        .finally(() => {
          hideOverlay(); // Optional
        });
    } else {
      Swal.fire("Cancelled", "No changes were made.", "info");
    }
  });
}

function InactivePayment(recordId) {
  Swal.fire({
    title: "Are you sure?",
    text: "This will mark the payment as inactive. You can reactivate it later.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, mark as inactive!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      showOverlay();

      fetch(
        `https://qa-api.pharmacollege.lk/tc-payments/inactive/${recordId}/`,
        {
          method: "POST",
        }
      )
        .then((response) => {
          if (response.ok) {
            Swal.fire(
              "Done!",
              "The payment has been marked as inactive.",
              "success"
            );
            OpenCourierList();
          } else {
            throw new Error(
              `Failed to update payment. Status: ${response.status}`
            );
          }
        })
        .catch((error) => {
          Swal.fire("Error!", `An error occurred: ${error.message}`, "error");
        })
        .finally(() => {
          hideOverlay();
        });
    } else {
      Swal.fire("Cancelled", "The payment is still active :)", "info");
    }
  });
}
