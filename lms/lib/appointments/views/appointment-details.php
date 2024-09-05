<?php
$appointmentCategories = [
  1 => 'Course Details',
  2 => 'Games'
];
?>

<style>
  .cover-image {
    height: 400px;
    background-position: top;
    background-image: url('./assets/images/doctor.jpg');
    background-position: center;
    background-repeat: no-repeat;
  }

  .time-button {
    background-color: #f8f9fa; /* Default Bootstrap background color */
    border: 1px solid #ced4da; /* Default border color */
    color: #000; /* Default text color */
  }

  .time-button.selected {
    background-color: orange; /* Change background color to orange */
    color: #fff; /* Change text color to white */
  }

  /* Media query for mobile devices */
  @media (max-width: 600px) {
    .cover-image {
      height: 300px; /* Adjust the height for mobile devices */
    }
  }
</style>

<div class="h-25 position-relative">
  <!-- Cover Image and Button -->
  <div class="cover-image m-0 object-fit-cover position-relative">
    <button onclick="GetStared()" class="m-2 border-0 bg-transparent position-absolute start-0">
      <i class="bi bi-arrow-left"></i>
    </button>
  </div>

  <!-- Response Container -->
  <div id="responseContainer" class="container mt-3">
    <div class="row justify-content-center">
      <!-- Card for Form -->
      <div class="col-12 col-md-10 col-xl-8">
        <div class="card">
          <div class="card-body">
            <!-- Form Start -->
            <form id="appointmentForm" action="" method="post">
              <!-- Category Select -->
              <div class="form-group">
                <label for="selectionBox">Select a Category:</label>
                <select id="selectionBox" class="form-control" name="selectionBox" required>
                  <?php foreach ($appointmentCategories as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Description Textarea -->
              <textarea id="description3" class="form-control bg-dark-subtle mt-3 p-0" name="description3" required placeholder="Type Your Reason Here"></textarea>

              <!-- Date Picker -->
              <div class="input-group mt-3 fs-6 bg-secondary-subtle rounded">
                <div class="input-group-text">
                  <i class="bi bi-calendar2-week-fill fs-5"></i>
                </div>
                <input type="date" class="form-control bg-body-secondary p-3" id="appointmentDate" name="appointmentDate" required>
                <span class="input-group-text bg-transparent border-0">
                  <button type="button" class="btn p-0" onclick="clearDate()">
                    <i class="bi bi-x-circle-fill"></i>
                  </button>
                </span>
              </div>

              <!-- Available Time Section -->
              <h6 class="mt-4 fw-bold">Available Time</h6>
              <div class="form-group">
                   
                  <div class="d-flex flex-wrap gap-2">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="time3" id="time3-09" value="09:00 AM" required>
                      <label class="form-check-label" for="time3-09">09:00 AM</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="time3" id="time3-0930" value="09:30 AM" required>
                      <label class="form-check-label" for="time3-0930">09:30 AM</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="time3" id="time3-10" value="10:00 AM" required>
                      <label class="form-check-label" for="time3-10">10:00 AM</label>
                    </div>
                  </div>
                </div>


              <!-- Submit Button -->
              <button type="button" class="btn btn-success col-12 mt-3" onclick="submitAppointment()">Next</button>
            </form>
            <!-- Form End -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function clearDate() {
      document.getElementById('appointmentDate').value = '';
  }

  document.querySelectorAll('.time-button').forEach(function(button) {
    button.addEventListener('click', function() {
      // Remove 'selected' class from all buttons
      document.querySelectorAll('.time-button').forEach(function(btn) {
        btn.classList.remove('selected');
      });

      // Add 'selected' class to the clicked button
      this.classList.add('selected');
    });
  });

  $(document).ready(function() {
    $('#selectionBox').select2({
      placeholder: 'Select an option',
      allowClear: true
    });
  });
</script>
