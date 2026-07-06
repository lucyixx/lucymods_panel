<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="flex justify-center pt-8">
    <div class="w-full max-w-sm">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body gap-0">
                <h1 class="card-title text-base mb-3">Register</h1>
                <?= form_open() ?>
                <div class="mb-2">
                    <label class="input validator w-full">
                        <svg class="icon opacity-60"><use href="#i-user" /></svg>
                        <input type="text" name="username" id="username" placeholder="Username" minlength="4" maxlength="24" pattern="[a-zA-Z0-9]+" value="<?= old('username') ?>" required>
                    </label>
                    <p class="validator-hint hidden text-xs mt-1 mb-0">4+ characters, letters and numbers only.</p>
                </div>
                <div class="mb-2">
                    <label class="input validator w-full">
                        <svg class="icon opacity-60"><use href="#i-lock" /></svg>
                        <input type="password" name="password" id="password" placeholder="Password" minlength="6" maxlength="24" required>
                    </label>
                    <p class="validator-hint hidden text-xs mt-1 mb-0">Must be at least 6 characters.</p>
                </div>
                <div class="mb-2">
                    <label class="input validator w-full">
                        <svg class="icon opacity-60"><use href="#i-lock" /></svg>
                        <input type="password" name="password2" id="password2" placeholder="Confirm password" minlength="6" maxlength="24" required>
                    </label>
                    <p class="validator-hint hidden text-xs mt-1 mb-0">Must match the password above.</p>
                </div>
                <div class="mb-3">
                    <label class="input validator w-full">
                        <svg class="icon opacity-60"><use href="#i-scan" /></svg>
                        <input type="text" name="referral" id="referral" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
                    </label>
                    <p class="validator-hint hidden text-xs mt-1 mb-0">Ask an admin for a referral code.</p>
                </div>
                <button type="submit" class="btn btn-primary w-full">Register</button>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-center text-sm opacity-70 mt-4">
            Already have an account? <a href="<?= site_url('login') ?>" class="link text-primary">Login here</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
