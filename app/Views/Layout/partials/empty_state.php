<?php
/**
 * Empty State (shared component)
 *
 * Deliberately minimal: icon, one line of text, one optional action.
 * No illustration. Currently used on the Games catalog when a
 * search/filter combination matches nothing.
 *
 * Expected vars:
 * @var string      $title       Main message
 * @var string|null $subtitle    Optional supporting line
 * @var string|null $actionLabel Optional button label
 * @var string      $actionId    Optional element id for the action button (for JS binding)
 * @var string      $wrapperId   Optional id on the outer wrapper (so JS can show/hide it)
 * @var bool        $hidden      Whether to render it hidden by default (class="hidden")
 */
?>
<div <?= !empty($wrapperId) ? 'id="' . esc($wrapperId) . '"' : '' ?> class="flex-col items-center text-center py-16 gap-3 <?= !empty($hidden) ? 'hidden' : 'flex' ?>">
    <svg class="icon opacity-30" style="width:2.5rem;height:2.5rem"><use href="#i-inbox" /></svg>
    <p class="text-base font-medium"><?= esc($title) ?></p>
    <?php if (!empty($subtitle)) : ?>
        <p class="text-sm opacity-60"><?= esc($subtitle) ?></p>
    <?php endif; ?>
    <?php if (!empty($actionLabel)) : ?>
        <button type="button" <?= !empty($actionId) ? 'id="' . esc($actionId) . '"' : '' ?> class="btn btn-ghost btn-sm"><?= esc($actionLabel) ?></button>
    <?php endif; ?>
</div>
