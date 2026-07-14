<?php

namespace App\Libraries\Debug\Collectors;

use App\Libraries\Debug\Collector;

/**
 * Sticky panel — finds every position:sticky element on the page and
 * reports its top offset, scroll container, stacking context, z-index, and
 * parent. See public/assets/debug/collectors/sticky.js.
 */
class StickyCollector extends Collector
{
    protected string $id = 'sticky';
    protected string $label = 'Sticky';
    protected string $icon = 'i-link';
    protected string $jsFile = 'sticky.js';
    protected string $panelView = 'Debug/panels/sticky';
    protected bool $hasOverlay = true;
}
