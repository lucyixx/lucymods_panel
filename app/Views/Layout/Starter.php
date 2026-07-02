<!DOCTYPE html>
<html data-bs-theme="auto" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('favicon.ico', "shortcut icon", "image/x-icon") ?>
    <title><?= BASE_NAME ?> - <?= isset($title) ? $title : 'Panel' ?></title>
    <?= link_tag('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') ?>
    <?= link_tag("https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css") ?>
    <?= link_tag('assets/css/style.css') ?>
    <?= $this->renderSection('css') ?>

    <?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
    <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
    <?= script_tag('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') ?>
    <?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.js") ?>
    <?= script_tag("https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js") ?>
</head>

<body>
  <?= $this->include('Layout/preloader') ?>
    <div class="d-flex min-vh-100 flex-column">
        <?= $this->include('Layout/Header') ?>
        <main class="content">
            <div class="container p-3 px-sm-0"><?= $this->renderSection('content') ?></div>
        </main>
        <footer class="border-top py-3 pt-3" style="background-color: var(--bs-header-bg);">
            <div class="container pt-2">
                <div class="d-flex align-content-center align-items-center mb-3">
                    <span class="border-top d-block flex-grow-1" style="margin-right: 1rem;"></span>
                    <div class="d-flex flex-grow justify-content-center">
                        <a href="#" target="_blank"><i class="bi bi-facebook" style="color:royalblue;"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-youtube" style="color:red"></i></a>
                        <a href="https://t.me/zygames" target="_blank"><i class="bi bi-telegram" style="color:cornflowerblue"></i></a>
                    </div>
                    <span class="border-top d-block flex-grow-1" style="margin-left: 1rem;"></span>
                </div>
            </div>
            <div class="small text-center text-body d-flex pt-2">
                <div class="container">
                    <p>
                        <em>&copy; Copyright 2018 - <?= date('Y') ?> <?= BASE_NAME ?></em>
                    </p>
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
<div id="cookieNotice" class="display-right card shadow" style="display: none;">
    <div id="closeIcon" style="display: none;">
    </div>
    <h2 class="h5 fw-bold">Save Cookie content</h2>
    <div>
        <div>
            <p>This website uses cookies, or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to the <a href="#">Privacy Policy</a></p>
            <div>
                <button class="btn btn-success w-100 shadow-sm" onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
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