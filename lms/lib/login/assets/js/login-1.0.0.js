$(document).ready(function() {
    OpenIndex()
})

// Prevent Refresh or Back Unexpectedly
// window.onbeforeunload = function () {
//   return 'Are you sure you want to leave?'
// }

const InnerLoader = document.getElementById('inner-preloader-content').innerHTML

function OpenIndex() {
    $('#root').html(InnerLoader)

    function fetch_data() {
        $.ajax({
            url: 'lib/login/index.php',
            method: 'POST',
            data: {},
            success: function(data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}