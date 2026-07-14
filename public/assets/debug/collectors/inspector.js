/**
 * Inspector collector.
 * Click "Pick element", hover highlights candidates, click selects one.
 * The actual pick-click is fully intercepted (capture phase, preventDefault
 * + stopPropagation) so inspecting a real <a>/<button> on the page never
 * triggers its normal behavior (navigation, form submit, etc).
 */
(function () {
    'use strict';
    if (!window.DebugToolbar) return;

    var picking = false;

    var STYLE_KEYS = [
        'display', 'position', 'top', 'right', 'bottom', 'left', 'zIndex',
        'width', 'height', 'boxSizing', 'overflow', 'overflowX', 'overflowY',
        'flexDirection', 'flexWrap', 'flexGrow', 'flexShrink', 'flexBasis', 'alignItems', 'justifyContent',
        'gridTemplateColumns', 'gridTemplateRows', 'gridColumn', 'gridRow',
        'transform', 'aspectRatio', 'margin', 'padding', 'border',
    ];

    function kvRow(key, val) {
        return '<span class="dbg-kv-key">' + key + '</span><span class="dbg-kv-val">' + val + '</span>';
    }

    function renderChildren(el) {
        if (!el.children.length) return '<li class="dbg-muted">(no element children)</li>';
        return Array.prototype.map.call(el.children, function (child) {
            return '<li><code>' + DebugToolbar.describeElement(child) + '</code></li>';
        }).join('');
    }

    function select(el) {
        var panel = DebugToolbar.panel('inspector');
        var output = panel.querySelector('[data-dbg-inspector-output]');
        var cs = getComputedStyle(el);
        var rect = el.getBoundingClientRect();

        output.hidden = false;
        panel.querySelector('[data-dbg-inspector-selector]').textContent = DebugToolbar.describeElement(el);

        panel.querySelector('[data-dbg-inspector-rect]').innerHTML = [
            kvRow('top', Math.round(rect.top) + 'px'),
            kvRow('left', Math.round(rect.left) + 'px'),
            kvRow('width', Math.round(rect.width) + 'px'),
            kvRow('height', Math.round(rect.height) + 'px'),
        ].join('');

        panel.querySelector('[data-dbg-inspector-style]').innerHTML = STYLE_KEYS.map(function (key) {
            var val = cs[key];
            return val && val !== 'none' && val !== 'normal' && val !== 'auto' && val !== '0px'
                ? kvRow(key, val)
                : '';
        }).join('');

        panel.querySelector('[data-dbg-inspector-parent]').textContent =
            el.parentElement ? DebugToolbar.describeElement(el.parentElement) : '(none)';

        panel.querySelector('[data-dbg-inspector-children]').innerHTML = renderChildren(el);
        panel.querySelector('[data-dbg-inspector-children-count]').textContent = el.children.length;

        DebugToolbar.drawOverlay('inspector', [{
            rect: rect,
            label: DebugToolbar.describeElement(el)
        }]);
    }

    function onHover(e) {
        if (!picking) return;
        var el = e.target;
        if (el.closest('#dbg-toolbar') || el.closest('#dbg-overlay-layer')) return;
        DebugToolbar.drawOverlay('inspector', [{ rect: el.getBoundingClientRect(), label: DebugToolbar.describeElement(el) }]);
    }

    function onPickClick(e) {
        if (!picking) return;
        var el = e.target;
        if (el.closest('#dbg-toolbar')) return; // let toolbar's own UI work normally
        e.preventDefault();
        e.stopPropagation();
        stopPicking();
        select(el);
    }

    function onKeydown(e) {
        if (picking && e.key === 'Escape') stopPicking();
    }

    function startPicking() {
        picking = true;
        document.body.style.cursor = 'crosshair';
        DebugToolbar.panel('inspector').querySelector('[data-dbg-inspector-hint]').textContent =
            'Click anything on the page to inspect it (Esc to cancel)...';
        document.addEventListener('mouseover', onHover, true);
        document.addEventListener('click', onPickClick, true);
        document.addEventListener('keydown', onKeydown, true);
    }

    function stopPicking() {
        picking = false;
        document.body.style.cursor = '';
        DebugToolbar.panel('inspector').querySelector('[data-dbg-inspector-hint]').textContent =
            'Click "Pick element", then click anything on the page. Press Esc to cancel.';
        document.removeEventListener('mouseover', onHover, true);
        document.removeEventListener('click', onPickClick, true);
        document.removeEventListener('keydown', onKeydown, true);
    }

    DebugToolbar.onAction('inspector:pick', function () {
        if (picking) { stopPicking(); return; }
        startPicking();
    });
})();
