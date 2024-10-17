<?php

$LoggedUser = $_POST['LoggedUser'];
$CourseCode = $_POST['CourseCode'];

?>

<div class="row g-3">
    <div class="col-12">
        <h5 class="table-title mb-4">course - 2002 |
            Winpharma Submissions</h5>
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
                                <th>Index Number</th>
                                <th>Level</th>
                                <th>Action</th>
                                <th>Time</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Checked By</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>588</td>
                                <td>55</td>
                                <td>Level One</td>
                                <td class="text-center">
                                    <button onclick="OpenSubmission('55'), 'status')" class="btn btn-primary btn-sm"
                                        type="button"><i class="fa-solid fa-eye"></i>
                                        View</button>

                                </td>
                                <td>2254</td>
                                <td>55%</td>
                                <td><span class="badge bg-danger">Failed</span>
                                </td>
                                <td>Studnet</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('#submission-table').DataTable({
        order: false,
        pageLength: 20
    });

});
</script>