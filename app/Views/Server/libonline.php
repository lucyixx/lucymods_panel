
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
function formatPermissions($file) : string
{
    $perms = [];
    if ($file['is_readable']) $perms[] = 'read';
    if ($file['is_writable']) $perms[] = 'write';
    if ($file['is_executable']) $perms[] = 'exec';
    return implode('+', $perms);
}
?>
<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css") ?>
<?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="card card-border bg-base-100 border-base-300">
    <div class="card-body">
        <div class="flex items-center justify-between">
            <h2 class="card-title">Lib Online</h2>
            <button type="button" class="btn btn-primary btn-sm" onclick="uploadModal.showModal()">
                <svg class="icon"><use href="#i-upload" /></svg>Open Upload
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="table" class="table table-sm table-zebra">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Modfied</th>
                        <th>Permissons</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Render table data dynamically using PHP -->
                    <?php foreach ($files as $file) : ?>
                        <tr>
                            <td><span class="badge badge-ghost"><?= $file['name'] ?></span></td>
                            <td><span class="badge badge-ghost"><?= formatFileSize($file['size']) ?></span></td>
                            <td><span class="badge badge-ghost"><?= formatTimestamp($file['mtime']) ?></span></td>
                            <td><span class="badge badge-ghost"><?= $file['permissions'] ?></span></td>
                            <td>
                                <div class="join">
                                    <?php if (!$file['is_dir']) : ?>
                                        <a href="<?= base_url('libOnline/download/' . base64_encode($file['path'])) ?>" class="btn btn-primary btn-sm join-item">
                                            <svg class="icon"><use href="#i-download" /></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($file['is_deleteable']) : ?>
                                        <a href="<?= base_url('libOnline/delete/' . base64_encode($file['path'])) ?>" class="btn btn-error btn-sm join-item">
                                            <svg class="icon"><use href="#i-trash" /></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload dialog: native <dialog>, showModal()/close() — no Bootstrap Modal JS -->
<dialog id="uploadModal" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">
                <svg class="icon"><use href="#i-x" /></svg>
            </button>
        </form>
        <h3 class="text-lg font-bold">Upload Lib File</h3>
        <?= form_open_multipart('libOnline/upload'); ?>
        <fieldset class="fieldset mt-2">
            <input type="file" name="file" class="file-input w-full" accept=".so" required>
        </fieldset>
        <div class="modal-action">
            <button type="submit" class="btn btn-error">Upload</button>
        </div>
        <?= form_close(); ?>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
<?= $this->endSection() ?>
