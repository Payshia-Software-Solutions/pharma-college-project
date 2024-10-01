<?php

$LoggedUser = $_POST['LoggedUser'];

?>


<div id="submission-list">

    <div class="row mt-5">

        <div class="col-md-3">
            <div class="card item-card">
                <div class="overlay-box">
                    <i class="fa-solid fa-users icon-card"></i>
                </div>
                <div class="card-body">
                    <p>Total Topics</p>
                    <h1>565</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card item-card">
                <div class="overlay-box">
                    <i class="fa-solid fa-user-shield icon-card"></i>
                </div>
                <div class="card-body">
                    <p>Total Answers</p>
                    <h1>55</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <h5 class="table-title mb-4">Students Answers Submissions</h5>
            <div class="row g-3">

                <div class="row g-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hovered table-striped" id="answer-table">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Total Answers</th>
                                                <th>Total Questions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>gdfg</td>
                                                <td>fgdfg</td>
                                                <td>fgdfgfd</td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#answer-table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
            // 'colvis'
        ],

    });

});
</script>