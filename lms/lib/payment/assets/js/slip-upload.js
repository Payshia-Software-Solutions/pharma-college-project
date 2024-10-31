function submitSlip() {
    var form = document.getElementById("slipPaymentForm");

    if (form.checkValidity()) {
        OpenPopup()
        document.getElementById('pop-content').innerHTML = InnerLoader

        var formData = new FormData(form);

        formData.append("LoggedUser", LoggedUser);
        formData.append("CourseCode", CourseCode);

        $.ajax({
            url: "lib/payment/controllers/submit-slip.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status === "success") {
                    var result = response.message;
                    showNotification(result, "success", "Done!");
                    OpenIndex();
                    ClosePopUP();
                } else {
                    var result = response.message;
                    showNotification(result, "error", "Done!");
                    ClosePopUP()
                }
            }
        });
    } else {
        form.reportValidity();
        showNotification("Please fill out all required fields.", "error", "Ops!");
    }
}

