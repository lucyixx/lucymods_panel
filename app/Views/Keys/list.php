<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <p class="text-sm opacity-60"><?= $keylist ? 'Your registered license keys' : 'Nothing keys to show' ?></p>
    <div class="flex gap-1">
        <a class="btn btn-sm" href="<?= site_url('keys/download/all') ?>" aria-label="Download all"><svg class="icon"><use href="#i-download" /></svg></a>
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-sm" aria-label="Bulk delete"><svg class="icon"><use href="#i-trash" /></svg></div>
            <ul tabindex="0" class="dropdown-content menu bg-base-200 border border-base-300 rounded-box z-10 w-48 p-2 shadow-lg mt-2">
                <li><a href="<?= site_url('keys/start') ?>">Keys not used</a></li>
                <li><a href="<?= site_url('keys/delExp') ?>">Expired keys</a></li>
            </ul>
        </div>
        <a class="btn btn-primary btn-sm" href="<?= site_url('keys/generate') ?>"><svg class="icon"><use href="#i-plus" /></svg> Generate license</a>
    </div>
</div>

<?php if ($keylist) : ?>
    <form class="filter mb-3" id="key-filter">
        <input class="btn btn-sm filter-reset" type="radio" name="key_tier" aria-label="All" checked onclick="filterKeyTier('')" />
        <input class="btn btn-sm" type="radio" name="key_tier" aria-label="Free" onclick="filterKeyTier('Free')" />
        <input class="btn btn-sm" type="radio" name="key_tier" aria-label="Vip" onclick="filterKeyTier('Vip')" />
        <input class="btn btn-sm" type="radio" name="key_tier" aria-label="Test" onclick="filterKeyTier('Test')" />
    </form>
    <div class="overflow-x-auto border border-base-300 rounded-box">
        <table id="datatable" class="table table-sm w-full">
            <thead>
                <tr class="text-xs uppercase opacity-60">
                    <th>ID</th>
                    <th>Game</th>
                    <th>License key</th>
                    <th>Devices</th>
                    <th>Duration</th>
                    <th>Expired</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
        </table>
    </div>
<?php else : ?>
    <div class="border border-dashed border-base-300 rounded-box">
        <div class="flex flex-col items-center text-center py-12">
            <svg class="icon opacity-40 mb-2" style="width:2.5rem;height:2.5rem"><use href="#i-inbox" /></svg>
            <p class="font-medium">No keys yet</p>
            <p class="text-sm opacity-60 mb-3">Generate your first license to see it listed here.</p>
            <a href="<?= site_url('keys/generate') ?>" class="btn btn-primary btn-sm"><svg class="icon"><use href="#i-plus" /></svg> Generate license</a>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script type="text/javascript">
    let keysTable;

    function filterKeyTier(tier) {
        keysTable.column(3).search(tier, true, false).draw();
    }

    $(document).ready(function() {
        keysTable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [0, "desc"]
            ],
            ajax: {
                url: "<?= site_url('keys/api') ?>",
                type: "POST"
            },
            columns: [{
                    data: 'id',
                    name: 'id_keys',
                    render: function(data, type, row, meta) {
                        return `<span class="text-sm font-mono opacity-70">${data}</span>`
                    }
                },
                {
                    data: 'game',
                    render: function(data, type, row, meta) {
                        return `<span class="text-sm">${data}</span>`;
                    }
                },
                {
                    data: 'user_key',
                    render: function(data, type, row, meta) {
                        const is_valid = (row.status == 'Active') ? "text-success" : "text-error";
                        const key = row.user_key ?? '&mdash;';
                        return `<span class="text-sm font-mono opacity-70 ${is_valid}" data-key="${key}">${key}</span> `;
                    }
                },
                {
                    data: 'devices',
                    render: function(data, type, row, meta) {
                        const totalDevice = (row.devices ? row.devices : 0);
                        if (row.key_level == 1) {
                            return `<span class="text-sm badge badge-outline text-success" id="devMax-${row.user_key}">Free ${totalDevice}/${row.max_devices}</span>`;
                        } else if (row.key_level == 2) {
                            return `<span class="text-sm badge badge-outline text-warning" id="devMax-${row.user_key}">Vip ${totalDevice}/${row.max_devices}</span>`;
                        } else if (row.key_level == 3) {
                            return `<span class="text-sm badge badge-outline text-primary" id="devMax-${row.user_key}">Test ${totalDevice}/${row.max_devices}</span>`;
                        }
                    }
                },
                {
                    data: 'duration',
                    render: function(data, type, row, meta) {
                        return `<span class="text-sm">${data}</span>`;
                    }
                },
                {
                    data: 'expired',
                    name: 'expired_date',
                    render: function(data, type, row, meta) {
                        const currentDate = new Date();
                        const expirationDate = new Date(data + 'Z');
                        return `<span class="text-sm text-nowrap ${row.expired && expirationDate <= currentDate ? 'text-error' : ''}">${row.expired ? data : '(not started yet)'}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        const btnReset = `<button class="btn btn-ghost btn-xs join-item text-warning" onclick="resetUserKey('${row.user_key}')" aria-label="Reset"><svg class="icon"><use href="#i-refresh" /></svg></button>`;
                        const btnEdits = `<a href="<?= base_url('keys/') ?>${row.id}" class="btn btn-ghost btn-xs join-item" aria-label="Edit"><svg class="icon"><use href="#i-gear" /></svg></a>`;
                        const btnDelete = `<button class="btn btn-ghost btn-xs join-item text-error" onclick="deleteKeys('${row.user_key}')" aria-label="Delete"><svg class="icon"><use href="#i-trash" /></svg></button>`;
                        return `<div class="join justify-end w-full">${btnReset} ${btnEdits} ${btnDelete}</div>`;
                    }
                }
            ]
        });
    });

    function deleteKeys(keys) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) {
                Toast.fire({
                    icon: 'info',
                    title: 'Please wait...'
                })

                var api_url = "<?= site_url('keys/delete') ?>";
                $.getJSON(api_url, {
                        userkey: keys,
                        delete: 1
                    },
                    function(data, textStatus, jqXHR) {
                        if (textStatus == 'success') {
                            if (data.registered) {
                                if (data.delete) {
                                    $(`#devMax-${keys}`).html(`0/${data.devices_max}`);
                                    Swal.fire(
                                        'Delete!',
                                        'Key has been delete.',
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        data.devices_total ? "You don't have any access to this user." : "Only Admin can delete the user.",
                                        'error'
                                    )
                                }
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    "User key no longer exists.",
                                    'error'
                                )
                            }
                        }
                    }
                );
            }
        });
    }

    function resetUserKey(keys) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset'
        }).then((result) => {
            if (result.isConfirmed) {
                Toast.fire({
                    icon: 'info',
                    title: 'Please wait...'
                })

                var api_url = "<?= site_url('keys/reset') ?>";
                $.getJSON(api_url, {
                        userkey: keys,
                        reset: 1
                    },
                    function(data, textStatus, jqXHR) {
                        if (textStatus == 'success') {
                            if (data.registered) {
                                if (data.reset) {
                                    $(`#devMax-${keys}`).html(`0/${data.devices_max}`);
                                    Swal.fire(
                                        'Reset!',
                                        'Your device key has been reset.',
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        data.devices_total ? "You don't have any access to this user." : "User key devices already reset.",
                                        data.devices_total ? 'error' : 'warning'
                                    )
                                }
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    "User key no longer exists.",
                                    'error'
                                )
                            }
                        }
                    }
                );
            }
        });
    }
</script>
<?= $this->endSection() ?>
