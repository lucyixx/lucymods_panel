<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
<?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css") ?>
<?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="card card-border bg-base-100 border-base-300">
    <div class="card-body">
        <div class="flex justify-between items-center mb-2 gap-2 flex-wrap">
            <h2 class="card-title">Keys Registered</h2>
            <div class="flex items-center gap-1">
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/generate') ?>" aria-label="Generate key">
                    <svg class="icon"><use href="#i-plus" /></svg>
                </a>
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/download/all') ?>" aria-label="Download all keys">
                    <svg class="icon"><use href="#i-download" /></svg>
                </a>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm" aria-label="Bulk delete options">
                        <svg class="icon"><use href="#i-trash" /></svg>
                    </div>
                    <ul tabindex="0" class="menu dropdown-content bg-base-200 border border-base-300 rounded-box z-[var(--z-modal)] mt-2 w-48 p-2 shadow-sm">
                        <li><a href="<?= site_url('keys/start') ?>">Keys Not Use</a></li>
                        <li><a href="<?= site_url('keys/delExp') ?>">Expired Keys</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if ($keylist) : ?>
            <div class="overflow-x-auto">
                <table id="datatable" class="table table-sm table-zebra w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Game</th>
                            <th>User Keys</th>
                            <th>Devices</th>
                            <th>Duration</th>
                            <th>Expired</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center opacity-70">Nothing keys to show</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        const table = $('#datatable').DataTable({
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
                        return `<span class="text-xs">${data}</span>`
                    }
                },
                {
                    data: 'game',
                    render: function(data, type, row, meta) {
                        return `<span class="text-xs">${data}</span>`;
                    }
                },
                {
                    data: 'user_key',
                    render: function(data, type, row, meta) {
                        const is_valid = (row.status == 'Active') ? "text-success" : "text-error";
                        const key = row.user_key ?? '&mdash;';
                        return `<span class="text-xs opacity-70 ${is_valid}" data-key="${key}">${key}</span> `;
                    }
                },
                {
                    data: 'devices',
                    render: function(data, type, row, meta) {
                        const totalDevice = (row.devices ? row.devices : 0);
                        if (row.key_level == 1) {
                            return `<span class="text-xs badge badge-success" id="devMax-${row.user_key}">Free ${totalDevice}/${row.max_devices}</span>`;
                        } else if (row.key_level == 2) {
                            return `<span class="text-xs badge badge-warning" id="devMax-${row.user_key}">Vip ${totalDevice}/${row.max_devices}</span>`;
                        } else if (row.key_level == 3) {
                            return `<span class="text-xs badge badge-primary" id="devMax-${row.user_key}">Test ${totalDevice}/${row.max_devices}</span>`;
                        }
                    }
                },
                {
                    data: 'duration',
                    render: function(data, type, row, meta) {
                        return `<span class="text-xs">${data}</span>`;
                    }
                },
                {
                    data: 'expired',
                    name: 'expired_date',
                    render: function(data, type, row, meta) {
                        const currentDate = new Date();
                        const expirationDate = new Date(data + 'Z');
                        return `<span class="text-xs text-nowrap ${row.expired && expirationDate <= currentDate ? 'text-error' : ''}">${row.expired ? data : '(not started yet)'}</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        console.log(row);
                        const btnReset = `<button class="btn btn-ghost btn-xs join-item" onclick="resetUserKey('${row.user_key}')"><svg class="icon" style="width:0.9rem;height:0.9rem"><use href="#i-refresh" /></svg></button>`;
                        const btnEdits = `<a href="<?= base_url('keys/') ?>${row.id}" class="btn btn-ghost btn-xs join-item"><svg class="icon" style="width:0.9rem;height:0.9rem"><use href="#i-gear" /></svg></a>`;
                        const btnDelete = `<button class="btn btn-ghost btn-xs join-item text-error" onclick="deleteKeys('${row.user_key}')"><svg class="icon" style="width:0.9rem;height:0.9rem"><use href="#i-trash" /></svg></button>`;
                        return `<div class="join">${btnReset} ${btnEdits} ${btnDelete}</div>`;
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
                                        data.devices_total ? 'error' : 'error'

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
