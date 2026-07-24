<?php
/**
 * Navbar (shared component — design-system foundation)
 *
 * Single-tier, floating pill bar: 3-line menu (public nav) + Logo | Theme
 * + Account dropdown/Login. Reused unmodified across every page that
 * extends Layout/Starter. No Drawer/Sidebar anywhere.
 *
 * Two dropdowns, two different jobs — kept deliberately separate rather
 * than merged into one giant menu:
 * - The 3-line menu (navbar-start) is public navigation: Home, Games.
 *   Visible to everyone, on every viewport, logged in or not.
 * - The avatar dropdown (navbar-end) is the user's own account surface:
 *   Dashboard/Keys/Generate/Settings, an Admin group for level 1, then
 *   Logout. It only exists when logged in, and Login replaces it when
 *   guest.
 * This mirrors how the routes themselves are split (public routes vs.
 * authenticated routes) instead of flattening everything into one list.
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
 * Both dropdowns use DaisyUI's native `dropdown` (a `tabindex`-focusable
 * trigger + `dropdown-content`) — no JS, no Bootstrap data-bs-* anything.
 * That gives keyboard users Tab-to-focus/Enter-or-Space-to-open and
 * Escape/click-outside-to-close for free from the browser + daisyUI CSS,
 * matching the account dropdown that already existed here before.
 *
 * Session state comes straight from the existing
 * session()->get('unames')/has('userid') — no controller change, no
 * invented fields.
 *
 * Admin visibility depends on $user->level, and $user is only passed in
 * by User/Keys/LibOnline controllers (Home/Games do not pass it) — same
 * pre-existing constraint the old AppShell drawer had. Guard every admin
 * check with isset($user) so Home/Games simply render without the Admin
 * group rather than notice-erroring; fixing that would mean touching
 * controllers, which is out of scope here.
 *
 * $currentTheme is recomputed here (not reused from Starter.php's local
 * variable) since $this->include() renders this partial through its own
 * separate call — see original note history for why.
 */
$currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame';
$isLoggedIn   = session()->has('userid');
$username     = $isLoggedIn ? (session()->get('unames') ?? 'User') : null;
$initial      = $username ? strtoupper(substr($username, 0, 1)) : 'U';
$isAdmin      = isset($user) && $user->level == 1;

// Public nav — lives in the 3-line menu, same on every page regardless
// of auth state.
$navLinks = [
    ['label' => 'Home', 'url' => site_url(''), 'active' => uri_string() === ''],
    ['label' => 'Games', 'url' => site_url('games'), 'active' => uri_string() === 'games'],
];

// Authenticated nav — lives inside the Account dropdown. Keys vs
// Generate is checked most-specific-first (see $active below) so a
// Generate page never also lights up the Keys item.
$menuItems = [
    ['icon' => 'i-server', 'label' => 'Dashboard', 'url' => 'dashboard', 'key' => 'dashboard'],
    ['icon' => 'i-key', 'label' => 'Keys', 'url' => 'keys', 'key' => 'keys'],
    ['icon' => 'i-gear', 'label' => 'Settings', 'url' => 'settings', 'key' => 'settings'],
];

// Admin-only nav — also inside the Account dropdown, below a divider.
// Matches app/Config/Routes.php exactly (Server has no admin/ prefix,
// Lib Online lives under the top-level libOnline group).
$adminItems = [
    ['icon' => 'i-users', 'label' => 'Manage Users', 'url' => 'admin/manage-users', 'key' => 'admin_users'],
    ['icon' => 'i-server', 'label' => 'Server', 'url' => 'Server', 'key' => 'admin_server'],
    ['icon' => 'i-upload', 'label' => 'Lib Online', 'url' => 'libOnline', 'key' => 'admin_lib'],
    ['icon' => 'i-scan', 'label' => 'Referral', 'url' => 'admin/create-referral', 'key' => 'admin_referral'],
];

// Canonical active key, resolved once against the real request URI.
$active = '';
$uri = strtolower(trim(uri_string(), '/'));
if ($isLoggedIn) {
    if ($uri === 'dashboard') {
        $active = 'dashboard';
    } elseif (str_starts_with($uri, 'keys')) {
        $active = 'keys';
    } elseif (str_starts_with($uri, 'settings')) {
        $active = 'settings';
    }
}
if ($isAdmin) {
    if (str_starts_with($uri, 'admin/manage-users') || str_starts_with($uri, 'admin/user')) {
        $active = 'admin_users';
    } elseif (str_starts_with($uri, 'server')) {
        $active = 'admin_server';
    } elseif (str_starts_with($uri, 'libonline')) {
        $active = 'admin_lib';
    } elseif (str_starts_with($uri, 'admin/create-referral') || str_starts_with($uri, 'admin/referral')) {
        $active = 'admin_referral';
    }
}
?>
<div class="sticky top-0 lg:top-3 z-[var(--z-navbar)] px-3 pt-2 pb-0 lg:px-4 lg:pt-0">
    <div class="max-w-7xl mx-auto navbar h-16 min-h-0 bg-base-200 border border-base-300 shadow-md rounded-xl px-3">
        <div class="navbar-start gap-1">
            <!-- Public nav: 3-line menu, same on every viewport (not just mobile) -->
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle w-11 h-11" aria-label="Open menu">
                    <svg class="icon" style="width:1.25rem;height:1.25rem"><use href="#i-menu" /></svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-200 border border-base-300 rounded-box z-[var(--z-modal)] mt-3 w-48 p-2 shadow-sm">
                    <?php foreach ($navLinks as $link) : ?>
                        <li><a class="<?= $link['active'] ? 'active' : '' ?>" href="<?= $link['url'] ?>"><?= esc($link['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a class="flex items-center gap-2 text-lg font-semibold px-2" href="<?= site_url('') ?>">
                <svg class="icon text-primary" style="width:1.4rem;height:1.4rem"><use href="#i-key" /></svg>ZyGames
            </a>
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
                    <ul tabindex="0" class="menu dropdown-content bg-base-200 border border-base-300 rounded-box z-[var(--z-modal)] mt-3 w-56 p-2 shadow-sm">
                        <li class="menu-title truncate"><?= esc($username) ?></li>
                        <?php foreach ($menuItems as $item) : ?>
                            <li><a class="<?= $active === $item['key'] ? 'active' : '' ?>" href="<?= site_url($item['url']) ?>"><svg class="icon"><use href="#<?= $item['icon'] ?>" /></svg><?= esc($item['label']) ?></a></li>
                        <?php endforeach; ?>

                        <?php if ($isAdmin) : ?>
                            <li class="menu-title mt-2">Admin</li>
                            <?php foreach ($adminItems as $item) : ?>
                                <li><a class="<?= $active === $item['key'] ? 'active' : '' ?>" href="<?= site_url($item['url']) ?>"><svg class="icon"><use href="#<?= $item['icon'] ?>" /></svg><?= esc($item['label']) ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>

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
