<div class="loading-popup-content">
    <div class="row">
        <div class="col-10">
            <h3 class="site-title mb-0">New Game</h3>
        </div>

        <div class="col-2 text-end">
            <button class="btn btn-sm btn-light rounded-5" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-12">
            <div class="border-bottom border-3 my-2"></div>
        </div>
        <div class="col-12">
            <form action="" method="post" id="gameForm">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="gameTitle" class="form-label">Game Title</label>
                        <input type="text" class="form-control" id="gameTitle" name="gameTitle" required>
                    </div>
                    <div class="col-12">
                        <label for="gameDescription" class="form-label">Game Description</label>
                        <textarea class="form-control" id="gameDescription" name="gameDescription" required></textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn btn-light" onclick="ClosePopUP()"><i class="fa-solid fa-xmark"></i> Cancel</button>
                        <button class="btn btn-dark" type="button" onclick="saveGame()"><i class="fa-solid fa-plus"></i> Add Game</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>