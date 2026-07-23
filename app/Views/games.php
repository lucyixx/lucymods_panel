<?php
/**
 * Games — the canonical marketplace catalog.
 *
 * Every browsing interaction (search, filter, sort, pagination) lives
 * here and only here; Home never duplicates this. Search/filter/sort
 * run entirely client-side over the already-rendered list below —
 * there is no search/filter API today, and the catalog is small enough
 * that this is the right amount of engineering, not a shortcut.
 *
 * Categories are derived here, in the view, from each game's ->features
 * text (simple keyword match). Field access goes through $field() rather
 * than -> directly, so this keeps working unchanged the day getSupportedGames()
 * returns DB rows/arrays instead of GameData objects.
 */
$field = function ($source, string $key) {
    if (is_array($source)) {
        return $source[$key] ?? null;
    }
    return $source->$key ?? null;
};

$games = getSupportedGames();

$categoryDefs = [
    'esp'    => 'ESP',
    'aimbot' => 'Aimbot',
    'bullet' => 'Bullet Track',
    'map'    => 'Hack Map',
    'icon'   => 'Icon Info',
];

$gamesWithCategories = array_map(function ($game) use ($categoryDefs, $field) {
    $features = $field($game, 'features') ?? [];
    $haystack = strtolower(implode(' ', $features));
    $cats = [];
    foreach ($categoryDefs as $key => $label) {
        if (str_contains($haystack, $key)) {
            $cats[] = $key;
        }
    }
    return ['game' => $game, 'name' => $field($game, 'name'), 'categories' => $cats];
}, $games);
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<!-- Toolbar: search + filter + sort, one cohesive surface matching the
     card language used everywhere else (Navbar, App Card, Hero CTA). -->
<div class="card card-border bg-base-100 border-base-300 p-3 mb-6">
    <label class="input input-sm sm:input-md flex items-center gap-2 w-full sm:max-w-xs mb-3">
        <svg class="icon opacity-50"><use href="#i-search" /></svg>
        <input id="gameSearch" type="text" class="grow" placeholder="Search games" value="<?= esc($_GET['q'] ?? '', 'attr') ?>">
    </label>

    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
        <div id="gameFilters" class="flex flex-wrap gap-2 flex-1 min-w-0">
            <button type="button" class="btn btn-primary btn-xs sm:btn-sm" data-category="" aria-label="All categories" aria-pressed="true">All</button>
            <?php foreach ($categoryDefs as $key => $label) : ?>
                <button type="button" class="btn btn-outline btn-xs sm:btn-sm" data-category="<?= esc($key, 'attr') ?>" aria-label="<?= esc($label) ?>" aria-pressed="false"><?= esc($label) ?></button>
            <?php endforeach; ?>
        </div>

        <label class="flex items-center gap-2 w-full sm:w-40">
            <svg class="icon opacity-50 shrink-0"><use href="#i-sort" /></svg>
            <select id="gameSort" class="select select-sm sm:select-md w-full">
                <option value="default">Newest</option>
                <option value="name">Name A–Z</option>
            </select>
        </label>
    </div>
</div>

<!-- Catalog -->
<div id="gameGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($gamesWithCategories as $i => $entry) : ?>
        <div class="game-card-wrap<?= $i >= 9 ? ' hidden' : '' ?>"
             data-name="<?= esc(strtolower($entry['name'])) ?>"
             data-categories="<?= esc(implode(' ', $entry['categories'])) ?>"
             data-batch="<?= $i < 9 ? '0' : (int) floor(($i - 9) / 9) + 1 ?>">
            <?= $this->setData(['game' => $entry['game'], 'density' => 'tight'])->include('Layout/partials/app_card') ?>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->setData([
    'wrapperId' => 'gameEmptyState',
    'hidden' => true,
    'title' => 'No games match your filters',
    'subtitle' => 'Try a different search term or clear your filters.',
    'actionLabel' => 'Clear filters',
    'actionId' => 'clearFiltersBtn',
])->include('Layout/partials/empty_state') ?>

<div class="text-center mt-6">
    <button id="loadMoreBtn" type="button" class="btn btn-outline btn-wide">Load more</button>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    (function() {
        const grid = document.getElementById('gameGrid');
        const cards = Array.from(grid.querySelectorAll('.game-card-wrap'));
        const searchInput = document.getElementById('gameSearch');
        const filterEl = document.getElementById('gameFilters');
        const sortSelect = document.getElementById('gameSort');
        const emptyState = document.getElementById('gameEmptyState');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const clearFiltersBtn = document.getElementById('clearFiltersBtn');

        let visibleBatches = 0; // how many extra batches of 9 have been revealed
        const maxBatch = Math.max(...cards.map(c => parseInt(c.dataset.batch, 10)));

        function currentCategory() {
            const active = filterEl.querySelector('button[aria-pressed="true"]');
            return active ? active.dataset.category : '';
        }

        function selectCategory(btn) {
            filterEl.querySelectorAll('button').forEach(b => {
                const selected = b === btn;
                b.setAttribute('aria-pressed', selected ? 'true' : 'false');
                b.classList.toggle('btn-primary', selected);
                b.classList.toggle('btn-outline', !selected);
            });
            applyFilters();
        }

        function applyFilters() {
            const q = searchInput.value.trim().toLowerCase();
            const cat = currentCategory();
            let anyVisible = false;

            cards.forEach(card => {
                const matchesSearch = !q || card.dataset.name.includes(q);
                const matchesCategory = !cat || card.dataset.categories.split(' ').includes(cat);
                const withinBatch = parseInt(card.dataset.batch, 10) <= visibleBatches;
                const show = matchesSearch && matchesCategory && withinBatch;
                card.classList.toggle('hidden', !show);
                if (show) anyVisible = true;
            });

            emptyState.classList.toggle('hidden', anyVisible);
            emptyState.classList.toggle('flex', !anyVisible);

            const moreToLoad = visibleBatches < maxBatch && (!q && !cat);
            loadMoreBtn.classList.toggle('hidden', !moreToLoad);
        }

        function applySort() {
            const mode = sortSelect.value;
            if (mode === 'name') {
                cards.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
            } else {
                cards.sort((a, b) => parseInt(a.dataset.batch, 10) - parseInt(b.dataset.batch, 10));
            }
            cards.forEach(card => grid.appendChild(card));
        }

        searchInput.addEventListener('input', applyFilters);
        filterEl.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-category]');
            if (btn) selectCategory(btn);
        });
        sortSelect.addEventListener('change', () => {
            applySort();
            applyFilters();
        });
        loadMoreBtn.addEventListener('click', () => {
            visibleBatches += 1;
            applyFilters();
        });
        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            selectCategory(filterEl.querySelector('button[data-category=""]'));
        });

        // Initial render — ?q= is still honored if linked to directly
        // (Home's search bar was replaced by the Game Selector and no
        // longer hands off a query here, but the support is harmless to
        // keep for any other entry point).
        applyFilters();
    })();
</script>
<?= $this->endSection() ?>
