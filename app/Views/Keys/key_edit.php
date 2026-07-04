<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-wrap pb-5 justify-center gap-4">
    <div class="w-full lg:w-2/3">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="w-full lg:w-2/3 mb-3">
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body">
                <div class="flex items-center justify-between mb-1">
                    <h1 class="card-title text-base">Key information</h1>
                    <div class="text-right">
                        <a class="btn btn-sm" href="<?= site_url('keys/generate') ?>"><i class="bi bi-person-plus"></i></a>
                        <a class="btn btn-sm" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                    </div>
                </div>
                <?= form_open('keys/edit') ?>
                <input type="hidden" name="id_keys" value="<?= $key->id_keys ?>">

                <div class="flex flex-wrap gap-4 mt-2">
                    <?php if ($user->level == 1) : ?>
                        <div class="w-full lg:w-1/2">
                            <div class="join w-full">
                                <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-controller"></i></span>
                                <?= form_dropdown('game', $game_list, $key->game, 'class="select join-item grow" id="game" required') ?>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label class="input validator w-full">
                                <i class="bi bi-key opacity-60"></i>
                                <input type="text" name="user_key" id="user_key" value="<?= old('user_key') ?: $key->user_key ?>" required>
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label class="input validator w-full">
                                <i class="bi bi-person-vcard opacity-60"></i>
                                <input type="text" name="registrator" id="registrator" placeholder="Seller" value="<?= old('registrator') ?: $key->registrator ?>" required>
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label class="input validator w-full">
                                <i class="bi bi-phone opacity-60"></i>
                                <input type="number" name="max_devices" id="max_devices" placeholder="Max devices" value="<?= old('max_devices') ?: $key->max_devices ?>" min="1" required>
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label class="input validator w-full">
                                <i class="bi bi-phone opacity-60"></i>
                                <input type="number" name="logins_remaining" id="logins_remaining" placeholder="Logins remaining" value="<?= old('logins_remaining') ?: $key->logins_remaining ?>" min="0" required>
                            </label>
                        </div>
                    <?php endif; ?>
                    <div class="w-full lg:w-1/2" id="col-status">
                        <div class="join w-full">
                            <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-patch-check"></i></span>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'select join-item grow', 'name' => 'status', 'id' => 'status', 'required'], $sel_status, $key->status) ?>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <div class="join w-full">
                            <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-gem"></i></span>
                            <?= form_dropdown('key_level', $levels, old('key_level') ?? $key->key_level, 'class="select join-item grow" id="key_level" required') ?>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <label class="input w-full">
                            <i class="bi bi-calendar-day opacity-60"></i>
                            <input type="datetime-local" name="expired_date" id="expired_date" value="<?= old('expired_date') ?? !$key->expired_date ?: date('Y-m-d\TH:i', strtotime($key->expired_date)) ?>" <?= $key->expired_date ?: "disabled" ?>>
                        </label>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <label class="input validator w-full">
                            <i class="bi bi-calendar-day opacity-60"></i>
                            <input type="number" name="duration" id="duration" placeholder="3" value="<?= old('duration') ?? $key->duration ?>" min="1" required>
                        </label>
                    </div>
                </div>
                <fieldset class="fieldset p-0 mt-3">
                    <legend class="fieldset-legend">Devices <span class="badge badge-neutral maxDev"><?= $key_info->total ?>/<?= $key->max_devices ?></span> <span class="opacity-60 text-xs">(one per line)</span></legend>
                    <textarea class="textarea w-full" name="devices" id="devices" rows="<?= ($key_info->total > $key->max_devices) ? 3 : $key_info->total ?>"><?= old('devices') ?? ($key_info->total ? $key_info->devices : '') ?></textarea>
                </fieldset>
                <div class="mt-4 text-right">
                    <button class="btn btn-sm btn-primary btnUpdate" disabled>Update user key</button>
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
    });

    var total = "<?= $key_info->total ?>";
    $("#max_devices").change(function() {
        $(".maxDev").html(total + '/' + $(this).val());
        $("#devices").attr('rows', $(this).val());
    });
</script>
<?= $this->endSection() ?>
