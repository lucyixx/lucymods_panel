<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>

<div class="flex justify-center pt-12">
    <div class="w-full lg:w-1/3">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card card-border bg-base-200 border-base-300 mb-6">
            <div class="card-body">
                <h1 class="card-title text-base mb-1">Register</h1>
                <?= form_open() ?>
                <div class="flex flex-col gap-1 my-3">
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-person opacity-60"></i>
                            <input type="text" name="username" id="username" placeholder="Username" minlength="4" maxlength="24" pattern="[a-zA-Z0-9]+" title="Letters and numbers only, at least 4 characters" value="<?= old('username') ?>" required>
                        </label>
                        <p class="validator-hint">Must be 4+ characters, letters and numbers only.</p>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password" id="password" placeholder="Password" minlength="6" maxlength="24" required>
                        </label>
                        <p class="validator-hint">Must be at least 6 characters.</p>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password2" id="password2" placeholder="Confirm password" minlength="6" maxlength="24" required>
                        </label>
                        <p class="validator-hint">Must match the password above.</p>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-upc-scan opacity-60"></i>
                            <input type="text" name="referral" id="referral" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
                        </label>
                        <p class="validator-hint">Ask an admin for a referral code.</p>
                    </div>
                </div>
                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-right"></i> Register</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-center opacity-70 after-card text-sm">
            Already have an account?
            <a href="<?= site_url('login') ?>" class="link text-primary">Login here</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
