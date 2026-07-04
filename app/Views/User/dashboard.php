<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="stats stats-vertical sm:stats-horizontal bg-base-200 border border-base-300 shadow-none w-full mb-4">
    <div class="stat py-3">
        <div class="stat-title text-xs">Revenue</div>
        <div class="stat-value text-lg">$<?= !isset($user) ?: $user->saldo ?></div>
    </div>
    <div class="stat py-3">
        <div class="stat-title text-xs">Sales</div>
        <div class="stat-value text-lg">3,435</div>
    </div>
    <div class="stat py-3">
        <div class="stat-title text-xs">Templates</div>
        <div class="stat-value text-lg">349</div>
    </div>
    <div class="stat py-3">
        <div class="stat-title text-xs">Clients</div>
        <div class="stat-value text-lg">2,986</div>
    </div>
</div>

<div class="flex flex-wrap gap-4">
    <div class="w-full lg:w-2/3">
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-b border-base-300">
                    <h2 class="card-title text-base">Registration history</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-center">
                        <tbody>
                            <?php foreach ($history as $h) : ?>
                                <?php $in = explode("|", $h->info) ?>
                                <tr>
                                    <td><span class="text-sm">#3812<?= $h->id_history ?></span></td>
                                    <td><?= $in[0] ?></td>
                                    <td><span class="text-sm text-nowrap"><?= $in[1] ?>**</span></td>
                                    <td><span class="text-sm text-nowrap"><?= $in[2] ?>Days</span></td>
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

    <div class="w-full lg:w-1/3 flex flex-col gap-4">
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-b border-base-300">
                    <h2 class="card-title text-base">Top up price</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Balance</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>$10</td>
                                <td>100K or $7</td>
                            </tr>
                            <tr>
                                <td>$15</td>
                                <td>150K or $10</td>
                            </tr>
                            <tr>
                                <td>$25</td>
                                <td>270K or $18</td>
                            </tr>
                            <tr>
                                <td>$50</td>
                                <td>590K or $40</td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>1.260K or $85</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-b border-base-300">
                    <h2 class="card-title text-base">Account</h2>
                </div>
                <ul class="text-sm">
                    <li class="flex justify-between items-center px-4 py-2 border-b border-base-300">
                        <span class="opacity-60">Role</span>
                        <span><?= !isset($user) ?: getLevel($user->level) ?></span>
                    </li>
                    <li class="flex justify-between items-center px-4 py-2 border-b border-base-300">
                        <span class="opacity-60">Balance</span>
                        <span>$<?= !isset($user) ?: $user->saldo ?></span>
                    </li>
                    <li class="flex justify-between items-center px-4 py-2 border-b border-base-300">
                        <span class="opacity-60">Login time</span>
                        <span><?= !isset($user) ?: $time::parse(session()->time_since)->humanize() ?></span>
                    </li>
                    <li class="flex justify-between items-center px-4 py-2">
                        <span class="opacity-60">Auto logout</span>
                        <span class="text-error"><?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
