<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="max-w-md">
    <?= form_open() ?>
    <div class="mb-3">
        <label class="input w-full">
            <svg class="icon opacity-60"><use href="#i-user" /></svg>
            <input type="text" name="fullname" id="fullname" placeholder="Admin full name" value="<?= old('fullname') ?: $user->fullname ?>">
        </label>
    </div>
    <div class="mb-3">
        <label class="input validator w-full">
            <svg class="icon opacity-60"><use href="#i-lock" /></svg>
            <input type="password" name="current" id="current" placeholder="Current password" minlength="6">
        </label>
    </div>
    <div class="mb-3">
        <label class="input validator w-full">
            <svg class="icon opacity-60"><use href="#i-lock" /></svg>
            <input type="password" name="password" id="password" placeholder="New password" minlength="6">
        </label>
        <p class="validator-hint hidden text-xs mt-1 mb-0">At least 6 characters.</p>
    </div>
    <div class="mb-4">
        <label class="input validator w-full">
            <svg class="icon opacity-60"><use href="#i-lock" /></svg>
            <input type="password" name="password2" id="password2" placeholder="Confirm new password" minlength="6">
        </label>
        <p class="validator-hint hidden text-xs mt-1 mb-0">Must match the new password above.</p>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Change password</button>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
