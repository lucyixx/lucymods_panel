<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex justify-center pt-12">
    <div class="w-full lg:w-1/3">
        <div class="mx-auto">
            <?= $this->include('Layout/msgStatus') ?>
            <div class="card shadow mb-12">
                <div class="border-b px-4 py-3 font-semibold">Login</div>
                <div class="card-body">
                    <?= form_open() ?>
                    <div class="flex flex-col gap-3 my-3">
                        <div>
                            <label class="input input-bordered flex items-center gap-2 w-full">
                                <i class="bi bi-person opacity-60"></i>
                                <input type="text" class="grow" name="username" id="username" placeholder="Your username" required minlength="4">
                            </label>
                        </div>
                        <div>
                            <label class="input input-bordered flex items-center gap-2 w-full">
                                <i class="bi bi-shield-lock opacity-60"></i>
                                <input type="password" class="grow" name="password" id="password" placeholder="Your password" required minlength="6">
                            </label>
                        </div>
                        <div>
                            <label class="label cursor-pointer gap-2 justify-start">
                                <input type="checkbox" class="checkbox checkbox-sm" name="stay_log" id="stay_log" value="yes">
                                <span class="label-text">Stay login?</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-in-right"></i> Log in</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <p class="text-center opacity-70 after-card">
                <small class="p-2 rounded">
                    Don't have an account yet?
                    <a href="<?= site_url('register') ?>" class="text-primary">Register here</a>
                </small>
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
