<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="flex justify-center">
    <div class="w-full">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="flex flex-wrap gap-4">
            <div class="w-full lg:w-2/3">
                <?php if (session()->getFlashdata('user_key')) : ?>
                    <div class="alert alert-success mb-3" role="alert">
                        Game : <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days<br>
                        License : <?= session()->getFlashdata('user_key') ?><br>
                        Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
                        <small>
                            <i>Duration will start when license login.</i><br>
                            <i class="bi bi-download"></i><a href="<?= site_url('keys/download/new') ?>"> Download New Keys Hare</a><br>
                            <i class="bi bi-wallet"></i> Saldo Reduce :
                            <span class="text-error">-<?= session()->getFlashdata('fees') ?></span>
                            (Total left <?= $user->saldo ?>$)
                        </small>
                    </div>
                <?php endif; ?>
                <div class="panel mb-3">
                    <div class="panel-head">
                        <span class="panel-head-title">Create License</span>
                        <a class="btn btn-sm btn-default" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                    </div>
                    <div class="panel-body">
                        <?= form_open() ?>
                        <div class="flex flex-wrap gap-4">
                            <div class="w-full md:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-controller"></i></span>
                                    <?= form_dropdown('game', $game, old('game'), 'class="select select-bordered join-item grow" id="game" required') ?>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-phone"></i></span>
                                    <input type="number" name="max_devices" id="max_devices" class="input input-bordered join-item grow" placeholder="max device" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-key"></i></span>
                                    <input type="text" name="user_key" id="user_key" class="input input-bordered join-item grow" placeholder="key name" value="<?= old('user_key') ?>" required>
                                    <button class="join-item btn btn-default" type="button" id="random_key"><i class="bi bi-shuffle"></i></button>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-calendar-day"></i></span>
                                    <?= form_dropdown('duration', $duration, old('duration'), 'class="select select-bordered join-item grow" id="duration" required') ?>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-gem"></i></span>
                                    <?= form_dropdown('key_level', $levels, old('key_level'), 'id="key_level" class="select select-bordered join-item grow" required') ?>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-battery-charging"></i></span>
                                    <input type="text" id="estimation" class="input input-bordered join-item grow" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-right">
                            <button type="submit" class="btn btn-sm btn-primary btn-hud">Generate</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/3">
                <div class="panel mb-3">
                    <div class="panel-head"><span class="panel-head-title">Minimum Seller Price</span></div>
                    <div class="panel-body">
                        <table class="table table-zebra">
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
<script>
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
