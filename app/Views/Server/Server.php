<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex justify-center">
    <div class="w-full lg:w-1/2">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body">
                <h1 class="card-title text-base mb-1">Server base mod</h1>
                <?= form_open() ?>
                <div class="my-3 flex flex-col gap-4">
                    <fieldset class="fieldset p-0">
                        <legend class="fieldset-legend">Current status: <span class="opacity-70"><?= $row->status; ?></span></legend>
                        <div class="flex flex-col gap-1">
                            <label class="label cursor-pointer gap-2 justify-start">
                                <input type="radio" class="radio radio-sm" name="radios" value="1" required>
                                <span class="label-text">Online server</span>
                            </label>
                            <label class="label cursor-pointer gap-2 justify-start">
                                <input type="radio" class="radio radio-sm" name="radios" value="2">
                                <span class="label-text">Offline server</span>
                            </label>
                        </div>
                    </fieldset>
                    <div>
                        <label class="input validator w-full">
                            <i class="bi bi-info-circle opacity-60"></i>
                            <input type="text" name="modname" id="modname" placeholder="Information" value="<?= $row->modname ?>" required>
                        </label>
                    </div>
                    <fieldset class="fieldset p-0">
                        <legend class="fieldset-legend">Offline message</legend>
                        <textarea class="textarea w-full" placeholder="Maintenance" name="myInput" id="myInput" rows="2"><?= $row->myinput; ?></textarea>
                    </fieldset>
                </div>
                <div class="text-right mt-1">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
