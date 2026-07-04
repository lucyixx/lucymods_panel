<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<style>
    table.table>tbody>tr>th>i.bi::before {
        margin-right: 0.5rem !important;
        font-weight: bolder !important;
    }

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
    <div style="max-width: 880px; width: 100%;">
        <div class="card card-border bg-base-200 border-base-300 my-3">
            <div class="card-body">
                <div class="relative rounded overflow-hidden mb-3">
                    <img class="w-full" id="app_featureGraphic"></img>
                    <div class="absolute w-full h-3/4" style="left: 0; bottom: 0; background-image: linear-gradient(to top, #000d, #0000)"></div>
                    <div class="flex m-3 absolute" style="left: 0; bottom: 0;">
                        <div class="shrink-0 me-3">
                            <img loading="lazy" class="rounded" width="68" id="app_icon" itemprop="image">
                        </div>
                        <div class="grid content-center">
                            <h2 class="text-lg app_name text-white m-0"></h2>
                            <span class="text-success app_developer text-sm"></span>
                            <span class="app_age" style="font-size: 0.64rem; color: #ffffff88"></span>
                        </div>
                    </div>
                </div>
                <div class="px-0 md:px-3">
                    <div class="mb-3">
                        <table class="table table-zebra">
                            <tbody style="font-size: 0.9rem;">
                                <tr>
                                    <th class="font-normal"><i class="bi bi-android text-error"></i>Name</th>
                                    <td class="opacity-70 app_name"></td>
                                </tr>
                                <tr>
                                    <th class="font-normal"><i class="bi bi-tools text-error"></i>Developer</th>
                                    <td class="app_developer text-success"></td>
                                </tr>
                                <tr>
                                    <th class="font-normal"><i class="bi bi-list-task text-error"></i>Type</th>
                                    <td class="opacity-70 app_type"></td>
                                </tr>
                                <tr>
                                    <th class="font-normal"><i class="bi bi-screwdriver text-error"></i>Version</th>
                                    <td class="opacity-70 app_version"></td>
                                </tr>
                                <tr>
                                    <th class="font-normal"><i class="bi bi-boxes text-error"></i>Package</th>
                                    <td><a class="app_packageName" target="_blank" href="https://play.google.com/store/apps/details?id=<?= $_GET['id'] ?>"></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <!-- Native <details>/<summary> accordion, replaces Bootstrap's collapse -->
                        <details class="collapse collapse-arrow border rounded">
                            <summary class="collapse-title">
                                MOD Info
                            </summary>
                            <div class="collapse-content">
                                <ul class="text-sm">
                                    <li><em>Draw Esp</em></li>
                                    <li><em>Chams hack</em></li>
                                    <li><em>[more..]</em></li>
                                </ul>
                            </div>
                        </details>
                    </div>

                    <div class="mb-3">
                        <!-- Minimal vanilla-JS carousel, replaces Bootstrap's carousel -->
                        <div id="carouselExample" class="relative rounded overflow-hidden" data-idx="0">
                            <div class="carousel-inner w-full"></div>
                            <button class="btn btn-circle btn-sm absolute left-2 top-1/2 -translate-y-1/2" type="button" onclick="carouselMove('carouselExample', -1)">
                                <i class="bi bi-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button class="btn btn-circle btn-sm absolute right-2 top-1/2 -translate-y-1/2" type="button" onclick="carouselMove('carouselExample', 1)">
                                <i class="bi bi-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <small class="opacity-70"><em class="app_summary"></em></small>
                    </div>

                    <div class="mb-3">
                        <h4>About this <span class="app_type"></span></h4>
                        <span class="opacity-70 text-sm app_description"></span>
                    </div>

                    <div class="mb-3">
                        <div>Last updated</div>
                        <div class="opacity-70 text-sm app_lastUpdated"></div>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-error w-full">Download Now</button>
                    </div>

                    <div class="mb-3">
                        <div class="border-t w-full"></div>
                        <div class="my-3">
                            <div class="flex justify-center opacity-70 text-sm">
                                <span class="app_installs"></span>
                                <span class="mx-2 border-r"></span>
                                <span class="app_rating"></span>
                            </div>
                        </div>
                        <div class="border-b w-full"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-border bg-base-200 border-base-300 my-3">
            <div class="card-body">
                <div class="mb-4"><span class="text-base">Reviews</span></div>
                <div class="mb-3" id="reviewer-list"></div>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?= site_url('proxy.php?id=') . $_GET['id'] ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    $('.body__preloader').addClass("loaded");

                    $('#app_featureGraphic').attr('src', response.featureGraphic);
                    $('#app_icon').attr('src', response.icon);
                    $('.app_name').text(response.name);
                    $('.app_developer').text(response.developer);
                    $('.app_age').text(response.iap ? 'In-app purchases' : response.ads ? 'Contains advertising' : '');
                    $('.app_type').text(response.type);
                    $('.app_version').text(response.versionName);
                    $('.app_description').html(response.description);
                    $('.app_lastUpdated').text(response.lastUpdated);
                    $('.app_packageName').text(response.packageName);
                    $('.app_summary').html(response.summary);
                    $('.app_installs').html('<i class="bi bi-download me-1"></i>' + response.installs);
                    $('.app_rating').html('<i class="bi bi-star me-1"></i>' + parseFloat(response.rating).toFixed(1));

                    var images = null;
                    response.images.forEach(function(element) {
                        images = (images ?? '') + `<div class="carousel-item"><img loading="lazy" class="block w-full" src="${element}"></div>`;
                    });
                    $('.carousel-inner').html(images);
                    $('#carouselExample').attr('data-idx', 0);
                    $('#carouselExample .carousel-inner').css('transform', 'translateX(0)');

                    var reviews = ``;
                    response.reviews.forEach(function(element) {
                        const formattedDate = getReviewerDate(element.review_date);
                        var stars = ``;
                        for (let i = 0; i < 5; i++) stars += `<i class="bi bi-star-fill text-${element.stars > i ? 'success' : 'base-content/30'}"></i>`;
                        reviews += `
                            <div class="mb-4">
                                <div class="flex mb-2 justify-between">
                                    <div>
                                        <img class="rounded-full me-1" width="32" aria-hidden="true" loading="lazy" src="${element.reviewer.avatar}" alt="">
                                        <span class="text-sm">${element.reviewer.name}</span>
                                    </div>
                                    <div class="opacity-70 grid" style="font-size: 0.8rem;">
                                        <small class="text-right">${stars}</small>
                                    </div>
                                </div>
                                <div class="mb-3 p-2 mt-1 rounded bg-base-300">
                                    <small class="opacity-70" style="font-size: 0.8rem;">${element.review_text}</small>
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

        function getReviewerDate(d) {
            // Unix timestamp: 1541407297
            const timestamp = d * 1000; // Convert to milliseconds

            // Create a new Date object using the timestamp
            const date = new Date(timestamp);

            // Define the options for formatting the date
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            // Format the date
            const formattedDate = date.toLocaleDateString('en-US', options);

            return formattedDate;
        }
    });
</script>

<?= $this->endSection() ?>
