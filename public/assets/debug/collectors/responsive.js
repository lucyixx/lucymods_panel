/**
 * Responsive collector.
 * Breakpoint + the numbers that actually cause sticky/overlap bugs:
 * navbar height, every sticky element's offset, safe-area, zoom, DPR.
 *
 * Navbar height is detected generically (topmost position:sticky/fixed
 * element whose top is ~0), not hardcoded to this project's own
 * Layout/partials/navbar.php markup, so this keeps working on any layout
 * (Starter, BootstrapLayout, or a future one) without modification.
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    var BREAKPOINTS = [
        { name: 'sm', min: 640 }, { name: 'md', min: 768 },
        { name: 'lg', min: 1024 }, { name: 'xl', min: 1280 }, { name: '2xl', min: 1536 },
    ];

    function currentBreakpoint(width) {
        var match = 'default (<640px)';
        BREAKPOINTS.forEach(function (bp) {
            if (width >= bp.min) match = bp.name + ' (>=' + bp.min + 'px)';
        });
        return match;
    }

    function detectNavbar() {
        var best = null;
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar')) return;
            var cs = getComputedStyle(el);
            if ((cs.position === 'sticky' || cs.position === 'fixed') && parseFloat(cs.top || '0') <= 4) {
                var r = el.getBoundingClientRect();
                if (r.top <= 4 && r.width > window.innerWidth * 0.5) {
                    if (!best || r.height < best.rect.height) best = { el: el, rect: r }; // prefer the tightest matching bar, not a full-page wrapper
                }
            }
        });
        return best;
    }

    function findAllSticky() {
        var list = [];
        document.querySelectorAll('*').forEach(function (el) {
            if (el.closest('#dbg-toolbar')) return;
            var cs = getComputedStyle(el);
            if (cs.position === 'sticky') {
                list.push(DebugToolbar.describeElement(el) + ' -> top:' + cs.top + ', z:' + cs.zIndex);
            }
        });
        return list;
    }

    function kv(pairs) {
        return pairs.map(function (p) {
            return '<span class="dbg-kv-key">' + p[0] + '</span><span class="dbg-kv-val">' + p[1] + '</span>';
        }).join('');
    }

    function collect() {
        var vw = window.innerWidth;
        var navbar = detectNavbar();
        var stickyList = findAllSticky();
        var zoomApprox = window.outerWidth ? (window.outerWidth / window.innerWidth).toFixed(2) : 'n/a';

        var pairs = [
            ['Breakpoint', currentBreakpoint(vw)],
            ['Navbar (detected)', navbar ? DebugToolbar.describeElement(navbar.el) : 'not found'],
            ['Navbar height', navbar ? Math.round(navbar.rect.height) + 'px' : 'n/a'],
            ['Sticky elements', stickyList.length ? stickyList.join('<br>') : 'none'],
            ['Device pixel ratio', window.devicePixelRatio],
            ['Zoom (approx, outerWidth/innerWidth)', zoomApprox],
        ];

        var panel = DebugToolbar.panel('responsive');
        panel.querySelector('[data-dbg-responsive-output]').innerHTML = kv(pairs);

        var copyAllBtn = panel.querySelector('[data-dbg-action="responsive:copy-all"]');
        if (copyAllBtn) {
            copyAllBtn.dataset.lines = pairs.map(function (p) {
                return p[0] + '\t' + p[1].replace(/<br>/g, ' | ').replace(/<[^>]+>/g, '');
            }).join('\n');
        }
    }

    DebugToolbar.onAction('responsive:refresh', collect);
    DebugToolbar.onAction('responsive:copy-all', function (btn) {
        DebugToolbar.copyText(btn.dataset.lines || '(not measured yet)', function () { DebugToolbar.flashCopied(btn); });
    });
    window.addEventListener('resize', function () {
        if (!DebugToolbar.panel('responsive').hidden) collect();
    });
    document.getElementById('dbg-toolbar').addEventListener('click', function (e) {
        if (e.target.closest('[data-dbg-tab="responsive"]')) collect();
    });
})();
