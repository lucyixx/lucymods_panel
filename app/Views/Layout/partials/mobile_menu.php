<?php
/**
 * Mobile navigation drawer content.
 *
 * Deliberately NOT a shrunk copy of the desktop navbar — full-height
 * panel, large tappable rows (min-h-12, text-base) so it's comfortable
 * to use one-handed. Same session-aware Profile/Login logic as the
 * navbar itself (session()->get('unames') — no controller change).
 */
$isLoggedIn = session()->has('userid');
$username   = $isLoggedIn ? (session()->get('unames') ?? 'User') : null;

$navLinks = [
    ['label' => 'Home', 'icon' => 'i-key', 'url' => site_url(''), 'active' => uri_string() === ''],
    ['label' => 'Games', 'icon' => 'i-gamepad', 'url' => site_url('games'), 'active' => uri_string() === 'games'],
];
?>
<div class="min-h-full w-72 bg-base-100 p-4 flex flex-col gap-1">
    <div class="flex items-center gap-2 px-2 py-3 mb-2">
        <svg class="icon text-primary" style="width:1.4rem;height:1.4rem"><use href="#i-key" /></svg>
        <span class="text-lg font-semibold">ZyGames</span>
    </div>

    <ul class="menu w-full p-0 gap-1">
        <?php foreach ($navLinks as $link) : ?>
            <li>
                <a class="min-h-12 text-base <?= $link['active'] ? 'active' : '' ?>" href="<?= $link['url'] ?>">
                    <svg class="icon"><use href="#<?= esc($link['icon']) ?>" /></svg>
                    <?= esc($link['label']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="grow"></div>

    <div class="border-t border-base-300 pt-3">
        <?php if ($isLoggedIn) : ?>
            <p class="px-2 pb-2 text-sm opacity-60 truncate">Signed in as <span class="text-base-content font-medium"><?= esc($username) ?></span></p>
            <ul class="menu w-full p-0 gap-1">
                <li><a class="min-h-12 text-base" href="<?= site_url('dashboard') ?>"><svg class="icon"><use href="#i-gear" /></svg>Dashboard</a></li>
                <li><a class="min-h-12 text-base text-error" href="<?= site_url('logout') ?>"><svg class="icon"><use href="#i-logout" /></svg>Logout</a></li>
            </ul>
        <?php else : ?>
            <a class="btn btn-primary btn-block gap-2" href="<?= site_url('login') ?>">
                <svg class="icon"><use href="#i-user" /></svg>Login
            </a>
        <?php endif; ?>
    </div>
</div>
