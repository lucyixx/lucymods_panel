<header>
    <nav class="navbar navbar-expand-md shadow-sm border-bottom px-3" style="background-color: var(--bs-header-bg);">
        <div class="container px-0">
            <div class="me-auto">
                <a class="navbar-brand text-body d-flex align-items-center p-0" href="<?= site_url(!session()->has('userid') ? '' : 'dashboard') ?>">
                    <i class="bi bi-controller me-2"></i>
                    <div class="row p-0">
                        <span style="transform: translateY(-0.2rem);"><?= BASE_NAME ?></span>
                        <span class="text-secondary position-absolute w-auto" style="top:2rem;font-size: 0.46rem;">World of game mods</span>
                    </div>
                </a>
            </div>
            <button class="btn border-0" id="bd-theme">
                <i class="bi bi-eyedropper"></i>
            </button>
            <button class="navbar-toggler border-0" style="box-shadow: none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <small class="navbar-toggler-icon"></small>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-md-auto">
                    <?php if (session()->has('userid') && isset($user)) : ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('keys') ?>">Keys</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('keys/generate') ?>">Generate</a></li>

                        <div class="float-right">
                            <ul class="navbar-nav me-auto mb-lg-0">
                                <div class="rounded shadow-sm d-none d-md-block m-2 border border-2 border-primary-subtle"></div>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle pe-2 text-danger"></i><?= $user ? getName($user) : "Friend" ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="<?= site_url('settings') ?>"><i class="bi bi-gear me-1"></i>Settings</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <?php if ($user->level == 1) : ?>
                                            <li class="dropdown-header text-muted disabled">Admin</li>
                                            <li><a class="dropdown-item" href="<?= site_url('admin/manage-users') ?>"><i class="bi bi-person-check me-1"></i>Manage Users</a></li>
                                            <li><a class="dropdown-item" href="<?= site_url('Server') ?>"><i class="bi bi-controller me-1"></i>Online System</a></li>
                                            <li><a class="dropdown-item" href="<?= site_url('libOnline') ?>"><i class="bi bi-upload me-1"></i>Lib Online</a></li>
                                            <li><a class="dropdown-item" href="<?= site_url('admin/create-referral') ?>"><i class="bi bi-person me-1"></i>Create Referral</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                        <?php endif; ?>
                                        <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-in-left me-1"></i>Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('keys/free') ?>">Key Free</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('login') ?>">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script <?= csp_script_nonce() ?>>
    $(document).ready(function() {
        $('#bd-theme').click(function(e) {
            var htmlElement = document.querySelector('html');
            var currentTheme = htmlElement.getAttribute('data-bs-theme');
            var newTheme = (currentTheme === 'dark') ? 'light' : 'dark';
            localStorage.setItem('selectedTheme', newTheme);
            htmlElement.setAttribute('data-bs-theme', newTheme);
        });
    })

    function applySavedTheme() {
        var htmlElement = document.querySelector('html');
        var savedTheme = localStorage.getItem('selectedTheme');
        if (savedTheme) {
            htmlElement.setAttribute('data-bs-theme', savedTheme);
        }
    }
    applySavedTheme();
</script>