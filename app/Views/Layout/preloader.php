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
    <span class="loading loading-spinner loading-lg text-primary"></span>
</div>

<script>
    window.addEventListener("load", function() {
        const loader = document.querySelector(".body__preloader");
        if (!loader) return;
        setTimeout(() => {
            loader.classList.add("loaded");
        }, 400);
    });
</script>
