<?= $this->extend('Layout/AppShell') ?>

<?= $this->section('content') ?>
<?= $this->include('Layout/msgStatus') ?>

<?php if (session()->getFlashdata('user_key')) : ?>
    <div class="alert alert-success mb-4" role="alert">
        <div>
            Game: <?= session()->getFlashdata('game') ?> / <?= session()->getFlashdata('duration') ?> Days<br>
            License: <span class="font-mono"><?= session()->getFlashdata('user_key') ?></span><br>
            Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
            <small>
                <em>Duration will start when license login.</em><br>
                <svg class="icon"><use href="#i-download" /></svg> <a href="<?= site_url('keys/download/new') ?>" class="link">Download New Keys Here</a><br>
                <svg class="icon"><use href="#i-wallet" /></svg> Saldo reduce:
                <span class="text-error">-<?= session()->getFlashdata('fees') ?></span>
                (total left <?= $user->saldo ?>$)
            </small>
        </div>
    </div>
<?php endif; ?>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <?= form_open() ?>
        <div class="grid sm:grid-cols-2 gap-3">
            <label class="select w-full">
                <svg class="icon opacity-60"><use href="#i-gamepad" /></svg>
                <?= form_dropdown('game', $game, old('game'), 'id="game" required') ?>
            </label>
            <label class="input validator w-full">
                <svg class="icon opacity-60"><use href="#i-users" /></svg>
                <input type="number" name="max_devices" id="max_devices" placeholder="Max devices" value="<?= old('max_devices') ?: 1 ?>" min="1" required>
            </label>
            <label class="input validator w-full sm:col-span-2">
                <svg class="icon opacity-60"><use href="#i-key" /></svg>
                <input type="text" name="user_key" id="user_key" placeholder="Key name" value="<?= old('user_key') ?>" required>
                <button type="button" class="opacity-60" id="random_key" aria-label="Randomize"><svg class="icon"><use href="#i-shuffle" /></svg></button>
            </label>
            <label class="select w-full">
                <svg class="icon opacity-60"><use href="#i-shield" /></svg>
                <?= form_dropdown('duration', $duration, old('duration'), 'id="duration" required') ?>
            </label>
            <label class="select w-full">
                <svg class="icon opacity-60"><use href="#i-check-circle" /></svg>
                <?= form_dropdown('key_level', $levels, old('key_level'), 'id="key_level" required') ?>
            </label>
            <label class="input w-full sm:col-span-2 opacity-70">
                <svg class="icon opacity-60"><use href="#i-wallet" /></svg>
                <input type="text" id="estimation" placeholder="Estimated price" disabled>
            </label>
        </div>
        <div class="mt-4 text-right">
            <button type="submit" class="btn btn-sm btn-primary">Generate</button>
        </div>
        <?= form_close() ?>
    </div>
    <div>
        <h2 class="text-sm uppercase tracking-wide opacity-60 mb-2">Minimum seller price</h2>
        <div class="divide-y divide-base-300 border-t border-base-300 text-sm">
            <div class="flex justify-between py-2"><span>3 days</span><span class="opacity-60">25K or 3$</span></div>
            <div class="flex justify-between py-2"><span>7 days</span><span class="opacity-60">50K or 5$</span></div>
            <div class="flex justify-between py-2"><span>30 days</span><span class="opacity-60">100K or 10$</span></div>
            <div class="flex justify-between py-2"><span>60 days</span><span class="opacity-60">150K or 17$</span></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        const price = JSON.parse('<?= $price ?>');
        getPrice(price);

        $("#max_devices, #duration, #game").change(function() {
            getPrice(price);
        });

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
