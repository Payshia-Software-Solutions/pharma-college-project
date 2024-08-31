<?php
$sidebarHtml = renderTemplate('components/sideBar.php', [
    'currentPage' => $currentPage,
    'userLevel' => $userLevel,
]);
?>
<div class="col-md-3 d-none d-md-block">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="height: 100vh; position: sticky; top: 0;">

        <div class="d-flex align-items-center  w-100">
            <img class="w-25 rounded-5 me-2 shadow-sm" src="./lib/forum/assets/images/chatbot.gif" alt="No image">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4 fw-bold">Olie</span>
            </a>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <?= $sidebarHtml ?>
        </ul>
        <hr>
    </div>
</div>

<!-- Offcanvas Sidebar for Mobile -->
<div class="col-12 d-md-none">
    <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center  w-100">
                <img class="w-25 rounded-5 me-2 shadow-sm" src="./lib/forum/assets/images/chatbot.gif" alt="No image">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <span class="fs-4 fw-bold">Olie</span>
                </a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column mb-auto">
                <?= $sidebarHtml ?>
            </ul>
        </div>
    </div>
</div>