<?php
/**
 * Home — discovery-only marketplace landing page.
 *
 * Locked hierarchy: Navbar → Hero (search) → What's New → Featured
 * Applications → Footer. No purchase CTA anywhere on this page — every
 * card here is pure navigation to Details, which is the only place
 * "Get Access" is shown.
 *
 * What's New is intentionally shaped like a future DB row (a game_id
 * reference + headline/meta/date) rather than a self-contained icon/text
 * blob — swapping this array for a real "select * from updates" query
 * later needs no template change, just the same field names.
 *
 * NOTE (tracked open item, not solved here): Featured Applications should
 * eventually come from a configurable backend selection rather than the
 * first N records — getSupportedGames() has no such flag yet.
 */
$allGames  = getSupportedGames();
$gamesById = [];
foreach ($allGames as $g) {
    $gamesById[$g->id] = $g;
}

$featuredGames = array_slice($allGames, 0, 6);

$whatsNew = [
    ['game_id' => 'com.activision.callofduty.shooter', 'icon' => 'i-gamepad', 'headline' => 'Call of Duty: Mobile — updated to v1.0.44', 'meta' => 'Recompiled ESP overlay, fixed a crash on Android 15', 'date' => '2 days ago'],
    ['game_id' => 'com.ngame.allstar.eu', 'icon' => 'i-star', 'headline' => 'Arena of Valor — new hack map module', 'meta' => 'Jungle & river vision overlay added', 'date' => '5 days ago'],
    ['game_id' => 'com.dts.freefiremax', 'icon' => 'i-refresh', 'headline' => 'Free Fire Max — updated to v2.1.9', 'meta' => 'Better long-range tracking, smaller APK', 'date' => '1 week ago'],
];
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<!-- Hero — identity + search only. No marketing copy, no pricing, no decoration. -->
<section class="max-w-2xl mx-auto text-center px-4 py-14 md:py-20">
    <h1 class="text-2xl md:text-3xl font-semibold mb-2">Find your game's mod tools</h1>
    <p class="text-sm opacity-60 mb-6">Search the full catalog of supported games</p>
    <form action="<?= site_url('games') ?>" method="get">
        <label class="input input-lg flex items-center gap-2 w-full">
            <svg class="icon opacity-50"><use href="#i-search" /></svg>
            <input type="text" name="q" class="grow" placeholder="Search games…" aria-label="Search games">
        </label>
    </form>
</section>

<!-- What's New — compact clickable cards, denser than Featured, no feature-list subtitle -->
<section class="py-8 md:py-10">
    <h2 class="text-lg font-medium mb-3 flex items-center gap-2">
        <svg class="icon opacity-60"><use href="#i-news" /></svg>What's New
    </h2>
    <div class="flex flex-col gap-2">
        <?php foreach ($whatsNew as $item) :
            $game = $gamesById[$item['game_id']] ?? null;
            if (!$game) continue; // data drift guard — never render a dead link
        ?>
            <?= $this->setData([
                'href' => site_url('details?id=' . $game->id),
                'icon' => $item['icon'],
                'title' => $item['headline'],
                'meta' => $item['meta'],
                'date' => $item['date'],
            ])->include('Layout/partials/feed_row') ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- Featured Applications — this is Home's most prominent block -->
<section class="py-8 md:py-10">
    <h2 class="text-lg font-medium mb-4">Featured Applications</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        <?php foreach ($featuredGames as $game) : ?>
            <?= $this->setData(['game' => $game, 'density' => 'roomier'])->include('Layout/partials/app_card') ?>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection() ?>
