<style>
    .carousel-item {
        height: 40vh;
        background-position: center;
        background-size: cover;
    }


    /* Styles for screens up to 600px wide */
    @media (max-width: 600px) {
        .carousel-item {
            height: 25vh;
        }
    }
</style>

<div id="carouselExampleCaptions" class="carousel slide mb-3 carousel-fade" data-bs-ride="carousel">

   <div class="carousel-inner rounded-2 rounded-md-4 shadow-sm">
        <div class="carousel-item active" style="background-image: url('./lib/home/assets/images/slider/cover5.jpg');" data-bs-interval="5000">
            <div class="carousel-caption d-none d-md-block">
                <h3 class="mb-0">Pharma Achievers</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('./lib/home/assets/images/slider/cover4.jpg');" data-bs-interval="5000">
            <div class="carousel-caption d-none d-md-block">
                <h3 class="mb-0">Pharma Achievers</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('./lib/home/assets/images/slider/cover2.jpg');" data-bs-interval="5000">
            <div class="carousel-caption d-none d-md-block">
                <h3 class="mb-0">Pharma Achievers</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('./lib/home/assets/images/slider/cover1.jpg');" data-bs-interval="5000">
            <div class="carousel-caption d-none d-md-block">
                <h3 class="mb-0">Pharma Achievers</h3>
                <p>2023</p>
            </div>
        </div>
        <div class="carousel-item" style="background-image: url('./lib/home/assets/images/slider/cover3.jpg');" data-bs-interval="5000">
            <div class="carousel-caption d-none d-md-block">
                <h3 class="mb-0">Pharma Achievers</h3>
                <p>2023</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>