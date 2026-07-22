<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-col items-center gap-6 py-8 sm:py-12 md:py-16">
    <div class="text-center px-4">
        <svg class="icon text-primary mx-auto mb-2" style="width:2rem;height:2rem"><use href="#i-key" /></svg>
        <h1 class="text-lg md:text-xl font-medium mb-1">Create an account</h1>
        <p class="text-sm opacity-60">Join to start requesting access</p>
    </div>

    <div class="w-full max-w-xs sm:max-w-sm px-4 sm:px-0">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <div class="card card-border bg-base-100 border-base-300 w-full max-w-xs sm:max-w-sm mx-4 sm:mx-0">
        <div class="card-body p-5 md:p-6">
            <?= form_open() ?>
            <label class="label">Username</label>
            <input type="text" name="username" id="username" class="input w-full" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>

            <label class="label mt-2">Password</label>
            <input type="password" name="password" id="password" class="input w-full" placeholder="Your password" minlength="6" maxlength="24" required>

            <label class="label mt-2">Confirm password</label>
            <input type="password" name="password2" id="password2" class="input w-full" placeholder="Confirm password" minlength="6" maxlength="24" required>

            <label class="label mt-2">Referral code</label>
            <input type="text" name="referral" id="referral" class="input w-full" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>

            <button type="submit" class="btn btn-primary w-full mt-4">Register</button>
            <?= form_close() ?>
        </div>
    </div>

    <p class="text-sm opacity-60 px-4 text-center">
        Already have an account?
        <a href="<?= site_url('login') ?>" class="link link-hover text-primary font-medium">Login here</a>
    </p>
</div>

<?= $this->endSection() ?>
