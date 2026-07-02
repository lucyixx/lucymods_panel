<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center"
                href="<?= site_url(!session()->has('userid') ? '' : 'dashboard') ?>">
                <i class="bi bi-controller me-2"></i>

                <div class="d-flex flex-column lh-1">
                    <span><?= BASE_NAME ?></span>
                    <small class="text-secondary">World of game mods</small>
                </div>
            </a>

            <button class="btn btn-sm text-white me-2 border-0" id="bd-theme">
                <i class="bi bi-eyedropper"></i>
            </button>

            <button class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <?php if (session()->has('userid') && isset($user)) : ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('keys') ?>">
                                Keys
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('keys/generate') ?>">
                                Generate
                            </a>
                        </li>

                        <?php if ($user->level == 1) : ?>

                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= site_url('admin/manage-users') ?>">
                                    Manage Users
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= site_url('Server') ?>">
                                    Online System
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= site_url('libOnline') ?>">
                                    Lib Online
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= site_url('admin/create-referral') ?>">
                                    Referral
                                </a>
                            </li>

                        <?php endif; ?>

                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown">

                                <i class="bi bi-person-circle text-danger me-1"></i>
                                <?= getName($user) ?>

                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a class="dropdown-item"
                                        href="<?= site_url('settings') ?>">
                                        <i class="bi bi-gear me-2"></i>
                                        Settings
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger"
                                        href="<?= site_url('logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </a>
                                </li>

                            </ul>

                        </li>

                    <?php else : ?>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= site_url('keys/free') ?>">
                                Key Free
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= site_url('login') ?>">
                                Login
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>

        </div>
    </nav>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const btn = document.getElementById("bd-theme");

    function applyTheme() {
        const theme = localStorage.getItem("selectedTheme") || "dark";
        document.documentElement.setAttribute("data-bs-theme", theme);
    }

    applyTheme();

    btn.addEventListener("click", function() {

        let current = document.documentElement.getAttribute("data-bs-theme");

        let next = current === "dark" ? "light" : "dark";

        document.documentElement.setAttribute("data-bs-theme", next);

        localStorage.setItem("selectedTheme", next);

    });

});
</script>