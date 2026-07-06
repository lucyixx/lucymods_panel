<style>
    .body__preloader {
        position: fixed;
        z-index: 9999999;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        /* background-color: #ffffff; */
        background-color: var(--bs-body-bg);
        -webkit-transition: all .3s ease;
        -o-transition: all .3s ease;
        transition: all .3s ease;
        opacity: 1;
        visibility: visible
    }

    .body__preloader.loaded {
        opacity: 0;
        visibility: hidden;
        z-index: -2
    }

    #loading {
        display: block;
        position: relative;
        z-index: 1001;
        left: 50%;
        top: 50%;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #3498db;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite
    }

    #loading:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #e74c3c;
        -webkit-animation: spin 3s linear infinite;
        animation: spin 3s linear infinite
    }

    #loading:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #f9c922;
        -webkit-animation: spin 1.5s linear infinite;
        animation: spin 1.5s linear infinite
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg)
        }

        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg)
        }

        100% {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }
</style>

<div class='body__preloader'>
    <div id="loading"></div>
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