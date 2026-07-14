<?php
/**
 * Frontend/UI Debug Toolbar — shell.
 *
 * Rendered only by DebugToolbar::render(), which already checked
 * ENVIRONMENT === 'development' before including this view. Never include
 * this file directly from a page/layout — always go through
 * (new \App\Libraries\Debug\DebugToolbar())->render().
 *
 * @var \App\Libraries\Debug\Collector[] $collectors
 */
?>
<link rel="stylesheet" href="<?= base_url('assets/debug/toolbar.css') ?>">

<div id="dbg-toolbar" class="dbg-toolbar" data-state="collapsed" aria-hidden="false">
    <div class="dbg-tabs" role="tablist">
        <button type="button" class="dbg-tab dbg-tab--brand" id="dbg-toggle" aria-label="Toggle debug toolbar">
            <svg class="dbg-icon"><use href="#i-scan" /></svg>
            <span>Debug</span>
        </button>

        <?php foreach ($collectors as $collector) : ?>
            <button type="button"
                    class="dbg-tab"
                    data-dbg-tab="<?= esc($collector->getId(), 'attr') ?>"
                    role="tab"
                    aria-selected="false">
                <svg class="dbg-icon"><use href="#<?= esc($collector->getIcon()) ?>" /></svg>
                <span><?= esc($collector->getLabel()) ?></span>
            </button>
        <?php endforeach; ?>

        <div class="dbg-tabs-spacer"></div>

        <span class="dbg-env" title="Only ever rendered when ENVIRONMENT === 'development'">development</span>
        <button type="button" class="dbg-tab dbg-tab--close" id="dbg-close" aria-label="Close debug toolbar">
            <svg class="dbg-icon"><use href="#i-x" /></svg>
        </button>
    </div>

    <div class="dbg-panels">
        <?php foreach ($collectors as $collector) : ?>
            <section class="dbg-panel" data-dbg-panel="<?= esc($collector->getId(), 'attr') ?>" hidden>
                <?= $this->include($collector->getPanelView()) ?>
            </section>
        <?php endforeach; ?>
    </div>
</div>

<!-- Shared overlay layer the collectors draw highlight boxes into. -->
<div id="dbg-overlay-layer" aria-hidden="true"></div>

<script src="<?= base_url('assets/debug/toolbar.js') ?>"></script>
<?php foreach ($collectors as $collector) : ?>
    <script src="<?= base_url('assets/debug/collectors/' . $collector->getJsFile()) ?>"></script>
<?php endforeach; ?>
