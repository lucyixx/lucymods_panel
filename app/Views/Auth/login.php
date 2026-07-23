<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center px-4 py-10">
    <div class="w-full max-w-sm">
        <?= $this->include('Layout/msgStatus') ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body gap-4">
                <h2 class="card-title">Login</h2>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <div>
                        <label class="label" for="username">Username</label>
                        <input type="text" class="input w-full" name="username" id="username" placeholder="Your username" required minlength="4">
                    </div>

                    <div>
                        <label class="label" for="password">Password</label>
                        <div class="join w-full">
                            <input type="password" class="input join-item w-full" name="password" id="password" placeholder="Your password" required minlength="6">
                            <button type="button" class="btn btn-outline join-item" id="togglePassword" aria-label="Show password">
                                <svg class="icon"><use href="#i-eye" /></svg>
                            </button>
                        </div>
                    </div>

                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" class="checkbox checkbox-sm" name="stay_log" id="stay_log" value="yes">
                        Stay login?
                    </label>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary">Log in</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>

        <p class="text-center text-sm opacity-70 mt-4">
            Don't have an account yet?
            <a href="<?= site_url('register') ?>" class="link link-primary">Register here</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // Show/hide password: swap type + icon, no separate library needed.
    (function() {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        toggle.addEventListener('click', function() {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            toggle.querySelector('use').setAttribute('href', isHidden ? '#i-eye-off' : '#i-eye');
        });
    })();
</script>
<?= $this->endSection() ?>
