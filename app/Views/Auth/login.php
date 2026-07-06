<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex justify-center pt-8">
    <div class="w-full max-w-sm">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body gap-0">
                <h1 class="card-title text-base mb-3">Log in</h1>
                <?= form_open() ?>
                <div class="mb-2">
                    <label class="input validator w-full">
                        <svg class="icon opacity-60"><use href="#i-user" /></svg>
                        <input type="text" name="username" id="username" placeholder="Username" required minlength="4" maxlength="25" pattern="[a-zA-Z0-9]+" value="<?= old('username') ?>">
                    </label>
                    <p class="validator-hint hidden text-xs mt-1 mb-0">4+ characters, letters and numbers only.</p>
                </div>
                <div class="mb-3">
                    <label class="input validator w-full">
                        <svg class="icon opacity-60"><use href="#i-lock" /></svg>
                        <input type="password" name="password" id="password" placeholder="Password" required minlength="6" maxlength="45">
                        <button type="button" class="opacity-60" onclick="const f=document.getElementById('password');f.type=f.type==='password'?'text':'password';" aria-label="Show password">
                            <svg class="icon"><use href="#i-eye" /></svg>
                        </button>
                    </label>
                    <p class="validator-hint hidden text-xs mt-1 mb-0">Must be at least 6 characters.</p>
                </div>
                <label class="label cursor-pointer gap-2 justify-start mb-3">
                    <input type="checkbox" class="checkbox checkbox-sm" name="stay_log" id="stay_log" value="yes">
                    <span class="label-text">Stay logged in</span>
                </label>
                <button type="submit" class="btn btn-primary w-full">Log in</button>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-center text-sm opacity-70 mt-4">
            Don't have an account yet? <a href="<?= site_url('register') ?>" class="link text-primary">Register here</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
