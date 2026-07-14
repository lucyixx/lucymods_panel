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
        var wrap = panel.querySelector('.dbg-table-wrap');
        var tbody = panel.querySelector('[data-dbg-sticky-table] tbody');

        summary.textContent = results.length === 0
            ? 'No position:sticky elements found.'
            : results.length + ' sticky element(s) found.';

        var allLines = ['Element\tTop\tZ-Index\tScroll container\tParent'];

        tbody.innerHTML = '';
        results.forEach(function (item, i) {
            var scrollContainerText = typeof item.scrollContainer === 'string' ? item.scrollContainer : DebugToolbar.describeElement(item.scrollContainer);
            var parentText = DebugToolbar.describeElement(item.el.parentElement);
            var line = DebugToolbar.describeElement(item.el) + '\t' + item.top + '\t' + item.zIndex + '\t' + scrollContainerText + '\t' + parentText;
            allLines.push(line);

            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td><code>' + DebugToolbar.describeElement(item.el) + '</code></td>' +
                '<td>' + item.top + '</td>' +
                '<td>' + item.zIndex + '</td>' +
                '<td><code>' + scrollContainerText + '</code></td>' +
                '<td><code>' + parentText + '</code></td>' +
                '<td><button type="button" class="dbg-row-btn" data-i="' + i + '">Show</button> ' +
                '<button type="button" class="dbg-row-btn" data-copy="' + i + '">Copy</button></td>';
            tr.querySelector('[data-i]').addEventListener('click', function () {
                item.el.scrollIntoView({ block: 'center', behavior: 'smooth' });
                DebugToolbar.drawOverlay('sticky', [{
                    rect: item.el.getBoundingClientRect(),
                    label: DebugToolbar.describeElement(item.el) + ' (top:' + item.top + ', z:' + item.zIndex + ')'
                }]);
                var box = panel.querySelector('[data-dbg-action="sticky:highlight"]');
                if (box) box.checked = true;
            });
            var copyBtn = tr.querySelector('[data-copy]');
            copyBtn.addEventListener('click', function () {
                DebugToolbar.copyText(line, function () { DebugToolbar.flashCopied(copyBtn); });
            });
            tbody.appendChild(tr);
        });

        var copyAllBtn = panel.querySelector('[data-dbg-action="sticky:copy-all"]');
        if (copyAllBtn) copyAllBtn.dataset.lines = allLines.join('\n');

        if (wrap) wrap.scrollLeft = 0;
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
    DebugToolbar.onAction('sticky:copy-all', function (btn) {
        DebugToolbar.copyText(btn.dataset.lines || '(nothing scanned yet)', function () { DebugToolbar.flashCopied(btn); });
    });
    DebugToolbar.onAction('sticky:highlight', function (el) {
        updateHighlightAll(el.checked);
    });
    DebugToolbar.onOverlayRedraw(function () {
        var checkbox = document.querySelector('[data-dbg-action="sticky:highlight"]');
        if (checkbox && checkbox.checked) updateHighlightAll(true);
    });
})();
