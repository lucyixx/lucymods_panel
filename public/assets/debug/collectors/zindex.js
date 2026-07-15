/**
 * Z-Index collector.
 * Lists every element with a computed z-index other than 'auto', and
 * resolves an "Effective Layer" label by comparing it against this
 * project's own tokens (--z-sticky, --z-navbar, --z-modal), read live
 * from :root rather than hardcoded, so this stays correct even if the
 * token values in daisyui.css ever change.
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    var lastResults = [];

    function readToken(name) {
        var raw = getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        var n = parseInt(raw, 10);
        return isNaN(n) ? null : n;
    }

    function effectiveLayer(z) {
        var n = parseInt(z, 10);
        if (isNaN(n)) return 'unknown';
        var tokens = [
            { name: '--z-sticky', label: 'Sticky tier (--z-sticky)' },
            { name: '--z-navbar', label: 'Navbar tier (--z-navbar)' },
            { name: '--z-modal', label: 'Modal tier (--z-modal)' },
        ].map(function (t) { return { value: readToken(t.name), label: t.label }; })
            .filter(function (t) { return t.value !== null; });

        for (var i = 0; i < tokens.length; i++) {
            if (n === tokens[i].value) return tokens[i].label + ' — exact match';
        }
        // Not an exact match to a known token — describe where it sits
        // relative to them, since that's what actually determines what
        // it paints above/below.
        var above = tokens.filter(function (t) { return n > t.value; }).map(function (t) { return t.label; });
        var below = tokens.filter(function (t) { return n < t.value; }).map(function (t) { return t.label; });
        if (n >= 2147483000) return 'Top-most (overlay/toolbar tier)';
        if (above.length && !below.length) return 'Above all known tiers (' + above.join(', ') + ')';
        if (below.length && !above.length) return 'Below all known tiers (' + below.join(', ') + ')';
        if (above.length && below.length) return 'Between tiers — above ' + above.join(', ') + '; below ' + below.join(', ');
        return 'Custom / other';
    }

    function scan() {
        var results = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer') || el.closest('#dbg-toast-layer')) return;
            var cs = getComputedStyle(el);
            if (cs.zIndex !== 'auto') {
                results.push({
                    el: el,
                    zIndex: cs.zIndex,
                    position: cs.position,
                    stackingParent: DebugToolbar.findStackingParent(el),
                    layer: effectiveLayer(cs.zIndex),
                });
            }
        });
        // Highest z-index first — the elements most likely to unexpectedly
        // cover something else are the ones worth seeing first.
        results.sort(function (a, b) { return parseInt(b.zIndex, 10) - parseInt(a.zIndex, 10); });
        lastResults = results;
        render(results);
        return results;
    }

    function itemReportBlock(item) {
        return DebugToolbar.describeElement(item.el) + '\n' +
            '  z-index: ' + item.zIndex + '\n' +
            '  stacking context: ' + DebugToolbar.describeElement(item.stackingParent) + '\n' +
            '  parent: ' + DebugToolbar.describeElement(item.el.parentElement) + '\n' +
            '  effective layer: ' + item.layer;
    }

    function buildReport(results) {
        var lines = ['=== Z-Index ===', ''];
        if (!results.length) {
            lines.push('No elements with an explicit z-index found.');
        } else {
            results.forEach(function (item, i) {
                lines.push(itemReportBlock(item));
                if (i < results.length - 1) lines.push('');
            });
        }
        return lines.join('\n');
    }

    function highlightOne(item) {
        item.el.scrollIntoView({ block: 'center', behavior: 'smooth' });
        DebugToolbar.drawOverlay('zindex', [{
            rect: item.el.getBoundingClientRect(),
            label: DebugToolbar.describeElement(item.el) + ' (z:' + item.zIndex + ')'
        }]);
        var box = DebugToolbar.panel('zindex').querySelector('[data-dbg-action="zindex:highlight"]');
        if (box) box.checked = true;
    }

    function render(results) {
        var panel = DebugToolbar.panel('zindex');
        var summary = panel.querySelector('[data-dbg-zindex-summary]');
        var wrap = panel.querySelector('.dbg-table-wrap');
        var tbody = panel.querySelector('[data-dbg-zindex-table] tbody');

        summary.textContent = results.length === 0
            ? 'No elements with an explicit z-index found.'
            : results.length + ' element(s) with a z-index other than auto.';

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code class="dbg-row-btn" data-i="' + i + '" title="Click to show on page">' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + item.zIndex + '</td>' +
                '<td><code>' + DebugToolbar.describeElement(item.stackingParent) + '</code></td>' +
                '<td><code>' + DebugToolbar.describeElement(item.el.parentElement) + '</code></td>' +
                '<td>' + item.layer + '</td>' +
                '<td><button type="button" class="dbg-row-btn" data-copy="' + i + '">Copy</button></td>';
            tr.querySelector('[data-i]').addEventListener('click', function () { highlightOne(item); });
            var copyBtn = tr.querySelector('[data-copy]');
            copyBtn.addEventListener('click', function () {
                DebugToolbar.copyText(itemReportBlock(item));
            });
            tbody.appendChild(tr);
        });

        var copyAllBtn = panel.querySelector('[data-dbg-action="zindex:copy-all"]');
        if (copyAllBtn) copyAllBtn.dataset.report = buildReport(results);

        if (wrap) wrap.scrollLeft = 0;
    }

    function updateHighlightAll(enabled) {
        if (!enabled) { DebugToolbar.clearOverlay('zindex'); return; }
        var boxes = lastResults.map(function (item) {
            return {
                rect: item.el.getBoundingClientRect(),
                label: DebugToolbar.describeElement(item.el) + ' (z:' + item.zIndex + ')'
            };
        });
        DebugToolbar.drawOverlay('zindex', boxes);
    }

    DebugToolbar.onAction('zindex:scan', scan);
    DebugToolbar.onAction('zindex:copy-all', function (btn) {
        DebugToolbar.copyText(btn.dataset.report || buildReport([]));
    });
    DebugToolbar.onAction('zindex:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="zindex:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
