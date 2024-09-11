<?php
$doctors = [
    [
        'name' => 'Dr. John Doe',
        'specialist' => 'Tooth Dentist',
        'experience' => '5 years of experience',
        'availability' => '09:00 AM Tomorrow',
        'status_percentage' => '74%',
        'stories' => '78 Stories',
        'image' => './assets/images/doctor.png'
    ],
    [
        'name' => 'Dr. Jane Smith',
        'specialist' => 'Heart Specialist',
        'experience' => '10 years of experience',
        'availability' => '02:00 PM Tomorrow',
        'status_percentage' => '85%',
        'stories' => '60 Stories',
        'image' => './assets/images/doctor.png'
    ],
    [
        'name' => 'Dr. Alan Brown',
        'specialist' => 'General Physician',
        'experience' => '8 years of experience',
        'availability' => '11:00 AM Tomorrow',
        'status_percentage' => '90%',
        'stories' => '95 Stories',
        'image' => './assets/images/doctor.png'
    ]
];
?>


<style>
.back-btn {
    background-color: transparent;
    border: 0;
    color: #333333;
    width: 18px;
    height: 8px;
}

.card {
    border-raduis: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 90%;
    /* height: 160px; */
}

.doc-img {
    width: 95px;
    height: 90px;
    border-radius: 4px;
}

.doc-name {
    font-family: 'Rubik', sans-serif;
    font-weight: 500;
    font-size: 18px;
    color: #333333;

}

.specialist {
    font-family: 'PT Sans', sans-serif;
    font-weight: 400;
    font-size: 13px;
    color: #0EBE7F;
}

.experience {
    font-family: 'Rubik', sans-serif;
    font-weight: 300;
    font-size: 12px;
    color: #677294;
}

.status-container {
    display: flex;
    align-items: center;
}

.status-dot {
    width: 10px;
    height: 10px;
    background-color: #0EBE7F;
    /* Green color */
    border-radius: 50%;
    margin-right: 8px;
}

.status-text {
    font-family: 'Rubik', sans-serif;
    font-size: 11px;
    font-weight: 300;
    color: #677294;
}

.available {
    font-family: 'Rubik', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #0EBE7F;

}

.available-time {
    font-family: 'Rubik', sans-serif;
    font-size: 12px;
    font-weight: 300;
    color: #677294;

}

.book-btn {
    width: 116px;
    height: 35px;
    background-color: #0EBE7F;
    color: #FFFFFF;
    border: 1px solid #0EBE7F;
    border-radius: 4px;
    /* padding: 10px 20px 10px 20px; */
    font-size: 15px;
    font-weight: 600;
}

.fix-bottom {
    height: 50px;
}
</style>

<div class="container-fluid">
    <!-- back btn section -->
    <div class="row row-one mb-3" onclick="goToAppointments()">
        <div class="col-12 p-4 d-flex justify-content-start">
            <button onclick="" class="back-btn"><i class="fa-solid fa-less-than"></i></button>
        </div>
    </div>

    <!-- image section -->
    <div class="row row-two">
        <div class="col-12 p-0">
            <!-- card start -->
            <?php foreach ($doctors as $doctor): ?>
            <div class="col mb-3 card p-3 mx-auto">

                <!-- row one Start -->
                <div class="row">
                    <div class="col-4">
                        <img class="img-fluid doc-img" src="<?= $doctor['image']; ?>" alt="Doctor Image">
                    </div>
                    <div class="col">
                        <div class="row">

                            <div class="col-9">
                                <h2 class="doc-name pb-0 mb-0"><?= $doctor['name']; ?></h2>
                                <span class="specialist mt-0 pt-0"><?= $doctor['specialist']; ?></span>
                                <p class="experience"><?= $doctor['experience']; ?></p>

                                <div class="row">
                                    <div class="col-3 d-flex justify-content-start">
                                        <div class="status-container">
                                            <div class="status-dot"></div>
                                            <div class="status-text"><?= $doctor['status_percentage']; ?></div>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-start">
                                        <div class="status-container">
                                            <div class="status-dot"></div>
                                            <div class="status-text"><?= $doctor['stories']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row one end -->

                <!-- Row Two start -->
                <div class="row mt-4 d-flex justify-content-between">
                    <div class="col">
                        <h6 class="available">Available</h6>
                        <span class="available-time"><?= $doctor['availability']; ?></span>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button class="book-btn" onclick="GotoBookingConfirmPage()">Book
                            Now</button>
                    </div>
                </div>
                <!-- row two end  -->

            </div>
            <!-- card end -->
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Fix-bottom should be after the foreach loop ends -->
    <div class="fix-bottom"></div>