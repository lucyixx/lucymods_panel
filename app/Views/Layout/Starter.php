<?php
$currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame';
// Same --color-base-100 values as public/assets/css/daisyui.css, so the
// browser chrome (status/address bar) always matches the page background —
// single source of truth, shared with the toggle script further down.
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

    <!-- Warm up the CDN connections early so the actual requests below don't
         each pay a fresh DNS+TLS handshake — shaves a noticeable chunk off
         first load, especially on mobile networks. -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://play-lh.googleusercontent.com" crossorigin>

    <!-- DaisyUI + Tailwind CSS (CDN, no build step needed on Serv00) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <?= link_tag('assets/css/daisyui.css') ?>
    <?= $this->renderSection('css') ?>

    <!-- jQuery/SweetAlert are only pulled in by pages that actually need
         them (e.g. details.php's AJAX call), via the headScripts section,
         instead of being loaded unconditionally on every page. -->
    <?= $this->renderSection('headScripts') ?>
</head>

<body class="min-h-screen bg-base-100 text-base-content">
    <?= $this->include('Layout/icons') ?>
    <?= $this->include('Layout/preloader') ?>

    <div class="flex flex-col min-h-screen">
        <?= $this->include('Layout/partials/navbar') ?>

        <main class="content">
            <div class="max-w-5xl mx-auto w-full p-4"><?= $this->renderSection('content') ?></div>
        </main>

        <?= $this->include('Layout/partials/footer') ?>
    </div>

    <!-- Cookie consent notice -->
    <div id="cookieNotice" class="card card-border bg-base-200 border-base-300 shadow-lg fixed z-[var(--z-modal)]" style="right: 10px; bottom: 10px; max-width: 380px; display: none;">
        <div class="card-body">
            <h2 class="card-title text-base">Cookie notice</h2>
            <p class="text-sm opacity-70">This website uses cookies, or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to the <a href="#" class="link text-primary">Privacy Policy</a></p>
            <button class="btn btn-primary btn-sm w-full mt-2" onclick="acceptCookieConsent();">Accept</button>
        </div>
    </div>

    <?= (new \App\Libraries\Debug\DebugToolbar())->render() ?>
</body>

</html>

<?= script_tag('assets/js/natacode.js') ?>
<?= $this->renderSection('js') ?>

<script>
    // Theme toggle: plain JS, sets data-theme directly on <html> and
    // persists the choice in a cookie. Deliberately not relying on
    // daisyUI's CSS-only theme-controller mechanism, so the switch always
    // works the same way regardless of browser/daisyUI version quirks.
    //
    // Also updates <meta name="theme-color"> so the browser status/address
    // bar recolors immediately — without this the browser keeps whatever
    // color it sampled on initial page load, since toggling here never
    // reloads the page. themeColors comes straight from PHP (Starter.php),
    // so this can never drift out of sync with the meta tag's initial value.
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

    // Cookie consent
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        document.cookie = cname + "=" + cvalue + ";expires=" + d.toUTCString() + ";path=/";
    }

    function deleteCookie(cname) {
        const d = new Date();
        d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
        document.cookie = cname + "=;expires=" + d.toUTCString() + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    function acceptCookieConsent() {
        deleteCookie('user_cookie_consent');
        setCookie('user_cookie_consent', 1, 30);
        document.getElementById("cookieNotice").style.display = "none";
    }

    if (getCookie("user_cookie_consent") == "") {
        document.getElementById("cookieNotice").style.display = "block";
    }
</script>
