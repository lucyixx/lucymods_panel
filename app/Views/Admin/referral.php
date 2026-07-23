<?= $this->extend('Layout/BootstrapLayout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <?= $this->include('Layout/BootstrapMsgStatus') ?>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title m-0"><span>Generate <?= $title ?></span></div>
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <div class="form-group mb-3">
                    <label for="saldo">You can set with multiple saldo</label>
                    <div class="input-group mt-2">
                        <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                        <input type="number" class="form-control" name="saldo" id="saldo" minlength="1" maxlength="11" value="5">
                    </div>
                    <?php if ($validation->hasError('saldo')) : ?>
                        <small id="help-saldo" class="text-danger"><?= $validation->getError('saldo') ?></small>
                    <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                    <label for="level">Account Level</label>
                    <div class="input-group mt-2">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <?= form_dropdown(['class' => 'form-select', 'name' => 'level', 'id' => 'level'], getLevelArray(), 2) ?>
                    </div>
                </div>
                <div class="form-group text-end">
                    <button type="submit" class="btn btn-sm btn-primary">Create Code</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <?php if ($code) : ?>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title m-0"><span>History Generate - Total <?= $total_code ?></span></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless table-striped" style="width:100%">
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