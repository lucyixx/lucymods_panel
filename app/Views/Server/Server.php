<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="max-w-md">
    <?= form_open() ?>
    <p class="text-sm mb-3">Current status: <span class="badge badge-outline badge-sm ml-1"><?= $row->status; ?></span></p>
    <div class="flex flex-col gap-1 mb-4">
        <label class="label cursor-pointer gap-2 justify-start">
            <input type="radio" class="radio radio-sm" name="radios" value="1" required>
            <span class="label-text">Online server</span>
        </label>
        <label class="label cursor-pointer gap-2 justify-start">
            <input type="radio" class="radio radio-sm" name="radios" value="2">
            <span class="label-text">Offline server</span>
        </label>
    </div>
    <div class="mb-3">
        <label class="input validator w-full">
            <svg class="icon opacity-60"><use href="#i-shield" /></svg>
            <input type="text" name="modname" id="modname" placeholder="Information" value="<?= $row->modname ?>" required>
        </label>
    </div>
    <div class="mb-4">
        <p class="text-sm opacity-60 mb-1">Offline message</p>
        <textarea class="textarea w-full" placeholder="Maintenance" name="myInput" id="myInput" rows="2"><?= $row->myinput; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Update</button>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
