<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('Layout/msgStatus') ?>

<?php if (session()->getFlashdata('user_key')) : ?>
    <div class="alert alert-success mb-4">
        <svg class="icon"><use href="#i-check-circle" /></svg>
        <div>
            Game : <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days<br>
            License : <?= session()->getFlashdata('user_key') ?><br>
            Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
            <small class="block mt-1 opacity-80">
                <i>Duration will start when license login.</i><br>
                <svg class="icon" style="width:0.9rem;height:0.9rem;display:inline-block;vertical-align:-0.15em"><use href="#i-download" /></svg>
                <a href="<?= site_url('keys/download/new') ?>" class="link">Download New Keys Hare</a><br>
                <svg class="icon" style="width:0.9rem;height:0.9rem;display:inline-block;vertical-align:-0.15em"><use href="#i-wallet" /></svg>
                Saldo Reduce :
                <span class="text-error">-<?= session()->getFlashdata('fees') ?></span>
                (Total left <?= $user->saldo ?>$)
            </small>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="lg:col-span-2">
        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <h2 class="card-title">Create License</h2>
                    <a class="btn btn-soft btn-sm" href="<?= site_url('keys') ?>" aria-label="Back to keys list">
                        <svg class="icon"><use href="#i-users" /></svg>
                    </a>
                </div>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="game">Game</label>
                            <?= form_dropdown('game', $game, old('game'), 'class="select w-full" id="game" required') ?>
                        </div>
                        <div>
                            <label class="label" for="max_devices">Max devices</label>
                            <input type="number" name="max_devices" id="max_devices" class="input w-full" placeholder="max device" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
                        </div>
                        <div>
                            <label class="label" for="user_key">Key name</label>
                            <div class="join w-full">
                                <label class="input join-item grow">
                                    <svg class="icon opacity-50"><use href="#i-key" /></svg>
                                    <input type="text" name="user_key" id="user_key" class="grow" placeholder="key name" value="<?= old('user_key') ?>" required>
                                </label>
                                <button class="btn btn-outline join-item" type="button" id="random_key" aria-label="Generate random key">
                                    <svg class="icon"><use href="#i-shuffle" /></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="label" for="duration">Duration</label>
                            <?= form_dropdown('duration', $duration, old('duration'), 'class="select w-full" id="duration" required') ?>
                        </div>
                        <div>
                            <label class="label" for="key_level">Key level</label>
                            <?= form_dropdown('key_level', $levels, old('key_level'), 'id="key_level" class="select w-full" required') ?>
                        </div>
                        <div>
                            <label class="label" for="estimation">Estimation</label>
                            <input type="text" id="estimation" class="input w-full" disabled>
                        </div>
                    </div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">Generate</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Minimum Seller Price</h2>
                <div class="overflow-x-auto">
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
