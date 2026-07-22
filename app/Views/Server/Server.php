<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<div class="max-w-md">
    <?= $this->include('Layout/msgStatus') ?>

    <?= form_open() ?>
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box border p-4">
        <legend class="fieldset-legend">Server base mod</legend>

        <label class="label">Current status: <span class="font-medium"><?= esc($row->status) ?></span></label>
        <div class="flex flex-col gap-2 mb-2">
            <label class="label cursor-pointer justify-start gap-2">
                <input type="radio" name="radios" value="1" class="radio" <?= $row->status === 'on' ? 'checked' : '' ?> required>
                Online server
            </label>
            <label class="label cursor-pointer justify-start gap-2">
                <input type="radio" name="radios" value="2" class="radio" <?= $row->status !== 'on' ? 'checked' : '' ?>>
                Offline server
            </label>
        </div>

        <label class="label">Information</label>
        <input type="text" name="modname" id="modname" class="input w-full" value="<?= $row->modname ?>" placeholder="Input information" required>

        <label class="label">Offline message</label>
        <textarea class="textarea w-full" placeholder="Maintenance" name="myInput" id="myInput" rows="3"><?= $row->myinput ?></textarea>

        <button type="submit" class="btn btn-primary mt-4">Update</button>
    </fieldset>
    <?= form_close() ?>
</div>

<?= $this->endSection() ?>
