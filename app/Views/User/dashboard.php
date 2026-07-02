<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<style>
    .bi-currency-bitcoin::before,
    .bi-cart-check-fill::before,
    .bi-wallet-fill::before,
    .bi-people-fill::before {
        font-size: 3rem;
        font-weight: bolder !important;
    }
</style>

<div class="row mb-3">
    <div class="col-lg-3 col-md-6">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 d-flex">
                <div class="me-5">
                    <i class="bi bi-currency-bitcoin text-success"></i>
                </div>
                <div class="d-flex flex-column ml-2">
                    <strong>$<?= !isset($user) ?: $user->saldo ?></strong>
                    <small class="text-muted">Revenue</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 d-flex">
                <div class="me-5">
                    <i class="bi bi-cart-check-fill" style="color: #ab8ce4;"></i>
                </div>
                <div class="d-flex flex-column ml-2">
                    <strong>3435</strong>
                    <small class="text-muted">Sales</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 d-flex">
                <div class="me-5">
                    <i class="bi bi-wallet-fill text-primary"></i>
                </div>
                <div class="d-flex flex-column ml-2">
                    <strong>349</strong>
                    <small class="text-muted">Templates</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 d-flex">
                <div class="me-5">
                    <i class="bi bi-people-fill text-danger"></i>
                </div>
                <div class="d-flex flex-column ml-2">
                    <strong>2986</strong>
                    <small class="text-muted">Clients</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-12">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <div class="card-title m-0"><span>Registration History</span></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-hover text-center">
                        <tbody>
                            <?php foreach ($history as $h) : ?>
                                <?php $in = explode("|", $h->info) ?>
                                <tr>
                                    <td><span class="small">#3812<?= $h->id_history ?></span></td>
                                    <td><?= $in[0]?></td>
                                    <td><span class="small text-nowrap"><?=$in[1]?>**</span></td>
                                    <td><span class="small text-nowrap"><?=$in[2]?>Days</span></td>
                                    <td><span class="small text-primary text-nowrap"><?= $in[3] ?> Devices</span></td>
                                    <td><i class="small d-inline text-muted text-nowrap"><?= $time::parse($h->created_at)->humanize() ?></i></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <div class="card-title m-0"><span>Top Up Price</span></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                            <tr>
                                <th>Balance Panel</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Balance $10</td>
                                <td>100K Or $7</td>
                            <tr>
                                <td>Balance $15</td>
                                <td>150K Or $10</td>
                            </tr>
                            <tr>
                                <td>Balance $25</td>
                                <td>270K Or $18</td>
                            </tr>
                            <tr>
                                <td>Balance $50</td>
                                <td>590K Or $40</td>
                            </tr>
                            <tr>
                                <td>Balance $100</td>
                                <td>1.260K Or $85</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="card-title m-0"><span>Information</span></div>
            </div>
            <div class="card-body">
                <ul class="list-group list-hover mb-3">
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Roles
                        <span class="small">
                            <?= !isset($user) ?: getLevel($user->level) ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Asset
                        <span class="small">$<?= !isset($user) ?: $user->saldo ?></span>
                    </li>
                </ul>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Login Time
                        <span class="small">
                            <?= !isset($user) ?: $time::parse(session()->time_since)->humanize() ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Auto Logout
                        <span class="small text-danger">
                            <?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>