/**
 * Sticky collector.
 * Finds every position:sticky element and reports what's needed to
 * actually debug a sticky bug: its top offset, its parent, and which
 * ancestor establishes the stacking context it paints within.
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    var lastResults = [];

    function findScrollContainer(el) {
        var node = el.parentElement;
        while (node && node !== document.documentElement) {
            var cs = getComputedStyle(node);
            if (/(auto|scroll)/.test(cs.overflowY) || /(auto|scroll)/.test(cs.overflowX)) {
                return DebugToolbar.describeElement(node);
            }
            node = node.parentElement;
        }
        return 'viewport (document)';
    }

    function scan() {
        var results = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer') || el.closest('#dbg-toast-layer')) return;
            var cs = getComputedStyle(el);
            if (cs.position === 'sticky') {
                results.push({
                    el: el,
                    position: cs.position,
                    top: cs.top,
                    zIndex: cs.zIndex,
                    scrollContainer: findScrollContainer(el),
                    stackingParent: DebugToolbar.findStackingParent(el),
                });
            }
        });
        lastResults = results;
        render(results);
        return results;
    }

    function itemReportBlock(item) {
        return DebugToolbar.describeElement(item.el) + '\n' +
            '  position: ' + item.position + '\n' +
            '  top: ' + item.top + '\n' +
            '  z-index: ' + item.zIndex + '\n' +
            '  parent: ' + DebugToolbar.describeElement(item.el.parentElement) + '\n' +
            '  stacking context: ' + DebugToolbar.describeElement(item.stackingParent) + '\n' +
            '  scroll container: ' + item.scrollContainer;
    }

    function buildReport(results) {
        var lines = ['=== Sticky ===', ''];
        if (!results.length) {
            lines.push('No position:sticky elements found.');
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
        DebugToolbar.drawOverlay('sticky', [{
            rect: item.el.getBoundingClientRect(),
            label: DebugToolbar.describeElement(item.el) + ' (top:' + item.top + ')'
        }]);
        var box = DebugToolbar.panel('sticky').querySelector('[data-dbg-action="sticky:highlight"]');
        if (box) box.checked = true;
    }

    function render(results) {
        var panel = DebugToolbar.panel('sticky');
        var summary = panel.querySelector('[data-dbg-sticky-summary]');
        var wrap = panel.querySelector('.dbg-table-wrap');
        var tbody = panel.querySelector('[data-dbg-sticky-table] tbody');

        summary.textContent = results.length === 0
            ? 'No position:sticky elements found.'
            : results.length + ' sticky element(s) found.';

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code class="dbg-row-btn" data-i="' + i + '" title="Click to show on page">' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + item.position + '</td>' +
                '<td>' + item.top + '</td>' +
                '<td><code>' + DebugToolbar.describeElement(item.el.parentElement) + '</code></td>' +
                '<td><code>' + DebugToolbar.describeElement(item.stackingParent) + '</code></td>' +
                '<td><button type="button" class="dbg-row-btn" data-copy="' + i + '">Copy</button></td>';
            tr.querySelector('[data-i]').addEventListener('click', function () { highlightOne(item); });
            var copyBtn = tr.querySelector('[data-copy]');
            copyBtn.addEventListener('click', function () {
                DebugToolbar.copyText(itemReportBlock(item));
            });
            tbody.appendChild(tr);
        });

        var copyAllBtn = panel.querySelector('[data-dbg-action="sticky:copy-all"]');
        if (copyAllBtn) copyAllBtn.dataset.report = buildReport(results);

        if (wrap) wrap.scrollLeft = 0;
    }

    function updateHighlightAll(enabled) {
        if (!enabled) { DebugToolbar.clearOverlay('sticky'); return; }
        var boxes = lastResults.map(function (item) {
            return {
                rect: item.el.getBoundingClientRect(),
                label: DebugToolbar.describeElement(item.el) + ' (top:' + item.top + ')'
            };
        });
        DebugToolbar.drawOverlay('sticky', boxes);
    }

    DebugToolbar.onAction('sticky:scan', scan);
    DebugToolbar.onAction('sticky:copy-all', function (btn) {
        DebugToolbar.copyText(btn.dataset.report || buildReport([]));
    });
    DebugToolbar.onAction('sticky:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="sticky:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
