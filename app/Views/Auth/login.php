<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-col items-center gap-4 py-8 sm:py-12 md:py-20">
    <div class="w-full max-w-xs sm:max-w-sm px-4 sm:px-0">
        <?= $this->include('Layout/msgStatus') ?>
    </div>

    <div class="card card-border bg-base-100 border-base-300 shadow-lg w-full max-w-xs sm:max-w-sm mx-4 sm:mx-0">
        <div class="card-body p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-bold mb-1">Welcome back</h1>
            <p class="text-sm opacity-60 mb-6">Log in to manage your account</p>

            <?= form_open() ?>
            <label class="input w-full">
                <svg class="icon opacity-50"><use href="#i-user" /></svg>
                <input type="text" name="username" id="username" class="grow" placeholder="Your username" required minlength="4">
            </label>

            <label class="input w-full mt-3">
                <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                <input type="password" name="password" id="password" class="grow" placeholder="Your password" required minlength="6">
                <button type="button" class="opacity-50 hover:opacity-100" onclick="togglePw('password', this)" aria-label="Show password">
                    <svg class="icon"><use href="#i-eye" /></svg>
                </button>
            </label>

            <label class="label cursor-pointer gap-2 mt-3">
                <input type="checkbox" class="checkbox checkbox-sm" name="stay_log" id="stay_log" value="yes">
                Stay logged in
            </label>

            <button type="submit" class="btn btn-primary w-full mt-4">Login</button>
            <?= form_close() ?>
        </div>
    </div>

    <p class="text-sm opacity-60 px-4 text-center">
        Don't have an account yet?
        <a href="<?= site_url('register') ?>" class="link link-hover text-primary font-medium">Register here</a>
    </p>
</div>

<?= $this->endSection() ?>
