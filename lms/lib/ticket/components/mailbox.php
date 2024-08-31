<div class="col-12 mt-4">
    <div class="row">
        <div class="col-12 col-md-3 bg-light p-4">
            <!-- Profile Info -->
            <div class="row">
                <div class="col-4">
                    <div class="profile-image mail-box-profile-img" style="background-image : url('./assets/images/user.png');"></div>
                </div>
                <div class="col-8">
                    <h4 class="mb-0 fw-bold"><?= $userInfo['first_name'] ?> <?= $userInfo['last_name'] ?></h4>
                    <p class="mb-0"><?= $loggedUser ?></p>
                </div>
            </div>

            <!-- Button Set -->
            <div class="row mt-5">
                <div class="col-12">
                    <button class="btn btn-success shadow-sm w-100 rounded-3 mb-2 text-start" onclick="CreateSupportTicket()">
                        <i class="fa-solid fa-plus "></i>
                        <span class="mx-2">Create Ticket</span>
                    </button>

                    <button onclick="GetMailBox(1)" class="btn btn-light bg-white shadow-sm w-100 rounded-3 mb-2 text-start">
                        <i class="fa-solid fa-inbox "></i>
                        <span class="mx-2">Tickets</span>
                    </button>

                    <button onclick="GetMailBox(2)" class="btn btn-light bg-white shadow-sm w-100 rounded-3 mb-2 text-start">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                        <span class="mx-2">Closed Tickets</span>
                    </button>

                    <button onclick="GetMailBox(3)" class="btn btn-light bg-white shadow-sm w-100 rounded-3 mb-2 text-start">
                        <i class="fa-solid fa-trash"></i>
                        <span class="mx-2">Deleted Tickets</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Mail List -->
        <div class="col-12 col-md-3 bg-white-cream" id="mailList"></div>
        <div class="col-12 col-md-6" id="mainBody">

        </div>

    </div>
</div>