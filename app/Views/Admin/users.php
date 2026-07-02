<!-- app/Views/user.php -->

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-primary" role="alert">
            INFO&middot; <small>Search specify user by their (username, fullname, saldo or uplink).</small>
        </div>
        <div class="card mb-3">
            <div class="card-header">
               <div class="card-title m-0"><span>Manage <?= $title ?></span></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-borderless table-hover table-sm table-striped" style="width:100%">
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
                                            $textc = (getLevel($user['level']) === 'Admin') ? 'primary' : 'dark';
                                            $saldo = (getLevel($user['level']) === 'Admin') ? '&mstpos;' : $user['saldo'];
                                            echo "<span class='badge text-$textc'>$saldo</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $status = ($user['status'] == 1) ? 'Active' : 'Banned';
                                            $text_color = ($user['status'] == 1) ? 'success' : 'danger';
                                            echo "<span class='text-$text_color'>$status</span>";
                                        ?>
                                    </td>
                                    <td><?= $user['uplink']; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('admin/user') . '/' . $user['id_users']; ?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" title="Edit key information?">
                                                <i class="bi bi-gear"></i>
                                            </a>
                                            <?php if (getLevel($user['level']) !== 'Admin') : ?>
                                            <a href="<?= base_url('admin/user/singledelete') . '/' . $user['id_users']; ?>" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete User?">
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