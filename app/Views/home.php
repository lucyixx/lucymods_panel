<?php

class GameData
{
    public string $name;
    public string $image_url;
    public string $id;
    public array $modes;
    public array $features;
    public function __construct(string $name, string $image_url, string $id, array $modes, array $features)
    {
        $this->name = $name;
        $this->image_url = $image_url;
        $this->id = $id;
        $this->modes = $modes;
        $this->features = $features;
    }
}

$games = [
    new GameData(
        "콜 오브 듀티: 모바일",
        "https://play-lh.googleusercontent.com/ZNtLvGqEhudE8aRFz6aZm4u4TJ_BNx7gUQQwvSXHZX6LHzN-tUX2advKOjLcnS6Odc8=w240-h480-rw",
        "com.tencent.tmgp.kr.codm",
        ["Zygisk Module", "Inject"],
        ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
    ),
    new GameData(
        "Call of Duty: Mobile Season 2",
        "https://play-lh.googleusercontent.com/zX7jmUbnCkH1LlhGFIffDv76OgJjIy3zZvzC6DPO-Cl-BPXfNVluTCDHTX6YSpvxKUrd=w240-h480-rw",
        "com.activision.callofduty.shooter",
        ["Zygisk Module", "Inject"],
        ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
    ),
    new GameData(
        "Call of Duty®: Mobile - Garena",
        "https://play-lh.googleusercontent.com/lyThPUTIsMNZFyXLxlb_zNS6nGocTLV9IUzbMfdmaikAdHz8enJrg9rAeGcXUljqa0Y=w240-h480-rw",
        "com.garena.game.codm",
        ["Zygisk Module", "Inject"],
        ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
    ),
    new GameData(
        "Call Of Duty: Mobile VN",
        "https://play-lh.googleusercontent.com/Z5oz3yGm79jlshxT_RlZmgr0j-FVPbppMkF9E28iCBLi5AgtBIhLhZM1H48GSbyVmbA=w240-h480-rw",
        "com.vng.codmvn",
        ["Zygisk Module", "Inject"],
        ["Draw Esp (Line, Name, Box, Head...)", "AimBot", "Bullet Track"]
    ),
    new GameData(
        "Arena of Valor",
        "https://play-lh.googleusercontent.com/3Qs6i05oAAUtjzwZCi0AJ9FpxT85w5BWCedIXCrsVKLTGOCcnP2B5yOVoheGSBZpj8z9=w240-h480-rw",
        "com.ngame.allstar.eu",
        ["Zygisk Module", "Inject"],
        ["Hack Map", "Show Icon Info"]
    ),
    new GameData(
        "Garena Liên Quân Mobile",
        "https://play-lh.googleusercontent.com/S3GPwY1-mc5876ZnMk65-VrG3Xlh1R8zgK-Q_LlnbjZ7llyyv0ZGWIlNnBM7LckMMzYy=w240-h480-rw",
        "com.garena.game.kgvn",
        ["Zygisk Module", "Inject"],
        ["Hack Map", "Show Icon Info"]
    ),
    new GameData(
        "Garena AOV",
        "https://play-lh.googleusercontent.com/caDiIvFl-VDvEPlzbHuypmXMTIwAiA8WesvsUIcFoQqokLaYRSYh-Y0LpR4RFhGgytEg=w240-h480-rw",
        "com.garena.game.kgid",
        ["Zygisk Module", "Inject"],
        ["Hack Map", "Show Icon Info"]
    ),
    new GameData(
        "Free Fire",
        "https://play-lh.googleusercontent.com/QjALB_Hon-W8P8OdoGrZ3DESdm7q4Lx8_pPyqckrIvHop3BKpD1bsc2wubwJ2yfCJyI=w240-h480-rw",
        "com.dts.freefireth",
        ["Zygisk Module", "Inject"],
        ["Draw Esp", "Aimbot"]
    ),
    new GameData(
        "Free Fire Max",
        "https://play-lh.googleusercontent.com/La2XvLnJqNI5JyshQ5RfxM18zHduji9KPgNge93Ibwpjc7znBZVYuuwJ4ycGk6T-DQ=w240-h480-rw",
        "com.dts.freefiremax",
        ["Zygisk Module", "Inject"],
        ["Draw Esp", "Aimbot"]
    ),
];
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<!-- Hero: the one thesis moment on the page, built from the actual featured
     game rather than a generic stock banner -->
<section class="hero relative overflow-hidden rounded-box mb-4" style="min-height: 280px;">
    <video class="absolute inset-0 w-full h-full object-cover" autoplay loop muted playsinline>
        <source src="https://www.callofduty.com/cdn/codm/videos/home/codm-hero-video-desktop.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay bg-black/65"></div>
    <div class="hero-content text-center text-white relative">
        <div class="max-w-xl">
            <p class="text-xs uppercase tracking-widest opacity-70 mb-2">Featured this week</p>
            <h1 class="text-3xl md:text-4xl font-medium mb-2">Call of Duty <span class="text-primary">Mobile</span></h1>
            <p class="opacity-80 mb-5">ESP, aimbot and bullet-track licenses, ready in seconds.</p>
            <a href="<?= site_url('keys/free') ?>" class="btn btn-primary">Get a free key</a>
        </div>
    </div>
</section>

<div class="flex flex-wrap gap-4">
    <aside class="w-full lg:w-1/4">
        <div class="card card-border bg-base-200 border-base-300">
            <div class="card-body">
                <div class="flex items-center gap-3 mb-3">
                    <div class="avatar">
                        <div class="w-14 rounded-full">
                            <img src="https://avatars.githubusercontent.com/u/41960847?v=4" alt="">
                        </div>
                    </div>
                    <div>
                        <p class="font-medium">Tis Nquyen</p>
                        <p class="text-sm opacity-60">Website developer</p>
                    </div>
                </div>
                <ul class="text-sm mb-4">
                    <li class="flex items-center gap-2 py-1 opacity-80"><i class="bi bi-link-45deg opacity-60"></i><a href="https://t.me/tis_nquyen" class="link-body" target="_blank">Telegram user</a></li>
                    <li class="flex items-center gap-2 py-1 opacity-80"><i class="bi bi-link-45deg opacity-60"></i><a href="https://t.me/zygames" class="link-body" target="_blank">Telegram channel</a></li>
                    <li class="flex items-center gap-2 py-1 opacity-80"><i class="bi bi-download opacity-60"></i>Download module <a href="#" class="link-body ml-1" target="_blank">Drive</a></li>
                </ul>
                <div class="join w-full mb-4">
                    <a class="btn btn-outline join-item flex-1" href="#">VIP Key</a>
                    <a class="btn btn-outline join-item flex-1" href="<?= site_url('keys/free') ?>">Free Key</a>
                </div>
                <div>
                    <h2 class="text-sm uppercase tracking-wide opacity-60 mb-2">Recent activity</h2>
                    <div class="border border-dashed border-base-300 rounded-box p-3">
                        <p class="note text-sm opacity-60 m-0">
                            When you take actions across ZyGames, we'll show links to that activity here.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <main class="w-full lg:flex-1">
        <h2 class="text-sm uppercase tracking-wide opacity-60 mb-2">Supported games</h2>
        <div class="grid sm:grid-cols-2 gap-3">
            <?php foreach ($games as $game) : ?>
                <a href="<?= site_url('details?id=' . $game->id) ?>" class="card card-border bg-base-200 border-base-300 hover:border-primary/50 transition-colors">
                    <div class="card-body p-3 flex-row items-center gap-3">
                        <img src="<?= $game->image_url ?>" loading="lazy" class="rounded-lg w-16 h-16 object-cover shrink-0" alt="<?= esc($game->name) ?>">
                        <div class="min-w-0">
                            <p class="font-medium text-sm truncate"><?= $game->name ?></p>
                            <p class="text-xs opacity-60 truncate"><i class="bi bi-boxes"></i> <?= implode(' + ', $game->modes) ?></p>
                            <p class="text-xs opacity-60 truncate"><i class="bi bi-stars"></i> <?= implode(', ', $game->features) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    window.onload = function() {
        loadAudio();
    };
    const loadAudio = function() {
        const audioCls = new Audio("<?= base_url('assets/audio/m.mp3') ?>");
        audioCls.autoplay = true;
        audioCls.loop = true;

        document.addEventListener("visibilitychange", function() {
            if (document.hidden) {
                audioCls.pause();
            } else {
                audioCls.play();
            }
        });

        setInterval(() => {
            try {
                if (!document.hidden) audioCls.play();
            } catch (e) {}
        }, 1000);
    }
</script>
<?= $this->endSection() ?>
