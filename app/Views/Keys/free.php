<?php

use Bbsnly\ChartJs\Chart;
use Bbsnly\ChartJs\Config\Data;
use Bbsnly\ChartJs\Config\Dataset;
use Bbsnly\ChartJs\Config\Options;

$labels = $dataX = $dataY = [];
for ($i = 0; $i <= 365; $i += round($i / 3) + 1) {
    array_push($labels, round(calculatePrice($i)) . "K");
    // array_push($labels,$i);
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

<?= $this->extend('Layout/AppShell') ?>
<?= $this->section('content') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="flex flex-col gap-3">
        <?= $this->include('Layout/msgStatus') ?>
        <?php if (session()->getFlashdata('user_key')) : ?>
            <div role="alert" class="alert alert-success">
                <div>
                    <p><span class="font-medium">Game:</span> <?= esc(session()->getFlashdata('game')) ?> / <?= esc(session()->getFlashdata('duration')) ?> Days</p>
                    <p><span class="font-medium">License:</span> <?= esc(session()->getFlashdata('user_key')) ?></p>
                    <p>Available for <?= esc(session()->getFlashdata('max_devices')) ?> Devices</p>
                </div>
            </div>
        <?php endif; ?>

        <div id="game_view" class="card bg-base-200 border border-base-300" hidden>
            <div class="card-body flex-row items-center gap-3 p-3">
                <img class="w-14 h-14 rounded-xl object-cover shrink-0" id="game_img" width="96" height="96" aria-hidden="true" alt="" itemprop="image" data-atf="true">
                <div class="min-w-0">
                    <h2 class="font-medium truncate" id="game_name"></h2>
                    <p class="text-sm text-success truncate" id="game_dev"></p>
                    <p class="text-xs opacity-60 truncate" id="game_i"></p>
                </div>
            </div>
        </div>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h2 class="card-title">Create license</h2>
                    <div class="flex items-center gap-1 text-sm opacity-60">
                        <svg class="icon" style="width:1em;height:1em"><use href="#i-link" /></svg>
                        <?= $link_total ?> links
                    </div>
                </div>

                <?= form_open() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div>
                        <label class="label">Game</label>
                        <?= form_dropdown('game', ['FREE' => 'All Games'], 'ALL', 'id="game" class="select w-full" disabled') ?>
                    </div>
                    <div>
                        <label class="label">Max devices</label>
                        <div class="join w-full">
                            <input type="number" name="max_devices" id="max_devices" class="input join-item w-full" value="1" disabled>
                            <span class="join-item btn btn-disabled no-animation">device</span>
                        </div>
                    </div>
                    <div>
                        <label class="label">Duration</label>
                        <?= form_dropdown('duration', ['1' => '1 Days'], '1', 'class="select w-full" disabled') ?>
                    </div>
                    <div>
                        <label class="label">Vip key</label>
                        <?= form_dropdown('vip_key', ['1' => 'FREE'], '1', 'class="select w-full" disabled') ?>
                    </div>
                </div>
                <div id="validationResult"></div>

                <button type="submit" class="btn btn-primary mt-4" id="btn_submit">
                    <svg class="icon"><use href="#i-arrow-right" /></svg>
                    Generate
                </button>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <div>
        <?= $chart->toHtml('my_chart'); ?>
    </div>

    <div class="lg:col-span-2">
        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <h2 class="card-title">Minimum seller price</h2>
                <div class="overflow-x-auto">
                    <table class="table table-sm text-center">
                        <thead>
                            <tr>
                                <th>Number of days</th>
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

<p class="text-center text-sm opacity-60 mt-4">
    Get key with donate?
    <a href="https://t.me/tis_nquyen" target="_blank" class="link link-hover text-primary">Contact Admin</a>
</p>

<?= $this->endSection() ?>
