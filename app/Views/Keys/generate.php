<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="flex justify-center">
    <div class="w-full">
        <?= $this->include('Layout/msgStatus') ?>
        <div class="flex flex-wrap gap-4">
            <div class="w-full lg:w-2/3">
                <?php if (session()->getFlashdata('user_key')) : ?>
                    <div class="alert alert-success mb-3" role="alert">
                        <div>
                            Game: <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days<br>
                            License: <span class="font-mono"><?= session()->getFlashdata('user_key') ?></span><br>
                            Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
                            <small>
                                <i>Duration will start when license login.</i><br>
                                <i class="bi bi-download"></i><a href="<?= site_url('keys/download/new') ?>" class="link"> Download New Keys Here</a><br>
                                <i class="bi bi-wallet"></i> Saldo reduce:
                                <span class="text-error">-<?= session()->getFlashdata('fees') ?></span>
                                (total left <?= $user->saldo ?>$)
                            </small>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card card-border bg-base-200 border-base-300 mb-3">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-1">
                            <h1 class="card-title text-base">Create license</h1>
                            <a class="btn btn-sm" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                        </div>
                        <?= form_open() ?>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <div class="w-full md:w-1/2">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-controller"></i></span>
                                    <?= form_dropdown('game', $game, old('game'), 'class="select join-item grow" id="game" required') ?>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-phone"></i></span>
                                    <input type="number" name="max_devices" id="max_devices" class="input join-item grow validator" placeholder="Max devices" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-key"></i></span>
                                    <input type="text" name="user_key" id="user_key" class="input join-item grow validator" placeholder="Key name" value="<?= old('user_key') ?>" required>
                                    <button class="join-item btn" type="button" id="random_key" aria-label="Randomize"><i class="bi bi-shuffle"></i></button>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-calendar-day"></i></span>
                                    <?= form_dropdown('duration', $duration, old('duration'), 'class="select join-item grow" id="duration" required') ?>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-gem"></i></span>
                                    <?= form_dropdown('key_level', $levels, old('key_level'), 'id="key_level" class="select join-item grow" required') ?>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-battery-charging"></i></span>
                                    <input type="text" id="estimation" class="input join-item grow" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/3">
                <div class="card card-border bg-base-200 border-base-300">
                    <div class="card-body p-0">
                        <div class="px-4 py-3 border-b border-base-300">
                            <h2 class="card-title text-base">Minimum seller price</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Days</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>3 days</td>
                                        <td>25K or 3$</td>
                                    </tr>
                                    <tr>
                                        <td>7 days</td>
                                        <td>50K or 5$</td>
                                    </tr>
                                    <tr>
                                        <td>30 days</td>
                                        <td>100K or 10$</td>
                                    </tr>
                                    <tr>
                                        <td>60 days</td>
                                        <td>150K or 17$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
