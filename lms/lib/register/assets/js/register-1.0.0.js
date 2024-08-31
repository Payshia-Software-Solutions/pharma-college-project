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
            url: 'lib/register/index.php',
            method: 'POST',
            data: {},
            success: function(data) {
                $('#root').html(data)
            }
        })
    }
    fetch_data()
}


function GetDistrict(city) {
    function fetch_data() {
        $.ajax({
            url: 'lib/register/requests/get-district.php',
            method: 'POST',
            data: { city: city },
            success: function(data) {
                document.getElementById("District").value = data;
                GetPostalCode(city);
            }
        })
    }
    fetch_data();
}

function GetPostalCode(city) {
    function fetch_data() {
        $.ajax({
            url: 'lib/register/requests/get-postal-code.php',
            method: 'POST',
            data: { city: city },
            success: function(data) {
                document.getElementById("postalCode").value = data;
            }
        })
    }
    fetch_data();
}