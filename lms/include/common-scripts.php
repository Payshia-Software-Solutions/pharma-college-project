<!-- <div id="button-overlay"></div>
<div class="card rounded-5" id="install-button" style="display: none;">
    <div class="card-body text-center">
        <img src="./assets/images/logo-round.png" class="w-25" />
        <h3>Ceylon Pharma College</h3>
        <button class="btn btn-primary">Install App</button>
        <button class="btn btn-primary" id="open-pwa-button">Open App</button>
    </div>

</div> -->

<script>
    document.getElementById('open-pwa-button').addEventListener('click', (e) => {
        window.location.href = window.location.origin;
    });
</script>
<script src="./assets/js/main.js"></script>
<script src="./vendor/jquery/jquery-3.7.1.min.js"></script>
<script src="./node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="./vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script src="./assets/js/script-1.0.0.js"></script>
<script src="./node_modules/dropify/dist/js/dropify.min.js"></script>
<script src="./vendor/select2/dist/js/select2.min.js"></script>
<script src="./vendor/summernote/summernote-lite.min.js"></script>