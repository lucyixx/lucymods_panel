<?php
// Helper function to format file size
function formatFileSize($bytes): string
{
    $s = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB'];
    for ($pos = 0; $bytes >= 1000; $pos++, $bytes /= 1024);
    $d = round($bytes * 10);
    return $pos ? (int)($d / 10) . '.' . $d % 10 . ' ' . $s[$pos] : $bytes . ' bytes';
}

// Helper function to format the timestamp
function formatTimestamp($unix_timestamp): string
{
    $m = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $d = new DateTime("@$unix_timestamp");
    return $m[$d->format('n') - 1] . ' ' . $d->format('j, Y h:i A');
}
// Helper function to format file permissions
function formatPermissions($file): string
{
    $perms = [];
    if ($file['is_readable']) $perms[] = 'read';
    if ($file['is_writable']) $perms[] = 'write';
    if ($file['is_executable']) $perms[] = 'exec';
    return implode('+', $perms);
}
?>

<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="flex justify-end mb-3">
    <button type="button" class="btn btn-sm" onclick="uploadModal.showModal()">
        <svg class="icon"><use href="#i-upload" /></svg> Open Upload
    </button>
</div>

<dialog id="uploadModal" class="modal">
    <div class="modal-box">
        <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="uploadModal.close()" aria-label="Close"><svg class="icon"><use href="#i-x" /></svg></button>
        <h3 class="font-bold text-lg mb-3 flex items-center gap-2"><svg class="icon"><use href="#i-upload" /></svg>Upload Lib File</h3>
        <?= form_open_multipart('libOnline/upload'); ?>
        <div class="mb-3">
            <input type="file" name="file" class="file-input w-full" accept=".so" required>
        </div>
        <button type="submit" class="btn btn-error w-full">Upload</button>
        <?= form_close(); ?>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<div class="overflow-x-auto border border-base-300 rounded-box">
    <table id="table" class="table table-sm">
        <thead>
            <tr class="text-xs uppercase opacity-60">
                <th>Name</th>
                <th>Size</th>
                <th>Modified</th>
                <th>Permissions</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file) : ?>
                <tr>
                    <td><span class="align-middle badge badge-ghost"><?= $file['name'] ?></span></td>
                    <td><span class="align-middle badge badge-ghost"><?= formatFileSize($file['size']) ?></span></td>
                    <td><span class="align-middle badge badge-ghost"><?= formatTimestamp($file['mtime']) ?></span></td>
                    <td><span class="align-middle badge badge-ghost"><?= $file['permissions'] ?></span></td>
                    <td class="text-right">
                        <div class="join">
                            <?php if (!$file['is_dir']) : ?>
                                <a href="<?= base_url('libOnline/download/' . base64_encode($file['path'])) ?>" class="btn btn-primary btn-sm join-item" aria-label="Download"><svg class="icon"><use href="#i-download" /></svg></a>
                            <?php endif; ?>
                            <?php if ($file['is_deleteable']) : ?>
                                <a href="<?= base_url('libOnline/delete/' . base64_encode($file['path'])) ?>" class="btn btn-error btn-sm join-item" aria-label="Delete"><svg class="icon"><use href="#i-trash" /></svg></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
<?= $this->endSection() ?>
