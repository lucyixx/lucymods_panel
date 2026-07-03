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
<div class="flex flex-wrap justify-center gap-4">
    <aside class="w-full lg:w-1/4 mb-3 lg:mb-0">
        <section class="card pt-3 px-3">
            <div class="">
                <div class="mb-3 flex items-center">
                    <div class="mb-1">
                        <img class="rounded-full p-1 border" loading="lazy" src="https://avatars.githubusercontent.com/u/41960847?v=4" width="90" alt="">
                    </div>
                    <div class="ml-2 flex flex-col">
                        <span class="font-semibold">Tis Nquyen</span>
                        <span class="text-sm opacity-70">Website developer</span>
                    </div>
                </div>
                <div class="mb-3 flex flex-col" style="font-size: 0.9rem;">
                    <div class="opacity-70"><i class="bi bi-link-45deg"></i><a href="https://t.me/tis_nquyen" class="text-sm link-body" target="_blank">Telegram user</a></div>
                    <div class="opacity-70"><i class="bi bi-link-45deg"></i><a href="https://t.me/zygames" class="text-sm link-body" target="_blank">Telegram channel</a></div>
                    <div class="opacity-70"><i class="bi bi-download"></i><span class="text-sm">Download module <a href="#" class="link-body" target="_blank">Drive</a></span></div>
                </div>
                <div class="mb-3 text-center" style="white-space: nowrap;">
                    <div class="join">
                        <a class="btn btn-default join-item px-3 rounded-l-full" href="#">
                            <span>VIP KEY</span>
                        </a>
                        <a class="btn btn-default join-item px-3 rounded-r-full" href="<?= site_url('keys/free') ?>">
                            <span>FREE KEY</span>
                        </a>
                    </div>
                </div>
                <div>
                    <h2 class="text-base mt-4 md:mt-4">Recent activity</h2>
                    <div class="mt-2 mb-4">
                        <div class="border border-dashed rounded p-3 mt-2">
                            <p class="note mt-0 text-sm">
                                When you take actions across ZyGames, we’ll provide links to that activity here.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </aside>
    <main class="w-full lg:w-3/4">
        <section class="border shadow-sm rounded overflow-hidden p-0 mb-3">
            <div class="relative">
                <video class="w-full h-auto object-cover block" autoplay loop muted>
                    <source src="https://www.callofduty.com/cdn/codm/videos/home/codm-hero-video-desktop.mp4" type="video/mp4">
                </video>
                <div class="absolute top-0 left-0 w-full h-full flex justify-center items-center">
                    <div class="text-center text-white">
                        <h1 class="text-xl md:text-4xl">Call <span class="text-2xl md:text-5xl">of</span> Duty MOBILE</h1>
                        <p class="text-lg" style="color: yellow;">PLAY FREE NOW</p>
                    </div>
                </div>
            </div>
        </section>
        <!--
            <section class="card border rounded pt-3 px-2 md:px-3 mb-3">
                <header class="flex justify-between mb-3">
                    <div class="flex">
                        <h2 class="text-base ms-1"><a href="#" class="link-body">Game Mods</a></h2>
                    </div>
                    <span class="ms-auto text-sm"><a href="#">View More</a></span>
                </header>
                <div class="flex flex-wrap gap-4">
                    <?php foreach ($games as $index => $game) { ?>
                        <div class="w-full md:w-1/2 xl:w-1/3 mb-3">
                            <a class="link-body app-workflow-bg border rounded overflow-hidden block h-full relative" href="<?= site_url('details?id='.$game->id) ?>">
                                <div class="flex" style="padding: 0.5rem;">
                                    <div class="shrink-0 me-2" style="width: 3.75rem;">
                                        <img src="<?= $game->image_url ?>" loading="lazy" class="rounded-lg" width="96" height="96" aria-hidden="true" alt="Icon image" itemprop="image" data-atf="true">
                                    </div>
                                    <div style="min-width: 0;">
                                        <h2 class="text-base truncate" style="margin-bottom: 2px;"><?= $game->name ?></h2>
                                        <div class="text-sm truncate opacity-70">
                                            <svg class="me-1" style="width: 1rem; fill: #999;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                <path d="M567.938 243.908L462.25 85.374A48.003 48.003 0 0 0 422.311 64H153.689a48 48 0 0 0-39.938 21.374L8.062 243.908A47.994 47.994 0 0 0 0 270.533V400c0 26.51 21.49 48 48 48h480c26.51 0 48-21.49 48-48V270.533a47.994 47.994 0 0 0-8.062-26.625zM162.252 128h251.497l85.333 128H376l-32 64H232l-32-64H76.918l85.334-128z"></path>
                                            </svg>
                                            <span class="text-sm"><?= implode(' + ', $game->modes) ?></span>
                                        </div>
                                        <div class="text-sm opacity-70 truncate">
                                            <svg class="me-1" style="width: 1rem; fill: #999;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M501.1 395.7L384 278.6c-23.1-23.1-57.6-27.6-85.4-13.9L192 158.1V96L64 0 0 64l96 128h62.1l106.6 106.6c-13.6 27.8-9.2 62.3 13.9 85.4l117.1 117.1c14.6 14.6 38.2 14.6 52.7 0l52.7-52.7c14.5-14.6 14.5-38.2 0-52.7zM331.7 225c28.3 0 54.9 11 74.9 31l19.4 19.4c15.8-6.9 30.8-16.5 43.8-29.5 37.1-37.1 49.7-89.3 37.9-136.7-2.2-9-13.5-12.1-20.1-5.5l-74.4 74.4-67.9-11.3L334 98.9l74.4-74.4c6.6-6.6 3.4-17.9-5.7-20.2-47.4-11.7-99.6.9-136.6 37.9-28.5 28.5-41.9 66.1-41.2 103.6l82.1 82.1c8.1-1.9 16.5-2.9 24.7-2.9zm-103.9 82l-56.7-56.7L18.7 402.8c-25 25-25 65.5 0 90.5s65.5 25 90.5 0l123.6-123.6c-7.6-19.9-9.9-41.6-5-62.7zM64 472c-13.2 0-24-10.8-24-24 0-13.3 10.7-24 24-24s24 10.7 24 24c0 13.2-10.7 24-24 24z"></path>
                                            </svg>
                                            <span class="text-sm"><?= implode(', ', $game->features) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </section>
            -->

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
