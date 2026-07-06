<?php $currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame'; ?>
<!DOCTYPE html>
<html data-theme="<?= $currentTheme ?>" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('favicon.ico', "shortcut icon", "image/x-icon") ?>
    <title><?= BASE_NAME ?> - <?= isset($title) ? $title : 'Panel' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css") ?>
    <?= link_tag('assets/css/style.css') ?>
    <?= $this->renderSection('css') ?>

    <?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
    <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
    <?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
</head>

<body class="bg-base-100 text-base-content">
    <?= $this->include('Layout/icons') ?>
    <?= $this->include('Layout/preloader') ?>

    <?php
    $navItems = [
        ['icon' => 'i-server', 'label' => 'Dashboard', 'url' => 'dashboard', 'key' => 'dashboard'],
        ['icon' => 'i-key', 'label' => 'Keys', 'url' => 'keys', 'key' => 'keys'],
        ['icon' => 'i-plus', 'label' => 'Generate', 'url' => 'keys/generate', 'key' => 'generate'],
        ['icon' => 'i-gear', 'label' => 'Settings', 'url' => 'settings', 'key' => 'settings'],
    ];
    $adminItems = [
        ['icon' => 'i-users', 'label' => 'Manage users', 'url' => 'admin/manage-users', 'key' => 'admin_users'],
        ['icon' => 'i-server', 'label' => 'Online system', 'url' => 'Server', 'key' => 'admin_server'],
        ['icon' => 'i-upload', 'label' => 'Lib online', 'url' => 'libOnline', 'key' => 'admin_lib'],
        ['icon' => 'i-scan', 'label' => 'Referral', 'url' => 'admin/create-referral', 'key' => 'admin_referral'],
    ];
    $active = $active ?? '';
    if ($active === '') {
        $uri = strtolower(trim(uri_string(), '/'));
        if ($uri === 'dashboard' || $uri === '') {
            $active = 'dashboard';
        } elseif (str_starts_with($uri, 'keys/generate')) {
            $active = 'generate';
        } elseif (str_starts_with($uri, 'keys')) {
            $active = 'keys';
        } elseif (str_starts_with($uri, 'settings')) {
            $active = 'settings';
        } elseif (str_starts_with($uri, 'admin/manage-users') || str_starts_with($uri, 'admin/user')) {
            $active = 'admin_users';
        } elseif (str_starts_with($uri, 'server') || str_starts_with($uri, 'Server')) {
            $active = 'admin_server';
        } elseif (str_starts_with($uri, 'libonline')) {
            $active = 'admin_lib';
        } elseif (str_starts_with($uri, 'admin/create-referral') || str_starts_with($uri, 'admin/referral')) {
            $active = 'admin_referral';
        }
    }
    ?>

    <div class="drawer lg:drawer-open">
        <input id="app-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col min-h-screen">
            <div class="navbar border-b border-base-300 px-4 lg:px-6">
                <div class="flex-1 flex items-center gap-2">
                    <label for="app-drawer" class="btn btn-ghost btn-square lg:hidden" aria-label="Open menu"><svg class="icon"><use href="#i-menu" /></svg></label>
                    <h1 class="text-lg font-medium"><?= isset($title) ? esc($title) : 'Panel' ?></h1>
                </div>
                <div class="flex-none flex items-center gap-1">
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
                        <input type="checkbox" class="theme-controller" value="zygame-light" <?= ($currentTheme === 'zygame-light') ? 'checked' : '' ?> onchange="document.cookie='theme='+(this.checked?'zygame-light':'zygame')+';path=/;max-age=31536000'" />
                        <svg class="icon swap-on"><use href="#i-sun" /></svg>
                        <svg class="icon swap-off"><use href="#i-moon" /></svg>
                    </label>
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle btn-sm">
                            <div class="avatar avatar-online avatar-placeholder">
                                <div class="bg-neutral text-neutral-content w-7 rounded-full"><span class="text-xs"><?= isset($user) ? strtoupper(substr(getName($user), 0, 2)) : '?' ?></span></div>
                            </div>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-200 border border-base-300 rounded-box z-10 w-44 p-2 shadow-lg mt-2">
                            <li><a class="text-error" href="<?= site_url('logout') ?>"><svg class="icon"><use href="#i-logout" /></svg>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <main class="p-4 lg:p-6 flex-1">
                <?= $this->renderSection('content') ?>
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-40">
            <label for="app-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="min-h-full w-64 bg-base-200 border-r border-base-300 flex flex-col">
                <a class="flex items-center gap-2 px-4 h-16 border-b border-base-300 shrink-0" href="<?= site_url('dashboard') ?>">
                    <svg class="icon text-primary" style="width:1.3rem;height:1.3rem"><use href="#i-key" /></svg>
                    <span class="font-semibold text-lg">ZyGames</span>
                </a>
                <ul class="menu w-full p-3 grow">
                    <?php foreach ($navItems as $item) : ?>
                        <li><a class="<?= $active === $item['key'] ? 'active' : '' ?>" href="<?= site_url($item['url']) ?>"><svg class="icon"><use href="#<?= $item['icon'] ?>" /></svg><?= $item['label'] ?></a></li>
                    <?php endforeach; ?>

                    <?php if (isset($user) && $user->level == 1) : ?>
                        <li class="menu-title mt-2">Admin</li>
                        <?php foreach ($adminItems as $item) : ?>
                            <li><a class="<?= $active === $item['key'] ? 'active' : '' ?>" href="<?= site_url($item['url']) ?>"><svg class="icon"><use href="#<?= $item['icon'] ?>" /></svg><?= $item['label'] ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="p-3 border-t border-base-300 flex items-center gap-2">
                    <div class="avatar avatar-online avatar-placeholder">
                        <div class="bg-neutral text-neutral-content w-8 rounded-full"><span class="text-xs"><?= isset($user) ? strtoupper(substr(getName($user), 0, 2)) : '?' ?></span></div>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate"><?= isset($user) ? getName($user) : '' ?></p>
                        <p class="text-xs opacity-60 truncate">$<?= isset($user) ? $user->saldo : '0' ?> balance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?= script_tag('assets/js/natacode.js') ?>
<?= $this->renderSection('js') ?>
