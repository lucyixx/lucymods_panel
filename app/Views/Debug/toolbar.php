<?php
/**
 * Frontend/UI Debug Toolbar — shell.
 *
 * Rendered only by DebugToolbar::render(), which already checked
 * ENVIRONMENT === 'development' before including this view. Never include
 * this file directly from a page/layout — always go through
 * (new \App\Libraries\Debug\DebugToolbar())->render().
 *
 * Deliberately independent from CI4's own Debug Toolbar: this renders as
 * a small floating launcher button (bottom-right) that expands into a
 * floating window, never a full-width bottom bar — so it can never sit
 * on top of / cover CI4's own toolbar, which owns the full-width bottom
 * bar. Both remain fully usable at the same time.
 *
 * @var \App\Libraries\Debug\Collector[] $collectors
 */
?>
<link rel="stylesheet" href="<?= base_url('assets/debug/toolbar.css') ?>">

<div id="dbg-toolbar" class="dbg-toolbar" data-state="collapsed">
    <button type="button" class="dbg-launcher" id="dbg-toggle" aria-label="Open UI debug toolbar" aria-expanded="false">
        <svg class="dbg-icon"><use href="#i-scan" /></svg>
    </button>

    <div class="dbg-window" id="dbg-window" role="dialog" aria-label="UI debug toolbar" aria-hidden="true">
        <div class="dbg-tabs" role="tablist">
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

            <span class="dbg-env" title="Only ever rendered when ENVIRONMENT === 'development'">dev</span>
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
</div>

<!-- Toasts for copy success/failure feedback. -->
<div id="dbg-toast-layer" aria-live="polite"></div>

<!-- Shared overlay layer the collectors draw highlight boxes into. -->
<div id="dbg-overlay-layer" aria-hidden="true"></div>

<script src="<?= base_url('assets/debug/toolbar.js') ?>"></script>
<?php foreach ($collectors as $collector) : ?>
    <script src="<?= base_url('assets/debug/collectors/' . $collector->getJsFile()) ?>"></script>
<?php endforeach; ?>
