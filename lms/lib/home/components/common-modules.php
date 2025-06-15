text/x-generic common-modules.php ( ASCII text )
<div class="row">
    <div class="col-12">
        <h4 class="section-topic">Common Modules</h4>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('course')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/course/assets/images/video-conference.gif" class="game-icon">
                        <h4 class="card-title">Recordings</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('assignments')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/assignments/assets/images/homework.gif" class="game-icon">
                        <h4 class="card-title">Assignments</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('quiz')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/question.gif" class="game-icon">
                        <h4 class="card-title">Quiz</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php
                        $ProgressValue = number_format(GetOverallGrade($loggedUser, $courseCode));
                        if ($ProgressValue < 0) {
                            $ProgressValue = 0;
                        }
                        ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('course')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/passed.gif" class="game-icon">
                        <h4 class="card-title">Exam</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('payment-portal')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/payment/assets/images/money.gif" class="game-icon">
                        <h4 class="card-title">Payments</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('student-ticket')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/home/assets/images/helpdesk.gif" class="game-icon">
                        <h4 class="card-title">Tickets</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('appointment')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/appointments/assets/images/appointment.gif" class="game-icon">
                        <h4 class="card-title">Appointments</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('community')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/forum/assets/images/chatbot.gif" class="game-icon">
                        <h4 class="card-title">Olie</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 mb-2 d-flex">
        <div class="card game-card shadow flex-fill" onclick="redirectToURL('convocation??forceActive=true')">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="./lib/certificate-center/assets/images/certificate.gif" class="game-icon">
                        <h4 class="card-title">Convocation/Certificate</h4>
                    </div>

                    <div class="col-12 mt-2">
                        <?php $ProgressValue = 0; ?>
                        <div class="progress" role="progressbar" aria-label="Example with label"
                            aria-valuenow="<?= $ProgressValue ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: <?= $ProgressValue ?>%"><?= $ProgressValue ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>