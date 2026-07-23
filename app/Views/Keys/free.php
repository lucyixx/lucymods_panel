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



<?= $this->extend('Layout/BootstrapLayout') ?>
<?= $this->section('content') ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

<div class="justify-content-center">
    <div class="row mb-5">
        <div class="col-lg-6 mb-3 px-0 px-lg-3">
            <div class="mb-3">
                <?= $this->include('Layout/BootstrapMsgStatus') ?>
                <?php if (session()->getFlashdata('user_key')) : ?>
                    <div class="alert alert-success" role="alert">
                        <strong>Game: </strong><?= esc(session()->getFlashdata('game')) ?> / <?= esc(session()->getFlashdata('duration')) ?> Days<br>
                        <strong>License: </strong><?= esc(session()->getFlashdata('user_key')) ?><br>
                        Available for <?= esc(session()->getFlashdata('max_devices')) ?> Devices<br>
                    </div>
                <?php endif; ?>
            </div>

            <div id="game_view" class="mb-3" hidden>
                <div class="text-body border rounded overflow-hidden d-block h-100 position-relative" style="background-color: var(--bs-workflow-bg);">
                    <div class="d-flex" style="padding: 0.5rem;">
                        <div class="flex-shrink-0 me-2" style="width: 3.75rem;">
                            <img class="rounded-3" id="game_img" width="96" height="96" aria-hidden="true" alt="Icon image" itemprop="image" data-atf="true">
                        </div>
                        <div style="min-width: 0;">
                            <h2 class="h6" id="game_name" style="margin-bottom: 2px;"></h2>
                            <div class="small text-truncate">
                                <span id="game_dev" class="text-success"></span>
                            </div>
                            <div class="small text-muted text-truncate">
                                <span id="game_i" class="small"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="card-title m-0"><span>Create License</span></span>
                    <div class="text-secondary">
                        <i class="bi bi-pass"></i>
                        <span class="small"><?= $link_total ?> links</span>
                    </div>
                </div>
                <div class="card-body my-3">

                    <?= form_open() ?>
                    <div class="my-0">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="game" class="input-group-text"><i class="bi bi-controller"></i></label>
                                    <?= form_dropdown('game', ['FREE' => 'All Games'], 'ALL', 'id="game" class="form-select" disabled') ?>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="max_devices" class="input-group-text"><i class="bi bi-phone"></i></label>
                                    <input type="number" name="max_devices" id="max_devices" class="form-control" value="1" disabled>
                                    <div class="input-group-text">device</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="duration" class="input-group-text"><i class="bi bi-calendar-day"></i></label>
                                    <?= form_dropdown('duration', ['1' => '1 Days'], '1', 'class="form-select" disabled') ?>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="input-group">
                                    <label for="vip_key" class="input-group-text"><i class="bi bi-gem"></i></label>
                                    <?= form_dropdown('vip_key', ['1' => 'FREE'], '1', 'class="form-select" disabled') ?>
                                </div>
                            </div>
                        </div>
                        <div id="validationResult"></div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary" id="btn_submit"><i class="bi bi-box-arrow-in-right"></i> Generate</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3 px-0 px-lg-3">
            <?= $chart->toHtml('my_chart'); ?>
        </div>
        <div class="mb-3 px-0 px-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title m-0"><span>Minimum Seller Price</span></div>
                </div>
                <div class="card-body text-center">
                    <table class="table table-borderless table-striped">
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

<p class="text-center text-muted after-card">
    <small class="px-auto p-2 rounded">
        Get key with donate?
        <a href="https://t.me/tis_nquyen" target="_blank" class="text-primary">Contact Admin</a>
    </small>
</p>
</div>

<?= $this->endSection() ?>