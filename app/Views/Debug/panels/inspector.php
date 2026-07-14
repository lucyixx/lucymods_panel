<div class="dbg-panel-header">
    <h3>Inspector</h3>
    <button type="button" class="dbg-btn dbg-btn--accent" data-dbg-action="inspector:pick">Pick element</button>
</div>
<p class="dbg-muted" data-dbg-inspector-hint>Click "Pick element", then click anything on the page. Press Esc to cancel.</p>
<div data-dbg-inspector-output hidden>
    <h4 class="dbg-section-title">Selector</h4>
    <code class="dbg-code" data-dbg-inspector-selector></code>

    <h4 class="dbg-section-title">Box</h4>
    <div class="dbg-kv-grid" data-dbg-inspector-rect></div>

    <h4 class="dbg-section-title">Computed style</h4>
    <div class="dbg-kv-grid" data-dbg-inspector-style></div>

    <h4 class="dbg-section-title">Parent</h4>
    <code class="dbg-code" data-dbg-inspector-parent></code>

    <h4 class="dbg-section-title">Children (<span data-dbg-inspector-children-count>0</span>)</h4>
    <ul class="dbg-list" data-dbg-inspector-children></ul>
</div>
