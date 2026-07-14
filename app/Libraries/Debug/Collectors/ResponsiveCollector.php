<?php

namespace App\Libraries\Debug\Collectors;

use App\Libraries\Debug\Collector;

/**
 * Responsive panel — current Tailwind breakpoint, navbar height, active
 * sticky offsets, safe-area insets, zoom level, device pixel ratio. See
 * public/assets/debug/collectors/responsive.js.
 */
class ResponsiveCollector extends Collector
{
    protected string $id = 'responsive';
    protected string $label = 'Responsive';
    protected string $icon = 'i-scan';
    protected string $jsFile = 'responsive.js';
    protected string $panelView = 'Debug/panels/responsive';
}
