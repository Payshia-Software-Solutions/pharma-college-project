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

/* .content-card {
    height: 75%;
} */

/* .row-one {}

.row-two {}

.row-three {} */

.box {
    width: 200p;
    height: 200px;
    background-color: red;
}
</style>

<div class="container-fluid">
    <!-- back btn section -->
    <div class="row row-one">
        <div class="col-12 p-4 d-flex justify-content-start">
            <button onclick="" class="back-btn"><i class="fa-solid fa-less-than"></i></button>
        </div>
    </div>

    <!-- image section -->
    <div class="row row-two">
        <div class="col-12 p-0">
            <div class="img-card">
                <img src="./assets/images/doctor.png" alt="Doctor Image">
            </div>
        </div>
    </div>dsd

    <div class="row row-three">
        <div class="col-12 content-card">
            sd
            <div class="box">d</div>
        </div>
    </div>


</div>