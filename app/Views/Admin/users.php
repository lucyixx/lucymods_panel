<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css") ?>
<?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="alert alert-info mb-4">
    <svg class="icon"><use href="#i-alert" /></svg>
    <span>INFO&middot; <small>Search specify user by their (username, fullname, saldo or uplink).</small></span>
</div>

<div class="card card-border bg-base-100 border-base-300">
    <div class="card-body">
        <h2 class="card-title">Manage <?= $title ?></h2>
        <div class="overflow-x-auto">
            <table id="datatable" class="table table-zebra" style="width:100%">
                <thead>
                    <tr>
                        <th scope="row">#</th>
                        <th>Username</th>
                        <th>Fullname</th>
                        <th>Level</th>
                        <th>Asset</th>
                        <th>Status</th>
                        <th>Uplink</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_list as $user) : ?>
                        <tr>
                            <td><?= $user['id_users']; ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['fullname'] ? $user['fullname'] : '~'; ?></td>
                            <td><?= $user['level']; ?></td>
                            <td>
                                <?php
                                    $textc = (getLevel($user['level']) === 'Admin') ? 'primary' : 'base-content';
                                    $saldo = (getLevel($user['level']) === 'Admin') ? '&mstpos;' : $user['saldo'];
                                    echo "<span class='text-$textc'>$saldo</span>";
                                ?>
                            </td>
                            <td>
                                <?php
                                    $status = ($user['status'] == 1) ? 'Active' : 'Banned';
                                    $badgeColor = ($user['status'] == 1) ? 'badge-success' : 'badge-error';
                                    echo "<span class='badge $badgeColor'>$status</span>";
                                ?>
                            </td>
                            <td><?= $user['uplink']; ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <div class="tooltip" data-tip="Edit key information?">
                                        <a href="<?= base_url('admin/user') . '/' . $user['id_users']; ?>" class="btn btn-warning btn-sm">
                                            <svg class="icon"><use href="#i-gear" /></svg>
                                        </a>
                                    </div>
                                    <?php if (getLevel($user['level']) !== 'Admin') : ?>
                                    <div class="tooltip" data-tip="Delete User?">
                                        <a href="<?= base_url('admin/user/singledelete') . '/' . $user['id_users']; ?>" class="btn btn-error btn-sm">
                                            <svg class="icon"><use href="#i-trash" /></svg>
                                        </a>
                                    </div>
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

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable();
    });
</script>
<?= $this->endSection() ?>
