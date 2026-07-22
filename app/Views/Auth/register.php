<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-col items-center gap-4 py-8 sm:py-12 md:py-20">
    <div class="w-full max-w-xs sm:max-w-sm px-4 sm:px-0">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <div class="card card-border bg-base-100 border-base-300 shadow-lg w-full max-w-xs sm:max-w-sm mx-4 sm:mx-0">
        <div class="card-body p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-bold mb-1">Create your account</h1>
            <p class="text-sm opacity-60 mb-6">Join to start requesting access</p>

            <?= form_open() ?>
            <label class="input w-full">
                <svg class="icon opacity-50"><use href="#i-user" /></svg>
                <input type="text" name="username" id="username" class="grow" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>
            </label>

            <label class="input w-full mt-3">
                <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                <input type="password" name="password" id="password" class="grow" placeholder="Your password" minlength="6" maxlength="24" required>
                <button type="button" class="opacity-50 hover:opacity-100" onclick="togglePw('password', this)" aria-label="Show password">
                    <svg class="icon"><use href="#i-eye" /></svg>
                </button>
            </label>

            <label class="input w-full mt-3">
                <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                <input type="password" name="password2" id="password2" class="grow" placeholder="Confirm password" minlength="6" maxlength="24" required>
                <button type="button" class="opacity-50 hover:opacity-100" onclick="togglePw('password2', this)" aria-label="Show password">
                    <svg class="icon"><use href="#i-eye" /></svg>
                </button>
            </label>

            <label class="input w-full mt-3">
                <svg class="icon opacity-50"><use href="#i-gift" /></svg>
                <input type="text" name="referral" id="referral" class="grow" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
            </label>

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
