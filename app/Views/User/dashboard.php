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

<div class="flex flex-wrap mb-3 gap-4">
    <div class="w-full sm:w-1/2 lg:w-1/4">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 flex">
                <div class="mr-5">
                    <i class="bi bi-currency-bitcoin text-success"></i>
                </div>
                <div class="flex flex-col ml-2">
                    <strong>$<?= !isset($user) ?: $user->saldo ?></strong>
                    <small class="opacity-70">Revenue</small>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full sm:w-1/2 lg:w-1/4">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 flex">
                <div class="mr-5">
                    <i class="bi bi-cart-check-fill" style="color: #ab8ce4;"></i>
                </div>
                <div class="flex flex-col ml-2">
                    <strong>3435</strong>
                    <small class="opacity-70">Sales</small>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full sm:w-1/2 lg:w-1/4">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 flex">
                <div class="mr-5">
                    <i class="bi bi-wallet-fill text-primary"></i>
                </div>
                <div class="flex flex-col ml-2">
                    <strong>349</strong>
                    <small class="opacity-70">Templates</small>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full sm:w-1/2 lg:w-1/4">
        <div class="card mb-3 shadow-sm border-0">
            <div class="p-3 flex">
                <div class="mr-5">
                    <i class="bi bi-people-fill text-error"></i>
                </div>
                <div class="flex flex-col ml-2">
                    <strong>2986</strong>
                    <small class="opacity-70">Clients</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-wrap mb-3 gap-4">
    <div class="w-full">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <div class="w-full lg:w-2/3">
        <div class="card mb-3">
            <div class="border-b px-4 py-3 font-semibold">Registration History</div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-center">
                        <tbody>
                            <?php foreach ($history as $h) : ?>
                                <?php $in = explode("|", $h->info) ?>
                                <tr>
                                    <td><span class="text-sm">#3812<?= $h->id_history ?></span></td>
                                    <td><?= $in[0]?></td>
                                    <td><span class="text-sm text-nowrap"><?=$in[1]?>**</span></td>
                                    <td><span class="text-sm text-nowrap"><?=$in[2]?>Days</span></td>
                                    <td><span class="text-sm text-primary text-nowrap"><?= $in[3] ?> Devices</span></td>
                                    <td><i class="text-sm inline opacity-70 text-nowrap"><?= $time::parse($h->created_at)->humanize() ?></i></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/3">
        <div class="card mb-3">
            <div class="border-b px-4 py-3 font-semibold">Top Up Price</div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
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
            <div class="border-b px-4 py-3 font-semibold">Information</div>
            <div class="card-body">
                <ul class="mb-3">
                    <li class="flex justify-between items-center px-3 py-2 border-b border-base-300/20">
                        Roles
                        <span class="text-sm">
                            <?= !isset($user) ?: getLevel($user->level) ?>
                        </span>
                    </li>
                    <li class="flex justify-between items-center px-3 py-2">
                        Asset
                        <span class="text-sm">$<?= !isset($user) ?: $user->saldo ?></span>
                    </li>
                </ul>
                <ul>
                    <li class="flex justify-between items-center px-3 py-2 border-b border-base-300/20">
                        Login Time
                        <span class="text-sm">
                            <?= !isset($user) ?: $time::parse(session()->time_since)->humanize() ?>
                        </span>
                    </li>
                    <li class="flex justify-between items-center px-3 py-2">
                        Auto Logout
                        <span class="text-sm text-error">
                            <?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
