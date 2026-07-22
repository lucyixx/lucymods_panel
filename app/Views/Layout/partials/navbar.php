<?php
/**
 * Navbar (shared component — design-system foundation)
 *
 * Single-tier, floating pill bar: Logo | Home Games | Theme  Profile/Login.
 * Reused unmodified across Home/Games/Details.
 *
 * Mobile and desktop deliberately use different sticky geometry, not a
 * shrunk copy of the same bar:
 * - Mobile: `sticky top-0` (sticks flush at the very top, no scroll gap)
 *   with inset padding (`pt-2 px-3`) on the wrapper so it still *reads*
 *   as a floating capsule rather than a flat edge-to-edge strip.
 * - Desktop: `sticky top-3` (small 12px reveal gap while scrolling),
 *   inner bar widened to `max-w-7xl` (1280px) instead of the page's own
 *   `max-w-5xl` content width, specifically so it doesn't read as a
 *   narrow vertical-sidebar-like strip.
 *
 * Either way the inner bar itself is a fixed `h-16` (64px) — see the
 * geometry note further down for how downstream sticky elements
 * (Details' sidebar) stay clear of it on desktop.
 *
 * All interactive controls here are explicitly sized to at least 44px
 * (`w-11 h-11` / `h-11`) — DaisyUI's own default `.btn-circle` (40px) and
 * `btn-sm` (32px) both fall short of that touch-target minimum.
 *
 * Geometry note for anything else that needs to sit below this and stay
 * clear of it while scrolling on desktop (Details' sticky sidebar): the
 * desktop bar is `top-3` (12px) + `h-16` (64px) = 76px tall from the very
 * top of the viewport. Downstream sticky elements use `top-20` (80px) —
 * the real 76px clearance plus a small 4px breathing gap — see the
 * matching comment in details.php. (Mobile never has a sticky sidebar,
 * so the mobile-only top-0 change here doesn't affect that.)
 *
 * Mobile nav uses DaisyUI's own official responsive pattern — a
 * `dropdown` anchored in `navbar-start` — not a Drawer/Sidebar. Session
 * state comes straight from the existing
 * session()->get('unames')/has('userid') — no controller change, no
 * invented fields. Nav items live in $navLinks below so adding a future
 * item (Dashboard, Licenses, Downloads...) never requires touching the
 * markup, just the array.
 *
 * The account dropdown (navbar-end, logged-in only) is the single home
 * for every dashboard-area page — Dashboard/Keys/Generate/Settings, plus
 * an Admin section gated by the same `$user->level == 1` check the old
 * AppShell sidebar used. Every AppShell-rendered controller already
 * passes $user; on pages that don't (Home/Games/Details), this partial
 * falls back to fetching it itself — but only when a session exists, so
 * anonymous visitors never trigger a lookup. This keeps the Admin
 * section correct regardless of which page an admin is currently on.
 * $navLinks intentionally stays Home/Games only — this keeps the public,
 * always-visible part of the navbar minimal regardless of how many
 * authenticated pages exist.
 *
 * $currentTheme is recomputed here (not reused from Starter.php's local
 * variable) since $this->include() renders this partial through its own
 * separate call — see original note history for why.
 */
$currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame';
$isLoggedIn   = session()->has('userid');
$username     = $isLoggedIn ? (session()->get('unames') ?? 'User') : null;
$initial      = $username ? strtoupper(substr($username, 0, 1)) : 'U';

// Home/Games/Details don't pass $user (they never needed it before). Every
// AppShell-rendered controller already does. Falling back to a lookup here
// only when logged in and it's missing keeps the Admin section correct on
// every page without a query for anonymous visitors, and without adding
// $user to controllers that have no other reason to fetch it.
if ($isLoggedIn && !isset($user)) {
    $user = model('UserModel')->getUser();
}
$isAdmin = isset($user) && is_object($user) && $user->level == 1;
$uri     = strtolower(trim(uri_string(), '/'));

$navLinks = [
    ['label' => 'Home', 'url' => site_url(''), 'active' => uri_string() === ''],
    ['label' => 'Games', 'url' => site_url('games'), 'active' => uri_string() === 'games'],
];

$accountLinks = [
    ['icon' => 'i-diagram', 'label' => 'Dashboard', 'url' => site_url('dashboard'), 'active' => $uri === 'dashboard' || $uri === ''],
    ['icon' => 'i-key', 'label' => 'Keys', 'url' => site_url('keys'), 'active' => str_starts_with($uri, 'keys') && $uri !== 'keys/generate'],
    ['icon' => 'i-plus', 'label' => 'Generate', 'url' => site_url('keys/generate'), 'active' => $uri === 'keys/generate'],
    ['icon' => 'i-gear', 'label' => 'Settings', 'url' => site_url('settings'), 'active' => $uri === 'settings'],
];

$adminLinks = [
    ['icon' => 'i-users', 'label' => 'Manage users', 'url' => site_url('admin/manage-users'), 'active' => str_starts_with($uri, 'admin/manage-users') || str_starts_with($uri, 'admin/user')],
    ['icon' => 'i-server', 'label' => 'Server', 'url' => site_url('Server'), 'active' => str_starts_with($uri, 'server')],
    ['icon' => 'i-upload', 'label' => 'Lib online', 'url' => site_url('libOnline'), 'active' => str_starts_with($uri, 'libonline')],
    ['icon' => 'i-gift', 'label' => 'Referral', 'url' => site_url('admin/create-referral'), 'active' => str_starts_with($uri, 'admin/create-referral') || str_starts_with($uri, 'admin/referral')],
];
?>
<div class="sticky top-0 lg:top-3 z-[var(--z-navbar)] px-3 pt-2 pb-0 lg:px-4 lg:pt-0">
    <div class="max-w-7xl mx-auto navbar h-16 min-h-0 bg-base-200 border border-base-300 shadow-md rounded-xl px-3">
        <div class="navbar-start gap-1">
            <div class="dropdown lg:hidden">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle w-11 h-11" aria-label="Open menu">
                    <svg class="icon" style="width:1.25rem;height:1.25rem"><use href="#i-menu" /></svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-200 border border-base-300 rounded-box z-[var(--z-modal)] mt-3 w-48 max-w-[calc(100vw-1.5rem)] p-2 shadow-sm">
                    <?php foreach ($navLinks as $link) : ?>
                        <li><a class="<?= $link['active'] ? 'active' : '' ?>" href="<?= $link['url'] ?>"><?= esc($link['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a class="flex items-center gap-2 text-lg font-semibold px-2" href="<?= site_url('') ?>">
                <svg class="icon text-primary" style="width:1.4rem;height:1.4rem"><use href="#i-key" /></svg>ZyGames
            </a>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="flex items-center gap-8 text-sm font-medium">
                <?php foreach ($navLinks as $link) : ?>
                    <li><a class="<?= $link['active'] ? 'text-primary' : 'opacity-80 hover:opacity-100 hover:text-primary transition-colors' ?>" href="<?= $link['url'] ?>"><?= esc($link['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="navbar-end gap-1">
            <label class="swap swap-rotate btn btn-ghost btn-circle w-11 h-11" aria-label="Toggle theme">
                <input type="checkbox" id="themeToggle" <?= ($currentTheme === 'zygame-light') ? 'checked' : '' ?> />
                <svg class="icon swap-on"><use href="#i-sun" /></svg>
                <svg class="icon swap-off"><use href="#i-moon" /></svg>
            </label>

            <?php if ($isLoggedIn) : ?>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle w-11 h-11 avatar avatar-placeholder" aria-label="Account menu">
                        <div class="bg-neutral text-neutral-content w-8 rounded-full">
                            <span class="text-xs"><?= esc($initial) ?></span>
                        </div>
                    </div>
                    <ul tabindex="0" class="menu dropdown-content bg-base-200 border border-base-300 rounded-box z-[var(--z-modal)] mt-3 w-64 max-w-[calc(100vw-1.5rem)] max-h-[calc(100vh-6rem)] overflow-y-auto p-2 shadow-sm">
                        <li class="menu-title truncate"><?= esc($username) ?></li>
                        <?php foreach ($accountLinks as $link) : ?>
                            <li><a class="<?= $link['active'] ? 'active' : '' ?>" href="<?= $link['url'] ?>"><svg class="icon"><use href="#<?= $link['icon'] ?>" /></svg><?= esc($link['label']) ?></a></li>
                        <?php endforeach; ?>

                        <?php if ($isAdmin) : ?>
                            <li class="menu-title mt-2">Admin</li>
                            <?php foreach ($adminLinks as $link) : ?>
                                <li><a class="<?= $link['active'] ? 'active' : '' ?>" href="<?= $link['url'] ?>"><svg class="icon"><use href="#<?= $link['icon'] ?>" /></svg><?= esc($link['label']) ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="divider my-1"></div>
                        <li><a href="<?= site_url('logout') ?>" class="text-error"><svg class="icon"><use href="#i-logout" /></svg>Logout</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <a class="btn btn-primary h-11 min-h-11 gap-1 px-3 sm:px-4" href="<?= site_url('login') ?>">
                    <svg class="icon"><use href="#i-user" /></svg><span class="hidden sm:inline">Login</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
