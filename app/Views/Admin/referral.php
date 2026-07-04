<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap gap-4">
    <div class="w-full">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="w-full lg:w-1/3 mb-3">
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body">
                <h1 class="card-title text-base mb-1">Generate <?= $title ?></h1>
                <?= form_open() ?>
                <div class="mb-3 mt-2">
                    <label class="input validator w-full">
                        <i class="bi bi-currency-dollar opacity-60"></i>
                        <input type="number" name="saldo" id="saldo" placeholder="Saldo" min="1" maxlength="11" value="5" required>
                    </label>
                    <p class="validator-hint">Balance to credit when this code is redeemed.</p>
                    <?php if ($validation->hasError('saldo')) : ?>
                        <p id="help-saldo" class="text-error text-sm"><?= $validation->getError('saldo') ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <fieldset class="fieldset p-0">
                        <legend class="fieldset-legend">Account level</legend>
                        <div class="join w-full">
                            <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-person"></i></span>
                            <?= form_dropdown(['class' => 'select join-item grow', 'name' => 'level', 'id' => 'level'], getLevelArray(), 2) ?>
                        </div>
                    </fieldset>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-primary">Create code</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-2/3">
        <?php if ($code) : ?>
            <div class="card card-border bg-base-200 border-base-300 mb-3">
                <div class="card-body p-0">
                    <div class="px-4 py-3 border-b border-base-300">
                        <h2 class="card-title text-base">History &middot; total <?= $total_code ?></h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-sm table-zebra">
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
                                        <td class="font-mono text-sm"><?= $c->code ?></td>
                                        <td class="font-mono text-sm opacity-70"><?= substr($c->hashed, 1, 15) ?></td>
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
