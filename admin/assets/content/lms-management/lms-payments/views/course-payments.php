<?php

$LoggedUser = $_POST['LoggedUser'];
// $CourseCode = $_POST['CourseCode'];

?>

<div class="row g-3">
    <div class="col-12">
        <h5 class="table-title mb-4">course - 2002 |
            Winpharma Payments</h5>
        <div class="row g-2 mb-4">
            <div class="col-6 col-md-2">
                <div class="card bg-black text-white clickable"
                    onclick="GetWinpharmaSubmissions('default course', 'All')">

                    <div class="card-body">
                        <p class="mb-0 text-white">All</p>
                        <h1>5785</h1>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <div class="card bg-warning text-white clickable"
                    onclick="GetWinpharmaSubmissions('default corese', 'Pending')">

                    <div class="card-body">
                        <p class="mb-0 text-white">Pending</p>
                        <h1>889</h1>
                    </div>
                </div>
            </div>



        </div>
        <div class="card shadow-lg">
            <div class="card-body">

                <p class="mb-0 mt-2">No 55 submissions found.</p>

                <div class="table-responsive">
                    <table class="table table-hovered table-striped" id="submission-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Upload Date</th>
                                <th>Action</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Reference Number</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>01</td>
                                <td>Dasun Kumara</td>
                                <td>2024-10-15</td>
                                <td class="text-center">
                                    <button onclick="OpenPaymentView()" class="btn btn-primary btn-sm" type="button"><i
                                            class="fa-solid fa-eye"></i>
                                        View</button>

                                </td>
                                <td>Course Fee</td>
                                <td><span class="badge bg-warning">Pending</span>
                                </td>
                                <td>Ref-4879663587</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<button onclick="click01()" type="button" class="btn btn-outline-primary">
    Button
</button>


<script>
$(document).ready(function() {
    $('#submission-table').DataTable({
        order: false,
        pageLength: 20
    });

});
</script>