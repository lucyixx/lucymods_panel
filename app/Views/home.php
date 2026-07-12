<?php
/**
 * Home — discovery-only marketplace landing page.
 *
 * Locked hierarchy: Navbar → Hero (search) → What's New → Featured
 * Applications → Company Announcements → Footer. No purchase CTA
 * anywhere on this page — every App Card here is pure navigation to
 * Details, which is the only place "Get Access" is shown.
 *
 * NOTE (tracked open item, not solved here): Featured Applications should
 * eventually come from a configurable backend selection rather than the
 * first N records. getSupportedGames() has no such flag yet, so this
 * still slices the first few — a backend/data decision outside this
 * frontend-only redesign.
 */
$featuredGames = array_slice(getSupportedGames(), 0, 6);

// What's New — merged product updates only (new support, version bumps,
// maintenance). Company Announcements below is intentionally separate
// and lower priority (company voice vs. product voice). Both are static
// content today; there's no backend feed for either yet.
$whatsNew = [
    ['icon' => 'i-gamepad', 'title' => 'Call of Duty: Mobile — updated to v1.0.44', 'meta' => 'Recompiled ESP overlay, fixed a crash on Android 15', 'date' => '2 days ago'],
    ['icon' => 'i-star', 'title' => 'Arena of Valor — new hack map module', 'meta' => 'Jungle & river vision overlay added', 'date' => '5 days ago'],
    ['icon' => 'i-refresh', 'title' => 'Free Fire Max — updated to v2.1.9', 'meta' => 'Better long-range tracking, smaller APK', 'date' => '1 week ago'],
];

$announcements = [
    ['icon' => 'i-news', 'title' => 'Scheduled maintenance completed', 'meta' => 'All servers back to normal operation', 'date' => '3 days ago'],
    ['icon' => 'i-users', 'title' => 'New Telegram support channel opened', 'meta' => 'Faster response times for common questions', 'date' => '1 week ago'],
];
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<!-- Hero — identity + search only. No marketing copy, no pricing, no decoration. -->
<section class="max-w-2xl mx-auto text-center px-4 py-14 md:py-20">
    <h1 class="text-2xl md:text-3xl font-semibold mb-2">Find your game's mod tools</h1>
    <p class="text-sm opacity-60 mb-6">Search the full catalog of supported games</p>
    <form action="<?= site_url('games') ?>" method="get">
        <label class="input input-lg input-bordered flex items-center gap-2 w-full">
            <svg class="icon opacity-50"><use href="#i-search" /></svg>
            <input type="text" name="q" class="grow" placeholder="Search games…" aria-label="Search games">
        </label>
    </form>
</section>

<!-- What's New -->
<section class="py-8 md:py-10">
    <h2 class="text-lg font-medium mb-3 flex items-center gap-2">
        <svg class="icon opacity-60"><use href="#i-news" /></svg>What's New
    </h2>
    <div class="flex flex-col divide-y divide-base-300">
        <?php foreach ($whatsNew as $item) : ?>
            <?= $this->setData($item)->include('Layout/partials/feed_row') ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- Featured Applications -->
<section class="py-8 md:py-10">
    <h2 class="text-lg font-medium mb-4">Featured Applications</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        <?php foreach ($featuredGames as $game) : ?>
            <?= $this->setData(['game' => $game, 'density' => 'roomier'])->include('Layout/partials/app_card') ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- Company Announcements — lowest priority -->
<section class="py-8 md:py-10">
    <h2 class="text-lg font-medium mb-3 opacity-80">Company Announcements</h2>
    <div class="flex flex-col divide-y divide-base-300">
        <?php foreach ($announcements as $item) : ?>
            <?= $this->setData(array_merge($item, ['variant' => 'announcement']))->include('Layout/partials/feed_row') ?>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection() ?>
