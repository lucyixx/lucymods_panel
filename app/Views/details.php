<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<style>
    table.table>tbody>tr>th>i.bi::before {
        margin-right: 0.5rem !important;
        font-weight: bolder !important;
    }
</style>

<?= $this->include('Layout/preloader') ?>
<div class="row justify-content-center">
    <div style="max-width: 880px;">
        <div class="card shadow-sm border-0 p-0 my-3">
            <div class="card-body">
                <div class="position-relative rounded overflow-hidden mb-3">
                    <img class="w-100" id="app_featureGraphic"></img>
                    <div class="position-absolute w-100 h-75" style="left: 0; bottom: 0; background-image: linear-gradient(to top, #000d, #0000)"></div>
                    <div class="d-flex m-3 position-absolute" style="left: 0; bottom: 0;">
                        <div class="flex-shrink-0 me-3">
                            <img loading="lazy" class="rounded" width="68" id="app_icon" itemprop="image">
                        </div>
                        <div class="d-grid align-content-center">
                            <h2 class="h4 app_name text-white m-0"></h2>
                            <span class="text-success app_developer small"></span>
                            <span class="app_age" style="font-size: 0.64rem; color: #ffffff88"></span>
                        </div>
                    </div>
                </div>
                <div class="px-0 px-md-3">
                    <div class="mb-3">
                        <table class="table table-striped table-borderless">
                            <tbody style="font-size: 0.9rem;">
                                <tr>
                                    <th class="fw-normal"><i class="bi bi-android text-danger"></i>Name</th>
                                    <td class="text-muted app_name"></td>
                                </tr>
                                <tr>
                                    <th class="fw-normal"><i class="bi bi-tools text-danger"></i>Developer</th>
                                    <td class="app_developer text-success"></td>
                                </tr>
                                <tr>
                                    <th class="fw-normal"><i class="bi bi-list-task text-danger"></i>Type</th>
                                    <td class="text-muted app_type"></td>
                                </tr>
                                <tr>
                                    <th class="fw-normal"><i class="bi bi-screwdriver text-danger"></i>Version</th>
                                    <td class="text-muted app_version"></td>
                                </tr>
                                <tr>
                                    <th class="fw-normal"><i class="bi bi-boxes text-danger"></i>Package</th>
                                    <td><a class="app_packageName" target="_blank" href="https://play.google.com/store/apps/details?id=<?= $_GET['id'] ?>"></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <div class="rounded border">
                            <div class="rounded d-flex align-items-center">
                                <button class="btn btn-default btn-sm border-0 w-100" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    MOD Info
                                </button>
                            </div>
                            <div id="collapseOne" class="collapse">
                                <div class="pt-3 px-3">
                                    <div>
                                        <ul class="small">
                                            <li><em>Draw Esp</em></li>
                                            <li><em>Chams hack</em></li>
                                            <li><em>[more..]</em></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner w-100"></div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <small class="text-muted"><em class="app_summary"></em></small>
                    </div>

                    <div class="mb-3">
                        <h4>About this <span class="app_type"></span></h4>
                        <span class="text-muted small app_description"></span>
                    </div>

                    <div class="mb-3">
                        <div>Last updated</div>
                        <div class="text-muted small app_lastUpdated"></div>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-danger w-100">Download Now</button>
                    </div>

                    <div class="mb-3">
                        <div class="border-top w-100"></div>
                        <div class="my-3">
                            <div class="d-flex justify-content-center text-muted small">
                                <span class="app_installs"></span>
                                <span class="mx-2 border-end"></span>
                                <span class="app_rating"></span>
                            </div>
                        </div>
                        <div class="border-bottom w-100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0 my-3">
            <div class="card-body">
                <div class="mb-4"><span class="h6">Reviews</span></div>
                <div class="mb-3" id="reviewer-list"></div>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?= site_url('public/proxy.php?id=') . $_GET['id'] ?>",
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
                        if (images)
                            images += `<div class="carousel-item"><img loading="lazy" class="d-block" src="${element}"></div>`
                        else
                            images = `<div class="carousel-item active"><img loading="lazy" class="d-block" src="${element}"></div>`
                    });
                    $('.carousel-inner').html(images);

                    var reviews = ``;
                    response.reviews.forEach(function(element) {
                        const formattedDate = getReviewerDate(element.review_date);
                        var stars = ``;
                        for (let i = 0; i < 5; i++) stars += `<i class="bi bi-star-fill text-${element.stars > i ? 'success' : 'body-tertiary'}"></i>`;
                        reviews += `
                            <div class="mb-4">
                                <div class="d-flex mb-2 justify-content-between">
                                    <div>
                                        <img class="rounded-5 me-1" width="32" aria-hidden="true" loading="lazy" src="${element.reviewer.avatar}" alt="">
                                        <span class="small">${element.reviewer.name}</span>
                                    </div>
                                    <div class="text-muted d-grid" style="font-size: 0.8rem;">
                                        <small class="ms-1">${formattedDate}</small>
                                        <small class="text-end">${stars}</small>
                                    </div>
                                </div>
                                <div class="mb-3 p-2 mt-1 rounded bg-body-tertiary">
                                    <small class="text-muted" style="font-size: 0.8rem;">${element.review_text}</small>
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