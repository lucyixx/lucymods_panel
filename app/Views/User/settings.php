<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center">
    <div class="w-full max-w-md">
        <?= $this->include('Layout/msgStatus') ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Account Information</h2>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-user" /></svg>
                        <input type="text" name="fullname" id="fullname" class="grow" placeholder="Admin full name" value="<?= old('fullname') ?: $user->fullname ?>">
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                        <input type="password" name="current" id="current" class="grow" placeholder="Current Password">
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                        <input type="password" name="password" id="password" class="grow" placeholder="New Password">
                    </label>

                    <label class="input w-full">
                        <svg class="icon opacity-50"><use href="#i-lock" /></svg>
                        <input type="password" name="password2" id="password2" class="grow" placeholder="Confirm Password">
                    </label>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Change Password</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
