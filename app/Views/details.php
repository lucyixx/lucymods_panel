<?= $this->extend('Layout/Starter') ?>
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
<div class="flex justify-center">
    <div style="max-width: 720px; width: 100%;">
        <div class="card card-border bg-base-200 border-base-300 my-3">
            <div class="card-body">
                <div class="relative rounded-box overflow-hidden mb-4">
                    <img class="w-full" id="app_featureGraphic">
                    <div class="absolute w-full h-3/4" style="left: 0; bottom: 0; background-image: linear-gradient(to top, #000d, #0000)"></div>
                    <div class="flex m-3 absolute items-center gap-3" style="left: 0; bottom: 0;">
                        <img loading="lazy" class="rounded-lg w-14 h-14 object-cover shrink-0" id="app_icon" itemprop="image">
                        <div>
                            <h1 class="text-lg app_name text-white m-0"></h1>
                            <p class="text-success app_developer text-sm m-0"></p>
                        </div>
                    </div>
                </div>

                <table class="table table-zebra mb-4">
                    <tbody class="text-sm">
                        <tr><th class="font-normal"><svg class="icon text-error"><use href="#i-gamepad" /></svg> Name</th><td class="opacity-70 app_name"></td></tr>
                        <tr><th class="font-normal"><svg class="icon text-error"><use href="#i-gear" /></svg> Developer</th><td class="text-success app_developer"></td></tr>
                        <tr><th class="font-normal"><svg class="icon text-error"><use href="#i-diagram" /></svg> Type</th><td class="opacity-70 app_type"></td></tr>
                        <tr><th class="font-normal"><svg class="icon text-error"><use href="#i-shield" /></svg> Version</th><td class="opacity-70 app_version"></td></tr>
                        <tr><th class="font-normal"><svg class="icon text-error"><use href="#i-key" /></svg> Package</th><td><a class="app_packageName link" target="_blank" href="https://play.google.com/store/apps/details?id=<?= esc($_GET['id'] ?? '') ?>"></a></td></tr>
                    </tbody>
                </table>

                <details class="collapse collapse-arrow border border-base-300 rounded-box mb-4">
                    <summary class="collapse-title">MOD Info</summary>
                    <div class="collapse-content"><ul class="text-sm"><li>Draw Esp</li><li>Chams hack</li><li>[more..]</li></ul></div>
                </details>

                <div class="mb-4">
                    <div id="carouselExample" class="relative rounded-box overflow-hidden" data-idx="0">
                        <div class="carousel-inner w-full"></div>
                        <button class="btn btn-circle btn-sm absolute left-2 top-1/2 -translate-y-1/2" type="button" onclick="carouselMove('carouselExample', -1)" aria-label="Previous">
                            <svg class="icon"><use href="#i-chev-l" /></svg>
                        </button>
                        <button class="btn btn-circle btn-sm absolute right-2 top-1/2 -translate-y-1/2" type="button" onclick="carouselMove('carouselExample', 1)" aria-label="Next">
                            <svg class="icon"><use href="#i-chev-r" /></svg>
                        </button>
                    </div>
                </div>

                <p class="text-center text-sm opacity-70 mb-4"><em class="app_summary"></em></p>

                <div class="mb-4">
                    <h2 class="text-base font-medium mb-1">About this <span class="app_type"></span></h2>
                    <p class="opacity-70 text-sm app_description"></p>
                </div>

                <div class="mb-4">
                    <p class="text-sm">Last updated</p>
                    <p class="opacity-70 text-sm app_lastUpdated"></p>
                </div>

                <button class="btn btn-error w-full mb-4">Download Now</button>

                <div class="flex items-center justify-center gap-3 border-t border-base-300 pt-4 text-sm opacity-70">
                    <span class="app_installs"></span>
                    <span class="border-r border-base-300 h-4"></span>
                    <span class="app_rating"></span>
                </div>
            </div>
        </div>

        <div class="card card-border bg-base-200 border-base-300 my-3">
            <div class="card-body">
                <h2 class="text-base font-medium mb-3">Reviews</h2>
                <div id="reviewer-list"></div>
            </div>
        </div>
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
                        images = (images ?? '') + `<div class="carousel-item"><img loading="lazy" class="block w-full" src="${element}"></div>`;
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
