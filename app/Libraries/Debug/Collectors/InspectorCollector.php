<?php

namespace App\Libraries\Debug\Collectors;

use App\Libraries\Debug\Collector;

/**
 * Inspector panel — click-to-select any element on the page, see its
 * selector, classes, id, bounding rect, full computed style (display,
 * position, flex, grid, overflow, transform, box-sizing, aspect-ratio...),
 * parent, and children. A small DevTools-style layout inspector scoped to
 * this project. See public/assets/debug/collectors/inspector.js.
 */
class InspectorCollector extends Collector
{
    protected string $id = 'inspector';
    protected string $label = 'Inspector';
    protected string $icon = 'i-search';
    protected string $jsFile = 'inspector.js';
    protected string $panelView = 'Debug/panels/inspector';
    protected bool $hasOverlay = false;
}
