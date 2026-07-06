<?php $currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame'; ?>
<!DOCTYPE html>
<html data-theme="<?= $currentTheme ?>" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('favicon.ico', "shortcut icon", "image/x-icon") ?>
    <title><?= BASE_NAME ?> - <?= isset($title) ? $title : 'Panel' ?></title>

    <!-- DaisyUI + Tailwind CSS (CDN, no build step needed on Serv00) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <?= link_tag('assets/css/daisyui.css') ?>
    <?= $this->renderSection('css') ?>

    <?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
    <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
</head>

<body class="min-h-screen flex flex-col bg-base-100 text-base-content">
    <?= $this->include('Layout/icons') ?>
    <?= $this->include('Layout/preloader') ?>

    <!-- Guest / marketing top navbar. The mobile dropdown panel lives INSIDE
         this same sticky wrapper so it always appears directly under the
         navbar, even if the page was scrolled before it was opened. -->
    <div class="sticky top-0 z-30">
        <div class="navbar bg-base-200/80 backdrop-blur border-b border-base-300 px-4">
            <div class="max-w-5xl mx-auto w-full flex items-center">
                <div class="flex-1 flex items-center gap-1">
                    <a class="btn btn-ghost text-lg px-2 gap-2" href="<?= site_url(!session()->has('userid') ? '' : 'dashboard') ?>">
                        <svg class="icon"><use href="#i-key" /></svg>ZyGames
                    </a>
                </div>
                <div class="flex-none flex items-center gap-1">
                    <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
                        <input type="checkbox" id="themeToggle" <?= ($currentTheme === 'zygame-light') ? 'checked' : '' ?> />
                        <svg class="icon swap-on"><use href="#i-sun" /></svg>
                        <svg class="icon swap-off"><use href="#i-moon" /></svg>
                    </label>
                    <div class="hidden md:flex items-center gap-1">
                        <?php if (session()->has('userid') && isset($user)) : ?>
                            <a class="btn btn-ghost btn-sm" href="<?= site_url('dashboard') ?>">Dashboard</a>
                        <?php else : ?>
                            <a class="btn btn-ghost btn-sm" href="<?= site_url('keys/free') ?>">Key Free</a>
                            <a class="btn btn-ghost btn-sm" href="<?= site_url('login') ?>">Login</a>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-ghost btn-square md:hidden" id="navToggle" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <svg class="icon" style="width:1.25rem;height:1.25rem"><use href="#i-menu" /></svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="hidden md:hidden flex-col border-b border-base-300 bg-base-200 px-4 pb-3" id="navbarSupportedContent">
            <?php if (session()->has('userid') && isset($user)) : ?>
                <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('dashboard') ?>">Dashboard</a>
            <?php else : ?>
                <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('keys/free') ?>">Key Free</a>
                <a class="btn btn-ghost btn-sm justify-start" href="<?= site_url('login') ?>">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <main class="content">
        <div class="max-w-5xl mx-auto w-full p-4"><?= $this->renderSection('content') ?></div>
    </main>

    <?= $this->renderSection('footer') ?>

    <!-- Cookie consent notice -->
    <div id="cookieNotice" class="card card-border bg-base-200 border-base-300 shadow-lg fixed z-50" style="right: 10px; bottom: 10px; max-width: 380px; display: none;">
        <div class="card-body">
            <h2 class="card-title text-base">Cookie notice</h2>
            <p class="text-sm opacity-70">This website uses cookies, or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to the <a href="#" class="link text-primary">Privacy Policy</a></p>
            <button class="btn btn-primary btn-sm w-full mt-2" onclick="acceptCookieConsent();">Accept</button>
        </div>
    </div>
</body>

</html>

<?= script_tag('assets/js/natacode.js') ?>
<?= $this->renderSection('js') ?>

<script>
    document.getElementById('navToggle').addEventListener('click', function() {
        const menu = document.getElementById('navbarSupportedContent');
        const expanded = menu.classList.contains('flex');
        menu.classList.toggle('flex');
        menu.classList.toggle('hidden');
        this.setAttribute('aria-expanded', String(!expanded));
    });

    // Theme toggle: plain JS, sets data-theme directly on <html> and
    // persists the choice in a cookie. Deliberately not relying on
    // daisyUI's CSS-only theme-controller mechanism, so the switch always
    // works the same way regardless of browser/daisyUI version quirks.
    (function() {
        const toggle = document.getElementById('themeToggle');
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            document.cookie = 'theme=' + theme + ';path=/;max-age=31536000';
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
