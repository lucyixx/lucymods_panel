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
<?= $this->section('content') ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

<div class="flex justify-center">
    <div class="flex flex-wrap mb-12 gap-4">
        <div class="w-full lg:w-1/2 mb-3">
            <div class="mb-3">
                <?= $this->include('Layout/msgStatus') ?>
                <?php if (session()->getFlashdata('user_key')) : ?>
                    <div class="alert alert-success" role="alert">
                        <strong>Game: </strong><?= esc(session()->getFlashdata('game')) ?> / <?= esc(session()->getFlashdata('duration')) ?> Days<br>
                        <strong>License: </strong><?= esc(session()->getFlashdata('user_key')) ?><br>
                        Available for <?= esc(session()->getFlashdata('max_devices')) ?> Devices<br>
                    </div>
                <?php endif; ?>
            </div>

            <div id="game_view" class="mb-3" hidden>
                <div class="app-workflow-bg text-inherit border rounded overflow-hidden block h-full relative">
                    <div class="flex" style="padding: 0.5rem;">
                        <div class="shrink-0 me-2" style="width: 3.75rem;">
                            <img class="rounded-lg" id="game_img" width="96" height="96" aria-hidden="true" alt="Icon image" itemprop="image" data-atf="true">
                        </div>
                        <div style="min-width: 0;">
                            <h2 class="font-display text-base" id="game_name" style="margin-bottom: 2px;"></h2>
                            <div class="text-sm truncate">
                                <span id="game_dev" class="text-success"></span>
                            </div>
                            <div class="text-sm opacity-70 truncate">
                                <span id="game_i" class="text-sm"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel mb-3">
                <div class="panel-head">
                    <span class="panel-head-title">Create License</span>
                    <div class="opacity-70">
                        <i class="bi bi-pass"></i>
                        <span class="text-sm"><?= $link_total ?> links</span>
                    </div>
                </div>
                <div class="panel-body my-3">

                    <?= form_open() ?>
                    <div class="my-0">
                        <div class="flex flex-wrap gap-4">
                            <div class="w-full lg:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-controller"></i></span>
                                    <?= form_dropdown('game', ['FREE' => 'All Games'], 'ALL', 'id="game" class="select select-bordered join-item grow" disabled') ?>
                                </div>
                            </div>
                            <div class="w-full lg:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-phone"></i></span>
                                    <input type="number" name="max_devices" id="max_devices" class="input input-bordered join-item grow" value="1" disabled>
                                    <span class="join-item btn btn-ghost pointer-events-none px-3">device</span>
                                </div>
                            </div>
                            <div class="w-full lg:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-calendar-day"></i></span>
                                    <?= form_dropdown('duration', ['1' => '1 Days'], '1', 'class="select select-bordered join-item grow" disabled') ?>
                                </div>
                            </div>
                            <div class="w-full lg:w-1/2 mb-3">
                                <div class="join w-full">
                                    <span class="join-item btn btn-ghost pointer-events-none px-3"><i class="bi bi-gem"></i></span>
                                    <?= form_dropdown('vip_key', ['1' => 'FREE'], '1', 'class="select select-bordered join-item grow" disabled') ?>
                                </div>
                            </div>
                        </div>
                        <div id="validationResult"></div>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-sm btn-primary btn-hud" id="btn_submit"><i class="bi bi-box-arrow-in-right"></i> Generate</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 mb-3">
            <?= $chart->toHtml('my_chart'); ?>
        </div>
        <div class="w-full mb-3">
            <div class="panel">
                <div class="panel-head"><span class="panel-head-title">Minimum Seller Price</span></div>
                <div class="panel-body text-center">
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

<p class="text-center opacity-70 after-card">
    <small class="p-2 rounded">
        Get key with donate?
        <a href="https://t.me/tis_nquyen" target="_blank" class="text-primary">Contact Admin</a>
    </small>
</p>

<?= $this->endSection() ?>
