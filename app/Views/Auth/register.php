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
                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-user" /></svg>
                        <input type="text" class="grow" name="username" id="username" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                        <input type="password" class="grow" name="password" id="password" placeholder="Your password" minlength="6" maxlength="24" required>
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                        <input type="password" name="password2" id="password2" class="grow" placeholder="Confirm password" minlength="6" maxlength="24" required>
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-scan" /></svg>
                        <input type="text" name="referral" id="referral" class="grow" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
                    </label>
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
