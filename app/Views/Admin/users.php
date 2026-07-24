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
                                    <div class="tooltip" data-tip="Edit user">
                                        <button type="button" class="btn btn-warning btn-sm edit-user-btn"
                                            data-id="<?= esc($user['id_users'], 'attr') ?>"
                                            data-username="<?= esc($user['username'], 'attr') ?>"
                                            data-fullname="<?= esc((string) $user['fullname'], 'attr') ?>"
                                            data-level="<?= esc($user['level'], 'attr') ?>"
                                            data-status="<?= esc($user['status'], 'attr') ?>"
                                            data-saldo="<?= esc($user['saldo'], 'attr') ?>"
                                            data-uplink="<?= esc((string) $user['uplink'], 'attr') ?>"
                                            aria-label="Edit user <?= esc($user['username'], 'attr') ?>">
                                            <svg class="icon"><use href="#i-gear" /></svg>
                                        </button>
                                    </div>
                                    <?php if (getLevel($user['level']) !== 'Admin') : ?>
                                    <div class="tooltip" data-tip="Delete User?">
                                        <a href="<?= base_url('admin/user/singledelete') . '/' . $user['id_users']; ?>" class="btn btn-error btn-sm" aria-label="Delete user <?= esc($user['username'], 'attr') ?>">
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

<!-- Edit User Modal — one shared modal for all rows, populated via data-* on click -->
<dialog id="editUserModal" class="modal">
    <div class="modal-box max-h-[85vh] overflow-y-auto">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">
                <svg class="icon"><use href="#i-x" /></svg>
            </button>
        </form>
        <h3 class="text-lg font-bold mb-2">Edit User</h3>

        <?= form_open('#', ['id' => 'editUserForm']) ?>
        <input type="hidden" name="user_id" id="edit_user_id">
        <fieldset class="fieldset gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label" for="edit_username">Username</label>
                    <input type="text" name="username" id="edit_username" class="input w-full" required>
                </div>
                <div>
                    <label class="label" for="edit_fullname">Fullname</label>
                    <input type="text" name="fullname" id="edit_fullname" class="input w-full">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label" for="edit_level">Roles</label>
                    <?= form_dropdown(['class' => 'select w-full', 'name' => 'level', 'id' => 'edit_level'], getLevelArray()) ?>
                </div>
                <div>
                    <label class="label" for="edit_status">Status</label>
                    <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                    <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'edit_status'], $sel_status) ?>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label" for="edit_saldo">Saldo</label>
                    <input type="number" name="saldo" id="edit_saldo" class="input w-full">
                </div>
                <div>
                    <label class="label" for="edit_uplink">Uplink</label>
                    <input type="text" name="uplink" id="edit_uplink" class="input w-full" disabled>
                </div>
            </div>
        </fieldset>

        <div class="modal-action">
            <button type="button" class="btn" onclick="editUserModal.close()">Cancel</button>
            <button type="submit" form="editUserForm" class="btn btn-primary">Save Changes</button>
        </div>
        <?= form_close() ?>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable();

        $('.edit-user-btn').on('click', function() {
            var btn = $(this);
            var id = btn.data('id');

            document.getElementById('editUserForm').action = '<?= site_url('admin/user') ?>/' + id;
            $('#edit_user_id').val(id);
            $('#edit_username').val(btn.data('username'));
            $('#edit_fullname').val(btn.data('fullname'));
            $('#edit_level').val(btn.data('level'));
            $('#edit_status').val(btn.data('status'));
            $('#edit_saldo').val(btn.data('saldo'));
            $('#edit_uplink').val(btn.data('uplink'));

            document.getElementById('editUserModal').showModal();
        });
    });
</script>
<?= $this->endSection() ?>
