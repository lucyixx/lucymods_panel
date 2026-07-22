<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="card card-border bg-base-100 border-base-300">
        <div class="card-body">
            <h2 class="card-title">Generate <?= $title ?></h2>

            <?= form_open() ?>
            <div class="mb-3">
                <label class="label">You can set with multiple saldo</label>
                <div class="join w-full mt-1">
                    <span class="join-item btn btn-disabled no-animation px-3">$</span>
                    <input type="number" class="input join-item w-full" name="saldo" id="saldo" minlength="1" maxlength="11" value="5">
                </div>
                <?php if ($validation->hasError('saldo')) : ?>
                    <p class="text-error text-sm mt-1"><?= $validation->getError('saldo') ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="label">Account level</label>
                <?= form_dropdown(['class' => 'select w-full mt-1', 'name' => 'level', 'id' => 'level'], getLevelArray(), 2) ?>
            </div>

            <button type="submit" class="btn btn-primary w-full">Create code</button>
            <?= form_close() ?>
        </div>
    </div>

    <?php if ($code) : ?>
        <div class="card card-border bg-base-100 border-base-300 lg:col-span-2">
            <div class="card-body">
                <h2 class="card-title">History generate &middot; Total <?= $total_code ?></h2>

                <div class="overflow-x-auto">
                    <table class="table table-sm">
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
                                    <td><?= $c->used_by ?: '—' ?></td>
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

<?= $this->endSection() ?>
