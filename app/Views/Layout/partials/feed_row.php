<?php
/**
 * Feed Row (shared component)
 *
 * Used by "What's New". Denser and simpler than App Card on purpose —
 * icon, headline, one meta line, a timestamp — so this never reads as a
 * second Featured Applications section.
 *
 * Expected vars:
 * @var string      $icon     Icon sprite id, e.g. 'i-gamepad'
 * @var string      $title    Headline
 * @var string|null $meta     Optional secondary line
 * @var string|null $date     Optional right-aligned timestamp text
 * @var string|null $href     If set, the whole row becomes a link
 */
?>
<?php $tag = !empty($href) ? 'a' : 'div'; ?>
<<?= $tag ?> <?= !empty($href) ? 'href="' . esc($href) . '"' : '' ?>
   class="flex items-center gap-3 px-3 py-2.5 card card-border bg-base-100 border-base-300 hover:border-primary/40 transition-colors">
    <svg class="icon opacity-60 shrink-0"><use href="#<?= esc($icon ?? 'i-news') ?>" /></svg>
    <div class="min-w-0 flex-1">
        <p class="text-sm font-medium truncate"><?= esc($title) ?></p>
        <?php if (!empty($meta)) : ?>
            <p class="text-xs opacity-55 truncate mt-0.5"><?= esc($meta) ?></p>
        <?php endif; ?>
    </div>
    <?php if (!empty($date)) : ?>
        <span class="text-xs opacity-40 shrink-0 whitespace-nowrap"><?= esc($date) ?></span>
    <?php endif; ?>
</<?= $tag ?>>
