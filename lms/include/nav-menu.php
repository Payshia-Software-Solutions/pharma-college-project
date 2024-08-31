<nav id="navbar" class="d-none d-md-block navbar navbar-expand-lg bg-light rounded-2 shadow-sm sticky-md-top mb-">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="./assets/images/logo.png" alt="Logo" height="50" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Payments</a>
                </li>

                <li class="nav-item" href="#">
                    <!-- Dark Mode Toggle Button -->
                    <a class="nav-link" onclick="toggleDarkMode()" href="#">Change Theme</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <button onclick="redirectToURL('logout')" class="btn btn-outline-success" type="button">Sign Out</button>
            </form>
        </div>
    </div>
</nav>