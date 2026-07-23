<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="lg:col-span-1">
        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Generate <?= $title ?></h2>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <div>
                        <label class="label" for="saldo">You can set with multiple saldo</label>
                        <label class="input w-full">
                            <svg class="icon opacity-50"><use href="#i-wallet" /></svg>
                            <input type="number" class="grow" name="saldo" id="saldo" minlength="1" maxlength="11" value="5">
                        </label>
                        <?php if ($validation->hasError('saldo')) : ?>
                            <small id="help-saldo" class="text-error"><?= $validation->getError('saldo') ?></small>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="label" for="level">Account Level</label>
                        <?= form_dropdown(['class' => 'select w-full', 'name' => 'level', 'id' => 'level'], getLevelArray(), 2) ?>
                    </div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Create Code</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <?php if ($code) : ?>
            <div class="card card-border bg-base-100 border-base-300">
                <div class="card-body">
                    <h2 class="card-title">History Generate - Total <?= $total_code ?></h2>
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
