<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center">
    <div class="w-full max-w-2xl">
        <?= $this->include('Layout/msgStatus') ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Edit Account &middot; <?= getName($target) ?></h2>

                <?= form_open() ?>
                <input type="hidden" name="user_id" value="<?= $target->id_users ?>">
                <fieldset class="fieldset gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="username">Username</label>
                            <input type="text" name="username" id="username" class="input w-full" value="<?= old('username') ?: $target->username ?>" required>
                        </div>
                        <div>
                            <label class="label" for="fullname">Fullname</label>
                            <input type="text" name="fullname" id="fullname" class="input w-full" value="<?= old('fullname') ?: $target->fullname ?>" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="level">Roles</label>
                            <?= form_dropdown(['class' => 'select w-full', 'name' => 'level', 'id' => 'level'], getLevelArray(), $target->level) ?>
                        </div>
                        <div>
                            <label class="label" for="status">Status</label>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'status'], $sel_status, $target->status) ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="saldo">Saldo</label>
                            <input type="number" name="saldo" id="saldo" class="input w-full" value="<?= old('saldo') ?: $target->saldo ?>" required>
                        </div>
                        <div>
                            <label class="label" for="uplink">Uplink</label>
                            <input type="text" name="uplink" id="uplink" class="input w-full" value="<?= old('uplink') ?: $target->uplink ?>" disabled>
                        </div>
                    </div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Update Account</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>

        <p class="text-center mt-4">
            <a href="<?= site_url('admin/manage-users') ?>" class="link opacity-70 text-sm">
                <svg class="icon" style="width:0.9rem;height:0.9rem;display:inline-block;vertical-align:-0.15em"><use href="#i-chev-l" /></svg> Back to Manage users
            </a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
