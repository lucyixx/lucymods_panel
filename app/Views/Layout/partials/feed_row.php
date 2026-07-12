<?php
/**
 * Feed Row (shared component)
 *
 * Used for both "What's New" and "Company Announcements" — same shape,
 * the only difference is $variant, which lightens typography/opacity for
 * announcements to reflect their lower priority. No card, no border.
 *
 * Expected vars:
 * @var string $icon    Icon sprite id, e.g. 'i-gamepad'
 * @var string $title   Main line
 * @var string $meta    Optional secondary line
 * @var string $date    Optional right-aligned timestamp text
 * @var string $variant 'update' (default) or 'announcement'
 */
$variant = $variant ?? 'update';
$isAnnouncement = $variant === 'announcement';
?>
<div class="flex items-center gap-3 py-2 <?= $isAnnouncement ? 'opacity-70' : '' ?>">
    <svg class="icon opacity-60 shrink-0"><use href="#<?= esc($icon ?? 'i-news') ?>" /></svg>
    <div class="min-w-0 flex-1">
        <p class="text-sm truncate <?= $isAnnouncement ? '' : 'font-medium' ?>"><?= esc($title) ?></p>
        <?php if (!empty($meta)) : ?>
            <p class="text-xs opacity-50 truncate"><?= esc($meta) ?></p>
        <?php endif; ?>
    </div>
    <?php if (!empty($date)) : ?>
        <span class="text-xs opacity-40 shrink-0 whitespace-nowrap"><?= esc($date) ?></span>
    <?php endif; ?>
</div>
