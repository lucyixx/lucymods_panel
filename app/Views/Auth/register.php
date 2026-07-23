<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center px-4 py-10">
    <div class="w-full max-w-sm">
        <?= $this->include('Layout/msgStatus') ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body gap-4">
                <h2 class="card-title">Register</h2>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <div>
                        <label class="label" for="username">Username</label>
                        <input type="text" class="input w-full" name="username" id="username" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>
                    </div>

                    <div>
                        <label class="label" for="password">Password</label>
                        <div class="join w-full">
                            <input type="password" class="input join-item w-full" name="password" id="password" placeholder="Your password" minlength="6" maxlength="24" required>
                            <button type="button" class="btn btn-outline join-item toggle-password" data-target="password" aria-label="Show password">
                                <svg class="icon"><use href="#i-eye" /></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="label" for="password2">Confirm password</label>
                        <div class="join w-full">
                            <input type="password" name="password2" id="password2" class="input join-item w-full" placeholder="Confirm password" minlength="6" maxlength="24" required>
                            <button type="button" class="btn btn-outline join-item toggle-password" data-target="password2" aria-label="Show password">
                                <svg class="icon"><use href="#i-eye" /></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="label" for="referral">Referral code</label>
                        <input type="text" name="referral" id="referral" class="input w-full" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
                    </div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>

        <p class="text-center text-sm opacity-70 mt-4">
            Already have an account?
            <a href="<?= site_url('login') ?>" class="link link-primary">Login here</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // Show/hide password: swap type + icon, one handler covers both fields.
    (function() {
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            const input = document.getElementById(toggle.dataset.target);
            toggle.addEventListener('click', function() {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                toggle.querySelector('use').setAttribute('href', isHidden ? '#i-eye-off' : '#i-eye');
            });
        });
    })();
</script>
<?= $this->endSection() ?>
