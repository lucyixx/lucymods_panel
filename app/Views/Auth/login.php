<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-col items-center gap-6 py-8 sm:py-12 md:py-16">
    <div class="text-center px-4">
        <svg class="icon text-primary mx-auto mb-2" style="width:2rem;height:2rem"><use href="#i-key" /></svg>
        <h1 class="text-lg md:text-xl font-medium mb-1">Welcome back</h1>
        <p class="text-sm opacity-60">Log in to manage your account</p>
    </div>

    <div class="w-full max-w-xs sm:max-w-sm px-4 sm:px-0">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <div class="card card-border bg-base-100 border-base-300 w-full max-w-xs sm:max-w-sm mx-4 sm:mx-0">
        <div class="card-body p-5 md:p-6">
            <?= form_open() ?>
            <label class="label">Username</label>
            <input type="text" name="username" id="username" class="input w-full" placeholder="Your username" required minlength="4">

            <label class="label mt-2">Password</label>
            <input type="password" name="password" id="password" class="input w-full" placeholder="Your password" required minlength="6">

            <label class="label cursor-pointer gap-2 mt-3">
                <input type="checkbox" class="checkbox checkbox-sm" name="stay_log" id="stay_log" value="yes">
                Stay logged in
            </label>

            <button type="submit" class="btn btn-primary w-full mt-4">Login</button>
            <?= form_close() ?>
        </div>
    </div>

    <p class="text-sm opacity-60 px-4 text-center">
        Don't have an account yet?
        <a href="<?= site_url('register') ?>" class="link link-hover text-primary font-medium">Register here</a>
    </p>
</div>

<?= $this->endSection() ?>
