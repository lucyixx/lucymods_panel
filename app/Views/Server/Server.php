<?= $this->extend('Layout/BootstrapLayout') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <?= $this->include('Layout/BootstrapMsgStatus') ?>
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <div class="card-title m-0"><span>Server Base Mod</span></div>
            </div>
            <div class="card-body">
                <?= form_open() ?>
                <div class="my-3">
                    <div class="mb-3">
                        <label for="status">Current Status: <span class="text-danger">*</span><span style="color: #a39c9b;"><?= $row->status; ?></span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="radio" id="radio" name="radios" value="1" aria-label="Checkbox for following text input" required>
                                <small required>&nbsp; Online Server</small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input type="radio" id="radio" name="radios" value="2" aria-label="Checkbox for following text input">
                                <small required>&nbsp; Offline Server</small>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="modname" class="input-group-text">Information</label>
                        <input type="text" name="modname" id="modname" class="form-control" value="<?= $row->modname ?>" placeholder="Input Information" required>
                    </div>
                    <div class="input-group mb-3">
                        <label for="myInput" class="input-group-text">Offline Msg</label>
                        <textarea class="form-control" placeholder="Maintenance" name="myInput" id="myInput" id="exampleFormControlTextarea1" rows="1"><?= $row->myinput; ?></textarea>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>