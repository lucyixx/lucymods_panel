<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .carousel-inner {
        display: flex;
        transition: transform 0.35s ease;
    }

    .carousel-item {
        flex: 0 0 100%;
        width: 100%;
    }
</style>

<?= $this->include('Layout/preloader') ?>

<!-- Banner: full width -->
<div class="relative rounded-box overflow-hidden mb-6 bg-base-300" style="aspect-ratio: 16/6;">
    <img class="w-full h-full object-cover" id="app_featureGraphic">
    <div class="absolute inset-0" style="background-image: linear-gradient(to top, #000d, #0000)"></div>
    <div class="absolute left-0 bottom-0 p-4 flex items-center gap-3">
        <img loading="lazy" class="rounded-lg w-16 h-16 object-cover shrink-0 border border-base-300" id="app_icon" itemprop="image">
        <div>
            <h1 class="text-xl app_name text-white m-0"></h1>
            <p class="text-success app_developer text-sm m-0"></p>
        </div>
    </div>
</div>

<!-- Desktop: 2 columns (media/description left, info sidebar right). Mobile: stacks. -->
<div class="grid lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 flex flex-col gap-6">
        <div id="carouselExample" class="relative rounded-box overflow-hidden bg-base-200" style="aspect-ratio: 16/9;" data-idx="0">
            <div class="carousel-inner w-full h-full"></div>
            <button class="btn btn-circle btn-sm absolute left-2 top-1/2 -translate-y-1/2" type="button" onclick="carouselMove('carouselExample', -1)" aria-label="Previous">
                <svg class="icon"><use href="#i-chev-l" /></svg>
            </button>
            <button class="btn btn-circle btn-sm absolute right-2 top-1/2 -translate-y-1/2" type="button" onclick="carouselMove('carouselExample', 1)" aria-label="Next">
                <svg class="icon"><use href="#i-chev-r" /></svg>
            </button>
        </div>

        <details class="collapse collapse-arrow bg-base-200 border border-base-300 rounded-box">
            <summary class="collapse-title">MOD Info</summary>
            <div class="collapse-content"><ul class="text-sm opacity-80"><li>Draw Esp</li><li>Chams hack</li><li>[more..]</li></ul></div>
        </details>

        <div>
            <h2 class="text-base font-medium mb-1">About this <span class="app_type"></span></h2>
            <p class="opacity-70 text-sm leading-relaxed app_description"></p>
            <p class="text-sm opacity-70 mt-2"><em class="app_summary"></em></p>
        </div>

        <div>
            <h2 class="text-base font-medium mb-3">Reviews</h2>
            <div id="reviewer-list"></div>
        </div>
    </div>

    <!-- Sidebar: info table + download, sticky on desktop -->
    <div class="lg:sticky lg:top-20 lg:self-start flex flex-col gap-4">
        <div class="bg-base-200 border border-base-300 rounded-box p-4">
            <table class="table table-sm">
                <tbody class="text-sm">
                    <tr><th class="font-normal px-0"><svg class="icon text-error"><use href="#i-gamepad" /></svg> Name</th><td class="opacity-70 text-right px-0 app_name"></td></tr>
                    <tr><th class="font-normal px-0"><svg class="icon text-error"><use href="#i-gear" /></svg> Developer</th><td class="text-success text-right px-0 app_developer"></td></tr>
                    <tr><th class="font-normal px-0"><svg class="icon text-error"><use href="#i-diagram" /></svg> Type</th><td class="opacity-70 text-right px-0 app_type"></td></tr>
                    <tr><th class="font-normal px-0"><svg class="icon text-error"><use href="#i-shield" /></svg> Version</th><td class="opacity-70 text-right px-0 app_version"></td></tr>
                </tbody>
            </table>
            <a class="app_packageName link text-sm block truncate mt-1" target="_blank" href="https://play.google.com/store/apps/details?id=<?= esc($_GET['id'] ?? '') ?>"></a>
        </div>

        <button class="btn btn-error w-full">Download Now</button>

        <div class="flex items-center justify-center gap-3 text-sm opacity-70 py-2 border-t border-base-300">
            <span class="app_installs"></span>
            <span class="border-r border-base-300 h-4"></span>
            <span class="app_rating"></span>
        </div>
        <p class="text-xs opacity-50 text-center">Last updated <span class="app_lastUpdated"></span></p>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?= site_url('proxy.php?id=') . esc($_GET['id'] ?? '') ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('.body__preloader').addClass("loaded");

                    $('#app_featureGraphic').attr('src', response.featureGraphic);
                    $('#app_icon').attr('src', response.icon);
                    $('.app_name').text(response.name);
                    $('.app_developer').text(response.developer);
                    $('.app_type').text(response.type);
                    $('.app_version').text(response.versionName);
                    $('.app_description').html(response.description);
                    $('.app_lastUpdated').text(response.lastUpdated);
                    $('.app_packageName').text(response.packageName);
                    $('.app_summary').html(response.summary);
                    $('.app_installs').html('<svg class="icon"><use href="#i-download" /></svg> ' + response.installs);
                    $('.app_rating').html('<svg class="icon text-warning"><use href="#i-check" /></svg> ' + parseFloat(response.rating).toFixed(1));

                    var images = null;
                    response.images.forEach(function(element) {
                        images = (images ?? '') + `<div class="carousel-item"><img loading="lazy" class="block w-full h-full object-cover" src="${element}"></div>`;
                    });
                    $('.carousel-inner').html(images);
                    $('#carouselExample').attr('data-idx', 0);
                    $('#carouselExample .carousel-inner').css('transform', 'translateX(0)');

                    var reviews = ``;
                    response.reviews.forEach(function(element) {
                        var stars = ``;
                        for (let i = 0; i < 5; i++) stars += `<svg class="icon ${element.stars > i ? 'text-warning' : 'opacity-20'}"><use href="#i-check-circle" /></svg>`;
                        reviews += `
                            <div class="mb-4">
                                <div class="flex mb-2 justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <img class="rounded-full w-8 h-8" aria-hidden="true" loading="lazy" src="${element.reviewer.avatar}" alt="">
                                        <span class="text-sm">${element.reviewer.name}</span>
                                    </div>
                                    <div class="opacity-70 flex gap-0.5">${stars}</div>
                                </div>
                                <div class="p-2 rounded bg-base-300">
                                    <p class="text-sm opacity-70 m-0">${element.review_text}</p>
                                </div>
                            </div>
                        `
                    });
                    $('#reviewer-list').html(reviews);
                } else {
                    console.warn(`Error: ${response.message}`);
                }
            },
            error: function() {
                console.error(`Error making request to the server`);
            }
        });
    });
</script>

<?= $this->endSection() ?>
