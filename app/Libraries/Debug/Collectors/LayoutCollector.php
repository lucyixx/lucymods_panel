<?php

namespace App\Libraries\Debug\Collectors;

use App\Libraries\Debug\Collector;

/**
 * Layout panel — viewport, document size, safe-area, scrollbar presence,
 * current breakpoint, orientation. See public/assets/debug/collectors/layout.js.
 */
class LayoutCollector extends Collector
{
    protected string $id = 'layout';
    protected string $label = 'Layout';
    protected string $icon = 'i-diagram';
    protected string $jsFile = 'layout.js';
    protected string $panelView = 'Debug/panels/layout';
}
