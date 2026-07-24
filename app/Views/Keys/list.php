<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
<?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css") ?>
<?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<?php if (session()->getFlashdata('user_key')) : ?>
    <div class="alert alert-success mb-4">
        <svg class="icon"><use href="#i-check-circle" /></svg>
        <div>
            Game : <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days<br>
            License : <?= session()->getFlashdata('user_key') ?><br>
            Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
            <small class="block mt-1 opacity-80">
                <i>Duration will start when license login.</i><br>
                <svg class="icon" style="width:0.9rem;height:0.9rem;display:inline-block;vertical-align:-0.15em"><use href="#i-download" /></svg>
                <a href="<?= site_url('keys/download/new') ?>" class="link">Download New Keys Hare</a><br>
                <svg class="icon" style="width:0.9rem;height:0.9rem;display:inline-block;vertical-align:-0.15em"><use href="#i-wallet" /></svg>
                Saldo Reduce :
                <span class="text-error">-<?= session()->getFlashdata('fees') ?></span>
                (Total left <?= $user->saldo ?>$)
            </small>
        </div>
    </div>
<?php endif; ?>

<div class="card card-border bg-base-100 border-base-300">
    <div class="card-body">
        <div class="flex justify-between items-center mb-2 gap-2 flex-wrap">
            <h2 class="card-title">Keys Registered</h2>
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-primary btn-sm" onclick="createLicenseModal.showModal()">
                    <svg class="icon"><use href="#i-plus" /></svg>Create License
                </button>
                <div class="tooltip" data-tip="Download all keys">
                    <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/download/all') ?>" aria-label="Download all keys">
                        <svg class="icon"><use href="#i-download" /></svg>
                    </a>
                </div>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm" aria-label="More bulk actions">
                        More
                        <svg class="icon" style="width:0.8rem;height:0.8rem"><use href="#i-chev-r" /></svg>
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

<!-- Create License Modal (was Keys/generate.php) — ids prefixed create_* to avoid
     colliding with the Edit License Modal below, which reuses the original
     unprefixed ids (#game/#user_key/#duration/#key_level/#max_devices) since those
     are the ones explicitly required to stay as-is. -->
<dialog id="createLicenseModal" class="modal">
    <div class="modal-box max-w-2xl max-h-[85vh] overflow-y-auto">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">
                <svg class="icon"><use href="#i-x" /></svg>
            </button>
        </form>
        <h3 class="text-lg font-bold mb-2">Create License</h3>

        <?= form_open('keys/generate', ['id' => 'generateForm']) ?>
        <fieldset class="fieldset gap-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label" for="create_game">Game</label>
                    <?= form_dropdown('game', $game, old('game'), 'class="select w-full" id="create_game" required') ?>
                </div>
                <div>
                    <label class="label" for="create_max_devices">Max devices</label>
                    <input type="number" name="max_devices" id="create_max_devices" class="input w-full" placeholder="max device" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
                </div>
                <div>
                    <label class="label" for="create_user_key">Key name</label>
                    <div class="join w-full">
                        <label class="input join-item grow">
                            <svg class="icon opacity-50"><use href="#i-key" /></svg>
                            <input type="text" name="user_key" id="create_user_key" class="grow" placeholder="key name" value="<?= old('user_key') ?>" required>
                        </label>
                        <button class="btn btn-outline join-item" type="button" id="create_random_key" aria-label="Generate random key">
                            <svg class="icon"><use href="#i-shuffle" /></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="label" for="create_duration">Duration</label>
                    <?= form_dropdown('duration', $duration, old('duration'), 'class="select w-full" id="create_duration" required') ?>
                </div>
                <div>
                    <label class="label" for="create_key_level">Key level</label>
                    <?= form_dropdown('key_level', $levels, old('key_level'), 'id="create_key_level" class="select w-full" required') ?>
                </div>
                <div>
                    <label class="label" for="create_estimation">Estimation</label>
                    <input type="text" id="create_estimation" class="input w-full" disabled>
                </div>
            </div>
        </fieldset>

        <div class="modal-action">
            <button type="button" class="btn" onclick="createLicenseModal.close()">Cancel</button>
            <button type="submit" form="generateForm" class="btn btn-primary">Create License</button>
        </div>
        <?= form_close() ?>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<!-- Edit License Modal (was Keys/key_edit.php) — one shared modal for every row,
     populated from the DataTables row object (no per-row modal, no AJAX fetch). -->
<dialog id="editLicenseModal" class="modal">
    <div class="modal-box max-w-2xl max-h-[85vh] overflow-y-auto">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" aria-label="Close">
                <svg class="icon"><use href="#i-x" /></svg>
            </button>
        </form>
        <h3 class="text-lg font-bold mb-2">Edit License</h3>

        <?= form_open('keys/edit', ['id' => 'editKeyForm']) ?>
        <input type="hidden" name="id_keys" id="edit_id_keys">
        <fieldset class="fieldset gap-4">
            <?php if ($user->level == 1) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label" for="game">Game</label>
                        <?= form_dropdown('game', $game, '', 'class="select w-full" id="game" required') ?>
                    </div>
                    <div>
                        <label class="label" for="user_key">User key</label>
                        <label class="input w-full">
                            <svg class="icon opacity-50"><use href="#i-key" /></svg>
                            <input type="text" name="user_key" id="user_key" class="grow" required>
                        </label>
                    </div>
                    <div>
                        <label class="label" for="registrator">Registrator</label>
                        <label class="input w-full">
                            <svg class="icon opacity-50"><use href="#i-user" /></svg>
                            <input type="text" name="registrator" id="registrator" class="grow" placeholder="Seller" required>
                        </label>
                    </div>
                    <div>
                        <label class="label" for="max_devices">Max devices</label>
                        <input type="number" name="max_devices" id="max_devices" class="input w-full" placeholder="Max devices" min="1" required>
                    </div>
                    <div>
                        <label class="label" for="logins_remaining">Logins remaining</label>
                        <input type="number" name="logins_remaining" id="logins_remaining" class="input w-full" placeholder="Logins remaining" min="0" required>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div id="col-status">
                    <label class="label" for="status">Status</label>
                    <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                    <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'status', 'required'], $sel_status) ?>
                </div>
                <div>
                    <label class="label" for="key_level">Key level</label>
                    <?= form_dropdown('key_level', $levels, '', 'class="select w-full" id="key_level" required') ?>
                </div>
                <div>
                    <label class="label" for="expired_date">Expired date</label>
                    <input type="datetime-local" class="input w-full" name="expired_date" id="expired_date">
                </div>
                <div>
                    <label class="label" for="duration">Duration</label>
                    <input type="number" name="duration" id="duration" class="input w-full" placeholder="3" min="1" required>
                </div>
            </div>

            <div>
                <label class="label" for="devices">
                    Devices <span class="badge badge-neutral maxDev">0/0</span>
                    <span class="text-xs opacity-60">(Separately with enter)</span>
                </label>
                <textarea class="textarea w-full" name="devices" id="devices" rows="3"></textarea>
            </div>
        </fieldset>

        <div class="modal-action">
            <button type="button" class="btn" onclick="editLicenseModal.close()">Cancel</button>
            <button type="submit" class="btn btn-primary btnUpdate" form="editKeyForm" disabled>Save Changes</button>
        </div>
        <?= form_close() ?>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        // Re-open Create License modal if a submission just failed validation
        // (generate_action() redirects back with old() input + msgDanger/msgWarning).
        <?php if (old('game') !== null || old('user_key') !== null) : ?>
            createLicenseModal.showModal();
        <?php endif; ?>

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
                        const btnEdit = `<button type="button" class="btn btn-primary btn-xs join-item edit-key-btn" aria-label="Edit license ${row.user_key}"><svg class="icon" style="width:0.85rem;height:0.85rem"><use href="#i-gear" /></svg>Edit</button>`;
                        return `
                            <div class="join">
                                ${btnEdit}
                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-ghost btn-xs join-item" aria-label="More actions for ${row.user_key}">More</div>
                                    <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-200 border border-base-300 rounded-box z-[var(--z-modal)] mt-2 w-40 p-2 shadow-sm">
                                        <li><a onclick="resetUserKey('${row.user_key}')"><svg class="icon" style="width:0.85rem;height:0.85rem"><use href="#i-refresh" /></svg>Reset</a></li>
                                        <li><a onclick="deleteKeys('${row.user_key}')" class="text-error"><svg class="icon" style="width:0.85rem;height:0.85rem"><use href="#i-trash" /></svg>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function() {
                $('.edit-key-btn').off('click').on('click', function() {
                    const rowData = table.row($(this).closest('tr')).data();
                    openEditLicenseModal(rowData);
                });
            }
        });

        // ---- Create License modal behavior (was Keys/generate.php inline JS) ----
        const price = JSON.parse('<?= $price ?>');
        getPrice(price);

        $("#create_max_devices, #create_duration, #create_game").change(function() {
            getPrice(price);
        });

        function getPrice(price) {
            const device = $("#create_max_devices").val();
            const durate = $("#create_duration").val();
            const gprice = price[durate];
            if (gprice != NaN) {
                var result = (device * gprice);
                $("#create_estimation").val(result);
            } else {
                $("#create_estimation").val('Estimation error');
            }
        }

        $("#create_random_key").click(function(a) {
            $("#create_user_key").val(randomString('alnum', 16));
        });

        function randomString(type, length) {
            var characters = '';
            if (type === 'alnum') {
                characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            }
            var result = '';
            for (var i = 0; i < length; i++) {
                var randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
            }
            return result;
        }

        // ---- Edit License modal behavior (was Keys/key_edit.php inline JS) ----
        const level = <?= $user->level ?>;

        if (level !== 1) {
            $("#registrator, #expired_date, #vip_key, #devices").prop('disabled', true);
        }

        $("#editLicenseModal input, #editLicenseModal select, #editLicenseModal textarea").on('input', function() {
            $(".btnUpdate").prop('disabled', false);
        });

        $("#max_devices").change(function() {
            const total = $(".maxDev").data('total') || 0;
            $(".maxDev").text(total + '/' + $(this).val());
            $("#devices").attr('rows', $(this).val());
        });
    });

    // Splits the raw comma-separated device string (same shape the old
    // getDevice() PHP helper parsed) into a count + newline list for the textarea.
    function parseDevices(raw) {
        if (!raw) return {
            total: 0,
            list: ''
        };
        const parts = raw.split(',').map(s => s.trim()).filter(Boolean);
        return {
            total: parts.length,
            list: parts.join('\n')
        };
    }

    function openEditLicenseModal(row) {
        $(".btnUpdate").prop('disabled', true);
        $('#edit_id_keys').val(row.id);
        $('#status').val(row.raw_status ? '1' : '0');
        $('#key_level').val(row.key_level);
        $('#duration').val(row.raw_duration);

        if ($('#game').length) $('#game').val(row.game);
        if ($('#user_key').length) $('#user_key').val(row.user_key);
        if ($('#registrator').length) $('#registrator').val(row.registrator);
        if ($('#max_devices').length) $('#max_devices').val(row.max_devices);
        if ($('#logins_remaining').length) $('#logins_remaining').val(row.logins_remaining);

        if (row.raw_expired_date) {
            $('#expired_date').val(row.raw_expired_date.replace(' ', 'T').slice(0, 16)).prop('disabled', false);
        } else {
            $('#expired_date').val('').prop('disabled', true);
        }

        const parsed = parseDevices(row.raw_devices);
        $('#devices').val(parsed.list).attr('rows', (parsed.total > row.max_devices) ? 3 : (parsed.total || 1));
        $('.maxDev').data('total', parsed.total).text(parsed.total + '/' + row.max_devices);

        editLicenseModal.showModal();
    }

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
