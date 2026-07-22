<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-col items-center gap-4 py-6 md:py-12">
    <div class="w-full max-w-xs">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <?= form_open() ?>
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-full max-w-xs border p-4">
        <legend class="fieldset-legend">Register</legend>

        <label class="label">Username</label>
        <input type="text" name="username" id="username" class="input" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>

        <label class="label">Password</label>
        <input type="password" name="password" id="password" class="input" placeholder="Your password" minlength="6" maxlength="24" required>

        <label class="label">Confirm password</label>
        <input type="password" name="password2" id="password2" class="input" placeholder="Confirm password" minlength="6" maxlength="24" required>

        <label class="label">Referral code</label>
        <input type="text" name="referral" id="referral" class="input" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>

        <button type="submit" class="btn btn-neutral mt-4">Register</button>
    </fieldset>
    <?= form_close() ?>

    <p class="text-sm opacity-60">
        Already have an account?
        <a href="<?= site_url('login') ?>" class="link link-hover text-primary font-medium">Login here</a>
    </p>
</div>

<?= $this->endSection() ?>
