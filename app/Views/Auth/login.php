<?= $this->extend('Layout/BootstrapLayout') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center pt-5">
    <div class="col-lg-4">
        <div class="mx-auto">
            <?= $this->include('Layout/BootstrapMsgStatus') ?>
            <div class="card mb-5">
                <div class="card-header">
                    <div class="card-title m-0"><span>Login</span></div>
                </div>
                <div class="card-body">
                    <?= form_open() ?>
                    <div class="row my-3">
                        <div class="mb-3">
                            <div class="input-group">
                                <label for="username" class="input-group-text"><i class="bi bi-person"></i></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Your username" required minlength="4">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <label for="password" class="input-group-text"><i class="bi bi-shield-lock"></i></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Your password" required minlength="6">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="stay_log" id="stay_log" value="yes">
                                <label class="form-check-label" for="stay_log">Stay login?</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-right"></i> Log in</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <p class="text-center text-muted after-card">
                <small class="px-auto p-2 rounded">
                    Don't have an account yet?
                    <a href="<?= site_url('register') ?>" class="text-primary">Register here</a>
                </small>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>