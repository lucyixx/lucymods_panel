<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap gap-4">
    <div class="w-full">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="w-full lg:w-1/3 mb-3">
        <div class="panel">
            <div class="panel-head"><span class="panel-head-title">Generate <?= $title ?></span></div>
            <div class="panel-body">
                <?= form_open() ?>
                <div class="mb-3">
                    <label for="saldo" class="label"><span class="label-text">You can set with multiple saldo</span></label>
                    <label class="input input-bordered flex items-center gap-2 w-full mt-2">
                        <i class="bi bi-currency-dollar opacity-60"></i>
                        <input type="number" class="grow" name="saldo" id="saldo" minlength="1" maxlength="11" value="5">
                    </label>
                    <?php if ($validation->hasError('saldo')) : ?>
                        <small id="help-saldo" class="text-error"><?= $validation->getError('saldo') ?></small>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="level" class="label"><span class="label-text">Account Level</span></label>
                    <div class="join w-full mt-2">
                        <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-person"></i></span>
                        <?= form_dropdown(['class' => 'select select-bordered join-item grow', 'name' => 'level', 'id' => 'level'], getLevelArray(), 2) ?>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-primary btn-hud">Create Code</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-2/3">
        <?php if ($code) : ?>
            <div class="panel mb-3">
                <div class="panel-head"><span class="panel-head-title">History Generate - Total <?= $total_code ?></span></div>
                <div class="panel-body">
                    <div class="overflow-x-auto">
                        <table class="table table-sm table-zebra" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Referral</th>
                                    <th>Hashed</th>
                                    <th>Saldo</th>
                                    <th>Level</th>
                                    <th>Used by</th>
                                    <th>Create by</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($code as $c) : ?>
                                    <tr>
                                        <td><?= $c->id_reff ?></td>
                                        <td><?= $c->code ?></td>
                                        <td><?= substr($c->hashed, 1, 15) ?></td>
                                        <td>$<?= $c->saldo ?></td>
                                        <td><?= $c->level ?></td>
                                        <td><?= $c->used_by ?: '&mdash;' ?></td>
                                        <td><?= $c->created_by ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
