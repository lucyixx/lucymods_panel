<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl">
    <?= $this->include('Layout/msgStatus') ?>

    <div class="card card-border bg-base-100 border-base-300">
        <div class="card-body">
            <h2 class="card-title">Edit account &middot; <?= getName($target) ?></h2>

            <?= form_open() ?>
            <input type="hidden" name="user_id" value="<?= $target->id_users ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Username</label>
                    <input type="text" name="username" id="username" class="input w-full" value="<?= old('username') ?: $target->username ?>" required>
                </div>
                <div>
                    <label class="label">Full name</label>
                    <input type="text" name="fullname" id="fullname" class="input w-full" value="<?= old('fullname') ?: $target->fullname ?>" required>
                </div>
                <div>
                    <label class="label">Role</label>
                    <?= form_dropdown(['class' => 'select w-full', 'name' => 'level', 'id' => 'level'], getLevelArray(), $target->level) ?>
                </div>
                <div>
                    <label class="label">Status</label>
                    <?php $sel_status = ['' => '— Select status —', '0' => 'Banned/Block', '1' => 'Active']; ?>
                    <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'status'], $sel_status, $target->status) ?>
                </div>
                <div>
                    <label class="label">Saldo</label>
                    <input type="number" name="saldo" id="saldo" class="input w-full" value="<?= old('saldo') ?: $target->saldo ?>" required>
                </div>
                <div>
                    <label class="label">Uplink</label>
                    <input type="text" name="uplink" id="uplink" class="input w-full" value="<?= old('uplink') ?: $target->uplink ?>" disabled>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update account</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>

    <p class="text-center mt-4">
        <a href="<?= site_url('admin/manage-users') ?>" class="link link-hover text-sm opacity-60">
            <svg class="icon inline-block align-text-bottom" style="width:1em;height:1em"><use href="#i-chev-l" /></svg>
            Back to manage users
        </a>
    </p>
</div>

<?= $this->endSection() ?>
