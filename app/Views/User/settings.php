<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<div class="max-w-md">
    <?= $this->include('Layout/msgStatus') ?>

    <?= form_open() ?>
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
        <legend class="fieldset-legend">Account information</legend>

        <label class="label">Full name</label>
        <input type="text" name="fullname" id="fullname" class="input w-full" placeholder="Admin full name" value="<?= old('fullname') ?: $user->fullname ?>">

        <label class="label">Current password</label>
        <input type="password" name="current" id="current" class="input w-full" placeholder="Current password">

        <label class="label">New password</label>
        <input type="password" name="password" id="password" class="input w-full" placeholder="New password">

        <label class="label">Confirm password</label>
        <input type="password" name="password2" id="password2" class="input w-full" placeholder="Confirm password">

        <button type="submit" class="btn btn-primary mt-4">Change password</button>
    </fieldset>
    <?= form_close() ?>
</div>

<?= $this->endSection() ?>
