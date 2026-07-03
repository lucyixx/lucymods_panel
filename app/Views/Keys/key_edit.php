<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex flex-wrap pb-5 justify-center gap-4">
    <div class="w-full lg:w-2/3">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="w-full lg:w-2/3 mb-3">
        <div class="card">
            <div class="flex items-center justify-between border-b px-4 py-3">
                <div class="font-semibold"><span>Key Information</span></div>
                <div class="text-right">
                    <a class="btn btn-sm btn-default" href="<?= site_url('keys/generate') ?>"><i class="bi bi-person-plus"></i></a>
                    <a class="btn btn-sm btn-default" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                </div>
            </div>
            <div class="card-body">
                <?= form_open('keys/edit') ?>
                <input type="hidden" name="id_keys" value="<?= $key->id_keys ?>">

                <div class="flex flex-wrap gap-4">
                    <?php if ($user->level == 1) : ?>
                        <div class="w-full lg:w-1/2 mb-3">
                            <div class="join w-full">
                                <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-controller"></i></span>
                                <?= form_dropdown('game', $game_list, $key->game, 'class="select select-bordered join-item grow" id="game" required') ?>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 mb-3">
                            <label class="input input-bordered flex items-center gap-2 w-full">
                                <i class="bi bi-key opacity-60"></i>
                                <input type="text" name="user_key" id="user_key" class="grow" value="<?= old('user_key') ?: $key->user_key ?>" required>
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2 mb-3">
                            <label class="input input-bordered flex items-center gap-2 w-full">
                                <i class="bi bi-person-vcard opacity-60"></i>
                                <input type="text" name="registrator" id="registrator" class="grow" placeholder="Seller" value="<?= old('registrator') ?: $key->registrator ?>" required>
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2 mb-3">
                            <label class="input input-bordered flex items-center gap-2 w-full">
                                <i class="bi bi-phone opacity-60"></i>
                                <input type="number" name="max_devices" id="max_devices" class="grow" placeholder="Max devices" value="<?= old('max_devices') ?: $key->max_devices ?>" min="1" required>
                            </label>
                        </div>
                        <div class="w-full lg:w-1/2 mb-3">
                            <label class="input input-bordered flex items-center gap-2 w-full">
                                <i class="bi bi-phone opacity-60"></i>
                                <input type="number" name="logins_remaining" id="logins_remaining" class="grow" placeholder="Logins remaining" value="<?= old('logins_remaining') ?: $key->logins_remaining ?>" min="0" required>
                            </label>
                        </div>
                    <?php endif; ?>
                    <div class="w-full lg:w-1/2 mb-3" id="col-status">
                        <div class="join w-full">
                            <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-patch-check"></i></span>
                            <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                            <?= form_dropdown(['class' => 'select select-bordered join-item grow', 'name' => 'status', 'id' => 'status', 'required'], $sel_status, $key->status) ?>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 mb-3">
                        <div class="join w-full">
                            <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-gem"></i></span>
                            <?= form_dropdown('key_level', $levels, old('key_level') ?? $key->key_level, 'class="select select-bordered join-item grow" id="key_level" required') ?>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 mb-3">
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-calendar-day opacity-60"></i>
                            <input type="datetime-local" class="grow" name="expired_date" id="expired_date" value="<?= old('expired_date') ?? !$key->expired_date ?: date('Y-m-d\TH:i', strtotime($key->expired_date)) ?>" <?= $key->expired_date ?: "disabled" ?>>
                        </label>
                    </div>
                    <div class="w-full lg:w-1/2 mb-3">
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <i class="bi bi-calendar-day opacity-60"></i>
                            <input type="number" name="duration" id="duration" class="grow" placeholder="3" value="<?= old('duration') ?? $key->duration ?>" min="1" required>
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="devices" class="label"><span class="label-text">Devices <span class="badge badge-neutral maxDev"><?= $key_info->total ?>/<?= $key->max_devices ?></span> <small class="opacity-60">(Separately with enter)</small></span></label>
                    <textarea class="textarea textarea-bordered w-full" name="devices" id="devices" rows="<?= ($key_info->total > $key->max_devices) ? 3 : $key_info->total ?>"><?= old('devices') ?? ($key_info->total ? $key_info->devices : '') ?></textarea>
                </div>
                <div class="mt-3 text-right">
                    <button class="btn btn-sm btn-primary btnUpdate" disabled>Update User Key</button>
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
