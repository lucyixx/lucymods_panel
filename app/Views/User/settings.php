<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card mb-3">
            <div class="card-header">
                <div class="card-title m-0"><span>Accont Information</span></div>
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <div class="my-3">
                    <div class="my-3">
                        <div class="mb-3">
                            <div class="input-group">
                                <label for="fullname" class="input-group-text"><i class="bi bi-person-gear"></i></label>
                                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Admin full name" value="<?= old('fullname') ?: $user->fullname ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="current" class="input-group-text"><i class="bi bi-shield-lock"></i></label>
                            <input type="password" name="current" id="current" class="form-control" placeholder="Current Password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="password" class="input-group-text"><i class="bi bi-shield-lock"></i></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="password2" class="input-group-text"><i class="bi bi-shield-lock"></i></label>
                            <input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-sm btn-primary">Change Password</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>