<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule</title>
  <link rel="stylesheet" href="./assets/css/shedule-page.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
<body>

  <div class="container-fluid">
    <!-- Header -->
     <div class="row header-card">
     
     
       
       
       <!-- Search Bar -->
       <h1 class="header-title pt-3 pb-3">Schedule</h1>
       <div class="search-bar">
         <svg class="search-icon" width="37" height="38" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
         <path fill-rule="evenodd" clip-rule="evenodd" d="M27.5955 25.3021L31.4758 29.1812C32.3943 30.0994 32.3943 31.588 31.4758 32.5062C30.5574 33.4244 29.0683 33.4244 28.1499 32.5062L24.2696 28.6271C23.9634 28.321 23.9634 27.8248 24.2696 27.5187L26.4869 25.3021C26.793 24.996 27.2894 24.996 27.5955 25.3021ZM16.6679 5.55515C23.1623 5.55515 28.427 10.8183 28.427 17.3108C28.427 23.8033 23.1623 29.0664 16.6679 29.0664C10.1736 29.0664 4.90884 23.8033 4.90884 17.3108C4.90884 10.8183 10.1736 5.55515 16.6679 5.55515ZM16.6679 8.68999C11.9054 8.68999 8.0446 12.5497 8.0446 17.3108C8.0446 22.0719 11.9054 25.9316 16.6679 25.9316C21.4305 25.9316 25.2913 22.0719 25.2913 17.3108C25.2913 12.5497 21.4305 8.68999 16.6679 8.68999ZM19.5211 10.0094C21.7615 10.8849 23.4883 12.7532 24.1791 15.0612C24.4274 15.8905 23.9561 16.764 23.1266 17.0121C22.3347 17.249 21.5026 16.8305 21.2127 16.0707L21.175 15.9599C20.7613 14.5778 19.7226 13.4539 18.3795 12.9291C17.573 12.6139 17.1748 11.7048 17.49 10.8986C17.8053 10.0923 18.7146 9.69422 19.5211 10.0094Z" fill="#1E1F2E"/>
         </svg>

              <input type="text" class="form-control" placeholder="Search">
          </div>
          
        </div>
      
    <!-- Doctor List -->
    <div class="card mb-3">
      <div class="row no-gutters">
        <div class="col-3">
          <img src="https://via.placeholder.com/80" alt="Doctor Image" class="img-fluid">
        </div>
        <div class="col-7">
          <div class="card-body">
            <h5 class="card-title">Dr. Hamza Tariq</h5>
            <p class="card-text text-muted">Senior Surgeon</p>
            <p class="card-text">
              <small class="text-muted"><i class="far fa-clock"></i> 10:30 AM - 3:30 PM</small><br>
              <small class="text-muted">Fee: $12</small>
            </p>
          </div>
        </div>
        <div class="col-2 d-flex align-items-center justify-content-center">
          <button class="btn btn-success">
            <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
    
    

    <!-- Add Doctor Button -->
    <button class="btn add-button">
      <i class="fas fa-plus"></i>
    </button>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
