<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="max-w-2xl">
    <p class="text-sm opacity-60 mb-4">Editing &middot; <?= getName($target) ?></p>
    <?= form_open() ?>
    <input type="hidden" name="user_id" value="<?= $target->id_users ?>">
    <div class="flex flex-wrap gap-4">
        <label class="input validator w-full md:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-user" /></svg>
            <input type="text" name="username" id="username" placeholder="Username" value="<?= old('username') ?: $target->username ?>" minlength="4" required>
        </label>
        <label class="input w-full md:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-user" /></svg>
            <input type="text" name="fullname" id="fullname" placeholder="Fullname" value="<?= old('fullname') ?: $target->fullname ?>" required>
        </label>
        <label class="select w-full md:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-shield" /></svg>
            <?= form_dropdown(['name' => 'level', 'id' => 'level'], getLevelArray(), $target->level) ?>
        </label>
        <label class="select w-full md:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-check-circle" /></svg>
            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
            <?= form_dropdown(['name' => 'status', 'id' => 'status'], $sel_status, $target->status) ?>
        </label>
        <label class="input validator w-full md:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-wallet" /></svg>
            <input type="number" name="saldo" id="saldo" placeholder="Saldo" value="<?= old('saldo') ?: $target->saldo ?>" required>
        </label>
        <label class="input w-full md:w-[calc(50%-0.5rem)] opacity-60">
            <svg class="icon opacity-60"><use href="#i-link" /></svg>
            <input type="text" name="uplink" id="uplink" placeholder="Uplink" value="<?= old('uplink') ?: $target->uplink ?>" disabled>
        </label>
    </div>
    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-sm btn-primary">Update account</button>
    </div>
    <?= form_close() ?>
    <p class="opacity-70 text-sm mt-4">
        <a href="<?= site_url('admin/manage-users') ?>" class="link">&larr; Back to manage users</a>
    </p>
</div>
<?= $this->endSection() ?>
