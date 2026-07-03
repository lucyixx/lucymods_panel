<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex justify-center">
    <div class="w-full lg:w-1/2">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="card shadow-sm mb-3">
            <div class="border-b px-4 py-3 font-semibold">Server Base Mod</div>
            <div class="card-body">
                <?= form_open() ?>
                <div class="my-3">
                    <div class="mb-3">
                        <label for="status" class="label"><span class="label-text">Current Status: <span class="text-error">*</span> <span style="color: #a39c9b;"><?= $row->status; ?></span></span></label>
                        <div class="flex flex-col gap-2 mb-3">
                            <label class="label cursor-pointer gap-2 justify-start">
                                <input type="radio" class="radio radio-sm" id="radio" name="radios" value="1" aria-label="Checkbox for following text input" required>
                                <span class="label-text">Online Server</span>
                            </label>
                            <label class="label cursor-pointer gap-2 justify-start">
                                <input type="radio" class="radio radio-sm" id="radio" name="radios" value="2" aria-label="Checkbox for following text input">
                                <span class="label-text">Offline Server</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modname" class="label"><span class="label-text">Information</span></label>
                        <input type="text" name="modname" id="modname" class="input input-bordered w-full" value="<?= $row->modname ?>" placeholder="Input Information" required>
                    </div>
                    <div class="mb-3">
                        <label for="myInput" class="label"><span class="label-text">Offline Msg</span></label>
                        <textarea class="textarea textarea-bordered w-full" placeholder="Maintenance" name="myInput" id="myInput" rows="1"><?= $row->myinput; ?></textarea>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
