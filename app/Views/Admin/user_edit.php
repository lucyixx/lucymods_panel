<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex flex-wrap justify-center pt-3 gap-4">
    <div class="w-full lg:w-2/3">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="w-full lg:w-2/3 mb-3">
        <div class="panel shadow mb-12">
            <div class="panel-head"><span class="panel-head-title">Edit Account &middot; <?= getName($target) ?></span></div>
            <div class="panel-body">
                <?= form_open() ?>
                <input type="hidden" name="user_id" value="<?= $target->id_users ?>">
                <div>
                    <div class="flex flex-wrap gap-4">
                        <div class="w-full md:w-1/2 mb-3">
                            <label for="username" class="label"><span class="label-text">Username</span></label>
                            <input type="text" name="username" id="username" class="input input-bordered w-full" value="<?= old('username') ?: $target->username ?>" required>
                        </div>
                        <div class="w-full md:w-1/2 mb-3">
                            <label for="fullname" class="label"><span class="label-text">Fullname</span></label>
                            <input type="text" name="fullname" id="fullname" class="input input-bordered w-full" value="<?= old('fullname') ?: $target->fullname ?>" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <div class="w-full md:w-1/2 mb-3">
                            <label for="level" class="label"><span class="label-text">Roles</span></label>
                            <?= form_dropdown(['class' => 'select select-bordered w-full', 'name' => 'level', 'id' => 'level'], getLevelArray(), $target->level) ?>
                        </div>
                        <div class="w-full md:w-1/2 mb-3">
                            <label for="status" class="label"><span class="label-text">Status</span></label>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'select select-bordered w-full', 'name' => 'status', 'id' => 'status'], $sel_status, $target->status) ?>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <div class="w-full md:w-1/2 mb-3">
                            <label for="saldo" class="label"><span class="label-text">Saldo</span></label>
                            <input type="number" name="saldo" id="saldo" class="input input-bordered w-full" value="<?= old('saldo') ?: $target->saldo ?>" required>
                        </div>
                        <div class="w-full md:w-1/2 mb-3">
                            <label for="uplink" class="label"><span class="label-text">Uplink</span></label>
                            <input type="text" name="uplink" id="uplink" class="input input-bordered w-full" value="<?= old('uplink') ?: $target->uplink ?>" disabled>
                        </div>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-sm btn-primary btn-hud">Update Account</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="opacity-70 text-center">
            <a href="<?= site_url('admin/manage-users') ?>" class="py-1 px-2 opacity-70"><small><i class="bi bi-arrow-left"></i> Back to Manage users</small></a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
