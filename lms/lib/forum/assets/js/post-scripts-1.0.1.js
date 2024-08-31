function NewThread(postId = 0) {
    OpenPopup()
    document.getElementById('pop-content').innerHTML = InnerLoader

    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/forum/components/newTopic.php',
            method: 'POST',
            data: {
                LoggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                postId: postId
            },
            success: function(data) {
                $('#pop-content').html(data)
                hideOverlay()
            }
        })
    }

    fetch_data()
}

function SaveTopic(postId = 0) {
    var form = document.getElementById("topic-form");
    var topicContent = $('#summernote').summernote('code');
    // Get form data
    if (form.checkValidity()) {
        showOverlay()
        var formData = new FormData(form);

        // Append drugs to form data
        formData.append('loggedUser', LoggedUser)
        formData.append('courseCode', CourseCode)
        formData.append('userLevel', UserLevel)
        formData.append('topicContent', topicContent)

        function fetch_data() {
            $.ajax({
                url: 'lib/forum/controllers/save-topic.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    var response = JSON.parse(data)
                    if (response.status === 'success') {
                        var result = response.message
                        showNotification(result, 'success', 'Done!')
                        OpenIndex()
                        ClosePopUP()
                    } else {
                        var result = response.message
                        showNotification(result, 'error', 'Ops!')
                    }
                    hideOverlay()
                }
            })
        }
        if (topicContent != "") {
            fetch_data()
        } else {
            result = 'Please Filled out All * marked Fields.'
            showNotification(result, 'error', 'Ops!')
            hideOverlay()
        }
    } else {
        form.reportValidity()
        result = 'Please Filled out All * marked Fields.'
        showNotification(result, 'error', 'Ops!')
        hideOverlay()
    }

}

function SavePostReply(postId) {
    var replyContent = $('#summernote').summernote('code');
    // Get form data
    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/forum/controllers/save-reply.php',
            method: 'POST',
            data: {
                loggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                postId: postId,
                replyContent: replyContent
            },
            success: function(data) {
                var response = JSON.parse(data)
                if (response.status === 'success') {
                    var result = response.message
                    showNotification(result, 'success', 'Done!')
                    OpenIndex()
                    ClosePopUP()
                } else {
                    var result = response.message
                    showNotification(result, 'error', 'Ops!')
                }
                hideOverlay()
            }
        })
    }
    if (replyContent != "") {
        fetch_data()
    } else {
        result = 'Please Filled out All * marked Fields.'
        showNotification(result, 'error', 'Ops!')
        hideOverlay()
    }


}

function ChangePostStatus(postId, updateStatus) {
    function fetch_data() {
        showOverlay()
        $.ajax({
            url: 'lib/forum/controllers/change-status.php',
            method: 'POST',
            data: {
                loggedUser: LoggedUser,
                UserLevel: UserLevel,
                company_id: company_id,
                postId: postId,
                updateStatus: updateStatus
            },
            success: function(data) {
                var response = JSON.parse(data)
                if (response.status === 'success') {
                    var result = response.message
                    showNotification(result, 'success', 'Done!')
                    OpenIndex()
                } else {
                    var result = response.message
                    showNotification(result, 'error', 'Ops!')
                }
                hideOverlay()
            }
        })
    }

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Update it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch_data()
        }
    });
}