<?php
/**
 * App Card (shared component)
 *
 * Pure navigation card: icon, title, subtitle, optional status badge.
 * The entire card is a single link to the app's Details page — no button,
 * no screenshots, no ratings, no install counts. Reused as-is on Home
 * (Featured Applications), Games (catalog), and Details (Related
 * Applications) — only `density` changes between contexts.
 *
 * Data access is normalized (array OR object) and reads only primitive
 * fields (id/name/image_url/features, optional badge) — nothing here
 * depends on the GameData class specifically. Swapping getSupportedGames()
 * for a real "games" table later only means passing rows/arrays with the
 * same field names; this partial does not need to change.
 *
 * Expected vars:
 * @var mixed  $game    Object or associative array with id, name, image_url, features[]
 * @var string $density 'roomier' (Home) or 'tight' (Games / Related). Defaults to 'tight'.
 */
$field = function ($source, string $key) {
    if (is_array($source)) {
        return $source[$key] ?? null;
    }
    return $source->$key ?? null;
};

$id       = $field($game, 'id');
$name     = $field($game, 'name');
$imageUrl = $field($game, 'image_url');
$features = $field($game, 'features') ?? [];
$badge    = $field($game, 'badge'); // {label, tone} — optional, backend-driven, no default values assumed

$density  = $density ?? 'tight';
$roomier  = $density === 'roomier';
$padding  = $roomier ? 'p-4' : 'p-3';
$iconBox  = $roomier ? 'w-14 h-14' : 'w-11 h-11';
$gap      = $roomier ? 'gap-4' : 'gap-3';
?>
<a href="<?= site_url('details?id=' . $id) ?>"
   class="group card card-border bg-base-100 border-base-300 hover:border-primary/50 hover:-translate-y-0.5 transition-all duration-150 flex-row items-center <?= $gap ?> <?= $padding ?>">
    <div class="<?= $iconBox ?> rounded-xl overflow-hidden shrink-0 bg-base-200 ring-1 ring-base-300 group-hover:ring-primary/30 transition-colors">
        <img src="<?= esc($imageUrl) ?>" loading="lazy" alt="" aria-hidden="true" class="w-full h-full object-cover">
    </div>
    <div class="min-w-0 flex-1">
        <div class="flex items-center gap-1.5">
            <p class="font-medium <?= $roomier ? 'text-base' : 'text-sm' ?> truncate text-base-content"><?= esc($name) ?></p>
            <?php if ($badge) : ?>
                <span class="badge badge-<?= esc($badge['tone']) ?> badge-outline badge-xs shrink-0"><?= esc($badge['label']) ?></span>
            <?php endif; ?>
        </div>
        <p class="<?= $roomier ? 'text-sm' : 'text-xs' ?> opacity-55 truncate mt-0.5"><?= esc(implode(' · ', $features)) ?></p>
    </div>
</a>
