<?php
/**
 * Navbar (shared component — design-system foundation)
 *
 * Single-tier, floating pill bar: Logo | Home Games | Theme  Profile/Login.
 * Reused unmodified across Home/Games/Details. This is intentionally the
 * foundation for the rest of the redesign — spacing (px-4 outer / px-3
 * inner), radius (rounded-box), and surface treatment (bg-base-100/90 +
 * backdrop-blur + shadow-sm) here are the values Games/Details should
 * reuse for their own sticky bars and cards, not one-off choices.
 *
 * Geometry note for anything else that needs to sit below this and stay
 * clear of it while scrolling (Games' sticky search, Details' sticky
 * sidebar): this bar is `top-3` (12px) + `h-16` (64px) = 76px tall from
 * the very top of the viewport. Downstream sticky elements use `top-20`
 * (80px) — the real 76px clearance plus a small 4px breathing gap — see
 * the matching comment in games.php / details.php.
 *
 * Mobile nav is a real DaisyUI drawer (see Layout/Starter.php), not a
 * shrunk copy of desktop — full-height, large touch rows, opened via the
 * hamburger label below. Session state comes straight from the existing
 * session()->get('unames')/has('userid') — no controller change, no
 * invented fields.
 *
 * $currentTheme is recomputed here (not reused from Starter.php's local
 * variable) since $this->include() renders this partial through its own
 * separate call — see original note history for why.
 */
$currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame';
$isLoggedIn   = session()->has('userid');
$username     = $isLoggedIn ? (session()->get('unames') ?? 'User') : null;
$initial      = $username ? strtoupper(substr($username, 0, 1)) : 'U';

$navLinks = [
    ['label' => 'Home', 'url' => site_url(''), 'active' => uri_string() === ''],
    ['label' => 'Games', 'url' => site_url('games'), 'active' => uri_string() === 'games'],
];
?>
<div class="sticky top-3 z-[var(--z-navbar)] px-4">
    <div class="max-w-5xl mx-auto navbar h-16 min-h-0 bg-base-100/90 backdrop-blur shadow-sm rounded-box px-3">
        <div class="navbar-start gap-1">
            <label for="app-drawer" class="btn btn-ghost btn-circle lg:hidden" aria-label="Open menu">
                <svg class="icon" style="width:1.25rem;height:1.25rem"><use href="#i-menu" /></svg>
            </label>
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
            <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
                <input type="checkbox" id="themeToggle" <?= ($currentTheme === 'zygame-light') ? 'checked' : '' ?> />
                <svg class="icon swap-on"><use href="#i-sun" /></svg>
                <svg class="icon swap-off"><use href="#i-moon" /></svg>
            </label>

            <?php if ($isLoggedIn) : ?>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar avatar-placeholder" aria-label="Account menu">
                        <div class="bg-neutral text-neutral-content w-8 rounded-full">
                            <span class="text-xs"><?= esc($initial) ?></span>
                        </div>
                    </div>
                    <ul tabindex="0" class="menu dropdown-content bg-base-100 border border-base-300 rounded-box z-[var(--z-modal)] mt-3 w-52 p-2 shadow-sm">
                        <li class="menu-title truncate"><?= esc($username) ?></li>
                        <li><a href="<?= site_url('dashboard') ?>"><svg class="icon"><use href="#i-gear" /></svg>Dashboard</a></li>
                        <li><a href="<?= site_url('logout') ?>" class="text-error"><svg class="icon"><use href="#i-logout" /></svg>Logout</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <a class="btn btn-primary btn-sm gap-1 px-4" href="<?= site_url('login') ?>">
                    <svg class="icon"><use href="#i-user" /></svg>Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
