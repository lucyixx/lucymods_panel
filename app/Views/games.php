<?php
/**
 * Games — the canonical marketplace catalog.
 *
 * Search and sort run entirely client-side over the already-rendered
 * list below — there is no search API today, and the catalog is small
 * enough that this is the right amount of engineering, not a shortcut.
 *
 * Field access goes through $field() rather than -> directly, so this
 * keeps working unchanged the day getSupportedGames() returns DB
 * rows/arrays instead of GameData objects.
 */
$field = function ($source, string $key) {
    if (is_array($source)) {
        return $source[$key] ?? null;
    }
    return $source->$key ?? null;
};

$games = getSupportedGames();

/**
 * Sort dropdown config: value => label. Values are stable keys used by
 * the client-side comparator map below; they are independent from the
 * label text so either can change without touching the other.
 *
 * Only 'alpha' has a working comparator today (see js section) — the
 * others need a date field the data source doesn't provide yet. They
 * stay in the list because the dropdown itself is final; wiring up
 * their comparator is a JS-only change once that field exists.
 */
$sortOptions = [
    'newest' => 'Newest → Oldest',
    'oldest' => 'Oldest → Newest',
    'alpha'  => 'Alphabetical (A–Z)',
    'month'  => 'By Month',
];
$defaultSort = 'newest';
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<!-- Toolbar: search + sort, one cohesive surface matching the card
     language used everywhere else (Navbar, App Card, Hero CTA). -->
<div class="card card-border bg-base-100 border-base-300 p-3 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
        <label class="input input-sm sm:input-md flex items-center gap-2 w-full sm:max-w-xs">
            <svg class="icon opacity-50"><use href="#i-search" /></svg>
            <input id="gameSearch" type="text" class="grow" placeholder="Search games" value="<?= esc($_GET['q'] ?? '', 'attr') ?>">
        </label>

        <label class="flex items-center gap-2 w-full sm:w-48 sm:ml-auto">
            <svg class="icon opacity-50 shrink-0"><use href="#i-sort" /></svg>
            <select id="gameSort" class="select select-sm sm:select-md w-full">
                <?php foreach ($sortOptions as $value => $label) : ?>
                    <option value="<?= esc($value, 'attr') ?>"<?= $value === $defaultSort ? ' selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
</div>

<!-- Catalog -->
<div id="gameGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($games as $i => $game) : ?>
        <div class="game-card-wrap<?= $i >= 9 ? ' hidden' : '' ?>"
             data-name="<?= esc(strtolower($field($game, 'name') ?? '')) ?>"
             data-batch="<?= $i < 9 ? '0' : (int) floor(($i - 9) / 9) + 1 ?>">
            <?= $this->setData(['game' => $game, 'density' => 'tight'])->include('Layout/partials/app_card') ?>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->setData([
    'wrapperId' => 'gameEmptyState',
    'hidden' => true,
    'title' => 'No games match your search',
    'subtitle' => 'Try a different search term.',
    'actionLabel' => 'Clear search',
    'actionId' => 'clearSearchBtn',
])->include('Layout/partials/empty_state') ?>

<div class="text-center mt-6">
    <button id="loadMoreBtn" type="button" class="btn btn-outline btn-wide">Load more</button>
</div>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<?= $this->include('Layout/partials/footer') ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    (function() {
        const grid = document.getElementById('gameGrid');
        const cards = Array.from(grid.querySelectorAll('.game-card-wrap'));
        const searchInput = document.getElementById('gameSearch');
        const sortSelect = document.getElementById('gameSort');
        const emptyState = document.getElementById('gameEmptyState');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const clearSearchBtn = document.getElementById('clearSearchBtn');

        let visibleBatches = 0; // extra batches of 9 revealed beyond the first
        const maxBatch = Math.max(...cards.map(c => parseInt(c.dataset.batch, 10)));

        // One comparator per sort mode. A mode with no entry here needs a
        // data field (e.g. a date) the source doesn't provide yet —
        // selecting it intentionally leaves the current order untouched.
        // Add the missing comparator once that field becomes available;
        // no other code here needs to change.
        const sortComparators = {
            alpha: (a, b) => a.dataset.name.localeCompare(b.dataset.name),
        };

        function applyFilters() {
            const q = searchInput.value.trim().toLowerCase();
            let anyVisible = false;

            cards.forEach(card => {
                const matchesSearch = !q || card.dataset.name.includes(q);
                const withinBatch = parseInt(card.dataset.batch, 10) <= visibleBatches;
                const show = matchesSearch && withinBatch;
                card.classList.toggle('hidden', !show);
                if (show) anyVisible = true;
            });

            emptyState.classList.toggle('hidden', anyVisible);
            emptyState.classList.toggle('flex', !anyVisible);

            const moreToLoad = visibleBatches < maxBatch && !q;
            loadMoreBtn.classList.toggle('hidden', !moreToLoad);
        }

        function applySort() {
            const comparator = sortComparators[sortSelect.value];
            if (!comparator) return; // no data for this mode yet — keep current order
            cards.sort(comparator);
            cards.forEach(card => grid.appendChild(card));
        }

        searchInput.addEventListener('input', applyFilters);
        sortSelect.addEventListener('change', () => {
            applySort();
            applyFilters();
        });
        loadMoreBtn.addEventListener('click', () => {
            visibleBatches += 1;
            applyFilters();
        });
        clearSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            applyFilters();
        });

        // Initial render — ?q= is still honored if linked to directly.
        applyFilters();
    })();
</script>
<?= $this->endSection() ?>
