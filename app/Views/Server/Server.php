<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex justify-center">
    <div class="w-full max-w-xl">
        <?= $this->include('Layout/msgStatus') ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Server Base Mod</h2>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <div>
                        <label class="label" for="status">Current Status: <span class="text-error">*</span> <span class="opacity-70"><?= $row->status; ?></span></label>
                        <div class="flex flex-col gap-2 mt-2">
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" id="radio" name="radios" value="1" class="radio" aria-label="Online Server" required>
                                Online Server
                            </label>
                            <label class="label cursor-pointer justify-start gap-2">
                                <input type="radio" id="radio" name="radios" value="2" class="radio" aria-label="Offline Server">
                                Offline Server
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="label" for="modname">Information</label>
                        <input type="text" name="modname" id="modname" class="input w-full" value="<?= $row->modname ?>" placeholder="Input Information" required>
                    </div>
                    <div>
                        <label class="label" for="myInput">Offline Msg</label>
                        <textarea class="textarea w-full" placeholder="Maintenance" name="myInput" id="myInput" rows="1"><?= $row->myinput; ?></textarea>
                    </div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
