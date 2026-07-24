<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex justify-center">
    <div class="w-full max-w-3xl">
        <?= $this->include('Layout/msgStatus') ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <h2 class="card-title">Key Information</h2>
                    <div class="flex items-center gap-1">
                        <a class="btn btn-soft btn-sm" href="<?= site_url('keys/generate') ?>" aria-label="Generate key">
                            <svg class="icon"><use href="#i-plus" /></svg>
                        </a>
                        <a class="btn btn-soft btn-sm" href="<?= site_url('keys') ?>" aria-label="Back to keys list">
                            <svg class="icon"><use href="#i-users" /></svg>
                        </a>
                    </div>
                </div>

                <?= form_open('keys/edit') ?>
                <input type="hidden" name="id_keys" value="<?= $key->id_keys ?>">

                <fieldset class="fieldset gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if ($user->level == 1) : ?>
                            <div>
                                <label class="label" for="game">Game</label>
                                <?= form_dropdown('game', $game_list, $key->game, 'class="select w-full" id="game" required') ?>
                            </div>
                            <div>
                                <label class="label" for="user_key">User key</label>
                                <label class="input w-full">
                                    <svg class="icon opacity-50"><use href="#i-key" /></svg>
                                    <input type="text" name="user_key" id="user_key" class="grow" value="<?= old('user_key') ?: $key->user_key ?>" required>
                                </label>
                            </div>
                            <div>
                                <label class="label" for="registrator">Registrator</label>
                                <label class="input w-full">
                                    <svg class="icon opacity-50"><use href="#i-user" /></svg>
                                    <input type="text" name="registrator" id="registrator" class="grow" placeholder="Seller" value="<?= old('registrator') ?: $key->registrator ?>" required>
                                </label>
                            </div>
                            <div>
                                <label class="label" for="max_devices">Max devices</label>
                                <input type="number" name="max_devices" id="max_devices" class="input w-full" placeholder="Max devices" value="<?= old('max_devices') ?: $key->max_devices ?>" min="1" required>
                            </div>
                            <div>
                                <label class="label" for="logins_remaining">Logins remaining</label>
                                <input type="number" name="logins_remaining" id="logins_remaining" class="input w-full" placeholder="Logins remaining" value="<?= old('logins_remaining') ?: $key->logins_remaining ?>" min="0" required>
                            </div>
                        <?php endif; ?>
                        <div id="col-status">
                            <label class="label" for="status">Status</label>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'select w-full', 'name' => 'status', 'id' => 'status', 'required'], $sel_status, $key->status) ?>
                        </div>
                        <div>
                            <label class="label" for="key_level">Key level</label>
                            <?= form_dropdown('key_level', $levels, old('key_level') ?? $key->key_level, 'class="select w-full" id="key_level" required') ?>
                        </div>
                        <div>
                            <label class="label" for="expired_date">Expired date</label>
                            <input type="datetime-local" class="input w-full" name="expired_date" id="expired_date" value="<?= old('expired_date') ?? !$key->expired_date ?: date('Y-m-d\TH:i', strtotime($key->expired_date)) ?>" <?= $key->expired_date ?: "disabled" ?>>
                        </div>
                        <div>
                            <label class="label" for="duration">Duration</label>
                            <input type="number" name="duration" id="duration" class="input w-full" placeholder="3" value="<?= old('duration') ?? $key->duration ?>" min="1" required>
                        </div>
                    </div>

                    <div>
                        <label class="label" for="devices">
                            Devices <span class="badge badge-neutral maxDev"><?= $key_info->total ?>/<?= $key->max_devices ?></span>
                            <span class="text-xs opacity-60">(Separately with enter)</span>
                        </label>
                        <textarea class="textarea w-full" name="devices" id="devices" rows="<?= ($key_info->total > $key->max_devices) ? 3 : $key_info->total ?>"><?= old('devices') ?? ($key_info->total ? $key_info->devices : '') ?></textarea>
                    </div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button class="btn btn-primary btn-sm btnUpdate" disabled>Update User Key</button>
                </div>
                <?= form_close() ?>
            </div>
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
