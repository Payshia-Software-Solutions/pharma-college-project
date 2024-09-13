<style>
.back-btn {
    background-color: transparent;
    border: 0;
    color: #333333;
    width: 18px;
    height: 8px;
}

.img-card {
    width: 100%;
    height: 390px;
    /* Set the height to 35% of the viewport height */
    margin: 0;
    overflow: hidden;
    /* Ensure that the image doesn't overflow the container */
}

.img-card img {
    width: 100%;
    height: 100%;
    /* Make the image take full width and height of the container */
    object-fit: cover;
    /* Ensures the image scales nicely within the container */
    display: block;
}

.content-card {
    height: 75%;
    background-color: white;
    border-radius: 40px 40px 0 0;
}

.row-one {
    position: absolute;
    z-index: 2;
}

.row-two {
    width: 100%;
    position: absolute;
    z-index: 1;
}

.row-three {
    padding: 0;
    width: 100vW;
    margin-top: 200px;
    z-index: 3;
    position: relative;
}

.box {
    width: 100%;
    height: 200px;
    background-color: red;
}

.category-btn {
    width: 334px;
    height: 52px;
    border: 1px solid #CBCBCB;
    border-radius: 10px;
    padding: 13px 20px 13px 20px;
    /* background-color: #CBCBCB; */
    /* color: #0EBE7F; */
    font-size: 17px;
    font-weight: 600;
}

.reason-input {
    width: 331px;
    height: 52px;
    border: 1px solid #CBCBCB;
    border-radius: 10px;
    padding: 13px 20px 13px 20px;
    background-color: #f8f9fa;
    /* color: #0EBE7F; */
    weight: 500;
    font-size: 13px;
}

.reason-input:focus {
    outline: none;
}

.date-input {
    width: 331px;
    height: 74px;
    border: 1px solid #CBCBCB;
    border-radius: 10px;
    padding: 13px 20px 13px 20px;
    background-color: #f8f9fa;
    /* color: #0EBE7F; */
    weight: 500;
    font-size: 13px;
}

.sub-heading {
    font-weight: 600;
    font-size: 15px;
    color: #1E1F2E;

}

.time-div {
    width: 335px;
    height: 77px;
    /* background-color: red; */
}

.time {
    cursor: pointer;
    width: 76px;
    height: 28px;
    border: 1px solid #CBCBCB;
    border-radius: 11px;
    padding: 3px 6px 3px 6px;
    weight: 600;
    font-size: 13px;
}

.active-time {
    background-color: #EDAE73;
    font-weight: bold;
    color: #FFFFFF;
}

.next-btn {
    width: 334px;
    height: 52px;
    border: 1px solid #CBCBCB;
    border-radius: 10px;
    padding: 13px 20px 13px 20px;
    background-color: #0EBE7F;
    color: #ffffff;
    font-size: 17px;
    font-weight: 600;
}

.fix-bottom {
    height: 50px;
}
</style>

<div class="container-fluid">
    <!-- back btn section -->
    <div class="row row-one" onclick="goToAppointments()">
        <div class="col-12 p-4 d-flex justify-content-start">
            <button onclick="" class="back-btn"><i class="fa-solid fa-less-than"></i></button>
        </div>
    </div>

    <!-- image section -->
    <div class="row row-two">
        <div class="col-12 p-0">
            <div class="img-card">
                <img class="img-fluid" src="./assets/images/doctor.png" alt="Doctor Image">
            </div>
        </div>
    </div>dsd

    <div class="row row-three">
        <div class="col-12 content-card p-0">
            <div class="card-body">
                <div class="mt-5">
                    <div class="col-12 text-center">
                        <button onclick="selectCategory()" class="btn btn-light category-btn">Category</button>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <input class="reason-input text-center" type="text" placeholder="Type Your Reason Here..." />
                    </div>
                </div>
                <div class="mt-5">
                    <div class="col-12 text-center">
                        <input class="date-input" type="date">

                    </div>
                </div>

                <div class="mt-5 p-0 mx-auto">
                    <div class="col-12 time-div mx-auto">
                        <h4 class="sub-heading">Available Time</h4>

                        <div class="rwo mt-4">
                            <div class="col d-flex justify-content-between">
                                <span class="time" onclick="selectTime(this)">09:00 AM</span>
                                <span class="time" onclick="selectTime(this)">10:00 AM</span>
                                <span class="time" onclick="selectTime(this)">11:00 AM</span>
                                <span class="time" onclick="selectTime(this)">12:00 PM</span>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="col-12 text-center">
                        <button onclick="getoBookingPage()" class="next-btn">Next</button>
                    </div>
                </div>

                <!-- <div class="box">d</div> -->
            </div>
        </div>


    </div>

    <div class="fix-bottom"></div>