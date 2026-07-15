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
    var lastViewport = 0;

    function containedBySafeScrollAncestor(el, vw) {
        var node = el.parentElement;
        while (node && node !== document.documentElement) {
            var cs = getComputedStyle(node);
            if (cs.overflowX === 'scroll' || cs.overflowX === 'auto' || cs.overflowX === 'hidden') {
                var ar = node.getBoundingClientRect();
                var ancestorBreaches = ar.right > vw + 1 || ar.width > vw + 1;
                // If the scrollable ancestor itself fits the viewport, whatever
                // it clips/scrolls inside it is by design, not a page bug.
                // If the ancestor ALSO breaches the viewport, that's the real
                // bug — surface the ancestor, not every child inside it.
                return !ancestorBreaches;
            }
            node = node.parentElement;
        }
        return false;
    }

    function scan() {
        var vw = window.innerWidth;
        var results = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer') || el.closest('#dbg-toast-layer')) return;
            var r = el.getBoundingClientRect();
            var overflowAmount = Math.max(r.right - vw, r.width - vw);
            if (overflowAmount > 1 && !containedBySafeScrollAncestor(el, vw)) {
                results.push({ el: el, rect: r, overflow: overflowAmount });
            }
        });
        // Largest offender first.
        results.sort(function (a, b) { return b.overflow - a.overflow; });
        lastResults = results;
        lastViewport = vw;
        render(results, vw);
        return results;
    }

    function itemReportBlock(item) {
        return DebugToolbar.describeElement(item.el) + '\n' +
            '  width: ' + Math.round(item.rect.width) + 'px\n' +
            '  right: ' + Math.round(item.rect.right) + 'px\n' +
            '  overflow: ' + Math.round(item.overflow) + 'px';
    }

    function buildReport(results, vw) {
        var lines = ['=== Overflow ===', 'Viewport: ' + vw + 'px', ''];
        if (!results.length) {
            lines.push('No horizontal overflow detected.');
        } else {
            results.forEach(function (item, i) {
                lines.push(itemReportBlock(item));
                if (i < results.length - 1) lines.push('');
            });
        }
        return lines.join('\n');
    }

    function render(results, vw) {
        var panel = DebugToolbar.panel('overflow');
        var summary = panel.querySelector('[data-dbg-overflow-summary]');
        var wrap = panel.querySelector('.dbg-table-wrap');
        var tbody = panel.querySelector('[data-dbg-overflow-table] tbody');

        summary.textContent = results.length === 0
            ? 'No horizontal overflow detected (viewport ' + vw + 'px).'
            : results.length + ' element(s) overflowing the ' + vw + 'px viewport.';

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code>' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + vw + 'px</td>' +
                '<td>' + Math.round(item.rect.width) + 'px</td>' +
                '<td>' + Math.round(item.overflow) + 'px</td>' +
                '<td><button type="button" class="dbg-row-btn" data-i="' + i + '">Show</button></td>' +
                '<td><button type="button" class="dbg-row-btn" data-copy="' + i + '">Copy</button></td>';
            tr.querySelector('[data-i]').addEventListener('click', function () {
                item.el.scrollIntoView({ block: 'center', behavior: 'smooth' });
                DebugToolbar.drawOverlay('overflow', [{
                    rect: item.el.getBoundingClientRect(),
                    label: DebugToolbar.describeElement(item.el) + ' (+' + Math.round(item.overflow) + 'px)'
                }]);
                var box = panel.querySelector('[data-dbg-action="overflow:highlight"]');
                if (box) box.checked = true;
            });
            var copyBtn = tr.querySelector('[data-copy]');
            copyBtn.addEventListener('click', function () {
                DebugToolbar.copyText(itemReportBlock(item));
            });
            tbody.appendChild(tr);
        });

        var copyAllBtn = panel.querySelector('[data-dbg-action="overflow:copy-all"]');
        if (copyAllBtn) copyAllBtn.dataset.report = buildReport(results, vw);

        // Always show results starting from the left edge, never scrolled
        // partway/to the right from a previous interaction.
        if (wrap) wrap.scrollLeft = 0;
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
    DebugToolbar.onAction('overflow:copy-all', function (btn) {
        DebugToolbar.copyText(btn.dataset.report || buildReport([], lastViewport || window.innerWidth));
    });
    DebugToolbar.onAction('overflow:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="overflow:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
