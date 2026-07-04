<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex flex-wrap justify-center pt-3 gap-4">
    <div class="w-full lg:w-2/3">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="w-full lg:w-2/3 mb-3">
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body">
                <h1 class="card-title text-base mb-1">Edit account &middot; <?= getName($target) ?></h1>
                <?= form_open() ?>
                <input type="hidden" name="user_id" value="<?= $target->id_users ?>">
                <div class="flex flex-wrap gap-4 mt-3">
                    <div class="w-full md:w-1/2">
                        <label class="input validator w-full">
                            <i class="bi bi-person opacity-60"></i>
                            <input type="text" name="username" id="username" placeholder="Username" value="<?= old('username') ?: $target->username ?>" minlength="4" required>
                        </label>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="input w-full">
                            <i class="bi bi-person-vcard opacity-60"></i>
                            <input type="text" name="fullname" id="fullname" placeholder="Fullname" value="<?= old('fullname') ?: $target->fullname ?>" required>
                        </label>
                    </div>
                    <div class="w-full md:w-1/2">
                        <fieldset class="fieldset p-0">
                            <legend class="fieldset-legend">Role</legend>
                            <?= form_dropdown(['class' => 'select w-full', 'name' => 'level', 'id' => 'level'], getLevelArray(), $target->level) ?>
                        </fieldset>
                    </div>
                    <div class="w-full md:w-1/2">
                        <fieldset class="fieldset p-0">
                            <legend class="fieldset-legend">Status</legend>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'status'], $sel_status, $target->status) ?>
                        </fieldset>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="input validator w-full">
                            <i class="bi bi-wallet2 opacity-60"></i>
                            <input type="number" name="saldo" id="saldo" placeholder="Saldo" value="<?= old('saldo') ?: $target->saldo ?>" required>
                        </label>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label class="input opacity-60">
                            <i class="bi bi-diagram-3 opacity-60"></i>
                            <input type="text" name="uplink" id="uplink" placeholder="Uplink" value="<?= old('uplink') ?: $target->uplink ?>" disabled>
                        </label>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">Update account</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <p class="opacity-70 text-center mt-3 text-sm">
            <a href="<?= site_url('admin/manage-users') ?>" class="link"><i class="bi bi-arrow-left"></i> Back to manage users</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
