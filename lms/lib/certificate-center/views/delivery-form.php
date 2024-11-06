<h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Delivery Form</h1>
<form>
    <div class="mb-3">
        <label for="certificateName" class="form-label">Certificate Name</label>
        <input disable type="text" class="form-control" placeholder="Advanced Certificate">
    </div>
    <div class="mb-3">
        <label for="studentName" class="form-label">Student Name</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label for="mobile" class="form-label">Mobile Number</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="payment" class="form-label">Payment</label>
        <input type="text" class="form-control" placeholder='LKR 5500.00'>
    </div>
    <div class="div text-end">
        <button onclick="orderConfirm()" type="button" class="btn btn-primary">Confirm Order</button>
    </div>
</form>