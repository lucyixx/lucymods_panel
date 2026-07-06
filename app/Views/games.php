<?php $games = getSupportedGames(); ?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-2">
    <h1 class="text-xl font-medium">Supported games</h1>
    <a href="<?= site_url('') ?>" class="text-sm link opacity-70">&larr; Back to home</a>
</div>
<p class="text-sm opacity-60 mb-6">All games with an active mod module. Tap any game to see full details.</p>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($games as $game) : ?>
        <a href="<?= site_url('details?id=' . $game->id) ?>" class="bg-base-200 border border-base-300 rounded-box p-4 flex items-center gap-3 hover:border-primary/50 hover:-translate-y-0.5 transition-all">
            <img src="<?= esc($game->image_url) ?>" loading="lazy" alt="<?= esc($game->name) ?>" class="w-14 h-14 rounded-lg object-cover shrink-0">
            <div class="min-w-0">
                <p class="font-medium text-sm truncate"><?= esc($game->name) ?></p>
                <p class="text-xs opacity-60 truncate"><?= esc(implode(' + ', $game->modes)) ?></p>
                <p class="text-xs opacity-60 truncate"><?= esc(implode(', ', $game->features)) ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
