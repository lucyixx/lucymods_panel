/**
 * Layout collector.
 * Viewport/document size, safe-area insets, scrollbar presence, current
 * breakpoint (matches this project's own Tailwind screens), orientation.
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    // Keep in sync with this project's actual Tailwind breakpoints.
    var BREAKPOINTS = [
        { name: 'sm', min: 640 },
        { name: 'md', min: 768 },
        { name: 'lg', min: 1024 },
        { name: 'xl', min: 1280 },
        { name: '2xl', min: 1536 },
    ];

    function currentBreakpoint(width) {
        var match = 'default (<640px)';
        BREAKPOINTS.forEach(function (bp) {
            if (width >= bp.min) match = bp.name + ' (>=' + bp.min + 'px)';
        });
        return match;
    }

    function safeAreaInset(side) {
        var probe = document.createElement('div');
        probe.style.position = 'fixed';
        probe.style.top = '0';
        probe.style.left = '0';
        probe.style.height = '0';
        probe.style.paddingTop = 'env(safe-area-inset-' + side + ', 0px)';
        probe.style.visibility = 'hidden';
        document.body.appendChild(probe);
        var value = getComputedStyle(probe).paddingTop;
        probe.remove();
        return value;
    }

    function kv(pairs) {
        return pairs.map(function (p) {
            return '<tr><th>' + p[0] + '</th><td>' + p[1] + '</td></tr>';
        }).join('');
    }

    function collect() {
        var vw = window.innerWidth;
        var vh = window.innerHeight;
        var doc = document.documentElement;
        var hasVScroll = doc.scrollHeight > doc.clientHeight;
        var hasHScroll = doc.scrollWidth > doc.clientWidth;

        var pairs = [
            ['Viewport', vw + ' x ' + vh + 'px'],
            ['Document size', doc.scrollWidth + ' x ' + doc.scrollHeight + 'px'],
            ['Breakpoint', currentBreakpoint(vw)],
            ['Orientation', screen.orientation ? screen.orientation.type : (vw > vh ? 'landscape' : 'portrait')],
            ['Vertical scrollbar', hasVScroll ? 'yes (' + (doc.scrollHeight - doc.clientHeight) + 'px overflow)' : 'no'],
            ['Horizontal scrollbar', hasHScroll ? '<span style="color:#ff5252">yes (' + (doc.scrollWidth - doc.clientWidth) + 'px overflow)</span>' : 'no'],
            ['Scrollbar width', (window.innerWidth - doc.clientWidth) + 'px'],
            ['Safe-area top/bottom', safeAreaInset('top') + ' / ' + safeAreaInset('bottom')],
            ['Device pixel ratio', window.devicePixelRatio],
        ];

        var panel = DebugToolbar.panel('layout');
        panel.querySelector('[data-dbg-layout-output]').innerHTML = kv(pairs);

        var copyAllBtn = panel.querySelector('[data-dbg-action="layout:copy-all"]');
        if (copyAllBtn) {
            var lines = ['=== Layout ==='].concat(pairs.map(function (p) {
                return p[0] + ': ' + p[1].replace(/<[^>]+>/g, '');
            }));
            copyAllBtn.dataset.report = lines.join('\n');
        }
    }

    DebugToolbar.onAction('layout:refresh', collect);
    DebugToolbar.onAction('layout:copy-all', function (btn) {
        DebugToolbar.copyText(btn.dataset.report || '=== Layout ===\nNot measured yet.');
    });

    // Auto-refresh whenever the panel becomes visible or the viewport changes,
    // so the numbers are never stale by the time someone looks at them.
    window.addEventListener('resize', function () {
        if (!DebugToolbar.panel('layout').hidden) collect();
    });
    document.getElementById('dbg-toolbar').addEventListener('click', function (e) {
        if (e.target.closest('[data-dbg-tab="layout"]')) collect();
    });
})();
