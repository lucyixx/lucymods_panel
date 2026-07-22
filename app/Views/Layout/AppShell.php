<?php
$currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame';
// Same tokens as Layout/Starter.php and public/assets/css/daisyui.css's
// --color-base-100 — keeps the browser status/address bar consistent with
// the page background across both layouts.
$themeColors = [
    'zygame'       => 'oklch(20% 0.004 80)',
    'zygame-light' => 'oklch(98% 0.003 80)',
];
?>
<!DOCTYPE html>
<html data-theme="<?= $currentTheme ?>" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="<?= $themeColors[$currentTheme] ?>">
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
    <?= script_tag('assets/js/datatables-daisyui.js') ?>
</head>

<body class="min-h-screen bg-base-100 text-base-content">
    <?= $this->include('Layout/icons') ?>
    <?= $this->include('Layout/preloader') ?>

    <div class="flex flex-col min-h-screen">
        <?= $this->include('Layout/partials/navbar') ?>

        <main class="flex-1">
            <div class="max-w-6xl mx-auto w-full p-4 lg:p-6">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
</body>

</html>

<?= script_tag('assets/js/natacode.js') ?>
<?= $this->renderSection('js') ?>

<script>
    // Same mechanism as Layout/Starter.php — plain JS, not daisyUI's
    // theme-controller CSS class, so behavior stays identical and
    // predictable across both layouts regardless of browser/daisyUI
    // version quirks. Also updates theme-color so the browser
    // status/address bar recolors immediately on toggle.
    (function() {
        const toggle = document.getElementById('themeToggle');
        const themeColors = <?= json_encode($themeColors) ?>;
        const themeColorMeta = document.querySelector('meta[name="theme-color"]');
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            document.cookie = 'theme=' + theme + ';path=/;max-age=31536000';
            if (themeColorMeta) themeColorMeta.setAttribute('content', themeColors[theme]);
        }
        toggle.addEventListener('change', function() {
            applyTheme(this.checked ? 'zygame-light' : 'zygame');
        });
    })();
</script>
