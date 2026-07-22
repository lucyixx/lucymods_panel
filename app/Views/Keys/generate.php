<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="lg:col-span-2 flex flex-col gap-4">
        <?php if (session()->getFlashdata('user_key')) : ?>
            <div role="alert" class="alert alert-success">
                <div>
                    <p>Game: <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days</p>
                    <p>License: <?= session()->getFlashdata('user_key') ?></p>
                    <p>Available for <?= session()->getFlashdata('max_devices') ?> Devices</p>
                    <p class="text-sm opacity-80 mt-2">Duration will start when license login.</p>
                    <p class="text-sm">
                        <svg class="icon inline-block align-text-bottom" style="width:1em;height:1em"><use href="#i-download" /></svg>
                        <a href="<?= site_url('keys/download/new') ?>" class="link link-hover">Download new keys here</a>
                    </p>
                    <p class="text-sm">
                        <svg class="icon inline-block align-text-bottom" style="width:1em;height:1em"><use href="#i-wallet" /></svg>
                        Saldo reduce: <span class="text-error">-<?= session()->getFlashdata('fees') ?></span>
                        (Total left <?= $user->saldo ?>$)
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h2 class="card-title">Create license</h2>
                    <a class="btn btn-sm btn-ghost btn-square" href="<?= site_url('keys') ?>" aria-label="View all keys">
                        <svg class="icon"><use href="#i-users" /></svg>
                    </a>
                </div>

                <?= form_open() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="label">Game</label>
                        <?= form_dropdown('game', $game, old('game'), 'class="select w-full" id="game" required') ?>
                    </div>
                    <div>
                        <label class="label">Max devices</label>
                        <input type="number" name="max_devices" id="max_devices" class="input w-full" placeholder="max device" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
                    </div>
                    <div>
                        <label class="label">Key name</label>
                        <div class="join w-full">
                            <input type="text" name="user_key" id="user_key" class="input join-item w-full" placeholder="key name" value="<?= old('user_key') ?>" required>
                            <button class="join-item btn" type="button" id="random_key" aria-label="Randomize key">
                                <svg class="icon"><use href="#i-shuffle" /></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="label">Duration</label>
                        <?= form_dropdown('duration', $duration, old('duration'), 'class="select w-full" id="duration" required') ?>
                    </div>
                    <div>
                        <label class="label">Key level</label>
                        <?= form_dropdown('key_level', $levels, old('key_level'), 'id="key_level" class="select w-full" required') ?>
                    </div>
                    <div>
                        <label class="label">Estimation</label>
                        <input type="text" id="estimation" class="input w-full" disabled>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Generate</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="card card-border bg-base-100 border-base-300">
        <div class="card-body">
            <h2 class="card-title">Minimum seller price</h2>
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Number of days</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>3 days</td>
                            <td>25K Or 3$</td>
                        </tr>
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
