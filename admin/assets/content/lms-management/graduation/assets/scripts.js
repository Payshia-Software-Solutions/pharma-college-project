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
    // Cache form values
    const packageName = document.getElementById("package_name").value.trim();
    const price = document.getElementById("price").value;
    const parentSeatCount = document.getElementById("parent_seat_count").value;
    const garland = document.getElementById("garland").checked ? 1 : 0;
    const graduationCloth = document.getElementById("graduation_cloth").checked ? 1 : 0;
    const photoPackage = document.getElementById("photo_package").value;

    // Validation helper function
    const validateField = (value, message) => {
        if (!value || isNaN(value) || parseFloat(value) <= 0) {
            OpenAlert("error", message, "");
            return false;
        }
        return true;
    };

    // Validate fields
    if (!packageName) {
        OpenAlert("error", "Package Name is required", "");
        return;
    }
    if (!validateField(price, "Please enter a valid price")) return;
    if (!validateField(parentSeatCount, "Please enter a valid parent seat count")) return;
    if (!validateField(photoPackage, "Please enter a valid photo package count")) return;

    showOverlay();

    // Prepare data
    const data = {
        package_name: packageName,
        price: parseFloat(price),
        parent_seat_count: parseInt(parentSeatCount),
        garland,
        graduation_cloth: graduationCloth,
        photo_package: parseInt(photoPackage),
    };

    // Determine the method (POST or PUT)
    const method = packageId === 0 ? "POST" : "PUT";
    const url = packageId === 0 
        ? "https://qa-api.pharmacollege.lk/packages" 
        : `https://qa-api.pharmacollege.lk/packages/${packageId}`;

    // Send data via the appropriate method (POST or PUT)
    fetch(url, {
        method: method,
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.status === (method === "POST" ? 201 : 200)) {
            // Parse the response as JSON if the status is successful
            return response.json();
        } else {
            // If the status is not successful, throw an error
            throw new Error(`Failed to save package. Status: ${response.status}`);
        }
    })
    .then(result => {
        hideOverlay();
        OpenPackageModal();
        ClosePopUP()

        // Assuming the server response contains a `message` field
        const successMessage = result.message || "Package saved successfully!";
        OpenAlert("success", "Done!", successMessage);
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

function InactivePackage(packageId) {
    // Confirm inactivation with SweetAlert
    Swal.fire({
        title: 'Are you sure?',
        text: "This will mark the package as inactive. You can reactivate it later.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, mark as inactive!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            showOverlay();  // Optionally show a loading spinner

            // Prepare data to update is_active to 0 (inactive)
            const data = {
                is_active: 0
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
                        'Your package has been marked as inactive.',
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
