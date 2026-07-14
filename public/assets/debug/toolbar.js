/**
 * Frontend/UI Debug Toolbar — core.
 *
 * Provides the shared registry every collector module uses:
 *   - DebugToolbar.onAction(id, handler)   delegated click/change handling
 *   - DebugToolbar.drawOverlay(id, boxes)  shared highlight-box renderer
 *   - DebugToolbar.clearOverlay(id)
 *   - DebugToolbar.panel(id)               the panel <section> element
 *
 * Vanilla JS only, no dependencies. This file is only ever loaded when
 * ENVIRONMENT === 'development' (see DebugToolbar.php / Debug/toolbar.php).
 */
(function () {
    'use strict';

    var toolbar = document.getElementById('dbg-toolbar');
    var overlayLayer = document.getElementById('dbg-overlay-layer');
    if (!toolbar || !overlayLayer) return;

    var tabs = Array.prototype.slice.call(toolbar.querySelectorAll('[data-dbg-tab]'));
    var panels = Array.prototype.slice.call(toolbar.querySelectorAll('[data-dbg-panel]'));

    function setExpanded(expanded) {
        toolbar.dataset.state = expanded ? 'expanded' : 'collapsed';
    }

    function selectTab(id) {
        tabs.forEach(function (tab) {
            var active = tab.dataset.dbgTab === id;
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        panels.forEach(function (panel) {
            panel.hidden = panel.getAttribute('data-dbg-panel') !== id;
        });
        setExpanded(true);
    }

    document.getElementById('dbg-toggle').addEventListener('click', function () {
        var isExpanded = toolbar.dataset.state === 'expanded';
        if (isExpanded) {
            setExpanded(false);
        } else {
            // Expand to whichever tab was last active, or the first one.
            var current = tabs.find(function (t) { return t.getAttribute('aria-selected') === 'true'; });
            selectTab((current || tabs[0]).dataset.dbgTab);
        }
    });

    document.getElementById('dbg-close').addEventListener('click', function () {
        setExpanded(false);
    });

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            selectTab(tab.dataset.dbgTab);
        });
    });

    // ---- Shared action-delegation helper --------------------------------
    // Collectors call DebugToolbar.onAction('overflow:scan', fn) instead of
    // wiring up their own querySelector/addEventListener boilerplate.
    var actionHandlers = {};

    toolbar.addEventListener('click', function (e) {
        var el = e.target.closest('[data-dbg-action]');
        if (!el || el.tagName === 'INPUT') return;
        var action = el.getAttribute('data-dbg-action');
        if (actionHandlers[action]) actionHandlers[action](el, e);
    });

    toolbar.addEventListener('change', function (e) {
        var el = e.target.closest('[data-dbg-action]');
        if (!el) return;
        var action = el.getAttribute('data-dbg-action');
        if (actionHandlers[action]) actionHandlers[action](el, e);
    });

    // ---- Shared overlay renderer ------------------------------------------
    // Each collector "owns" a variant name (matches its highlight color in
    // toolbar.css) so multiple overlays can coexist without clobbering
    // each other's boxes.
    var overlayGroups = {};

    function drawOverlay(variant, boxes) {
        clearOverlay(variant);
        var group = document.createElement('div');
        group.dataset.dbgOverlayGroup = variant;
        boxes.forEach(function (box) {
            var el = document.createElement('div');
            el.className = 'dbg-highlight-box dbg-highlight-box--' + variant;
            el.style.left = box.rect.left + 'px';
            el.style.top = box.rect.top + 'px';
            el.style.width = box.rect.width + 'px';
            el.style.height = box.rect.height + 'px';
            if (box.label) {
                var label = document.createElement('span');
                label.className = 'dbg-highlight-label';
                label.textContent = box.label;
                el.appendChild(label);
            }
            group.appendChild(el);
        });
        overlayLayer.appendChild(group);
        overlayGroups[variant] = group;
    }

    function clearOverlay(variant) {
        if (overlayGroups[variant]) {
            overlayGroups[variant].remove();
            delete overlayGroups[variant];
        }
    }

    // Overlay boxes are positioned in viewport coordinates (getBoundingClientRect),
    // so they need to be redrawn on scroll/resize for as long as any group is active.
    function redrawActiveOverlays() {
        window.dispatchEvent(new CustomEvent('dbg:overlay:redraw'));
    }
    window.addEventListener('scroll', redrawActiveOverlays, { passive: true });
    window.addEventListener('resize', redrawActiveOverlays);

    // ---- Shared stacking-context helpers -------------------------------
    // Used by both sticky.js and zindex.js (and any future collector) so
    // this logic exists in exactly one place.
    function establishesStackingContext(el) {
        var cs = getComputedStyle(el);
        if (cs.position !== 'static' && cs.zIndex !== 'auto') return true;
        if (cs.opacity !== '1') return true;
        if (cs.transform !== 'none') return true;
        if (cs.filter !== 'none') return true;
        if (cs.perspective !== 'none') return true;
        if (cs.isolation === 'isolate') return true;
        if (cs.mixBlendMode !== 'normal') return true;
        if (cs.willChange && /transform|opacity|filter/.test(cs.willChange)) return true;
        if (cs.contain && /layout|paint|strict|content/.test(cs.contain)) return true;
        if (cs.position === 'fixed' || cs.position === 'sticky') return true;
        return false;
    }

    function findStackingParent(el) {
        var node = el.parentElement;
        while (node && node !== document.documentElement) {
            if (establishesStackingContext(node)) return node;
            node = node.parentElement;
        }
        return document.documentElement;
    }

    // ---- Public API ---------------------------------------------------
    window.DebugToolbar = {
        panel: function (id) {
            return toolbar.querySelector('[data-dbg-panel="' + id + '"]');
        },
        onAction: function (id, handler) {
            actionHandlers[id] = handler;
        },
        drawOverlay: drawOverlay,
        clearOverlay: clearOverlay,
        onOverlayRedraw: function (handler) {
            window.addEventListener('dbg:overlay:redraw', handler);
        },
        establishesStackingContext: establishesStackingContext,
        findStackingParent: findStackingParent,
        /** Best-effort CSS selector for an element, for display purposes. */
        describeElement: function (el) {
            if (!el) return '(none)';
            var s = el.tagName.toLowerCase();
            if (el.id) s += '#' + el.id;
            if (el.className && typeof el.className === 'string' && el.className.trim()) {
                s += '.' + el.className.trim().split(/\s+/).slice(0, 3).join('.');
            }
            return s;
        },
    };
})();
