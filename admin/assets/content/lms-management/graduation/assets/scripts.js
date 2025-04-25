var UserLevel = document.getElementById('UserLevel').value
var LoggedUser = document.getElementById('LoggedUser').value
var company_id = document.getElementById('company_id').value

$(document).ready(function () {
    OpenIndex()
})

function OpenIndex() {
    var userTheme = $("#userTheme").val();
    document.getElementById('index-content').innerHTML = InnerLoader
    ClosePopUP()

    function fetch_data() {
        $.ajax({
            url: 'assets/content/lms-management/graduation/index.php',
            method: 'POST',
            data: {
                userTheme: userTheme,
                LoggedUser: LoggedUser,
                UserLevel: UserLevel
            },
            success: function (data) {
                $('#index-content').html(data)
            }
        })
    }
    fetch_data()
}

function OpenPackageModal() {
    var userTheme = $("#userTheme").val();
    OpenPopupRight();
    $("#loading-popup-right").html(InnerLoader);
  
    function fetch_data() {
      $.ajax({
        url: 'assets/content/lms-management/graduation/side-modals/package-modal.php',
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
        url: 'assets/content/lms-management/graduation/side-modals/inactive-packages-modal.php',
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
    const graduationCloth = document.getElementById("graduation_cloth").checked ? 1 : 0;
    const photoPackage = document.getElementById("photo_package").value;
    const coverImageInput = document.getElementById("cover_image"); // NEW
    const selectedCourses = Array.from(document.querySelectorAll("input[name='courses[]']:checked"))
        .map(input => input.value)
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
    if (!validateField(parentSeatCount, "Please enter a valid parent seat count")) return;
    if (!validateField(photoPackage, "Please enter a valid photo package count")) return;

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
    const url = packageId === 0
        ? "http://localhost/pharma-college-project/server/packages"
        : `http://localhost/pharma-college-project/server/packages/${packageId}`;

    fetch(url, {
        method: method,
        body: formData
    })
        .then(response => {
            if (response.status === 200 || response.status === 201) {
                return response.json();
            } else {
                throw new Error(`Failed to save package. Status: ${response.status}`);
            }
        })
        .then(result => {
            hideOverlay();
            OpenPackageModal();
            ClosePopUP();
            OpenAlert("success", "Done!", result.message || "Package saved successfully!");
        })
        .catch(error => {
            hideOverlay();
            OpenAlert("error", "Error saving package", error.message);
        });
}

    



function DeletePackage(packageId) {
    // Confirm deletion with SweetAlert
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            showOverlay();  // Optionally show a loading spinner

            // Send DELETE request to API
            fetch(`https://qa-api.pharmacollege.lk/packages/${packageId}`, {
                method: 'DELETE',
            })
            .then(response => {
                if (response.status === 200) {
                    // Successfully deleted
                    Swal.fire(
                        'Deleted!',
                        'Your package has been deleted.',
                        'success'
                    );
                    
                    OpenPackageModal();
                    // You can refresh the package list or update the UI here
                    // Optionally hide any relevant modal or refresh the package list
                } else {
                    // If deletion fails
                    throw new Error(`Failed to delete package. Status: ${response.status}`);
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error!',
                    `An error occurred: ${error.message}`,
                    'error'
                );
            })
            .finally(() => {
                hideOverlay();  // Hide loading spinner (if any)
            });
        } else {
            // Action canceled
            Swal.fire(
                'Cancelled',
                'Your package is safe :)',
                'info'
            );
        }
    });
}

function ChangePackageStatus(packageId, packageStatus = 1) {
    var statusText = 'inactive'
    if(packageStatus === 1 ){
        statusText = 'active'
    }
    // Confirm inactivation with SweetAlert
    Swal.fire({
        title: 'Are you sure?',
        text: "This will mark the package as "+statusText+". You can reactivate it later.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, mark as '+statusText+'!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            showOverlay();  // Optionally show a loading spinner

            // Prepare data to update is_active to 0 (inactive)
            const data = {
                is_active: packageStatus
            };

            // Send PUT request to update the package as inactive
            fetch(`https://qa-api.pharmacollege.lk/packages/${packageId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (response.status === 200) {
                    // Successfully updated the package status
                    Swal.fire(
                        'Inactive!',
                        'Your package has been marked as '+statusText+'.',
                        'success'
                    );
                    
                    OpenPackageModal();
                    // You can refresh the package list or update the UI here
                    // Optionally hide any relevant modal or refresh the package list
                } else {
                    // If inactivation fails
                    throw new Error(`Failed to update package. Status: ${response.status}`);
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error!',
                    `An error occurred: ${error.message}`,
                    'error'
                );
            })
            .finally(() => {
                hideOverlay();  // Hide loading spinner (if any)
            });
        } else {
            // Action canceled
            Swal.fire(
                'Cancelled',
                'Your package is still active :)',
                'info'
            );
        }
    });
}
