<header>
    <nav class="navbar border-b border-base-300 px-3 max-w-5xl mx-auto w-full">
        <div class="flex-1">
            <a class="flex items-center p-0 gap-2 text-inherit" href="<?= site_url(!session()->has('userid') ? '' : 'dashboard') ?>">
                <span class="status-dot"></span>
                <span class="font-display font-bold text-lg tracking-wide">ZY<span class="text-primary">//</span>GAMES</span>
            </a>
        </div>

        <button class="btn btn-ghost btn-circle" id="bd-theme" title="Toggle theme">
            <i class="bi bi-cpu"></i>
        </button>

        <!-- Mobile menu toggle (replaces Bootstrap's navbar-toggler/collapse) -->
        <button class="btn btn-ghost btn-square md:hidden" id="navToggle" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-xl"></i>
        </button>

        <!-- Desktop nav -->
        <div class="hidden md:flex items-center gap-1 font-mono text-xs uppercase tracking-wider" id="navbarDesktop">
            <?php if (session()->has('userid') && isset($user)) : ?>
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys') ?>">Keys</a>
                <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/generate') ?>">Generate</a>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                        <i class="bi bi-person-circle text-primary"></i><?= $user ? getName($user) : "Friend" ?>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-200 rounded-box z-[1] w-56 p-2 shadow-lg border border-base-300 normal-case">
                        <li><a href="<?= site_url('settings') ?>"><i class="bi bi-gear"></i>Settings</a></li>
                        <li><hr class="my-1 opacity-20"></li>
                        <?php if ($user->level == 1) : ?>
                            <li class="menu-title opacity-60">Admin</li>
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
    </nav>

    <!-- Mobile nav (shown/hidden via #navToggle) -->
    <div class="hidden md:hidden flex-col border-b border-base-300 px-3 pb-3 font-mono text-xs uppercase tracking-wider" id="navbarSupportedContent">
        <?php if (session()->has('userid') && isset($user)) : ?>
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
</header>

<script>
    // Mobile nav toggle (replaces Bootstrap's data-bs-toggle="collapse")
    document.getElementById('navToggle').addEventListener('click', function() {
        const menu = document.getElementById('navbarSupportedContent');
        const expanded = menu.classList.contains('flex');
        menu.classList.toggle('flex');
        menu.classList.toggle('hidden');
        this.setAttribute('aria-expanded', String(!expanded));
    });

    // Theme toggle between the two custom daisyUI themes (hackerdark / hackerlight)
    document.getElementById('bd-theme').addEventListener('click', function() {
        var htmlElement = document.querySelector('html');
        var bodyElement = document.querySelector('body');
        var currentTheme = htmlElement.getAttribute('data-theme');
        var newTheme = (currentTheme === 'hackerdark') ? 'hackerlight' : 'hackerdark';
        localStorage.setItem('selectedTheme', newTheme);
        htmlElement.setAttribute('data-theme', newTheme);
        bodyElement.setAttribute('data-theme', newTheme);
    });

    function applySavedTheme() {
        var htmlElement = document.querySelector('html');
        var bodyElement = document.querySelector('body');
        var savedTheme = localStorage.getItem('selectedTheme');
        if (savedTheme) {
            htmlElement.setAttribute('data-theme', savedTheme);
            bodyElement.setAttribute('data-theme', savedTheme);
        }
    }
    applySavedTheme();
</script>
