<div class="site-title">
    <?php $UserDetails =  GetUserDetails($link, $loggedUser); ?>
    <div class="row">
        <div class="col-8">
            <h2 class="greet-text">Hi <?= $UserDetails['first_name'] ?> <?= $UserDetails['last_name'] ?></h2>
            <p class="text-secondary">Let's Make this day Productive</p>
        </div>
        <div class="col-4 text-center">
            <div class="profile-image" style="background-image : url('./assets/images/user.png')"></div>
        </div>
    </div>
</div>