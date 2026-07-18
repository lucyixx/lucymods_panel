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
    window.addEventListener("load", function() {
        const loader = document.querySelector(".body__preloader");
        if (!loader) return;
        setTimeout(() => {
            loader.classList.add("loaded");
        }, 400);
    });
</script>
