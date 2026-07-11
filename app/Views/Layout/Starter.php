<?php $currentTheme = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'zygame-light') ? 'zygame-light' : 'zygame'; ?>
<!DOCTYPE html>
<html data-theme="<?= $currentTheme ?>" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<body class="min-h-screen flex flex-col bg-base-100 text-base-content">
    <?= $this->include('Layout/icons') ?>
    <?= $this->include('Layout/preloader') ?>

    <!-- Guest / marketing top navbar — landing-page style: logo + plain
         text links (active link underlined) centered on desktop, single
         Login CTA on the right. Mobile collapses to a native daisyUI
         dropdown (no JS needed, always opens attached to the toggle). -->
    <div class="bg-base-100/90 backdrop-blur border-b border-base-300 px-4 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto w-full navbar p-0 min-h-14 py-1">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden" aria-label="Toggle navigation">
                        <svg class="icon" style="width:1.25rem;height:1.25rem"><use href="#i-menu" /></svg>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 border border-base-300 rounded-box z-10 mt-3 w-52 p-2 shadow">
                        <li><a href="<?= site_url('') ?>">Home</a></li>
                        <li><a href="<?= site_url('games') ?>">Supported games</a></li>
                        <?php if (session()->has('userid') && isset($user)) : ?>
                            <li><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <?php else : ?>
                            <li><a href="<?= site_url('keys/free') ?>">Key Free</a></li>
                            <li><a href="<?= site_url('login') ?>">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <a class="flex items-center gap-2 text-xl font-semibold px-2" href="<?= site_url(!session()->has('userid') ? '' : 'dashboard') ?>">
                    <svg class="icon text-primary" style="width:1.4rem;height:1.4rem"><use href="#i-key" /></svg>ZyGames
                </a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="flex items-center gap-8 text-sm font-medium">
                    <li><a class="<?= (uri_string() === '') ? 'text-primary border-b-2 border-primary pb-1' : 'opacity-80 hover:opacity-100 hover:text-primary transition-colors' ?>" href="<?= site_url('') ?>">Home</a></li>
                    <li><a class="<?= (uri_string() === 'games') ? 'text-primary border-b-2 border-primary pb-1' : 'opacity-80 hover:opacity-100 hover:text-primary transition-colors' ?>" href="<?= site_url('games') ?>">Supported games</a></li>
                    <?php if (!(session()->has('userid') && isset($user))) : ?>
                        <li><a class="opacity-80 hover:opacity-100 hover:text-primary transition-colors" href="<?= site_url('keys/free') ?>">Key Free</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="navbar-end gap-2">
                <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
                    <input type="checkbox" id="themeToggle" <?= ($currentTheme === 'zygame-light') ? 'checked' : '' ?> />
                    <svg class="icon swap-on"><use href="#i-sun" /></svg>
                    <svg class="icon swap-off"><use href="#i-moon" /></svg>
                </label>
                <?php if (session()->has('userid') && isset($user)) : ?>
                    <a class="btn btn-primary btn-sm gap-1 px-4" href="<?= site_url('dashboard') ?>">Dashboard</a>
                <?php else : ?>
                    <a class="btn btn-ghost btn-sm hidden sm:inline-flex gap-1" href="<?= site_url('keys/free') ?>"><svg class="icon"><use href="#i-gift" /></svg>Key Free</a>
                    <a class="btn btn-primary btn-sm gap-1 px-4" href="<?= site_url('login') ?>"><svg class="icon"><use href="#i-user" /></svg>Login</a>
                <?php endif; ?>
            </div>
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
