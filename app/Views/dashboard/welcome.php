<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Welcome, <?php echo ucfirst(strtolower(session()->get('name'))); ?>! </h3>
                <h6 class="font-weight-normal mb-0">Have a great day! <span class="text-primary"></span></h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
                <img src="assets/images/dashboard/people.svg" alt="people">
                <div class="weather-info">
                    <div class="d-flex">
                        <div>
                            <h2 class="mb-0 font-weight-normal"><i class="mdi mdi-account-card-details"></i><?php echo session()->get('id_user') ?></h2>
                        </div>
                        <div class="ml-2">
                            <h4 class="location font-weight-bold"><?php echo strtolower(session()->get('nama_booth')) ?></h4>
                            <h6 class="font-weight-normal"><?php echo strtolower(session()->get('name')) ?></h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Today’s Transactions</p>
                        <p class="mb-2 font-weight-bold"> <?= $todays_transaction; ?></p>
                        <!-- <p>yesterday's transaction was</p> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Today's Income </p>
                        <p class="fs mb-2 font-weight-bold">Rp. <?= $todays_income['harga_total'] ? $todays_income['harga_total'] : '0'; ?></p>
                        <!-- <p>2.00% up/down</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Yesterday's Income</p>
                        <p class="font-weight-bold mb-2">Rp. <?= $yesterday_income['harga_total'] ? $yesterday_income['harga_total'] : '0'; ?></p>
                        <!-- <p>2.00% </p> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Weekly Transactions</p>
                        <p class="font-weight-bold"><?= $weekly_receipts?> Receipts</p>
                        <!-- <p>you served 0 people</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card position-relative">
            <div class="card-body">
                <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                                    <div class="ml-xl-4 mt-3">
                                        <p class="card-title">What is</p>
                                        <h1 class="text-primary">MyBooth?</h1>
                                        <h3 class="font-weight-500 mb-xl-4 text-primary">a simple app for booth managing</h3>
                                        <p class="mb-2 mb-xl-0">is a convenient web-based app to manage transaction that happens in booths or stands. It provides help to operate your business and
                                            now you can ring up sales, manage inventory, manage employee, and reporting just in one app.</p>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                                    <div class="ml-xl-4 mt-3">

                                    </div>
                                </div>
                                <!-- <div class="col-md-12 col-xl-9">
                                    <div class="row">
                                        <div class="col-md-6 border-right">
                                            <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                <table class="table table-borderless report-table">
                                                    <tr>
                                                        <td class="text-muted">Illinois</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">713</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Washington</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">583</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Mississippi</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">924</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">California</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">664</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Maryland</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">560</h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Alaska</td>
                                                        <td class="w-100 px-0">
                                                            <div class="progress progress-md mx-4">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-weight-bold mb-0">793</h5>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <canvas id="north-america-chart"></canvas>
                                            <div id="north-america-legend"></div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                                    <div class="ml-xl-4 mt-3">
                                        <p class="card-title">What is</p>
                                        <h1 class="text-primary">MyBooth?</h1>
                                        <h3 class="font-weight-500 mb-xl-4 text-primary">a simple app for booth managing</h3>
                                        <p class="mb-2 mb-xl-0">is a convenient web-based app to manage transaction that happens in booths or stands. It provides help to operate your business and
                                            now you can ring up sales, manage inventory, manage employee, and reporting just in one app.</p>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-6 d-flex flex-column justify-content-start">
                                    <div class="ml-xl-4 mt-3">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>