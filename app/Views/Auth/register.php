<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>

<div class="flex justify-center pt-12">
    <div class="w-full lg:w-1/3">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="panel shadow mb-12">
            <div class="panel-head"><span class="panel-head-title">Register</span></div>
            <div class="panel-body">
                <?= form_open() ?>
                <div class="flex flex-col gap-3 my-3">
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-person opacity-60"></i>
                            <input type="text" class="grow" name="username" id="username" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>
                        </label>
                    </div>
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" class="grow" name="password" id="password" placeholder="Your password" minlength="6" maxlength="24" required>
                        </label>
                    </div>
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password2" id="password2" class="grow" placeholder="Confirm password" minlength="6" maxlength="24" required>
                        </label>
                    </div>
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-upc-scan opacity-60"></i>
                            <input type="text" name="referral" id="referral" class="grow" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
                        </label>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-sm btn-primary btn-hud"><i class="bi bi-box-arrow-in-right"></i> Register</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-center opacity-70 after-card">
            <small class="p-2 rounded">
                Already have an account?
                <a href="<?= site_url('login') ?>" class="text-primary">Login here</a>
            </small>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
