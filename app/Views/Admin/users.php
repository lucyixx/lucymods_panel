<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<div class="alert alert-info mb-4" role="alert">
    <svg class="icon"><use href="#i-shield" /></svg>
    <span>Search specify user by their (username, fullname, saldo or uplink).</span>
</div>

<div class="overflow-x-auto border border-base-300 rounded-box">
    <table id="datatable" class="table table-sm" style="width:100%">
        <thead>
            <tr class="text-xs uppercase opacity-60">
                <th scope="row">#</th>
                <th>Username</th>
                <th>Fullname</th>
                <th>Level</th>
                <th>Asset</th>
                <th>Status</th>
                <th>Uplink</th>
                <th class="text-right">Action</th>
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
                            echo "<span class='$text_color text-sm'>$status</span>";
                        ?>
                    </td>
                    <td><?= $user['uplink']; ?></td>
                    <td class="text-right">
                        <div class="join">
                            <a href="<?= base_url('admin/user') . '/' . $user['id_users']; ?>" class="btn btn-warning btn-xs join-item tooltip tooltip-left" data-tip="Edit key information?" aria-label="Edit">
                                <svg class="icon"><use href="#i-gear" /></svg>
                            </a>
                            <?php if (getLevel($user['level']) !== 'Admin') : ?>
                                <a href="<?= base_url('admin/user/singledelete') . '/' . $user['id_users']; ?>" class="btn btn-error btn-xs join-item tooltip tooltip-left" data-tip="Delete User?" aria-label="Delete">
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
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable();
    });
</script>
<?= $this->endSection() ?>
