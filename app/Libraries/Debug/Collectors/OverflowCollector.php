<?php

namespace App\Libraries\Debug\Collectors;

use App\Libraries\Debug\Collector;

/**
 * Overflow panel — scans the entire DOM for any element whose box breaches
 * the viewport, lists it (selector, rect, computed width, overflow amount),
 * and can highlight it directly on the page. See
 * public/assets/debug/collectors/overflow.js.
 */
class OverflowCollector extends Collector
{
    protected string $id = 'overflow';
    protected string $label = 'Overflow';
    protected string $icon = 'i-alert';
    protected string $jsFile = 'overflow.js';
    protected string $panelView = 'Debug/panels/overflow';
    protected bool $hasOverlay = true;
}
