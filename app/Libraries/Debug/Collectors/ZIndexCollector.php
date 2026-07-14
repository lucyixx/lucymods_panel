<?php

namespace App\Libraries\Debug\Collectors;

use App\Libraries\Debug\Collector;

/**
 * Z-Index panel — lists every element with a non-auto z-index (navbar,
 * dropdown, sidebar, modal, tooltip, toast, sticky bars, gallery...) along
 * with its parent stacking context and computed value, sorted so stacking
 * conflicts are obvious at a glance. See
 * public/assets/debug/collectors/zindex.js.
 */
class ZIndexCollector extends Collector
{
    protected string $id = 'zindex';
    protected string $label = 'Z-Index';
    protected string $icon = 'i-server';
    protected string $jsFile = 'zindex.js';
    protected string $panelView = 'Debug/panels/zindex';
    protected bool $hasOverlay = true;
}
