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

<div class="card card-border bg-base-100 border-base-300">
    <div class="card-body">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
            <h2 class="card-title">Lib online</h2>
            <button type="button" class="btn btn-ghost btn-sm" onclick="document.getElementById('uploadModal').showModal()">
                Open upload
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="table" class="table table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Modified</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Render table data dynamically using PHP -->
                    <?php foreach ($files as $file) : ?>
                        <tr>
                            <td><span class="text-sm"><?= $file['name'] ?></span></td>
                            <td><span class="text-sm"><?= formatFileSize($file['size']) ?></span></td>
                            <td><span class="text-sm"><?= formatTimestamp($file['mtime']) ?></span></td>
                            <td><span class="text-sm"><?= $file['permissions'] ?></span></td>
                            <td>
                                <div class="join">
                                    <?php if (!$file['is_dir']) : ?>
                                        <a href="<?= base_url('libOnline/download/' . base64_encode($file['path'])) ?>" class="join-item btn btn-primary btn-sm">
                                            <svg class="icon"><use href="#i-download" /></svg>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($file['is_deleteable']) : ?>
                                        <a href="<?= base_url('libOnline/delete/' . base64_encode($file['path'])) ?>" class="join-item btn btn-error btn-sm">
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

<dialog id="uploadModal" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
                <svg class="icon"><use href="#i-x" /></svg>
            </button>
        </form>
        <h3 class="font-bold text-lg mb-4">Upload lib file</h3>
        <?= form_open_multipart('libOnline/upload'); ?>
        <input type="file" name="file" class="file-input w-full" accept=".so" required>
        <button type="submit" class="btn btn-error mt-4">Upload</button>
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
        $('#table').DataTable(daisyuiTableDefaults());
    });
</script>
<?= $this->endSection() ?>
