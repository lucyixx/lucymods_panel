
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
<?= $this->section('content') ?>
<main>
    <div class="w-full">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="panel mb-3">
        <div class="panel-head">
            <span class="panel-head-title">Lib Online</span>
            <div class="text-right">
                <button type="button" class="btn btn-default btn-sm" onclick="uploadModal.showModal()">
                    Open Upload
                </button>
                <!-- Native <dialog> modal (daisyUI), replaces the Bootstrap modal -->
                <dialog id="uploadModal" class="modal">
                    <div class="modal-box">
                        <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="uploadModal.close()" aria-label="Close">✕</button>
                        <h3 class="font-bold text-lg mb-3">Upload Lib File</h3>
                        <?= form_open_multipart('libOnline/upload'); ?>
                        <div class="mb-3">
                            <input type="file" name="file" class="file-input file-input-bordered w-full" accept=".so" required>
                        </div>
                        <button type="submit" class="btn btn-error">Upload</button>
                        <?= form_close(); ?>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>
            </div>
        </div>
        <div class="panel-body">
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
                                <td><span class="align-middle badge badge-ghost"><?= $file['name'] ?></span></td>
                                <td><span class="align-middle badge badge-ghost"><?= formatFileSize($file['size']) ?></span></td>
                                <td><span class="align-middle badge badge-ghost"><?= formatTimestamp($file['mtime']) ?></span></td>
                                <td><span class="align-middle badge badge-ghost"><?= $file['permissions'] ?></span></td>
                                <td>
                                    <div class="join">
                                        <?php if (!$file['is_dir']) : ?>
                                            <a href="<?= base_url('libOnline/download/' . base64_encode($file['path'])) ?>" class="btn btn-primary btn-sm join-item"><i class="bi bi-download"></i></a>
                                        <?php endif; ?>
                                        <?php if ($file['is_deleteable']) : ?>
                                            <a href="<?= base_url('libOnline/delete/' . base64_encode($file['path'])) ?>" class="btn btn-error btn-sm join-item"><i class="bi bi-trash-fill"></i></a>
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
</main>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
<?= $this->endSection() ?>
