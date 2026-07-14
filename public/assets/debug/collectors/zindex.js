/**
 * Z-Index collector.
 * Lists every element with a computed z-index other than 'auto' — this
 * project's own tokens (--z-sticky, --z-navbar, --z-modal) resolve to
 * plain numbers by the time getComputedStyle sees them, so whatever is
 * actually applied shows up here exactly as the browser sees it, not as
 * whatever the source CSS claims.
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    var lastResults = [];

    function scan() {
        var results = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer')) return;
            var cs = getComputedStyle(el);
            if (cs.zIndex !== 'auto') {
                results.push({
                    el: el,
                    zIndex: cs.zIndex,
                    position: cs.position,
                    stackingParent: DebugToolbar.findStackingParent(el),
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

    function render(results) {
        var panel = DebugToolbar.panel('zindex');
        var summary = panel.querySelector('[data-dbg-zindex-summary]');
        var tbody = panel.querySelector('[data-dbg-zindex-table] tbody');

        summary.textContent = results.length === 0
            ? 'No elements with an explicit z-index found.'
            : results.length + ' element(s) with a z-index other than auto.';

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code>' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + item.zIndex + '</td>' +
                '<td>' + item.position + '</td>' +
                '<td><code>' + DebugToolbar.describeElement(item.stackingParent) + '</code></td>' +
                '<td><button type="button" class="dbg-row-btn" data-i="' + i + '">Show</button></td>';
            tr.querySelector('button').addEventListener('click', function () {
                item.el.scrollIntoView({ block: 'center', behavior: 'smooth' });
                DebugToolbar.drawOverlay('zindex', [{
                    rect: item.el.getBoundingClientRect(),
                    label: DebugToolbar.describeElement(item.el) + ' (z:' + item.zIndex + ')'
                }]);
                var box = panel.querySelector('[data-dbg-action="zindex:highlight"]');
                if (box) box.checked = true;
            });
            tbody.appendChild(tr);
        });
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
    DebugToolbar.onAction('zindex:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="zindex:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
