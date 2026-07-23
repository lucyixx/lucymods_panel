<style>
    .body__preloader {
        position: fixed;
        z-index: 9999999;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background-color: var(--color-base-100, #1a1a1a);
        transition: all .3s ease;
        opacity: 1;
        visibility: visible;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .body__preloader.loaded {
        opacity: 0;
        visibility: hidden;
        z-index: -2;
    }
</style>

<div class='body__preloader'>
    <div class="flex flex-col items-center gap-3 animate-pulse">
        <svg class="icon text-primary" style="width:2.25rem;height:2.25rem"><use href="#i-key" /></svg>
        <div class="skeleton h-1.5 w-20 rounded-full"></div>
    </div>
</div>

<script>
    window.addEventListener("load", function () {
        const loader = document.querySelector(".body__preloader");
        if (!loader) return;

        // Pages with an initial AJAX call (Home's Hero, Details) assign
        // their fetch promise to window.__pageDataReady so the preloader
        // doesn't hide until that data has actually arrived — otherwise
        // window.load alone fires before an async fetch finishes, and the
        // page flashes empty/skeleton content right after the preloader
        // clears. Pages with nothing async (Games) don't define this, so
        // this resolves immediately and behaves exactly as before.
        const candidate = window.__pageDataReady;
        const dataReady = candidate && typeof candidate.then === "function"
            ? candidate
            : Promise.resolve();

        dataReady
            .catch(() => { /* never block the page on a failed fetch */ })
            .then(() => {
                setTimeout(() => {
                    loader.classList.add("loaded");
                }, 200);
            });
    });
</script>
