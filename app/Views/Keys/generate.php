<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="justify-content-center">
    <?= $this->include('Layout/msgStatus') ?>
    <div class="row">
        <div class="col-lg-8">
            <?php if (session()->getFlashdata('user_key')) : ?>
                <div class="alert alert-success" role="alert">
                    Game : <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days<br>
                    License : <?= session()->getFlashdata('user_key') ?><br>
                    Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
                    <small>
                        <i>Duration will start when license login.</i><br>
                        <i class="bi bi-download"></i><a href="<?= site_url('keys/download/new') ?>"> Download New Keys Hare</a><br>
                        <i class="bi bi-wallet"></i> Saldo Reduce :
                        <span class="text-danger">-<?= session()->getFlashdata('fees') ?></span>
                        (Total left <?= $user->saldo ?>$)
                    </small>
                </div>
            <?php endif; ?>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="card-title m-0"><span>Create License</span></div>
                        </div>
                        <div class="col text-end">
                            <a class="btn btn-sm btn-default" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= form_open() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <label for="game" class="input-group-text"><i class="bi bi-controller"></i></label>
                                <?= form_dropdown('game', $game, old('game'), 'class="form-select" id="game" required') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <label for="max_devices" class="input-group-text"><i class="bi bi-phone"></i></label>
                                <input type="number" name="max_devices" id="max_devices" class="form-control" placeholder="max device" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <label for="user_key" class="input-group-text"><i class="bi bi-key"></i></label>
                                <input type="text" name="user_key" id="user_key" class="form-control" placeholder="key name" value="<?= old('user_key') ?>" required>
                                <button class="input-group-text" type="button" id="random_key"><i class="bi bi-shuffle"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <label for="duration" class="input-group-text"><i class="bi bi-calendar-day"></i></label>
                                <?= form_dropdown('duration', $duration, old('duration'), 'class="form-select" id="duration" required') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <label for="key_level" class="input-group-text"><i class="bi bi-gem"></i></label>
                                <?= form_dropdown('key_level', $levels, old('key_level'), 'id="key_level" class="form-select" required') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <label for="estimation" class="input-group-text"><i class="bi bi-battery-charging"></i></label>
                                <input type="text" id="estimation" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title m-0"><span>Minimum Seller Price</span></div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Number Of Days</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3 days</td>
                                <td>25K Or 3$</td>
                            <tr>
                                <td>7 days</td>
                                <td>50K Or 5$</td>
                            </tr>
                            <tr>
                                <td>30 days</td>
                                <td>100K Or 10$</td>
                            </tr>
                            <tr>
                                <td>60 days</td>
                                <td>150K Or 17$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script <?= csp_script_nonce() ?>>
    $(document).ready(function() {
        const price = JSON.parse('<?= $price ?>');
        getPrice(price);

        // When selected
        $("#max_devices, #duration, #game").change(function() {
            getPrice(price);

        });
        // try to get price
        function getPrice(price) {
            const device = $("#max_devices").val();
            const durate = $("#duration").val();
            const gprice = price[durate];
            if (gprice != NaN) {
                var result = (device * gprice);
                $("#estimation").val(result);
            } else {
                $("#estimation").val('Estimation error');
            }
        }


        $("#random_key").click(function(a) {
            $("#user_key").val(randomString('alnum', 16));
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
    });
</script>
<?= $this->endSection() ?>