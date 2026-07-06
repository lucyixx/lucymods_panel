<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="flex items-center justify-between mb-4">
    <p class="text-sm opacity-60">Key #<?= $key->id_keys ?></p>
    <div class="flex gap-1">
        <a class="btn btn-sm" href="<?= site_url('keys/generate') ?>" aria-label="Generate"><svg class="icon"><use href="#i-plus" /></svg></a>
        <a class="btn btn-sm" href="<?= site_url('keys') ?>" aria-label="Back to keys"><svg class="icon"><use href="#i-key" /></svg></a>
    </div>
</div>

<div class="max-w-3xl">
    <?= form_open('keys/edit') ?>
    <input type="hidden" name="id_keys" value="<?= $key->id_keys ?>">

    <div class="flex flex-wrap gap-4">
        <?php if ($user->level == 1) : ?>
            <label class="select w-full lg:w-[calc(50%-0.5rem)]">
                <svg class="icon opacity-60"><use href="#i-gamepad" /></svg>
                <?= form_dropdown('game', $game_list, $key->game, 'id="game" required') ?>
            </label>
            <label class="input validator w-full lg:w-[calc(50%-0.5rem)]">
                <svg class="icon opacity-60"><use href="#i-key" /></svg>
                <input type="text" name="user_key" id="user_key" value="<?= old('user_key') ?: $key->user_key ?>" required>
            </label>
            <label class="input validator w-full lg:w-[calc(50%-0.5rem)]">
                <svg class="icon opacity-60"><use href="#i-user" /></svg>
                <input type="text" name="registrator" id="registrator" placeholder="Seller" value="<?= old('registrator') ?: $key->registrator ?>" required>
            </label>
            <label class="input validator w-full lg:w-[calc(50%-0.5rem)]">
                <svg class="icon opacity-60"><use href="#i-users" /></svg>
                <input type="number" name="max_devices" id="max_devices" placeholder="Max devices" value="<?= old('max_devices') ?: $key->max_devices ?>" min="1" required>
            </label>
            <label class="input validator w-full lg:w-[calc(50%-0.5rem)]">
                <svg class="icon opacity-60"><use href="#i-users" /></svg>
                <input type="number" name="logins_remaining" id="logins_remaining" placeholder="Logins remaining" value="<?= old('logins_remaining') ?: $key->logins_remaining ?>" min="0" required>
            </label>
        <?php endif; ?>
        <label class="select w-full lg:w-[calc(50%-0.5rem)]" id="col-status">
            <svg class="icon opacity-60"><use href="#i-check-circle" /></svg>
            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
            <?= form_dropdown(['name' => 'status', 'id' => 'status', 'required'], $sel_status, $key->status) ?>
        </label>
        <label class="select w-full lg:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-shield" /></svg>
            <?= form_dropdown('key_level', $levels, old('key_level') ?? $key->key_level, 'id="key_level" required') ?>
        </label>
        <label class="input w-full lg:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-key" /></svg>
            <input type="datetime-local" name="expired_date" id="expired_date" value="<?= old('expired_date') ?? !$key->expired_date ?: date('Y-m-d\TH:i', strtotime($key->expired_date)) ?>" <?= $key->expired_date ?: "disabled" ?>>
        </label>
        <label class="input validator w-full lg:w-[calc(50%-0.5rem)]">
            <svg class="icon opacity-60"><use href="#i-key" /></svg>
            <input type="number" name="duration" id="duration" placeholder="3" value="<?= old('duration') ?? $key->duration ?>" min="1" required>
        </label>
    </div>
    <fieldset class="mt-4">
        <legend class="text-sm mb-1 flex items-center gap-2">Devices <span class="badge badge-neutral maxDev"><?= $key_info->total ?>/<?= $key->max_devices ?></span> <span class="opacity-60 text-xs">(one per line)</span></legend>
        <textarea class="textarea w-full" name="devices" id="devices" rows="<?= ($key_info->total > $key->max_devices) ? 3 : $key_info->total ?>"><?= old('devices') ?? ($key_info->total ? $key_info->devices : '') ?></textarea>
    </fieldset>
    <div class="mt-4 text-right">
        <button class="btn btn-sm btn-primary btnUpdate" disabled>Update user key</button>
    </div>
    <?= form_close() ?>
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
    });

    var total = "<?= $key_info->total ?>";
    $("#max_devices").change(function() {
        $(".maxDev").html(total + '/' + $(this).val());
        $("#devices").attr('rows', $(this).val());
    });
</script>
<?= $this->endSection() ?>
