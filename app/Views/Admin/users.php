<!-- app/Views/user.php -->

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="flex flex-col gap-3">
    <div class="w-full">
        <div class="alert alert-info" role="alert">
            INFO&middot; <small>Search specify user by their (username, fullname, saldo or uplink).</small>
        </div>
        <div class="card mb-3">
            <div class="border-b px-4 py-3 font-semibold">Manage <?= $title ?></div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table id="datatable" class="table table-sm table-zebra" style="width:100%">
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
                                            $textc = (getLevel($user['level']) === 'Admin') ? 'badge-primary badge-outline' : 'badge-neutral badge-outline';
                                            $saldo = (getLevel($user['level']) === 'Admin') ? '&mstpos;' : $user['saldo'];
                                            echo "<span class='badge $textc'>$saldo</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $status = ($user['status'] == 1) ? 'Active' : 'Banned';
                                            $text_color = ($user['status'] == 1) ? 'text-success' : 'text-error';
                                            echo "<span class='$text_color'>$status</span>";
                                        ?>
                                    </td>
                                    <td><?= $user['uplink']; ?></td>
                                    <td>
                                        <div class="join">
                                            <a href="<?= base_url('admin/user') . '/' . $user['id_users']; ?>" class="btn btn-warning btn-sm join-item tooltip tooltip-left" data-tip="Edit key information?">
                                                <i class="bi bi-gear"></i>
                                            </a>
                                            <?php if (getLevel($user['level']) !== 'Admin') : ?>
                                            <a href="<?= base_url('admin/user/singledelete') . '/' . $user['id_users']; ?>" class="btn btn-error btn-sm join-item tooltip tooltip-left" data-tip="Delete User?">
                                                <i class="bi bi-trash"></i>
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
