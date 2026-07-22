<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-col items-center gap-4 py-6 md:py-12">
    <div class="w-full max-w-xs">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <?= form_open() ?>
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-xs border p-4">
        <legend class="fieldset-legend">Login</legend>

        <label class="label">Username</label>
        <input type="text" name="username" id="username" class="input" placeholder="Username" required minlength="4">

        <label class="label">Password</label>
        <input type="password" name="password" id="password" class="input" placeholder="Password" required minlength="6">

        <label class="fieldset-label">
            <input type="checkbox" class="checkbox" name="stay_log" id="stay_log" value="yes">
            Stay logged in
        </label>

        <button type="submit" class="btn btn-neutral mt-4">Login</button>
    </fieldset>
    <?= form_close() ?>

    <p class="text-sm opacity-60">
        Don't have an account yet?
        <a href="<?= site_url('register') ?>" class="link link-hover text-primary font-medium">Register here</a>
    </p>
</div>

<?= $this->endSection() ?>
