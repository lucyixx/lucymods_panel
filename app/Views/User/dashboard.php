<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stats shadow bg-base-100 border border-base-300">
        <div class="stat">
            <div class="stat-title">Revenue</div>
            <div class="stat-value text-success text-2xl">$<?= !isset($user) ?: $user->saldo ?></div>
        </div>
    </div>
    <div class="stats shadow bg-base-100 border border-base-300">
        <div class="stat">
            <div class="stat-title">Sales</div>
            <div class="stat-value text-2xl">3435</div>
        </div>
    </div>
    <div class="stats shadow bg-base-100 border border-base-300">
        <div class="stat">
            <div class="stat-title">Templates</div>
            <div class="stat-value text-primary text-2xl">349</div>
        </div>
    </div>
    <div class="stats shadow bg-base-100 border border-base-300">
        <div class="stat">
            <div class="stat-title">Clients</div>
            <div class="stat-value text-error text-2xl">2986</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="lg:col-span-2">
        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Registration History</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <tbody>
                            <?php foreach ($history as $h) : ?>
                                <?php $in = explode("|", $h->info) ?>
                                <tr>
                                    <td><span class="text-xs opacity-60">#3812<?= $h->id_history ?></span></td>
                                    <td><?= $in[0] ?></td>
                                    <td><span class="text-xs whitespace-nowrap"><?= $in[1] ?>**</span></td>
                                    <td><span class="text-xs whitespace-nowrap"><?= $in[2] ?>Days</span></td>
                                    <td><span class="text-xs text-primary whitespace-nowrap"><?= $in[3] ?> Devices</span></td>
                                    <td><span class="text-xs opacity-60 whitespace-nowrap"><?= $time::parse($h->created_at)->humanize() ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-4">
        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Top Up Price</h2>
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
                            </tr>
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

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Information</h2>
                <ul class="list bg-base-100 rounded-box">
                    <li class="list-row flex items-center justify-between">
                        <span class="opacity-70">Roles</span>
                        <span class="badge badge-primary"><?= !isset($user) ?: getLevel($user->level) ?></span>
                    </li>
                    <li class="list-row flex items-center justify-between">
                        <span class="opacity-70">Asset</span>
                        <span>$<?= !isset($user) ?: $user->saldo ?></span>
                    </li>
                    <li class="list-row flex items-center justify-between">
                        <span class="opacity-70">Login Time</span>
                        <span><?= !isset($user) ?: $time::parse(session()->time_since)->humanize() ?></span>
                    </li>
                    <li class="list-row flex items-center justify-between">
                        <span class="opacity-70">Auto Logout</span>
                        <span class="text-error"><?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
