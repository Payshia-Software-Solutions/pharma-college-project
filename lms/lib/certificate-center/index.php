<?php

$certificateList = [
    [
        'id' => 1,
        'name' => 'Advanced Certificate',
        'bg_color' => '#797bba',
        'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
    ],
    [
        'id' => 1,
        'name' => 'Workshop Certificate',
        'bg_color' => '#8498ba',
        'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
    ],
    [
        'id' => 1,
        'name' => 'Canada Certificate',
        'bg_color' => '#7aeb89',
        'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
    ],
    [
        'id' => 1,
        'name' => 'Pharma Hunter Certificate',
        'bg_color' => '#b6d9bb',
        'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
    ],
    [
        'id' => 1,
        'name' => 'HP Drugs Certificate',
        'bg_color' => '#000000',
        'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
    ],
];

$orderedCertificate = [
         [
             'id' => 1,
             'name' => 'Advanced Certificate',
             'created_at' => '2022-01-01',
             'bg_color' => '#797bba',
             'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
             'status' => 'In Printing'
         ],
         [
             'id' => 1,
             'name' => 'Workshop Certificate',
             'created_at' => '2022-01-25',
             'bg_color' => '#8498ba',
             'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
             'status' => 'In Delivery'
         ],
         [
             'id' => 1,
             'name' => 'Canada Certificate',
             'created_at' => '2022-01-25',
             'bg_color' => '#7aeb89',
             'icon' => '<i class="fa-solid fa-graduation-cap"></i>',
             'status' => 'Delivered'
         ]
         
];

?>

<div class="row mt-2 mb-5">
    <div class="col-12 mt-3">
        <div class="card shadow mt-5 border-0">
            <div class="card-body">
                <div class="certificate-img-box sha">
                    <img src="./lib/certificate-center/assets/images/certificate.gif"
                        class="certificate-img shadow rounded-4">
                </div>
                <h1 class="card-title text-center mt-2 fw-bold bg-light p-3 rounded-5 mb-0">Certificate Center</h1>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">


    <?php if ($orderedCertificate) : ?>
    <div class="col-md-6">
        <?php else : ?>
        <div class="col-12"></div>
        <?php endif ?>
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body">


                <div class="text-center">
                    <h3 class="p-2 fw-bold">Order a Certificate</h3>
                </div>

                <div class="row">

                    <?php foreach ($certificateList as $certificate) : ?>
                    <div class="col-md-6 d-flex mt-2">
                        <div class="card rounded-1 clickable knowledge-card flex-fill">
                            <div class="card-body">
                                <h4 class="mb-0 knowledge-title"
                                    style="--bg-color: <?= htmlspecialchars($certificate['bg_color']) ?>;">>
                                    <span class="rectangle"></span>
                                    <?= $certificate['icon'] ?>
                                </h4>
                                <p class="mb-0 text-muted"><?= $certificate['name'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>

            </div>
        </div>

        <div class="border-bottom my-4"></div>
    </div>

    <!-- only show if had order -->
    <?php if ($orderedCertificate) : ?>
    <div class="col">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body">

                <div class="text-center">
                    <h3 class="p-2 fw-bold">Ongoing Orders</h3>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Certificate Name</th>
                                    <!-- <th scope="col">Order Date</th> -->
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orderedCertificate as $certificate) : ?>
                                <tr>
                                    <td><?= $certificate['name'] ?></td>

                                    <td>
                                        <button onclick="statusView()" class="btn btn-primary btn-sm" type="button"><i
                                                class="fa-solid fa-eye"></i>
                                            View</button>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="border-bottom my-4"></div>
    </div>
    <?php endif ?>
</div>