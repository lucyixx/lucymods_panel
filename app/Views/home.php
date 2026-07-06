<?php
$games = array_slice(getSupportedGames(), 0, 5);

// Gradient accents cycle per card so the rail doesn't look monotone (see style.css theme vars)
$gradientVars = ['primary', 'accent', 'info', 'success', 'warning'];
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<div class="text-center max-w-lg mx-auto pt-4 pb-8">
    <h2 class="text-lg font-medium mb-1">Mod tools &amp; license keys for your favorite mobile games</h2>
    <p class="text-sm opacity-60">Generate, manage and track your game licenses in one place — fast, reliable, always up to date.</p>
</div>

<p class="text-center text-xs uppercase tracking-widest text-primary font-medium mb-4">Featured this week</p>

<section class="relative rounded-box bg-base-200 border border-base-300 px-6 md:px-10 py-12 md:py-16 mb-10">
    <div class="absolute inset-0 overflow-hidden rounded-box pointer-events-none">
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full opacity-60" style="background: radial-gradient(circle, var(--hero-glow), transparent 70%);"></div>
    </div>
    <div class="relative grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-semibold leading-[1.1] mb-4">Your next license,<br><span class="opacity-45">30 seconds away.</span></h1>
            <p class="opacity-70 max-w-sm mb-6 leading-relaxed">ESP, aimbot and bullet-track for Call of Duty: Mobile, Free Fire and Liên Quân — generate a key and drop it straight into the loader.</p>
            <div class="flex flex-wrap gap-2 mb-2">
                <a href="<?= site_url('keys/free') ?>" class="btn btn-primary">Get a free key</a>
                <a href="#games" class="btn btn-ghost">See supported games</a>
            </div>
        </div>
        <div class="flex flex-col items-center lg:items-end" style="perspective: 1400px;">
            <div class="relative w-full max-w-xs" style="aspect-ratio: 16/10; margin-bottom: 22px; margin-right: 18px;">

                <!-- Silver card -->
                <div id="card-silver" class="absolute inset-0 rounded-2xl p-6 text-white overflow-hidden transition-transform duration-300 ease-out cursor-pointer"
                     data-back-transform="translate(18px, 22px) rotateY(-6deg) rotateX(4deg) rotate(3deg)"
                     data-front-transform="rotateY(-10deg) rotateX(6deg)"
                     style="background: linear-gradient(135deg, #b6bcc4, #6b7280 55%, #40474f); box-shadow: 0 20px 40px -14px rgba(0,0,0,.45); transform: translate(18px, 22px) rotateY(-6deg) rotateX(4deg) rotate(3deg); z-index: 1;">
                    <div class="absolute -right-6 -bottom-8 opacity-15" style="transform: rotate(-12deg);"><svg class="icon" style="width:8rem;height:8rem"><use href="#i-gamepad" /></svg></div>
                    <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(115deg, transparent 0 8px, rgba(255,255,255,.25) 8px 9px);"></div>
                    <div class="relative flex items-center justify-between mb-5">
                        <div class="w-8 h-6 rounded-sm bg-white/25 border border-white/40"></div>
                        <span class="text-[10px] font-semibold uppercase tracking-[0.2em] opacity-80">Silver</span>
                    </div>
                    <p class="relative font-mono text-lg tracking-widest mb-6 opacity-85">XXXX-XXXX-XXXX</p>
                    <div class="relative flex items-center justify-between text-[11px] uppercase tracking-wide opacity-85">
                        <div><p class="opacity-60 mb-0.5">Access</p><p class="font-medium">1 Game</p></div>
                        <div><p class="opacity-60 mb-0.5">Expires</p><p class="font-medium">7 Day</p></div>
                    </div>
                </div>

                <!-- Gold card — default front, interactive tilt -->
                <div id="card-gold" class="absolute inset-0 rounded-2xl p-6 text-white overflow-hidden transition-transform duration-300 ease-out cursor-pointer"
                     data-back-transform="translate(18px, 22px) rotateY(-6deg) rotateX(4deg) rotate(3deg)"
                     data-front-transform="rotateY(-10deg) rotateX(6deg)"
                     style="background: linear-gradient(135deg, #f6dc8e, #d4a628 55%, #93701b); box-shadow: 0 25px 50px -12px rgba(0,0,0,.55); transform: rotateY(-10deg) rotateX(6deg); z-index: 2;">
                    <div class="absolute -right-8 -bottom-10 opacity-15" style="transform: rotate(-12deg);"><svg class="icon" style="width:9rem;height:9rem"><use href="#i-gamepad" /></svg></div>
                    <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(115deg, transparent 0 8px, rgba(255,255,255,.3) 8px 9px);"></div>
                    <div class="absolute inset-0 opacity-30" style="background: linear-gradient(115deg, transparent 40%, white 50%, transparent 60%);"></div>
                    <div class="relative flex items-center justify-between mb-5">
                        <div class="w-8 h-6 rounded-sm bg-white/25 border border-white/40"></div>
                        <span class="text-[10px] font-semibold uppercase tracking-[0.2em] opacity-90">Gold</span>
                    </div>
                    <p class="relative font-mono text-xl md:text-2xl tracking-widest mb-6 opacity-95">XXXX-XXXX-XXXX</p>
                    <div class="relative flex items-center justify-between text-[11px] uppercase tracking-wide opacity-90">
                        <div><p class="opacity-60 mb-0.5">Access</p><p class="font-medium">All Game</p></div>
                        <div><p class="opacity-60 mb-0.5">Expires</p><p class="font-medium">Life Time</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="flex items-center justify-between mb-4" id="games">
    <h2 class="text-sm uppercase tracking-wide opacity-60">Supported games</h2>
    <a href="<?= site_url('games') ?>" class="text-sm link opacity-70 flex items-center gap-1">View more <svg class="icon"><use href="#i-arrow-right" /></svg></a>
</div>
<div class="flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x">
    <?php foreach ($games as $i => $game) : ?>
        <button onclick="openGameModal(<?= $i ?>)" class="snap-start shrink-0 w-44 text-left bg-base-200 border border-base-300 rounded-box p-4 hover:border-primary/50 hover:-translate-y-0.5 transition-all cursor-pointer">
            <div class="rounded-lg w-full h-24 flex items-center justify-center mb-3 overflow-hidden" style="background: linear-gradient(135deg, color-mix(in oklch, var(--color-<?= $gradientVars[$i % count($gradientVars)] ?>) 25%, transparent), var(--color-base-300));">
                <img src="<?= esc($game->image_url) ?>" loading="lazy" alt="<?= esc($game->name) ?>" class="w-12 h-12 rounded-lg object-cover">
            </div>
            <p class="font-medium text-sm truncate"><?= esc($game->name) ?></p>
            <p class="text-xs opacity-60 truncate"><?= esc(implode(', ', $game->features)) ?></p>
        </button>
    <?php endforeach; ?>
</div>

<dialog id="gameModal" class="modal">
    <div class="modal-box">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="gameModal.close()" aria-label="Close"><svg class="icon"><use href="#i-x" /></svg></button>
        <img id="gameModalIcon" src="" alt="" class="rounded-lg w-16 h-16 object-cover mb-4">
        <h3 id="gameModalTitle" class="font-bold text-lg mb-1"></h3>
        <p id="gameModalModes" class="text-sm text-primary mb-3"></p>
        <ul id="gameModalFeatures" class="text-sm opacity-80 list-disc pl-5 mb-5 flex flex-col gap-1"></ul>
        <a id="gameModalLink" href="#" class="btn btn-primary w-full">View details</a>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<div class="divider my-10"></div>

<div class="flex items-center justify-between mb-4">
    <h2 class="text-sm uppercase tracking-wide opacity-60">Latest news</h2>
</div>
<div class="flex flex-col gap-3 mb-10">
    <button onclick="openNewsModal('codm-update')" class="flex items-center gap-4 text-left bg-base-200 border border-base-300 rounded-box p-4 hover:border-primary/50 hover:-translate-y-0.5 transition-all cursor-pointer">
        <div class="rounded-lg w-14 h-14 flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, color-mix(in oklch, var(--color-primary) 25%, transparent), var(--color-base-300));"><svg class="icon opacity-70"><use href="#i-gamepad" /></svg></div>
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 mb-0.5">
                <span class="badge badge-success badge-outline badge-xs">Updated</span>
                <span class="text-xs opacity-50">2 days ago</span>
            </div>
            <p class="text-sm font-medium truncate">Call of Duty: Mobile &mdash; module updated to v1.0.44</p>
            <p class="text-xs opacity-50 truncate">Recompiled ESP overlay, fixed crash on Android 15</p>
        </div>
        <svg class="icon opacity-30 shrink-0"><use href="#i-arrow-right" /></svg>
    </button>
    <button onclick="openNewsModal('aov-new')" class="flex items-center gap-4 text-left bg-base-200 border border-base-300 rounded-box p-4 hover:border-primary/50 hover:-translate-y-0.5 transition-all cursor-pointer">
        <div class="rounded-lg w-14 h-14 flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, color-mix(in oklch, var(--color-success) 25%, transparent), var(--color-base-300));"><svg class="icon opacity-70"><use href="#i-gamepad" /></svg></div>
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 mb-0.5">
                <span class="badge badge-primary badge-outline badge-xs">New</span>
                <span class="text-xs opacity-50">5 days ago</span>
            </div>
            <p class="text-sm font-medium truncate">Arena of Valor &mdash; new hack map module</p>
            <p class="text-xs opacity-50 truncate">Added icon info overlay for jungle &amp; river vision</p>
        </div>
        <svg class="icon opacity-30 shrink-0"><use href="#i-arrow-right" /></svg>
    </button>
    <button onclick="openNewsModal('ff-update')" class="flex items-center gap-4 text-left bg-base-200 border border-base-300 rounded-box p-4 hover:border-primary/50 hover:-translate-y-0.5 transition-all cursor-pointer">
        <div class="rounded-lg w-14 h-14 flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, color-mix(in oklch, var(--color-accent) 25%, transparent), var(--color-base-300));"><svg class="icon opacity-70"><use href="#i-gamepad" /></svg></div>
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 mb-0.5">
                <span class="badge badge-success badge-outline badge-xs">Updated</span>
                <span class="text-xs opacity-50">1 week ago</span>
            </div>
            <p class="text-sm font-medium truncate">Free Fire Max &mdash; module updated to v2.1.9</p>
            <p class="text-xs opacity-50 truncate">Improved bullet-track accuracy, smaller APK size</p>
        </div>
        <svg class="icon opacity-30 shrink-0"><use href="#i-arrow-right" /></svg>
    </button>
</div>

<dialog id="newsModal" class="modal">
    <div class="modal-box">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="newsModal.close()" aria-label="Close"><svg class="icon"><use href="#i-x" /></svg></button>
        <div class="flex items-center gap-2 mb-3">
            <span id="newsModalBadge" class="badge badge-success badge-outline badge-sm">Updated</span>
            <span id="newsModalDate" class="text-xs opacity-50">2 days ago</span>
        </div>
        <h3 id="newsModalTitle" class="font-bold text-lg mb-3"></h3>
        <p id="newsModalBody" class="text-sm opacity-80 leading-relaxed"></p>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<footer class="border-t border-base-300 mt-4">
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div class="lg:col-span-2">
                <a class="flex items-center gap-2 mb-2">
                    <svg class="icon text-primary" style="width:1.2rem;height:1.2rem"><use href="#i-key" /></svg>
                    <span class="font-semibold">ZyGames</span>
                </a>
                <p class="text-sm opacity-60 max-w-sm">Mod tools and license keys for mobile games — built and maintained by Tis Nquyen.</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide opacity-50 mb-3">Product</p>
                <ul class="flex flex-col gap-2 text-sm opacity-80">
                    <li><a class="link link-hover" href="#games">Supported games</a></li>
                    <li><a class="link link-hover" href="<?= site_url('keys/free') ?>">Get a free key</a></li>
                </ul>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide opacity-50 mb-3">Contact</p>
                <ul class="flex flex-col gap-2 text-sm opacity-80">
                    <li><a class="link link-hover" href="https://t.me/tis_nquyen" target="_blank">Telegram user</a></li>
                    <li><a class="link link-hover" href="https://t.me/zygames" target="_blank">Telegram channel</a></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-base-300 pt-6">
            <p class="text-xs opacity-50">&copy; <?= date('Y') ?> ZyGames. All rights reserved.</p>
            <div class="flex items-center gap-1">
                <a href="#" target="_blank" class="btn btn-ghost btn-circle btn-sm" aria-label="Facebook"><svg class="icon"><use href="#i-facebook" /></svg></a>
                <a href="#" target="_blank" class="btn btn-ghost btn-circle btn-sm" aria-label="YouTube"><svg class="icon"><use href="#i-youtube" /></svg></a>
                <a href="https://t.me/zygames" target="_blank" class="btn btn-ghost btn-circle btn-sm" aria-label="Telegram"><svg class="icon"><use href="#i-telegram" /></svg></a>
            </div>
        </div>
    </div>
</footer>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // ---- License card stack: click to bring a card to front ----
    (function() {
        const gold = document.getElementById('card-gold');
        const silver = document.getElementById('card-silver');
        let front = gold;

        function applyBackTransform(card) {
            card.style.transform = card.dataset.backTransform;
        }

        function bringToFront(card) {
            if (card === front) return;
            const other = card === gold ? silver : gold;
            card.style.zIndex = 2;
            other.style.zIndex = 1;
            card.style.transform = card.dataset.frontTransform;
            applyBackTransform(other);
            front = card;
        }

        [gold, silver].forEach(card => {
            card.addEventListener('click', () => bringToFront(card));
            card.addEventListener('mousemove', (e) => {
                if (front !== card) return;
                const r = card.getBoundingClientRect();
                const x = (e.clientX - r.left) / r.width - 0.5;
                const y = (e.clientY - r.top) / r.height - 0.5;
                card.style.transform = `rotateY(${-10 + x * 16}deg) rotateX(${6 - y * 16}deg)`;
            });
            card.addEventListener('mouseleave', () => {
                if (front === card) card.style.transform = card.dataset.frontTransform;
            });
        });
    })();

    // ---- Games modal: populated from the real $games array on the server ----
    const GAMES = <?= json_encode(array_map(function ($g) {
        return [
            'name' => $g->name,
            'image' => $g->image_url,
            'modes' => implode(' + ', $g->modes),
            'features' => $g->features,
            'link' => site_url('details?id=' . $g->id),
        ];
    }, $games)) ?>;

    function openGameModal(i) {
        const g = GAMES[i];
        document.getElementById('gameModalIcon').src = g.image;
        document.getElementById('gameModalTitle').textContent = g.name;
        document.getElementById('gameModalModes').textContent = g.modes;
        document.getElementById('gameModalFeatures').innerHTML = g.features.map(f => `<li>${f}</li>`).join('');
        document.getElementById('gameModalLink').href = g.link;
        gameModal.showModal();
    }

    const NEWS = {
        'codm-update': { badge: 'Updated', badgeClass: 'badge-success', date: '2 days ago', title: 'Call of Duty: Mobile — module updated to v1.0.44', body: 'Recompiled the ESP overlay against the latest client build, fixed a crash affecting some Android 15 devices, and reduced overlay input lag. Existing license keys keep working — just re-download the module.' },
        'aov-new':     { badge: 'New', badgeClass: 'badge-primary', date: '5 days ago', title: 'Arena of Valor — new hack map module', body: 'Added an icon-info overlay covering jungle and river vision, showing enemy cooldowns at a glance. Available now under the Arena of Valor license tier.' },
        'ff-update':   { badge: 'Updated', badgeClass: 'badge-success', date: '1 week ago', title: 'Free Fire Max — module updated to v2.1.9', body: 'Improved bullet-track accuracy at long range and trimmed the APK size by about 8MB. Recommended for everyone on the previous version.' },
    };

    function openNewsModal(id) {
        const n = NEWS[id];
        const badgeEl = document.getElementById('newsModalBadge');
        badgeEl.textContent = n.badge;
        badgeEl.className = 'badge badge-outline badge-sm ' + n.badgeClass;
        document.getElementById('newsModalDate').textContent = n.date;
        document.getElementById('newsModalTitle').textContent = n.title;
        document.getElementById('newsModalBody').textContent = n.body;
        newsModal.showModal();
    }
</script>
<?= $this->endSection() ?>
