/**
 * Frontend/UI Debug Toolbar — core.
 *
 * Provides the shared registry every collector module uses:
 *   - DebugToolbar.onAction(id, handler)   delegated click/change handling
 *   - DebugToolbar.drawOverlay(id, boxes)  shared highlight-box renderer
 *   - DebugToolbar.clearOverlay(id)
 *   - DebugToolbar.panel(id)               the panel <section> element
 *   - DebugToolbar.copyText(text, cb)      robust clipboard write + toast
 *
 * Vanilla JS only, no dependencies. This file is only ever loaded when
 * ENVIRONMENT === 'development' (see DebugToolbar.php / Debug/toolbar.php).
 */
(function () {
    'use strict';

    var toolbar = document.getElementById('dbg-toolbar');
    var win = document.getElementById('dbg-window');
    var overlayLayer = document.getElementById('dbg-overlay-layer');
    var toastLayer = document.getElementById('dbg-toast-layer');
    if (!toolbar || !win || !overlayLayer) return;

    var STORAGE_KEY = 'dbgToolbarOpen';
    var tabs = Array.prototype.slice.call(toolbar.querySelectorAll('[data-dbg-tab]'));
    var panels = Array.prototype.slice.call(toolbar.querySelectorAll('[data-dbg-panel]'));

    // ---- Open / close (floating button <-> floating window) -----------
    function setExpanded(expanded) {
        toolbar.dataset.state = expanded ? 'expanded' : 'collapsed';
        document.getElementById('dbg-toggle').setAttribute('aria-expanded', expanded ? 'true' : 'false');
        win.setAttribute('aria-hidden', expanded ? 'false' : 'true');
        try { localStorage.setItem(STORAGE_KEY, expanded ? '1' : '0'); } catch (e) { /* private mode, etc — non-fatal */ }
    }

    function selectTab(id) {
        tabs.forEach(function (tab) {
            var active = tab.dataset.dbgTab === id;
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        panels.forEach(function (panel) {
            panel.hidden = panel.getAttribute('data-dbg-panel') !== id;
        });
    }

    document.getElementById('dbg-toggle').addEventListener('click', function () {
        setExpanded(true);
        var current = tabs.filter(function (t) { return t.getAttribute('aria-selected') === 'true'; })[0];
        selectTab((current || tabs[0]).dataset.dbgTab);
    });

    document.getElementById('dbg-close').addEventListener('click', function () {
        setExpanded(false);
    });

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            selectTab(tab.dataset.dbgTab);
        });
    });

    // ESC closes the window.
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && toolbar.dataset.state === 'expanded') {
            setExpanded(false);
        }
    });

    // Clicking anywhere outside the window (and outside the launcher)
    // closes it. Uses mousedown so it doesn't fight with a click that's
    // still opening the window in the same event.
    document.addEventListener('mousedown', function (e) {
        if (toolbar.dataset.state !== 'expanded') return;
        if (toolbar.contains(e.target)) return;
        setExpanded(false);
    });

    // Restore last-open state on load.
    try {
        if (localStorage.getItem(STORAGE_KEY) === '1') {
            setExpanded(true);
            selectTab((tabs[0] || {}).dataset && tabs[0].dataset.dbgTab);
        }
    } catch (e) { /* private mode, etc — default to collapsed */ }

    // ---- Shared action-delegation helper --------------------------------
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

    function redrawActiveOverlays() {
        window.dispatchEvent(new CustomEvent('dbg:overlay:redraw'));
    }
    window.addEventListener('scroll', redrawActiveOverlays, { passive: true });
    window.addEventListener('resize', redrawActiveOverlays);

    // ---- Shared stacking-context helpers -------------------------------
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

    // ---- Toast --------------------------------------------------------
    function showToast(message, kind) {
        if (!toastLayer) return;
        var el = document.createElement('div');
        el.className = 'dbg-toast dbg-toast--' + (kind || 'success');
        el.textContent = message;
        toastLayer.appendChild(el);
        // Force layout so the transition actually runs.
        void el.offsetWidth;
        el.classList.add('dbg-toast--visible');
        setTimeout(function () {
            el.classList.remove('dbg-toast--visible');
            setTimeout(function () { el.remove(); }, 200);
        }, 1800);
    }

    // ---- Clipboard ------------------------------------------------------
    // Tries the modern async Clipboard API first (requires a secure
    // context — HTTPS or localhost — and a real user gesture). Falls back
    // to the older execCommand('copy') via a temporary textarea, which
    // still works over plain HTTP and on older Android WebViews. Every
    // path reports real, verified success/failure via a toast — nothing
    // is assumed to have worked.
    function execCommandCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.setAttribute('readonly', '');
        // Off-screen but NOT display:none/opacity:0 — some Android/iOS
        // browsers refuse to select() an invisible field.
        ta.style.position = 'fixed';
        ta.style.top = '0';
        ta.style.left = '-9999px';
        ta.style.width = '1px';
        ta.style.height = '1px';
        document.body.appendChild(ta);
        ta.focus();
        ta.select();
        try { ta.setSelectionRange(0, text.length); } catch (e) { /* not all inputs support this */ }
        var ok = false;
        try { ok = document.execCommand('copy'); } catch (e) { ok = false; }
        ta.remove();
        return ok;
    }

    function copyText(text, onDone) {
        function finish(ok) {
            showToast(ok ? 'Copied to clipboard' : 'Copy failed — select and copy manually', ok ? 'success' : 'error');
            if (onDone) onDone(ok);
        }

        if (navigator.clipboard && navigator.clipboard.writeText && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(
                function () { finish(true); },
                function () { finish(execCommandCopy(text)); }
            );
        } else {
            // Not a secure context (plain HTTP) or API unavailable — go
            // straight to the fallback rather than letting the async API
            // silently reject.
            finish(execCommandCopy(text));
        }
    }

    function flashCopied(btn) {
        // Kept for backward compatibility with any caller still using it —
        // the toast is now the primary success/failure signal.
        var original = btn.textContent;
        btn.textContent = 'Copied!';
        setTimeout(function () { btn.textContent = original; }, 1000);
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
        copyText: copyText,
        flashCopied: flashCopied,
        showToast: showToast,
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
