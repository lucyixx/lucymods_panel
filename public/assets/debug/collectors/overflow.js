/**
 * Overflow collector.
 * Finds every element whose bounding box extends past the viewport width
 * (right edge > innerWidth, or width itself > innerWidth) — the same
 * technique used to hunt the earlier horizontal-overflow bugs, now
 * generalized and available on any page, not hardcoded to Details.
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    var lastResults = [];

    function scan() {
        var vw = window.innerWidth;
        var results = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer')) return;
            var r = el.getBoundingClientRect();
            var overflowAmount = Math.max(r.right - vw, r.width - vw);
            if (overflowAmount > 1) {
                results.push({ el: el, rect: r, overflow: overflowAmount });
            }
        });
        // Largest offender first.
        results.sort(function (a, b) { return b.overflow - a.overflow; });
        lastResults = results;
        render(results, vw);
        return results;
    }

    function render(results, vw) {
        var panel = DebugToolbar.panel('overflow');
        var summary = panel.querySelector('[data-dbg-overflow-summary]');
        var tbody = panel.querySelector('[data-dbg-overflow-table] tbody');

        summary.textContent = results.length === 0
            ? 'No horizontal overflow detected (viewport ' + vw + 'px).'
            : results.length + ' element(s) overflowing the ' + vw + 'px viewport.';

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var cs = getComputedStyle(item.el);
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code>' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + Math.round(item.rect.width) + 'px</td>' +
                '<td>' + cs.width + '</td>' +
                '<td>' + Math.round(item.overflow) + 'px</td>' +
                '<td><button type="button" class="dbg-row-btn" data-i="' + i + '">Show</button></td>';
            tr.querySelector('button').addEventListener('click', function () {
                item.el.scrollIntoView({ block: 'center', behavior: 'smooth' });
                DebugToolbar.drawOverlay('overflow', [{
                    rect: item.el.getBoundingClientRect(),
                    label: DebugToolbar.describeElement(item.el) + ' (+' + Math.round(item.overflow) + 'px)'
                }]);
                var box = panel.querySelector('[data-dbg-action="overflow:highlight"]');
                if (box) box.checked = true;
            });
            tbody.appendChild(tr);
        });
    }

    function updateHighlightAll(enabled) {
        if (!enabled) { DebugToolbar.clearOverlay('overflow'); return; }
        var boxes = lastResults.map(function (item) {
            return {
                rect: item.el.getBoundingClientRect(),
                label: DebugToolbar.describeElement(item.el) + ' (+' + Math.round(item.overflow) + 'px)'
            };
        });
        DebugToolbar.drawOverlay('overflow', boxes);
    }

    DebugToolbar.onAction('overflow:scan', scan);
    DebugToolbar.onAction('overflow:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="overflow:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
