<?php
/**
 * Feed Row (shared component)
 *
 * Used by "What's New". Deliberately lighter than App Card — small icon,
 * one line of title, a timestamp. No subtitle/description line: that's
 * what kept it feeling like a second App Card. This sits between a plain
 * text row and a full card, on purpose.
 *
 * Expected vars:
 * @var string      $icon  Icon sprite id, e.g. 'i-gamepad'
 * @var string      $title Headline (single line)
 * @var string|null $date  Optional right-aligned timestamp text
 * @var string|null $href  If set, the whole row becomes a link
 */
$tag = !empty($href) ? 'a' : 'div';
?>
<<?= $tag ?> <?= !empty($href) ? 'href="' . esc($href) . '"' : '' ?>
   class="flex items-center gap-2.5 px-2.5 py-1.5 card card-border bg-base-100 border-base-300 hover:border-primary/40 transition-colors">
    <svg class="icon opacity-60 shrink-0" style="width:0.85rem;height:0.85rem"><use href="#<?= esc($icon ?? 'i-news') ?>" /></svg>
    <p class="text-sm truncate flex-1 min-w-0"><?= esc($title) ?></p>
    <?php if (!empty($date)) : ?>
        <span class="text-xs opacity-40 shrink-0 whitespace-nowrap"><?= esc($date) ?></span>
    <?php endif; ?>
</<?= $tag ?>>
