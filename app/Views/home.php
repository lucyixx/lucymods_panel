<?php
/**
 * Home — showcase-style homepage.
 *
 * Hierarchy: Navbar -> Hero (shows whichever game is selected) -> Game
 * Selector (all games, horizontal) -> Feature section -> Footer.
 *
 * Hero starts on the first game from getSupportedGames() (no hardcoding).
 * Selecting another game in the strip below re-fetches that game's
 * artwork/developer/description from the existing proxy.php?id= endpoint
 * (same one details.php already uses) and swaps Hero's content in place —
 * no page reload, no new route.
 *
 * Version Status: getSupportedGames()/GameData has no "supported version"
 * field today (verified — only name/image_url/id/modes/features exist),
 * so there is nothing real to compare against the proxy's latest version
 * yet. Per explicit decision, the badge always reads "Unknown" for now,
 * but the three-state logic (Unknown / Up-to-date / Outdated) is written
 * for real so that once a local version field exists, only the
 * comparison input changes — not this markup or the JS around it.
 *
 * Deliberately NOT introducing a normalize_game()/service layer yet
 * (explicit decision) — getSupportedGames() is still the only data
 * source, so that abstraction has nothing real to abstract over yet.
 */
$field = function ($source, string $key) {
    if (is_array($source)) {
        return $source[$key] ?? null;
    }
    return $source->$key ?? null;
};

$allGames  = getSupportedGames();
$heroGame  = $allGames[0] ?? null;
$gameCount = count($allGames);
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<?php if ($heroGame) : ?>
<!-- Hero — shows whichever game is currently selected below. No gallery,
     no auto-rotate: it only ever reflects the current selection. -->
<section class="mb-6 md:mb-8">
    <div id="heroCard" class="relative rounded-box overflow-hidden bg-base-200" style="aspect-ratio: 16/9;">
        <div id="heroSkeleton" class="skeleton absolute inset-0 rounded-box"></div>
        <img id="heroArtwork" alt="" style="display:none; width:100%; height:100%; object-fit:cover;">
        <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(to top, rgba(0,0,0,.85), rgba(0,0,0,0) 55%);"></div>

        <div class="absolute inset-x-0 bottom-0 p-4 md:p-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div class="flex items-center gap-3 md:gap-4 min-w-0">
                <img id="heroIcon" src="<?= esc($field($heroGame, 'image_url')) ?>" alt="" loading="lazy"
                     class="w-14 h-14 md:w-20 md:h-20 rounded-2xl object-cover shrink-0 border border-white/20">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 min-w-0">
                        <h1 id="heroName" class="text-lg md:text-3xl font-semibold text-white truncate min-w-0"><?= esc($field($heroGame, 'name')) ?></h1>
                        <span id="heroVersionBadge" class="badge badge-neutral badge-sm shrink-0">Unknown</span>
                    </div>

                    <div class="mt-1.5 h-4 md:h-6 flex items-center">
                        <div id="heroDeveloperSkeleton" class="skeleton h-3 w-24 md:h-3.5 md:w-32 rounded"></div>
                        <p id="heroDeveloper" class="text-xs md:text-base text-success" style="display:none"></p>
                    </div>

                    <div class="hidden md:block mt-1.5 max-w-lg" style="height: 2.6em;">
                        <div id="heroDescriptionSkeleton" class="flex flex-col gap-1.5 pt-0.5">
                            <div class="skeleton h-3 w-full rounded"></div>
                            <div class="skeleton h-3 w-2/3 rounded"></div>
                        </div>
                        <p id="heroDescription" class="text-sm text-white/70 overflow-hidden" style="display:none; -webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;"></p>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 w-full md:w-auto shrink-0">
                <a id="heroViewDetails" href="<?= site_url('details?id=' . esc($field($heroGame, 'id'), 'url')) ?>" class="btn bg-white/10 text-white border-white/20 hover:bg-white/20 btn-sm md:btn-md flex-1 md:flex-none">View Details</a>
                <a id="heroGetAccess" href="<?= site_url('details?id=' . esc($field($heroGame, 'id'), 'url')) ?>" class="btn btn-primary btn-sm md:btn-md flex-1 md:flex-none shadow-lg shadow-primary/40 ring-1 ring-primary/50 hover:shadow-primary/60 hover:-translate-y-0.5 transition-all font-semibold">Get Access</a>
            </div>
        </div>
    </div>
</section>

<!-- Game Selector — switches which game Hero shows. No card, no page
     reload: icon + name only, horizontally scrollable. -->
<section class="mb-8 md:mb-10">
    <div id="gameSelector" class="flex items-center gap-2 overflow-x-auto pb-1">
        <?php foreach ($allGames as $game) : ?>
            <button type="button"
                    class="game-selector-item btn btn-ghost h-auto min-h-0 py-2 px-3 flex-col gap-1.5 shrink-0 <?= $field($game, 'id') === $field($heroGame, 'id') ? 'btn-active' : '' ?>"
                    data-id="<?= esc($field($game, 'id'), 'attr') ?>"
                    data-name="<?= esc($field($game, 'name'), 'attr') ?>"
                    data-icon="<?= esc($field($game, 'image_url'), 'attr') ?>"
                    data-details-url="<?= site_url('details?id=' . esc($field($game, 'id'), 'url')) ?>">
                <img src="<?= esc($field($game, 'image_url')) ?>" alt="" loading="lazy" class="w-10 h-10 rounded-xl object-cover">
                <span class="text-xs font-medium max-w-16 truncate"><?= esc($field($game, 'name')) ?></span>
            </button>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<div class="divider opacity-20 my-0"></div>

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
        var proxyBase = "<?= site_url('proxy.php?id=') ?>";

        // Version status: three real states. Only "Unknown" is reachable
        // today because no local "supported version" field exists yet —
        // see the PHP comment at the top of this file. Once one does,
        // pass it as localVersion here and the other two states light up
        // with no markup/JS changes needed.
        function computeVersionStatus(localVersion, proxyVersion) {
            if (!localVersion) return { label: 'Unknown', tone: 'neutral' };
            if (localVersion === proxyVersion) return { label: 'Up-to-date', tone: 'success' };
            return { label: 'Outdated', tone: 'warning' };
        }

        function applyVersionBadge(localVersion, proxyVersion) {
            var status = computeVersionStatus(localVersion, proxyVersion);
            var badge = document.getElementById('heroVersionBadge');
            badge.textContent = status.label;
            badge.className = 'badge badge-' + status.tone + ' badge-sm shrink-0';
        }

        function applyArtwork(src) {
            var img = document.getElementById('heroArtwork');
            var skeleton = document.getElementById('heroSkeleton');
            img.style.display = 'none';
            skeleton.style.display = '';
            img.onload = function () {
                img.style.display = 'block';
                skeleton.style.display = 'none';
            };
            img.src = src;
        }

        function setDeveloper(text) {
            var skeleton = document.getElementById('heroDeveloperSkeleton');
            var el = document.getElementById('heroDeveloper');
            if (text) {
                el.textContent = text;
                el.style.display = '';
                skeleton.style.display = 'none';
            } else {
                el.style.display = 'none';
                skeleton.style.display = '';
            }
        }

        function setDescription(text) {
            var skeleton = document.getElementById('heroDescriptionSkeleton');
            var el = document.getElementById('heroDescription');
            if (text) {
                el.textContent = text;
                el.style.display = '-webkit-box';
                skeleton.style.display = 'none';
            } else {
                el.style.display = 'none';
                skeleton.style.display = '';
            }
        }

        function selectGame(btn) {
            var id = btn.dataset.id;
            var name = btn.dataset.name;
            var icon = btn.dataset.icon;
            var detailsUrl = btn.dataset.detailsUrl;

            document.querySelectorAll('.game-selector-item').forEach(function (el) {
                el.classList.toggle('btn-active', el === btn);
            });

            // Known instantly (already in the page), update without waiting.
            document.getElementById('heroName').textContent = name;
            document.getElementById('heroIcon').src = icon;
            document.getElementById('heroViewDetails').href = detailsUrl;
            document.getElementById('heroGetAccess').href = detailsUrl;
            setDeveloper(null);
            setDescription(null);
            applyVersionBadge(null, null);
            applyArtwork(''); // reset to skeleton while the new artwork loads

            fetch(proxyBase + encodeURIComponent(id))
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (!data || !data.success) return;
                    setDeveloper(data.developer || '');
                    setDescription(data.summary || data.description || '');
                    if (data.featureGraphic) applyArtwork(data.featureGraphic);
                    applyVersionBadge(null, data.versionName || null);
                })
                .catch(function () { /* keep skeleton visible if artwork can't load — never a broken image */ });
        }

        document.querySelectorAll('.game-selector-item').forEach(function (btn) {
            btn.addEventListener('click', function () { selectGame(btn); });
        });

        // Initial load — same fetch, for the game already shown server-side.
        selectGame(document.querySelector('.game-selector-item.btn-active') || document.querySelector('.game-selector-item'));
    })();
</script>
<?php endif; ?>

<?= $this->endSection() ?>
