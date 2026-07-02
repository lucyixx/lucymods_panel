
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
    <div class="col-lg-12">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col card-title m-0"><span>Lib Online</span></div>
                <div class="col text-end">
                    <button type="button" class="btn btn-default btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        Open Upload
                    </button>
                    <!-- The Bootstrap modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-dark" id="uploadModalLabel">Upload Lib File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?= form_open_multipart('libOnline/upload'); ?>
                                    <div class="mb-3">
                                        <input type="file" name="file" class="form-control" accept=".so" required>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Upload</button>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-sm table-borderless table-striped">
                    <thead>
                        <str>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Modfied</th>
                            <th>Permissons</th>
                            <th>Actions</th>
                        </str>
                    </thead>
                    <tbody>
                        <!-- Render table data dynamically using PHP -->
                        <?php foreach ($files as $file) : ?>
                            <tr>
                                <td><span class="align-middle badge text-dark"><?= $file['name'] ?></span></td>
                                <td><span class="align-middle badge text-dark"><?= formatFileSize($file['size']) ?></span></td>
                                <td><span class="align-middle badge text-dark"><?= formatTimestamp($file['mtime']) ?></span></td>
                                <td><span class="align-middle badge text-dark"><?= $file['permissions'] ?></span></td>
                                <td>
                                    <div class="btn-group">
                                        <?php if (!$file['is_dir']) : ?>
                                            <a href="<?= base_url('libOnline/download/' . base64_encode($file['path'])) ?>" class="btn btn-primary btn-sm"><i class="bi bi-download"></i></a>
                                        <?php endif; ?>
                                        <?php if ($file['is_deleteable']) : ?>
                                            <a href="<?= base_url('libOnline/delete/' . base64_encode($file['path'])) ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></a>
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
<script <?= csp_script_nonce() ?>>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
<?= $this->endSection() ?>