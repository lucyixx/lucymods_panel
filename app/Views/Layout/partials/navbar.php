<?php
/**
 * Navbar (shared component)
 *
 * Identical on every page: Logo | Home | Games ... Theme | Login.
 * No search, no filters, no license status, no page-specific controls —
 * locked from the very first planning pass. Session-aware branching
 * (Key Free / Dashboard) that used to live here has been removed.
 *
 * $currentTheme is recomputed here rather than reused from Starter.php's
 * local variable: $this->include() renders this partial through its own
 * separate call, so a plain PHP variable from the parent file's top isn't
 * guaranteed to be in scope — recomputing the (cheap) cookie check here
 * keeps this partial correct on its own.
 */
$currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame';
?>
<div class="bg-base-100/90 backdrop-blur border-b border-base-300 px-4 sticky top-0 z-[var(--z-navbar)]">
    <div class="max-w-5xl mx-auto w-full navbar p-0 min-h-14 py-1">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden" aria-label="Toggle navigation">
                    <svg class="icon" style="width:1.25rem;height:1.25rem"><use href="#i-menu" /></svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 border border-base-300 rounded-box z-[var(--z-modal)] mt-3 w-48 p-2 shadow-sm">
                    <li><a href="<?= site_url('') ?>">Home</a></li>
                    <li><a href="<?= site_url('games') ?>">Games</a></li>
                </ul>
            </div>
            <a class="flex items-center gap-2 text-xl font-semibold px-2" href="<?= site_url('') ?>">
                <svg class="icon text-primary" style="width:1.4rem;height:1.4rem"><use href="#i-key" /></svg>ZyGames
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="flex items-center gap-8 text-sm font-medium">
                <li><a class="<?= (uri_string() === '') ? 'text-primary border-b-2 border-primary pb-1' : 'opacity-80 hover:opacity-100 hover:text-primary transition-colors' ?>" href="<?= site_url('') ?>">Home</a></li>
                <li><a class="<?= (uri_string() === 'games') ? 'text-primary border-b-2 border-primary pb-1' : 'opacity-80 hover:opacity-100 hover:text-primary transition-colors' ?>" href="<?= site_url('games') ?>">Games</a></li>
            </ul>
        </div>
        <div class="navbar-end gap-2">
            <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
                <input type="checkbox" id="themeToggle" <?= ($currentTheme === 'zygame-light') ? 'checked' : '' ?> />
                <svg class="icon swap-on"><use href="#i-sun" /></svg>
                <svg class="icon swap-off"><use href="#i-moon" /></svg>
            </label>
            <a class="btn btn-primary btn-sm gap-1 px-4" href="<?= site_url('login') ?>">
                <svg class="icon"><use href="#i-user" /></svg>Login
            </a>
        </div>
    </div>
</div>
