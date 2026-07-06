<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<p class="opacity-60 mb-6">Welcome back, <?= getName($user) ?> &middot; here's how things look today.</p>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    <div class="bg-base-200 border border-base-300 rounded-box p-4">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs uppercase tracking-wide opacity-60">Balance</span>
            <svg class="icon text-primary"><use href="#i-wallet" /></svg>
        </div>
        <p class="text-2xl font-semibold">$<?= $user->saldo ?></p>
    </div>
    <div class="bg-base-200 border border-base-300 rounded-box p-4">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs uppercase tracking-wide opacity-60">Role</span>
            <svg class="icon text-primary"><use href="#i-shield" /></svg>
        </div>
        <p class="text-2xl font-semibold"><?= getLevel($user->level) ?></p>
    </div>
    <div class="bg-base-200 border border-base-300 rounded-box p-4">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs uppercase tracking-wide opacity-60">Session</span>
            <svg class="icon text-primary"><use href="#i-user" /></svg>
        </div>
        <p class="text-2xl font-semibold"><?= $time::parse(session()->time_since)->humanize() ?></p>
    </div>
    <div class="bg-base-200 border border-base-300 rounded-box p-4">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs uppercase tracking-wide opacity-60">Auto logout</span>
            <svg class="icon text-error"><use href="#i-logout" /></svg>
        </div>
        <p class="text-2xl font-semibold text-error"><?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?></p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-base-200 border border-base-300 rounded-box">
            <div class="px-5 py-4 border-b border-base-300"><h2 class="font-medium">Registration history</h2></div>
            <?php if ($history) : ?>
                <ul>
                    <?php foreach ($history as $h) : ?>
                        <?php $in = explode("|", $h->info) ?>
                        <li class="flex items-center justify-between px-5 py-3 border-b border-base-300 last:border-b-0 hover:bg-base-300/30">
                            <div class="flex items-center gap-3">
                                <div class="bg-base-300 rounded-lg w-9 h-9 flex items-center justify-center"><svg class="icon opacity-70"><use href="#i-gamepad" /></svg></div>
                                <div>
                                    <p class="text-sm font-medium">#3812<?= $h->id_history ?> &middot; <?= $in[0] ?></p>
                                    <p class="text-xs opacity-50"><?= $in[3] ?> devices &middot; <?= $in[2] ?> days</p>
                                </div>
                            </div>
                            <span class="text-xs opacity-50"><?= $time::parse($h->created_at)->humanize() ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="text-sm opacity-60 text-center py-8">No registrations yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="flex flex-col gap-6">
        <div class="bg-base-200 border border-base-300 rounded-box p-5">
            <h2 class="font-medium mb-3">Quick actions</h2>
            <div class="flex flex-col gap-2">
                <a href="<?= site_url('keys/generate') ?>" class="btn btn-primary btn-sm justify-start"><svg class="icon"><use href="#i-plus" /></svg>Generate license</a>
                <a href="<?= site_url('keys') ?>" class="btn btn-sm justify-start"><svg class="icon"><use href="#i-key" /></svg>View keys</a>
                <a href="<?= site_url('settings') ?>" class="btn btn-sm justify-start"><svg class="icon"><use href="#i-gear" /></svg>Account settings</a>
            </div>
        </div>
        <div class="bg-base-200 border border-base-300 rounded-box p-5">
            <h2 class="font-medium mb-3">Top up price</h2>
            <div class="divide-y divide-base-300 text-sm">
                <div class="flex justify-between py-2"><span>$10</span><span class="opacity-60">100K or $7</span></div>
                <div class="flex justify-between py-2"><span>$15</span><span class="opacity-60">150K or $10</span></div>
                <div class="flex justify-between py-2"><span>$25</span><span class="opacity-60">270K or $18</span></div>
                <div class="flex justify-between py-2"><span>$50</span><span class="opacity-60">590K or $40</span></div>
                <div class="flex justify-between py-2"><span>$100</span><span class="opacity-60">1.260K or $85</span></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
