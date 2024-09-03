<?php
$appointmentCategories = [
  1=>[1=>'Couse Details'],
  2=>[2=>'Games']];
     
 ?>


<div class="row mt-2 mb-5">
  <div class="col-12 mt-3">
    <div class="card mt-5 border-0">
      <div class="card-body">
        <div class="quiz-img-box sha">
          <img src="./lib/appointments/assets/images/appointment.gif" class="quiz-img shadow rounded-4">
        </div>
        <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Appointments</h1>
      </div>
    </div>
  </div>
</div>

<div id="responseContainer">



  <div class="col-12 text-end">
    <button class="btn btn-warning" onclick="Getappointment()">Reload</button>
  </div>

  <div class="card  ">
    <form id="appointmentForm" action="" method="post">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="date3">Date:</label>
            <input type="date" id="date3" name="date3" class="form-control mb-2" required>
          </div>
          <div class="col-md-6">
            <label for="time3">Time:</label>
            <input type="time" id="time3" name="time3" class="form-control mb-2" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <label for="selectionBox">Select an Option:</label>
            <select id="selectionBox" class="form-control mb-2" name="selectionBox" required>
              <?php  foreach($appointmentCategories as  $key =>$selectedArray):?>
              <option value="<?= $key ?>"><?= $selectedArray[$key] ?></option>
              <?php endforeach  ?>
            </select>
          </div>
        </div>

        <label for="description3">Description:</label>
        <textarea id="description3" class="form-control mb-2" rows="3" name="description3" required></textarea>
      </div>
      <div class="card-footer text-end">
        <button type="button" class="btn btn-primary" onclick="submitAppointment()">Submit</button>
      </div>
    </form>
  </div>

</div>
<script>
  $(document).ready(function() {
    $('#selectionBox').select2({
      placeholder: 'Select an option',
      allowClear: true
    });
  });
</script>