<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center pt-5">
    <div class="col-lg-4">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title m-0"><span>Rigister</span></div>
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <div class="row my-3">
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="username" class="input-group-text"><i class="bi bi-person"></i></label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Your username" minlength="4" maxlength="24" value="<?= old('username') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="password" class="input-group-text"><i class="bi bi-shield-lock"></i></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Your password" minlength="6" maxlength="24" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="password2" class="input-group-text"><i class="bi bi-shield-lock"></i></label>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm password" minlength="6" maxlength="24" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="referral" class="input-group-text"><i class="bi bi-upc-scan"></i></label>
                            <input type="text" name="referral" id="referral" class="form-control" placeholder="Referral code" value="<?= old('referral') ?>" maxlength="25" required>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-right"></i> Register</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-center text-muted after-card">
            <small class="px-auto p-2 rounded">
                Already have an account?
                <a href="<?= site_url('login') ?>" class="text-primary">Login here</a>
            </small>
        </p>
    </div>
</div>

<?= $this->endSection() ?>