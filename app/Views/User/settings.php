<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center">
    <div class="w-full lg:w-1/2">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body">
                <h1 class="card-title text-base mb-1">Account information</h1>
                <?= form_open() ?>
                <div class="my-3 flex flex-col gap-1">
                    <div>
                        <label class="input w-full">
                            <i class="bi bi-person-gear opacity-60"></i>
                            <input type="text" name="fullname" id="fullname" placeholder="Admin full name" value="<?= old('fullname') ?: $user->fullname ?>">
                        </label>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="current" id="current" placeholder="Current password" minlength="6">
                        </label>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password" id="password" placeholder="New password" minlength="6">
                        </label>
                        <p class="validator-hint">Must be at least 6 characters.</p>
                    </div>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password2" id="password2" placeholder="Confirm new password" minlength="6">
                        </label>
                        <p class="validator-hint">Must match the new password above.</p>
                    </div>
                </div>
                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-sm btn-primary">Change password</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
