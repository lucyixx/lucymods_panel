/**
 * Sticky collector.
 * Finds every position:sticky element on the page and reports the data
 * needed to actually debug a sticky bug: its own top offset and z-index,
 * which ancestor is its scrolling container, and which ancestor
 * establishes the stacking context it paints within.
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
                return node;
            }
            node = node.parentElement;
        }
        return 'viewport (document)';
    }

    function scan() {
        var results = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer')) return;
            var cs = getComputedStyle(el);
            if (cs.position === 'sticky') {
                results.push({
                    el: el,
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

    function render(results) {
        var panel = DebugToolbar.panel('sticky');
        var summary = panel.querySelector('[data-dbg-sticky-summary]');
        var tbody = panel.querySelector('[data-dbg-sticky-table] tbody');

        summary.textContent = results.length === 0
            ? 'No position:sticky elements found.'
            : results.length + ' sticky element(s) found.';

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code>' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + item.top + '</td>' +
                '<td>' + item.zIndex + '</td>' +
                '<td><code>' + (typeof item.scrollContainer === 'string' ? item.scrollContainer : DebugToolbar.describeElement(item.scrollContainer)) + '</code></td>' +
                '<td><code>' + DebugToolbar.describeElement(item.el.parentElement) + '</code></td>' +
                '<td><button type="button" class="dbg-row-btn" data-i="' + i + '">Show</button></td>';
            tr.querySelector('button').addEventListener('click', function () {
                item.el.scrollIntoView({ block: 'center', behavior: 'smooth' });
                DebugToolbar.drawOverlay('sticky', [{
                    rect: item.el.getBoundingClientRect(),
                    label: DebugToolbar.describeElement(item.el) + ' (top:' + item.top + ', z:' + item.zIndex + ')'
                }]);
                var box = panel.querySelector('[data-dbg-action="sticky:highlight"]');
                if (box) box.checked = true;
            });
            tbody.appendChild(tr);
        });
    }

    function updateHighlightAll(enabled) {
        if (!enabled) { DebugToolbar.clearOverlay('sticky'); return; }
        var boxes = lastResults.map(function (item) {
            return {
                rect: item.el.getBoundingClientRect(),
                label: DebugToolbar.describeElement(item.el) + ' (top:' + item.top + ', z:' + item.zIndex + ')'
            };
        });
        DebugToolbar.drawOverlay('sticky', boxes);
    }

    DebugToolbar.onAction('sticky:scan', scan);
    DebugToolbar.onAction('sticky:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="sticky:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
