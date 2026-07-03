<style>
    .body__preloader {
        position: fixed;
        z-index: 9999999;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background-color: var(--color-base-100, #0e131a);
        -webkit-transition: all .3s ease;
        -o-transition: all .3s ease;
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
        z-index: -2
    }

    #loading {
        font-family: 'JetBrains Mono', monospace;
        color: var(--color-base-content, #c9d1d9);
        text-align: center;
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    #loading .boot-bar {
        margin: 0.75rem auto 0;
        width: 180px;
        height: 3px;
        background: var(--color-base-300, #222);
        overflow: hidden;
        border-radius: 2px;
    }

    #loading .boot-bar span {
        display: block;
        width: 40%;
        height: 100%;
        background: var(--color-primary, #c6ff3d);
        animation: bootSweep 1.1s ease-in-out infinite;
    }

    @keyframes bootSweep {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(250%);
        }
    }
</style>

<div class='body__preloader'>
    <div id="loading">
        <span class="status-dot"></span> Booting ZY//GAMES
        <div class="boot-bar">
            <span></span>
        </div>
    </div>
</div>

<script>
window.addEventListener("load", function () {
    const loader = document.querySelector(".body__preloader");

    if (!loader) return;

    setTimeout(() => {
        loader.classList.add("loaded");
    }, 600);
});
</script>
