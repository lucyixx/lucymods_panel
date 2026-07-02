<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="row pb-5 justify-content-center">
    <div class="col-lg-8">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="card-title m-0"><span>Key Information</span></div>
                    </div>
                    <div class="col">
                        <div class="text-end">
                            <a class="btn btn-sm btn-default" href="<?= site_url('keys/generate') ?>"><i class="bi bi-person-plus"></i></a>
                            <a class="btn btn-sm btn-default" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?= form_open('keys/edit') ?>
                    <input type="hidden" name="id_keys" value="<?= $key->id_keys ?>">

                    <div class="row">
                        <?php if ($user->level == 1) : ?>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="game" class="input-group-text"><i class="bi bi-controller"></i></label>
                                    <?= form_dropdown('game', $game_list, $key->game, 'class="form-select" id="game" required') ?>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="user_key" class="input-group-text"><i class="bi bi-key"></i></label>
                                    <input type="text" name="user_key" id="user_key" class="form-control" value="<?= old('user_key') ?: $key->user_key ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="registrator" class="input-group-text"><i class="bi bi-person-vcard"></i></label>
                                    <input type="text" name="registrator" id="registrator" class="form-control" placeholder="Seller" value="<?= old('registrator') ?: $key->registrator ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="max_devices" class="input-group-text"><i class="bi bi-phone"></i></label>
                                    <input type="number" name="max_devices" id="max_devices" class="form-control" placeholder="Max devices" value="<?= old('max_devices') ?: $key->max_devices ?>" min="1" required>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="logins_remaining" class="input-group-text"><i class="bi bi-phone"></i></label>
                                    <input type="number" name="logins_remaining" id="logins_remaining" class="form-control" placeholder="Logins remaining" value="<?= old('logins_remaining') ?: $key->logins_remaining ?>" min="0" required>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-lg-6 mb-3" id="col-status">
                            <div class="input-group">
                                <label for="status" class="input-group-text"><i class="bi bi-patch-check"></i></label>
                                <?php $sel_status = ['' => '&mdash; Select Status &mdash;', '0' => 'Banned/Block', '1' => 'Active',]; ?>
                                <?= form_dropdown(['class' => 'form-select', 'name' => 'status', 'id' => 'status', 'required'], $sel_status, $key->status) ?>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <label for="key_level" class="input-group-text"><i class="bi bi-gem"></i></label>
                                <?= form_dropdown('key_level', $levels, old('key_level') ?? $key->key_level, 'class="form-select" id="key_level" required') ?>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <label for="expired_date" class="input-group-text"><i class="bi bi-calendar-day"></i></label>
                                <input type="datetime-local" class="form-control" name="expired_date" id="expired_date" value="<?= old('expired_date') ?? !$key->expired_date ?: date('Y-m-d\TH:i', strtotime($key->expired_date)) ?>" <?= $key->expired_date ?: "disabled" ?>>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <label for="duration" class="input-group-text"><i class="bi bi-calendar-day"></i></label>
                                <input type="number" name="duration" id="duration" class="form-control" placeholder="3" value="<?= old('duration') ?? $key->duration ?>" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <label for="devices" class="form-label">Devices <span class="bg-dark text-white px-1 rounded maxDev"><?= $key_info->total ?>/<?= $key->max_devices ?></span> <small class="text-muted">(Separately with enter)</small></label>
                        <textarea class="form-control" name="devices" id="devices" rows="<?= ($key_info->total > $key->max_devices) ? 3 : $key_info->total ?>"><?= old('devices') ?? ($key_info->total ? $key_info->devices : '') ?></textarea>
                    </div>
                    <div class="mt-3 text-end">
                        <button class="btn btn-sm btn-primary btnUpdate" disabled>Update User Key</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script <?= csp_script_nonce() ?>>
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