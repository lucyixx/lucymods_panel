<?php

namespace App\Libraries\Debug;

/**
 * Base class for a Frontend/UI Debug Toolbar panel.
 *
 * This is intentionally NOT a server-side data collector the way CI4's own
 * Database/Views/Logs collectors are — layout, overflow, sticky behavior,
 * and computed styles only exist in the browser, not in PHP. So each
 * Collector here is a small *descriptor*: which tab it registers, which
 * icon it uses, which JS module actually does the DOM inspection, and
 * which panel view renders its container markup. The real work happens in
 * the paired JS file under public/assets/debug/collectors/.
 */
abstract class Collector
{
    /** Unique id, used as the tab/panel data-attribute. */
    protected string $id;

    /** Human-readable tab label. */
    protected string $label;

    /** Icon sprite id from Layout/icons.php (e.g. 'i-layout'). */
    protected string $icon;

    /** Path relative to public/assets/debug/collectors/, e.g. 'layout.js'. */
    protected string $jsFile;

    /** View path relative to app/Views/, e.g. 'Debug/panels/layout'. */
    protected string $panelView;

    /** Whether this panel offers a visual page overlay toggle. */
    protected bool $hasOverlay = false;

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getJsFile(): string
    {
        return $this->jsFile;
    }

    public function getPanelView(): string
    {
        return $this->panelView;
    }

    public function hasOverlay(): bool
    {
        return $this->hasOverlay;
    }
}
