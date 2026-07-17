<?php
/**
 * Home — marketplace homepage, Hero-first.
 *
 * Locked hierarchy (per latest direction): Navbar -> Hero -> Featured
 * Applications -> Feature section -> Footer. What's New intentionally
 * removed from Home (may move to Games or its own page later — not now,
 * no route invented for it).
 *
 * Hero shows the first game from getSupportedGames() (no hardcoding).
 * Its artwork/description are NOT available on GameData — only the
 * per-app endpoint (proxy.php, the same one details.php already calls)
 * has featureGraphic/description/summary. Hero renders a Skeleton first,
 * then fills in from one AJAX call to that existing endpoint — same data
 * source, same contract, no backend change. No thumbnail/gallery strip
 * here — that already lives on Details, not duplicated on Home.
 */
$field = function ($source, string $key) {
    if (is_array($source)) {
        return $source[$key] ?? null;
    }
    return $source->$key ?? null;
};

$allGames      = getSupportedGames();
$heroGame      = $allGames[0] ?? null;
$featuredGames = array_slice($allGames, 0, 6);
$gameCount     = count($allGames);
$heroDetailsUrl = $heroGame ? site_url('details?id=' . esc($field($heroGame, 'id'), 'url')) : null;
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<?php if ($heroGame) : ?>
<!-- Hero — cinematic centerpiece, single focal area (no thumbnail strip
     splitting it up). Skeleton first, real artwork after the existing
     proxy.php?id= endpoint resolves (see script below). -->
<section class="mb-8 md:mb-10">
    <div id="heroCard" class="relative rounded-box overflow-hidden bg-base-200" style="aspect-ratio: 16/9;">
        <div id="heroSkeleton" class="skeleton absolute inset-0 rounded-box"></div>
        <img id="heroArtwork" alt="" style="display:none; width:100%; height:100%; object-fit:cover;">
        <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(to top, rgba(0,0,0,.85), rgba(0,0,0,0) 55%);"></div>

        <div class="absolute inset-x-0 bottom-0 p-4 md:p-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div class="flex items-center gap-3 md:gap-4 min-w-0">
                <img src="<?= esc($field($heroGame, 'image_url')) ?>" alt="" loading="lazy"
                     class="w-14 h-14 md:w-20 md:h-20 rounded-2xl object-cover shrink-0 border border-white/20">
                <div class="min-w-0">
                    <h1 class="text-lg md:text-3xl font-semibold text-white truncate"><?= esc($field($heroGame, 'name')) ?></h1>
                    <p id="heroDeveloper" class="text-xs md:text-base text-success"></p>
                    <p id="heroDescription" class="hidden md:block text-sm text-white/70 mt-1 max-w-lg overflow-hidden" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;"></p>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="<?= $heroDetailsUrl ?>" class="btn bg-white/10 text-white border-white/20 hover:bg-white/20 btn-sm md:btn-md">View Details</a>
                <a href="<?= $heroDetailsUrl ?>" class="btn btn-primary btn-sm md:btn-md">Get Access</a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Applications — Home's primary content block -->
<section class="py-6 md:py-8">
    <h2 class="text-lg font-medium mb-4">Featured Applications</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
        <?php foreach ($featuredGames as $game) : ?>
            <?= $this->setData(['game' => $game, 'density' => 'roomier'])->include('Layout/partials/app_card') ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- Feature section — real capabilities only, no filler marketing copy -->
<section class="py-8 md:py-10 text-center">
    <h2 class="text-lg font-medium mb-1">Why ZyGames</h2>
    <p class="text-sm opacity-60 mb-6 md:mb-8">A few things this catalog actually does</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 text-left">
        <div class="card card-border bg-base-100 border-base-300 p-5">
            <svg class="icon text-primary mb-2" style="width:1.5rem;height:1.5rem"><use href="#i-gamepad" /></svg>
            <h3 class="font-medium mb-1"><?= (int) $gameCount ?> games supported</h3>
            <p class="text-sm opacity-60">Browse the full catalog and search by name or feature on the Games page.</p>
        </div>
        <div class="card card-border bg-base-100 border-base-300 p-5">
            <svg class="icon text-primary mb-2" style="width:1.5rem;height:1.5rem"><use href="#i-refresh" /></svg>
            <h3 class="font-medium mb-1">Regularly updated</h3>
            <p class="text-sm opacity-60">Games and mod versions here are kept current as new updates ship.</p>
        </div>
        <div class="card card-border bg-base-100 border-base-300 p-5">
            <svg class="icon text-primary mb-2" style="width:1.5rem;height:1.5rem"><use href="#i-shield" /></svg>
            <h3 class="font-medium mb-1">Straightforward access</h3>
            <p class="text-sm opacity-60">Open any app's Details page to review it, then request access in one place.</p>
        </div>
    </div>
</section>

<?php if ($heroGame) : ?>
<script>
    (function () {
        var heroId = <?= json_encode($field($heroGame, 'id')) ?>;

        function applyArtwork(src) {
            var img = document.getElementById('heroArtwork');
            var skeleton = document.getElementById('heroSkeleton');
            img.onload = function () {
                img.style.display = 'block';
                skeleton.style.display = 'none';
            };
            img.src = src;
        }

        fetch("<?= site_url('proxy.php?id=') ?>" + encodeURIComponent(heroId))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.success) return;
                document.getElementById('heroDeveloper').textContent = data.developer || '';
                document.getElementById('heroDescription').textContent = data.summary || data.description || '';
                if (data.featureGraphic) applyArtwork(data.featureGraphic);
            })
            .catch(function () { /* keep skeleton visible if artwork can't load — never a broken image */ });
    })();
</script>
<?php endif; ?>

<?= $this->endSection() ?>
