<?= $this->extend('Layout/BootstrapLayout') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center pt-3">
    <div class="col-lg-8">
        <?= $this->include('Layout/BootstrapMsgStatus') ?>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card mb-5">
            <div class="card-header">
                <div class="card-title m-0"><span>Edit Account &middot; <?= getName($target) ?></span></div>
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <input type="hidden" name="user_id" value="<?= $target->id_users ?>">
                <div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?: $target->username ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fullname" class="form-label">Fullname</label>
                            <input type="text" name="fullname" id="fullname" class="form-control" value="<?= old('fullname') ?: $target->fullname ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="level" class="form-label">Roles</label>
                            <?= form_dropdown(['class' => 'form-select', 'name' => 'level', 'id' => 'level'], getLevelArray(), $target->level) ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'form-select', 'name' => 'status', 'id' => 'status'], $sel_status, $target->status) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="saldo" class="form-label">Saldo</label>
                            <input type="number" name="saldo" id="saldo" class="form-control" value="<?= old('saldo') ?: $target->saldo ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="uplink" class="form-label">Uplink</label>
                            <input type="text" name="uplink" id="uplink" class="form-control" value="<?= old('uplink') ?: $target->uplink ?>" disabled>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Update Account</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="text-muted text-center">
            <a href="<?= site_url('admin/manage-users') ?>" class="py-1 px-2 text-muted"><small><i class="bi bi-arrow-left"></i> Back to Manage users</small></a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>