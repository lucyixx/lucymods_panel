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
 * Expected vars:
 * @var GameData $game     Object with ->id, ->name, ->image_url, ->features
 * @var string    $density 'roomier' (Home) or 'tight' (Games / Related). Defaults to 'tight'.
 */
$density = $density ?? 'tight';
$padding = $density === 'roomier' ? 'p-4' : 'p-3';
$iconSize = $density === 'roomier' ? 'w-12 h-12' : 'w-10 h-10';

// Status badge is backend-driven ({label, tone}) and entirely optional —
// the component never assumes New/Updated/Outdated are the only possible
// values. Nothing in the current data source sets this yet, so cards
// simply render without a badge until that's wired up.
$badge = isset($game->badge) && !empty($game->badge['label']) ? $game->badge : null;
?>
<a href="<?= site_url('details?id=' . $game->id) ?>"
   class="card card-border bg-base-100 border-base-300 hover:border-primary/50 transition-colors flex-row items-center gap-3 <?= $padding ?>">
    <img src="<?= esc($game->image_url) ?>" loading="lazy" alt="" aria-hidden="true"
         class="<?= $iconSize ?> rounded-lg object-cover shrink-0">
    <div class="min-w-0 flex-1">
        <div class="flex items-center gap-1.5">
            <p class="font-medium text-sm truncate"><?= esc($game->name) ?></p>
            <?php if ($badge) : ?>
                <span class="badge badge-<?= esc($badge['tone']) ?> badge-outline badge-xs shrink-0"><?= esc($badge['label']) ?></span>
            <?php endif; ?>
        </div>
        <p class="text-xs opacity-60 truncate"><?= esc(implode(', ', $game->features)) ?></p>
    </div>
</a>
