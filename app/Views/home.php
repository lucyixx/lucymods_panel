<?php
/**
 * Home — marketplace homepage, Hero-first.
 *
 * Hero shows the first game from getSupportedGames() (no hardcoding).
 * Its artwork/description/screenshots are NOT available on GameData —
 * only the per-app endpoint (proxy.php, the same one details.php already
 * calls) has featureGraphic/images/description. So Hero renders a
 * Skeleton first, then fills in from one AJAX call to that existing
 * endpoint — same data source, same contract, no backend change.
 *
 * Featured Applications / What's New reuse the same partials as before
 * (app_card.php, feed_row.php) — only spacing/density tuned here.
 */
$field = function ($source, string $key) {
    if (is_array($source)) {
        return $source[$key] ?? null;
    }
    return $source->$key ?? null;
};

$allGames  = getSupportedGames();
$gamesById = [];
foreach ($allGames as $g) {
    $gamesById[$field($g, 'id')] = $g;
}

$heroGame      = $allGames[0] ?? null;
$featuredGames = array_slice($allGames, 0, 6);
$gameCount     = count($allGames);

$whatsNew = [
    ['game_id' => 'com.activision.callofduty.shooter', 'icon' => 'i-gamepad', 'headline' => 'Call of Duty: Mobile — updated to v1.0.44', 'date' => '2 days ago'],
    ['game_id' => 'com.ngame.allstar.eu', 'icon' => 'i-star', 'headline' => 'Arena of Valor — new hack map module', 'date' => '5 days ago'],
    ['game_id' => 'com.dts.freefiremax', 'icon' => 'i-refresh', 'headline' => 'Free Fire Max — updated to v2.1.9', 'date' => '1 week ago'],
];
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<?php if ($heroGame) : ?>
<!-- Hero — cinematic centerpiece. Skeleton first, real artwork after the
     existing proxy.php?id= endpoint resolves (see script below). -->
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
                <a href="<?= site_url('details?id=' . esc($field($heroGame, 'id'), 'url')) ?>" class="btn btn-primary btn-sm md:btn-md">View Details</a>
                <a href="<?= site_url('games') ?>" class="btn btn-sm md:btn-md bg-white/10 text-white border-white/20 hover:bg-white/20">Browse Games</a>
            </div>
        </div>
    </div>

    <!-- Thumbnail carousel -->
    <div class="relative mt-3">
        <div id="heroThumbs" class="carousel carousel-center gap-2" style="height:4.5rem; overflow-y:hidden;">
            <?php for ($i = 0; $i < 5; $i++) : ?>
                <div class="carousel-item skeleton shrink-0" style="width:6rem; height:4.5rem; border-radius:var(--radius-box);"></div>
            <?php endfor; ?>
        </div>
        <button type="button" id="heroThumbPrev" class="btn btn-circle btn-sm bg-base-100/80 absolute left-1 top-1/2 -translate-y-1/2" aria-label="Previous screenshot" style="display:none">
            <svg class="icon"><use href="#i-chev-l" /></svg>
        </button>
        <button type="button" id="heroThumbNext" class="btn btn-circle btn-sm bg-base-100/80 absolute right-1 top-1/2 -translate-y-1/2" aria-label="Next screenshot" style="display:none">
            <svg class="icon"><use href="#i-chev-r" /></svg>
        </button>
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

<!-- What's New -->
<section class="py-6 md:py-8">
    <h2 class="text-lg font-medium mb-2.5 flex items-center gap-2">
        <svg class="icon opacity-60"><use href="#i-news" /></svg>What's New
    </h2>
    <div class="flex flex-col gap-1.5">
        <?php foreach ($whatsNew as $item) :
            $game = $gamesById[$item['game_id']] ?? null;
            if (!$game) continue;
        ?>
            <?= $this->setData([
                'href' => site_url('details?id=' . esc($field($game, 'id'), 'url')),
                'icon' => $item['icon'],
                'title' => $item['headline'],
                'date' => $item['date'],
            ])->include('Layout/partials/feed_row') ?>
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
            <p class="text-sm opacity-60">New game support and version updates are posted in What's New above.</p>
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
        var thumbSources = [];
        var activeThumb = 0;

        function setActiveThumb(i) {
            var items = document.querySelectorAll('#heroThumbs .carousel-item');
            items.forEach(function (el, idx) {
                el.style.outline = idx === i ? '2px solid var(--color-primary)' : 'none';
                el.style.outlineOffset = '-2px';
            });
            activeThumb = i;
        }

        function applyArtwork(src) {
            var img = document.getElementById('heroArtwork');
            var skeleton = document.getElementById('heroSkeleton');
            img.onload = function () {
                img.style.display = 'block';
                skeleton.style.display = 'none';
            };
            img.src = src;
        }

        function renderThumbs(images) {
            var wrap = document.getElementById('heroThumbs');
            wrap.innerHTML = '';
            thumbSources = images;
            images.forEach(function (src, i) {
                var item = document.createElement('div');
                item.className = 'carousel-item shrink-0';
                item.style.cssText = 'width:6rem;height:4.5rem;overflow:hidden;border-radius:var(--radius-box);cursor:pointer;';
                var img = document.createElement('img');
                img.loading = 'lazy';
                img.alt = '';
                img.src = src;
                img.style.cssText = 'display:block;width:100%;height:100%;object-fit:cover;';
                item.appendChild(img);
                item.addEventListener('click', function () {
                    applyArtwork(src);
                    setActiveThumb(i);
                });
                wrap.appendChild(item);
            });
            if (images.length) {
                applyArtwork(images[0]);
                setActiveThumb(0);
                document.getElementById('heroThumbPrev').style.display = '';
                document.getElementById('heroThumbNext').style.display = '';
            }
        }

        document.getElementById('heroThumbPrev').addEventListener('click', function () {
            document.getElementById('heroThumbs').scrollBy({ left: -100, behavior: 'smooth' });
        });
        document.getElementById('heroThumbNext').addEventListener('click', function () {
            document.getElementById('heroThumbs').scrollBy({ left: 100, behavior: 'smooth' });
        });

        fetch("<?= site_url('proxy.php?id=') ?>" + encodeURIComponent(heroId))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.success) return;
                document.getElementById('heroDeveloper').textContent = data.developer || '';
                var desc = document.getElementById('heroDescription');
                desc.textContent = data.summary || data.description || '';
                if (data.featureGraphic) applyArtwork(data.featureGraphic);
                if (Array.isArray(data.images) && data.images.length) renderThumbs(data.images);
                else document.getElementById('heroThumbs').innerHTML = '';
            })
            .catch(function () { /* keep skeleton visible if artwork can't load — never a broken image */ });
    })();
</script>
<?php endif; ?>

<?= $this->endSection() ?>
