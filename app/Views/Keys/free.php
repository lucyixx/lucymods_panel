<?php

use Bbsnly\ChartJs\Chart;
use Bbsnly\ChartJs\Config\Data;
use Bbsnly\ChartJs\Config\Dataset;
use Bbsnly\ChartJs\Config\Options;

$labels = $dataX = $dataY = [];
for ($i = 0; $i <= 365; $i += round($i / 3) + 1) {
    array_push($labels, round(calculatePrice($i)) . "K");
    array_push($dataX, round(calculatePrice($i, true)));
    array_push($dataY, $i);
}

$chart = new Chart;
$chart->type = 'line';

$data = new Data();
$data->labels = $labels;
$data->datasets = new Dataset(
    [
        [
            'label' => 'USD',
            'backgroundColor' => ['rgba(105, 0, 132, .2)'],
            'borderColor' => ['rgba(200, 99, 132, .7)'],
            'data' => $dataX,
            'borderWidth' => 2
        ],
        [
            'label' => 'Days',
            'backgroundColor' => ['rgba(0, 137, 132, .2)'],
            'borderColor' => ['rgba(0, 10, 130, .7)'],
            'data' => $dataY,
            'borderWidth' => 2
        ],
    ]
);
$chart->data($data);
$options = new Options([
    'responsive' => true,
    'title' => ['display' => true, 'text' => 'USD vs Days',],
    'legend' => ['display' => false,],
    'scales' => ['xAxes' => [['ticks' => ['min' => 10, 'max' => 60,]]]]
]);
$chart->options($options);
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="flex justify-center">
    <div class="flex flex-wrap mb-12 gap-4">
        <div class="w-full lg:w-1/2 mb-3">
            <div class="mb-3">
                <?= $this->include('Layout/msgStatus') ?>
                <?php if (session()->getFlashdata('user_key')) : ?>
                    <div class="alert alert-success" role="alert">
                        <div>
                            <strong>Game: </strong><?= esc(session()->getFlashdata('game')) ?> / <?= esc(session()->getFlashdata('duration')) ?> Days<br>
                            <strong>License: </strong><span class="font-mono"><?= esc(session()->getFlashdata('user_key')) ?></span><br>
                            Available for <?= esc(session()->getFlashdata('max_devices')) ?> Devices
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div id="game_view" class="mb-3" hidden>
                <div class="bg-base-300 border border-base-300 rounded-box overflow-hidden p-3 flex items-center gap-3">
                    <img class="rounded-lg w-16 h-16 object-cover shrink-0" id="game_img" alt="Icon image" itemprop="image">
                    <div class="min-w-0">
                        <h2 class="text-base font-medium truncate" id="game_name"></h2>
                        <p class="text-sm text-success truncate m-0" id="game_dev"></p>
                        <p class="text-sm opacity-70 truncate m-0" id="game_i"></p>
                    </div>
                </div>
            </div>

            <div class="card card-border bg-base-200 border-base-300 mb-3">
                <div class="flex items-center justify-between px-4 py-3 border-b border-base-300">
                    <h2 class="card-title text-base">Create license</h2>
                    <div class="opacity-70 flex items-center gap-1 text-sm">
                        <svg class="icon"><use href="#i-link" /></svg>
                        <span><?= $link_total ?> links</span>
                    </div>
                </div>
                <div class="card-body">
                    <?= form_open() ?>
                    <div class="flex flex-wrap gap-4">
                        <label class="select w-full md:w-[calc(50%-0.5rem)]">
                            <svg class="icon opacity-60"><use href="#i-gamepad" /></svg>
                            <?= form_dropdown('game', ['FREE' => 'All Games'], 'ALL', 'id="game" disabled') ?>
                        </label>
                        <label class="input w-full md:w-[calc(50%-0.5rem)]">
                            <svg class="icon opacity-60"><use href="#i-users" /></svg>
                            <input type="number" name="max_devices" id="max_devices" value="1" disabled>
                            <span class="opacity-60 text-sm">device</span>
                        </label>
                        <label class="select w-full md:w-[calc(50%-0.5rem)]">
                            <svg class="icon opacity-60"><use href="#i-shield" /></svg>
                            <?= form_dropdown('duration', ['1' => '1 Days'], '1', 'disabled') ?>
                        </label>
                        <label class="select w-full md:w-[calc(50%-0.5rem)]">
                            <svg class="icon opacity-60"><use href="#i-check-circle" /></svg>
                            <?= form_dropdown('vip_key', ['1' => 'FREE'], '1', 'disabled') ?>
                        </label>
                    </div>
                    <div id="validationResult"></div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-sm btn-primary" id="btn_submit"><svg class="icon"><use href="#i-arrow-right" /></svg> Generate</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 mb-3">
            <?= $chart->toHtml('my_chart'); ?>
        </div>
        <div class="w-full mb-3">
            <div class="card card-border bg-base-200 border-base-300">
                <div class="px-4 py-3 border-b border-base-300"><h2 class="card-title text-base">Minimum seller price</h2></div>
                <div class="card-body text-center">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Number Of Days</th>
                                <th>Price vnđ</th>
                                <th>Price dollar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $days = [1, 3, 7, 30, 60]; ?>
                            <?php foreach ($days as $day) : ?>
                                <tr>
                                    <td><?= $day ?> days</td>
                                    <td><?= calculatePrice($day - 1) ?>k</td>
                                    <td><?= calculatePrice($day - 1, true) ?>$</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<p class="text-center opacity-70 text-sm mt-2">
    Get key with donate?
    <a href="https://t.me/tis_nquyen" target="_blank" class="link text-primary">Contact Admin</a>
</p>

<?= $this->endSection() ?>
