<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center">
    <div class="w-full lg:w-1/2">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="panel mb-3">
            <div class="panel-head"><span class="panel-head-title">Account Information</span></div>
            <div class="panel-body">
                <?= form_open() ?>
                <div class="my-3 flex flex-col gap-3">
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-person-gear opacity-60"></i>
                            <input type="text" name="fullname" id="fullname" class="grow" placeholder="Admin full name" value="<?= old('fullname') ?: $user->fullname ?>">
                        </label>
                    </div>
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="current" id="current" class="grow" placeholder="Current Password">
                        </label>
                    </div>
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password" id="password" class="grow" placeholder="New Password">
                        </label>
                    </div>
                    <div>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-shield-lock opacity-60"></i>
                            <input type="password" name="password2" id="password2" class="grow" placeholder="Confirm Password">
                        </label>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-sm btn-primary btn-hud">Change Password</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
