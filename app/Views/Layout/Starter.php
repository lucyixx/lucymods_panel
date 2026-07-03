<!DOCTYPE html>
<html data-theme="hackerdark" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('favicon.ico', "shortcut icon", "image/x-icon") ?>
    <title><?= BASE_NAME ?> - <?= isset($title) ? $title : 'Panel' ?></title>

    <!-- DaisyUI + Tailwind CSS (CDN, no build step needed on Serv00) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- DataTables base skin (Bootstrap-free) -->
    <?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css") ?>

    <?= link_tag('assets/css/style.css') ?>
    <?= $this->renderSection('css') ?>

    <?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
    <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
    <?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
</head>

<body class="min-h-screen flex flex-col" data-theme="hackerdark">
    <?= $this->include('Layout/preloader') ?>
    <div class="flex min-h-screen flex-col">
        <?= $this->include('Layout/Header') ?>
        <main class="content">
            <div class="max-w-5xl mx-auto w-full p-3 sm:px-0"><?= $this->renderSection('content') ?></div>
        </main>
        <footer class="border-t border-base-300 py-3 pt-3">
            <div class="max-w-5xl mx-auto w-full pt-2 px-3 sm:px-0">
                <div class="flex items-center mb-3">
                    <span class="border-t border-base-300 block grow" style="margin-right: 1rem;"></span>
                    <div class="flex grow justify-center">
                        <a href="#" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" target="_blank" class="social-icon"><i class="bi bi-youtube"></i></a>
                        <a href="https://t.me/zygames" target="_blank" class="social-icon"><i class="bi bi-telegram"></i></a>
                    </div>
                    <span class="border-t border-base-300 block grow" style="margin-left: 1rem;"></span>
                </div>
                <div class="text-sm text-center flex pt-2 opacity-60 font-mono">
                    <div class="w-full">
                        <p>
                            &copy; <?= date('Y') ?> ZY // GAMES
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>

<?= script_tag('assets/js/natacode.js') ?>
<?= $this->renderSection('js') ?>

<script>
    function adjustBottomPadding() {
        const fixedTop = document.querySelector('.fixed-top');
        const fixedBottom = document.querySelector('.fixed-bottom');
        const content = document.querySelector('.content');

        if (fixedBottom && content) {
            const fixedBottomHeight = fixedBottom.clientHeight;
            content.style.paddingBottom = fixedBottomHeight + 'px';
        }

        if (fixedTop && content) {
            const fixedTopHeight = fixedTop.clientHeight;
            content.style.paddingTop = fixedTopHeight + 'px';
        }
    }

    window.addEventListener('load', adjustBottomPadding);
    window.addEventListener('resize', adjustBottomPadding);

    $(document).ready(function() {
        $('.dataTables_paginate ul.pagination').addClass('pagination-sm pt-2');
    });
</script>




<!-- Thong bao luu cookie tren trinh duyet -->
<div id="cookieNotice" class="display-right panel shadow-lg" style="display: none;">
    <div class="panel-body">
        <h2 class="font-display text-base font-semibold mb-2">Save Cookie content</h2>
        <p class="text-sm opacity-70">This website uses cookies, or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to the <a href="#" class="text-primary">Privacy Policy</a></p>
        <button class="btn btn-success btn-hud btn-sm w-full mt-2" onclick="acceptCookieConsent();">Accept</button>
    </div>
</div>


<script>
    // Create cookie
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    // Delete cookie
    function deleteCookie(cname) {
        const d = new Date();
        d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=;" + expires + ";path=/";
    }

    // Read cookie
    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    // Set cookie consent
    function acceptCookieConsent() {
        deleteCookie('user_cookie_consent');
        setCookie('user_cookie_consent', 1, 30);
        document.getElementById("cookieNotice").style.display = "none";
    }
    let cookie_consent = getCookie("user_cookie_consent");
    if (cookie_consent != "") {
        document.getElementById("cookieNotice").style.display = "none";
    } else {
        document.getElementById("cookieNotice").style.display = "block";
    }
</script>
<style>
    #cookieNotice.display-right {
        right: 10px;
        bottom: 10px;
        max-width: 395px;
    }

    #cookieNotice {
        position: fixed;
        padding: 20px;
        border-radius: 10px;
        z-index: 999997;
    }
</style>
