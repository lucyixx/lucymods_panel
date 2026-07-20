<?= $this->extend('Layout/Starter') ?>

<?= $this->section('headScripts') ?>
<?= script_tag('https://code.jquery.com/jquery-3.6.0.js') ?>
<?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js") ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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

<!--
    Desktop: 3-col grid, Gallery (row 1, cols 1-2), Sidebar (rows 1-2, col 3,
    sticky — spans the full height of Gallery + Main content so it stays in
    view while scrolling), Main content (row 2, cols 1-2).
    Mobile: order-* gives the locked sequence Gallery → Sidebar (Metadata +
    Get Access) → Main content (MOD Info, About, Reviews, Related) — the
    one deliberate trade-off where Get Access appears before About/Reviews
    on mobile, since there's no sticky sidebar there to keep it in view.
-->
<div class="grid grid-cols-1 lg:grid-cols-3 lg:grid-rows-[auto_1fr] gap-6">

    <!-- Gallery -->
    <div class="order-1 lg:order-none lg:col-span-2 lg:row-start-1 min-w-0">
        <div class="relative">
            <div id="carouselGallery" class="carousel carousel-center rounded-box bg-base-200 gap-2" style="width:100%; height:clamp(180px, 42vw, 320px); overflow-y:hidden;"></div>
            <button class="btn btn-circle btn-md bg-base-100/80 border-base-300 hover:bg-base-100 absolute left-2 top-1/2 -translate-y-1/2" type="button" onclick="galleryScroll(-1)" aria-label="Previous screenshot">
                <svg class="icon"><use href="#i-chev-l" /></svg>
            </button>
            <button class="btn btn-circle btn-md bg-base-100/80 border-base-300 hover:bg-base-100 absolute right-2 top-1/2 -translate-y-1/2" type="button" onclick="galleryScroll(1)" aria-label="Next screenshot">
                <svg class="icon"><use href="#i-chev-r" /></svg>
            </button>
        </div>
    </div>

    <!-- Sidebar: metadata + Get Access, sticky, spans full height on desktop.
         top-20 matches the new floating Navbar's real clearance (top-3 + h-16
         = 76px) plus a small breathing gap — see Layout/partials/navbar.php. -->
    <div class="order-2 lg:order-none lg:col-span-1 lg:row-start-1 lg:row-span-2 lg:sticky lg:top-20 lg:self-start flex flex-col gap-4">
        <div class="card card-border bg-base-200 border-base-300 p-4">
            <div class="grid grid-cols-2 gap-x-3 gap-y-4">
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wide opacity-50 mb-0.5">Name</p>
                    <p class="text-sm font-medium truncate app_name"></p>
                </div>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wide opacity-50 mb-0.5">Developer</p>
                    <p class="text-sm text-success truncate app_developer"></p>
                </div>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wide opacity-50 mb-0.5">Package Name</p>
                    <a class="app_packageName link link-hover text-sm opacity-80 truncate block" target="_blank" href="https://play.google.com/store/apps/details?id=<?= esc($_GET['id'] ?? '', 'url') ?>"></a>
                </div>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wide opacity-50 mb-0.5">Version</p>
                    <p class="text-sm opacity-80 truncate app_version"></p>
                </div>
            </div>
        </div>

        <!-- Get Access — the only purchase CTA in the entire public marketplace UI.
             Product Selection doesn't exist yet (tracked open item), so this gives
             honest feedback instead of doing nothing when pressed. -->
        <button type="button" class="btn btn-primary w-full mt-2" onclick="Swal.fire({icon: 'info', title: 'Coming soon', text: 'Product selection isn\'t available yet — check back soon.', confirmButtonColor: 'var(--color-primary)'})">Get Access</button>

        <div class="flex items-center justify-center gap-3 text-sm opacity-70 py-2 border-t border-base-300">
            <span class="app_installs"></span>
            <span class="border-r border-base-300 h-4"></span>
            <span class="app_rating"></span>
        </div>
        <p class="text-xs opacity-50 text-center">Last updated <span class="app_lastUpdated"></span></p>
    </div>

    <!-- Main content: MOD Info, About, Reviews, Related Applications -->
    <div class="order-3 lg:order-none lg:col-span-2 lg:row-start-2 flex flex-col gap-6 min-w-0">
        <details class="collapse collapse-arrow bg-base-200 border border-base-300 rounded-box">
            <summary class="collapse-title">MOD Info</summary>
            <div class="collapse-content"><ul class="text-sm opacity-80"><li>Draw Esp</li><li>Chams hack</li><li>[more..]</li></ul></div>
        </details>

        <div>
            <h2 class="text-lg font-medium mb-1">About this <span class="app_type"></span></h2>
            <p class="opacity-70 text-sm leading-relaxed app_description"></p>
            <p class="text-sm opacity-70 mt-2"><em class="app_summary"></em></p>
        </div>

        <div>
            <h2 class="text-lg font-medium mb-3">Reviews</h2>
            <div id="reviewer-list" class="flex flex-col gap-4"></div>
        </div>

        <!--
            Related Applications — reuses the same App Card shape (icon,
            title, subtitle, whole card links to Details). Hidden until
            populated: the current API response has no similar-apps field
            yet (parseSimilar()/parseOthers() exist in google-play.php but
            aren't wired into proxy.php's output — a backend task, not
            solved here).
        -->
        <div id="relatedAppsSection" class="hidden">
            <h2 class="text-lg font-medium mb-3">Related Applications</h2>
            <div id="relatedAppsGrid" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div>
        </div>
    </div>
</div>

<script>
    // ---- Gallery: native scroll-snap carousel (DaisyUI `carousel`), no
    // transform/index bookkeeping needed like the old custom carousel. ----
    function galleryScroll(dir) {
        const el = document.getElementById('carouselGallery');
        if (!el) return;
        el.scrollBy({ left: dir * el.clientWidth, behavior: 'smooth' });
    }

    $(document).ready(function() {
        $.ajax({
            url: "<?= site_url('proxy.php?id=') . esc($_GET['id'] ?? '', 'url') ?>",
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
                    $('.app_description').text(response.description);
                    $('.app_lastUpdated').text(response.lastUpdated);
                    $('.app_packageName').text(response.packageName);
                    $('.app_summary').html(response.summary);
                    $('.app_installs').html('<svg class="icon"><use href="#i-download" /></svg> ' + response.installs);
                    $('.app_rating').html('<svg class="icon text-warning"><use href="#i-check" /></svg> ' + parseFloat(response.rating).toFixed(1));

                    var gallery = '';
                    response.images.forEach(function(src) {
                        gallery += `<div class="carousel-item" style="flex:0 0 100%; width:100%; height:100%; overflow:hidden;"><img loading="lazy" style="display:block; width:100%; height:100%; object-fit:cover; border-radius:var(--radius-box);" src="${src}"></div>`;
                    });
                    $('#carouselGallery').html(gallery);

                    var reviews = '';
                    response.reviews.forEach(function(element) {
                        var stars = '';
                        for (let i = 0; i < 5; i++) stars += `<svg class="icon ${element.stars > i ? 'text-warning' : 'opacity-20'}"><use href="#i-check-circle" /></svg>`;
                        reviews += `
                            <div>
                                <div class="flex mb-2 justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <img style="display:block; width:2rem; height:2rem; border-radius:9999px; object-fit:cover;" aria-hidden="true" loading="lazy" src="${element.reviewer.avatar}" alt="">
                                        <span class="text-sm">${element.reviewer.name}</span>
                                    </div>
                                    <div class="opacity-70 flex gap-0.5">${stars}</div>
                                </div>
                                <div class="p-2 rounded bg-base-300">
                                    <p class="text-sm opacity-70 m-0">${element.review_text}</p>
                                </div>
                            </div>
                        `;
                    });
                    $('#reviewer-list').html(reviews);

                    // Related Applications — only renders if the API ever
                    // starts returning this field (see comment above).
                    if (response.similarApps && response.similarApps.length) {
                        var related = '';
                        response.similarApps.forEach(function(app) {
                            related += `
                                <a href="<?= site_url('details') ?>?id=${encodeURIComponent(app.packageName)}"
                                   class="card card-border bg-base-100 border-base-300 hover:border-primary/50 transition-colors flex-row items-center gap-3 p-3">
                                    <img src="${app.icon}" loading="lazy" alt="" style="display:block; width:2.5rem; height:2.5rem; border-radius:0.75rem; object-fit:cover; flex-shrink:0;">
                                    <div class="min-w-0 flex-1">
                                        <p class="font-medium text-sm truncate">${app.name}</p>
                                        <p class="text-xs opacity-60 truncate">${app.developer || ''}</p>
                                    </div>
                                </a>
                            `;
                        });
                        $('#relatedAppsGrid').html(related);
                        $('#relatedAppsSection').removeClass('hidden');
                    }
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
