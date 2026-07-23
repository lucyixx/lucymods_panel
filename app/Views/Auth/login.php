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
                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-user" /></svg>
                        <input type="text" class="grow" name="username" id="username" placeholder="Your username" required minlength="4">
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                        <input type="password" class="grow" name="password" id="password" placeholder="Your password" required minlength="6">
                    </label>

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
