<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex justify-center pt-12">
    <div class="w-full lg:w-1/3">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card card-border bg-base-200 border-base-300 mb-6">
            <div class="card-body">
                <h1 class="card-title text-base mb-1">Login</h1>
                <?= form_open() ?>
                <div class="flex flex-col gap-1 my-3">
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-person opacity-60"></i>
                            <input type="text" name="username" id="username" placeholder="Username" required minlength="4" maxlength="25" pattern="[a-zA-Z0-9]+" title="Letters and numbers only, at least 4 characters" value="<?= old('username') ?>">
                        </label>
                        <p class="validator-hint">Must be 4+ characters, letters and numbers only.</p>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password" id="password" placeholder="Password" required minlength="6" maxlength="45">
                        </label>
                        <p class="validator-hint">Must be at least 6 characters.</p>
                    </div>
                    <div>
                        <label class="label cursor-pointer gap-2 justify-start">
                            <input type="checkbox" class="checkbox checkbox-sm" name="stay_log" id="stay_log" value="yes">
                            <span class="label-text">Stay logged in</span>
                        </label>
                    </div>
                </div>
                <div class="mt-2 text-right">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-right"></i> Log in</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-center opacity-70 after-card text-sm">
            Don't have an account yet?
            <a href="<?= site_url('register') ?>" class="link text-primary">Register here</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
