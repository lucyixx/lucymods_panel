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
<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div>
        <?= $this->include('Layout/msgStatus') ?>

        <?php if (session()->getFlashdata('user_key')) : ?>
            <div class="alert alert-success mb-4">
                <svg class="icon"><use href="#i-check-circle" /></svg>
                <div>
                    <strong>Game: </strong><?= esc(session()->getFlashdata('game')) ?> / <?= esc(session()->getFlashdata('duration')) ?> Days<br>
                    <strong>License: </strong><?= esc(session()->getFlashdata('user_key')) ?><br>
                    Available for <?= esc(session()->getFlashdata('max_devices')) ?> Devices<br>
                </div>
            </div>
        <?php endif; ?>

        <div id="game_view" class="mb-4" hidden>
            <div class="card card-border bg-base-100 border-base-300">
                <div class="card-body flex-row items-start gap-3 p-3">
                    <img class="rounded-box shrink-0" id="game_img" width="96" height="96" aria-hidden="true" alt="Icon image" itemprop="image" data-atf="true">
                    <div class="min-w-0">
                        <h2 class="font-semibold text-base truncate" id="game_name"></h2>
                        <div class="text-sm truncate">
                            <span id="game_dev" class="text-success"></span>
                        </div>
                        <div class="text-xs opacity-60 truncate">
                            <span id="game_i"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-border bg-base-100 border-base-300">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <h2 class="card-title">Create License</h2>
                    <div class="text-sm opacity-70 flex items-center gap-1">
                        <svg class="icon" style="width:0.9rem;height:0.9rem"><use href="#i-link" /></svg>
                        <span><?= $link_total ?> links</span>
                    </div>
                </div>

                <?= form_open() ?>
                <fieldset class="fieldset gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label" for="game">Game</label>
                            <?= form_dropdown('game', ['FREE' => 'All Games'], 'ALL', 'id="game" class="select w-full" disabled') ?>
                        </div>
                        <div>
                            <label class="label" for="max_devices">Max devices</label>
                            <label class="input w-full">
                                <input type="number" name="max_devices" id="max_devices" class="grow" value="1" disabled>
                                <span class="label">device</span>
                            </label>
                        </div>
                        <div>
                            <label class="label" for="duration">Duration</label>
                            <?= form_dropdown('duration', ['1' => '1 Days'], '1', 'class="select w-full" disabled') ?>
                        </div>
                        <div>
                            <label class="label" for="vip_key">Key level</label>
                            <?= form_dropdown('vip_key', ['1' => 'FREE'], '1', 'class="select w-full" disabled') ?>
                        </div>
                    </div>
                    <div id="validationResult"></div>
                </fieldset>

                <div class="card-actions justify-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm" id="btn_submit">
                        <svg class="icon"><use href="#i-arrow-right" /></svg>Generate
                    </button>
                </div>
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
                <h2 class="card-title">Minimum Seller Price</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-center">
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

<p class="text-center opacity-60 mt-4 after-card">
    <small>
        Get key with donate?
        <a href="https://t.me/tis_nquyen" target="_blank" class="link link-primary">Contact Admin</a>
    </small>
</p>

<?= $this->endSection() ?>
