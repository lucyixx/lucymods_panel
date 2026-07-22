<!-- app/Views/user.php -->

<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<div role="alert" class="alert alert-info mb-3">
    <span>INFO &middot; Search specify user by their (username, fullname, saldo or uplink).</span>
</div>

<div class="card card-border bg-base-100 border-base-300">
    <div class="card-body">
        <h2 class="card-title">Manage <?= $title ?></h2>

        <div class="overflow-x-auto">
            <table id="datatable" class="table table-sm" style="width:100%">
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
                                    $badgeColor = (getLevel($user['level']) === 'Admin') ? 'primary' : 'neutral';
                                    $saldo = (getLevel($user['level']) === 'Admin') ? '&mstpos;' : $user['saldo'];
                                    echo "<span class='badge badge-$badgeColor'>$saldo</span>";
                                ?>
                            </td>
                            <td>
                                <?php
                                    $status = ($user['status'] == 1) ? 'Active' : 'Banned';
                                    $badgeStatus = ($user['status'] == 1) ? 'success' : 'error';
                                    echo "<span class='badge badge-$badgeStatus'>$status</span>";
                                ?>
                            </td>
                            <td><?= $user['uplink']; ?></td>
                            <td>
                                <div class="join">
                                    <a href="<?= base_url('admin/user') . '/' . $user['id_users']; ?>" class="join-item btn btn-warning btn-sm tooltip" data-tip="Edit key information?">
                                        <svg class="icon"><use href="#i-gear" /></svg>
                                    </a>
                                    <?php if (getLevel($user['level']) !== 'Admin') : ?>
                                        <a href="<?= base_url('admin/user/singledelete') . '/' . $user['id_users']; ?>" class="join-item btn btn-error btn-sm tooltip" data-tip="Delete user?">
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

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable(daisyuiTableDefaults());
    });
</script>
<?= $this->endSection() ?>
