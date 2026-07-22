<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl">
    <?= $this->include('Layout/msgStatus') ?>

    <div class="card card-border bg-base-100 border-base-300">
        <div class="card-body">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h2 class="card-title">Key information</h2>
                <div class="flex gap-1">
                    <a class="btn btn-sm btn-ghost btn-square" href="<?= site_url('keys/generate') ?>" aria-label="Generate new key">
                        <svg class="icon"><use href="#i-plus" /></svg>
                    </a>
                    <a class="btn btn-sm btn-ghost btn-square" href="<?= site_url('keys') ?>" aria-label="View all keys">
                        <svg class="icon"><use href="#i-users" /></svg>
                    </a>
                </div>
            </div>

            <?= form_open('keys/edit') ?>
            <input type="hidden" name="id_keys" value="<?= $key->id_keys ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <?php if ($user->level == 1) : ?>
                    <div>
                        <label class="label">Game</label>
                        <?= form_dropdown('game', $game_list, $key->game, 'class="select w-full" id="game" required') ?>
                    </div>
                    <div>
                        <label class="label">Key name</label>
                        <input type="text" name="user_key" id="user_key" class="input w-full" value="<?= old('user_key') ?: $key->user_key ?>" required>
                    </div>
                    <div>
                        <label class="label">Seller</label>
                        <input type="text" name="registrator" id="registrator" class="input w-full" placeholder="Seller" value="<?= old('registrator') ?: $key->registrator ?>" required>
                    </div>
                    <div>
                        <label class="label">Max devices</label>
                        <input type="number" name="max_devices" id="max_devices" class="input w-full" placeholder="Max devices" value="<?= old('max_devices') ?: $key->max_devices ?>" min="1" required>
                    </div>
                    <div>
                        <label class="label">Logins remaining</label>
                        <input type="number" name="logins_remaining" id="logins_remaining" class="input w-full" placeholder="Logins remaining" value="<?= old('logins_remaining') ?: $key->logins_remaining ?>" min="0" required>
                    </div>
                <?php endif; ?>
                <div id="col-status">
                    <label class="label">Status</label>
                    <?php $sel_status = ['' => '— Select status —', '0' => 'Banned/Block', '1' => 'Active']; ?>
                    <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'status', 'required'], $sel_status, $key->status) ?>
                </div>
                <div>
                    <label class="label">Key level</label>
                    <?= form_dropdown('key_level', $levels, old('key_level') ?? $key->key_level, 'class="select w-full" id="key_level" required') ?>
                </div>
                <div>
                    <label class="label">Expired date</label>
                    <input type="datetime-local" class="input w-full" name="expired_date" id="expired_date" value="<?= old('expired_date') ?? !$key->expired_date ?: date('Y-m-d\TH:i', strtotime($key->expired_date)) ?>" <?= $key->expired_date ?: "disabled" ?>>
                </div>
                <div>
                    <label class="label">Duration</label>
                    <input type="number" name="duration" id="duration" class="input w-full" placeholder="3" value="<?= old('duration') ?? $key->duration ?>" min="1" required>
                </div>
            </div>

            <div class="mt-3">
                <label class="label">
                    Devices
                    <span class="badge badge-neutral maxDev"><?= $key_info->total ?>/<?= $key->max_devices ?></span>
                    <span class="text-xs opacity-60">(Separately with enter)</span>
                </label>
                <textarea class="textarea w-full" name="devices" id="devices" rows="<?= ($key_info->total > $key->max_devices) ? 3 : $key_info->total ?>"><?= old('devices') ?? ($key_info->total ? $key_info->devices : '') ?></textarea>
            </div>

            <button class="btn btn-primary mt-4 btnUpdate" disabled>Update user key</button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const old_duration = parseInt(<?= $key->duration ?>);
        const expired = $('#expired_date').val();
        const level = <?= $user->level ?>;

        if (level !== 1) {
            $("#registrator, #expired_date, #vip_key, #devices").prop('disabled', true);
        }

        $("input, select, textarea").on('input', function() {
            $(".btnUpdate").prop('disabled', false);
        });

        // $("#duration").on('input', function() {
        //     const duration = parseInt($(this).val());

        //     if (expired && !isNaN(duration)) {
        //         const expired_date = new Date(expired);
        //         expired_date.setDate(expired_date.getDate() + (duration - old_duration));
        //         const formattedNewExpired = expired_date.toISOString();
        //         const timePart = expired.split('T')[1];
        //         $("#expired_date").val(formattedNewExpired.split('T')[0] + 'T' + timePart);
        //     }
        // });
    });



    var total = "<?= $key_info->total ?>";
    $("#max_devices").change(function() {
        $(".maxDev").html(total + '/' + $(this).val());
        $("#devices").attr('rows', $(this).val());
    });
</script>
<?= $this->endSection() ?>
