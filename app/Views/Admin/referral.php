<?= $this->extend('Layout/AppShell') ?>

<?= $this->section('content') ?>
<?= $this->include('Layout/msgStatus') ?>

<div class="grid lg:grid-cols-3 gap-6">
    <div>
        <?= form_open() ?>
        <div class="mb-3">
            <label class="input validator w-full">
                <svg class="icon opacity-60"><use href="#i-wallet" /></svg>
                <input type="number" name="saldo" id="saldo" placeholder="Saldo" min="1" maxlength="11" value="5" required>
            </label>
            <p class="validator-hint hidden text-xs mt-1 mb-0">Balance to credit when this code is redeemed.</p>
            <?php if ($validation->hasError('saldo')) : ?>
                <p id="help-saldo" class="text-error text-xs mt-1"><?= $validation->getError('saldo') ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="select w-full">
                <svg class="icon opacity-60"><use href="#i-user" /></svg>
                <?= form_dropdown(['name' => 'level', 'id' => 'level'], getLevelArray(), 2) ?>
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Create code</button>
        <?= form_close() ?>
    </div>
    <div class="lg:col-span-2">
        <?php if ($code) : ?>
            <h2 class="text-sm uppercase tracking-wide opacity-60 mb-2">History &middot; total <?= $total_code ?></h2>
            <div class="overflow-x-auto border border-base-300 rounded-box">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-xs uppercase opacity-60">
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
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
