<?php

namespace App\Libraries\Debug;

use App\Libraries\Debug\Collectors\LayoutCollector;
use App\Libraries\Debug\Collectors\OverflowCollector;
use App\Libraries\Debug\Collectors\StickyCollector;
use App\Libraries\Debug\Collectors\ResponsiveCollector;
use App\Libraries\Debug\Collectors\ZIndexCollector;
use App\Libraries\Debug\Collectors\InspectorCollector;

/**
 * Frontend/UI Debug Toolbar.
 *
 * Project-wide infrastructure, not tied to any one View. Any layout calls:
 *
 *     <?= (new \App\Libraries\Debug\DebugToolbar())->render() ?>
 *
 * In production (ENVIRONMENT !== 'development') render() returns an empty
 * string — no HTML, no <link>/<script> tags, zero bytes shipped, zero
 * overhead. This check is deliberately the very first thing render() does.
 *
 * To add a new panel later: create a Collectors\XCollector (extends
 * Collector), add it to registerDefaultCollectors() below, add its JS file
 * under public/assets/debug/collectors/, and its panel view under
 * app/Views/Debug/panels/. Nothing else in the project needs to change.
 */
class DebugToolbar
{
    /** @var Collector[] */
    protected array $collectors = [];

    public function __construct()
    {
        $this->registerDefaultCollectors();
    }

    protected function registerDefaultCollectors(): void
    {
        $this->collectors = [
            new LayoutCollector(),
            new OverflowCollector(),
            new StickyCollector(),
            new ResponsiveCollector(),
            new ZIndexCollector(),
            new InspectorCollector(),
        ];
    }

    /**
     * Register an additional collector at runtime (e.g. from a Filter or a
     * specific controller that wants a project-specific panel). Kept for
     * extensibility — not used by the default set above.
     */
    public function addCollector(Collector $collector): static
    {
        $this->collectors[] = $collector;

        return $this;
    }

    /** @return Collector[] */
    public function getCollectors(): array
    {
        return $this->collectors;
    }

    public static function isEnabled(): bool
    {
        return defined('ENVIRONMENT') && ENVIRONMENT === 'development';
    }

    /**
     * Renders the toolbar, or an empty string outside development.
     * This is the only method a layout ever needs to call.
     */
    public function render(): string
    {
        if (! self::isEnabled()) {
            return '';
        }

        return view('Debug/toolbar', [
            'collectors' => $this->collectors,
        ]);
    }
}
