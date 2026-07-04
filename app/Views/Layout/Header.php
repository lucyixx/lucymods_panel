<div class="navbar bg-base-200 border-b border-base-300 px-3 max-w-5xl mx-auto w-full gap-1">
    <div class="flex-1 min-w-0">
        <a class="btn btn-ghost text-lg px-2" href="<?= site_url(!session()->has('userid') ? '' : 'dashboard') ?>">ZyGames</a>
        <?php if (session()->has('userid') && isset($user)) : ?>
            <div class="hidden md:flex ml-1 gap-1 text-sm">
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys') ?>">Keys</a>
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/generate') ?>">Generate</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex-none flex items-center gap-1">
        <!-- Theme toggle: daisyUI's own theme-controller + swap, always visible
             at any breakpoint (no custom JS needed to flip the theme itself) -->
        <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
            <input type="checkbox" class="theme-controller" value="zygame-light" <?= (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'checked' : '' ?> />
            <i class="bi bi-sun swap-on"></i>
            <i class="bi bi-moon-stars swap-off"></i>
        </label>

        <!-- Desktop-only account area -->
        <div class="hidden md:block">
            <?php if (session()->has('userid') && isset($user)) : ?>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm gap-2">
                        <div class="avatar avatar-online avatar-placeholder">
                            <div class="bg-neutral text-neutral-content w-6 rounded-full">
                                <span class="text-xs"><?= strtoupper(substr(getName($user), 0, 2)) ?></span>
                            </div>
                        </div>
                        <?= getName($user) ?>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-200 border border-base-300 rounded-box z-10 w-56 p-2 shadow-lg mt-2">
                        <li><a href="<?= site_url('settings') ?>"><i class="bi bi-gear"></i>Settings</a></li>
                        <?php if ($user->level == 1) : ?>
                            <li class="menu-title">Admin</li>
                            <li><a href="<?= site_url('admin/manage-users') ?>"><i class="bi bi-person-check"></i>Manage Users</a></li>
                            <li><a href="<?= site_url('Server') ?>"><i class="bi bi-controller"></i>Online System</a></li>
                            <li><a href="<?= site_url('libOnline') ?>"><i class="bi bi-upload"></i>Lib Online</a></li>
                            <li><a href="<?= site_url('admin/create-referral') ?>"><i class="bi bi-person"></i>Create Referral</a></li>
                            <li><hr class="my-1 opacity-20"></li>
                        <?php endif; ?>
                        <li><a href="<?= site_url('logout') ?>" class="text-error"><i class="bi bi-box-arrow-in-left"></i>Logout</a></li>
                    </ul>
                </div>
            <?php else : ?>
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/free') ?>">Key Free</a>
                <a class="btn btn-ghost btn-sm" href="<?= site_url('login') ?>">Login</a>
            <?php endif; ?>
        </div>

        <!-- Mobile menu toggle (replaces Bootstrap's navbar-toggler/collapse) -->
        <button class="btn btn-ghost btn-square md:hidden" id="navToggle" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-xl"></i>
        </button>
    </div>
</div>

<!-- Mobile nav (shown/hidden via #navToggle) -->
<div class="hidden md:hidden flex-col border-b border-base-300 bg-base-200 px-3 pb-3 max-w-5xl mx-auto w-full" id="navbarSupportedContent">
    <?php if (session()->has('userid') && isset($user)) : ?>
        <div class="flex items-center gap-2 py-2 px-1 border-b border-base-300 mb-1">
            <div class="avatar avatar-online avatar-placeholder">
                <div class="bg-neutral text-neutral-content w-7 rounded-full">
                    <span class="text-xs"><?= strtoupper(substr(getName($user), 0, 2)) ?></span>
                </div>
            </div>
            <span class="text-sm font-medium"><?= getName($user) ?></span>
        </div>
        <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('keys') ?>">Keys</a>
        <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('keys/generate') ?>">Generate</a>
        <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('settings') ?>"><i class="bi bi-gear"></i>Settings</a>
        <?php if ($user->level == 1) : ?>
            <div class="text-xs uppercase opacity-60 px-2 pt-2">Admin</div>
            <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('admin/manage-users') ?>"><i class="bi bi-person-check"></i>Manage Users</a>
            <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('Server') ?>"><i class="bi bi-controller"></i>Online System</a>
            <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('libOnline') ?>"><i class="bi bi-upload"></i>Lib Online</a>
            <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('admin/create-referral') ?>"><i class="bi bi-person"></i>Create Referral</a>
        <?php endif; ?>
        <a class="btn btn-ghost btn-sm justify-start text-error" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-in-left"></i>Logout</a>
    <?php else : ?>
        <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('keys/free') ?>">Key Free</a>
        <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('login') ?>">Login</a>
    <?php endif; ?>
</div>

<script>
    // Mobile nav toggle (replaces Bootstrap's data-bs-toggle="collapse")
    document.getElementById('navToggle').addEventListener('click', function() {
        const menu = document.getElementById('navbarSupportedContent');
        const expanded = menu.classList.contains('flex');
        menu.classList.toggle('flex');
        menu.classList.toggle('hidden');
        this.setAttribute('aria-expanded', String(!expanded));
    });

    // Persist the daisyUI theme choice for the next full page load (this is
    // a classic multi-page app, not an SPA, so each nav is a fresh request).
    document.querySelectorAll('.theme-controller').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const theme = this.checked ? this.value : 'zygame';
            document.cookie = 'theme=' + theme + ';path=/;max-age=31536000';
        });
    });
</script>
