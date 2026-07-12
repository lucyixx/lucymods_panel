<?php
/**
 * Footer (shared component)
 *
 * Same on every page. Kept deliberately plain — brand blurb, a couple of
 * link columns, copyright + socials. No promotional CTA banner: this
 * redesign's whole point is that Home/Games/Details never push a
 * purchase action outside Details' own sidebar, and a footer banner
 * would quietly reintroduce that.
 */
?>
<footer class="border-t border-base-300 mt-8">
    <div class="max-w-5xl mx-auto px-4 py-10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div class="lg:col-span-2">
                <a class="flex items-center gap-2 mb-2" href="<?= site_url('') ?>">
                    <svg class="icon text-primary" style="width:1.2rem;height:1.2rem"><use href="#i-key" /></svg>
                    <span class="font-semibold">ZyGames</span>
                </a>
                <p class="text-sm opacity-60 max-w-sm">Mod tools for mobile games — built and maintained by Tis Nquyen.</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide opacity-50 mb-3">Product</p>
                <ul class="flex flex-col gap-2 text-sm opacity-80">
                    <li><a class="link link-hover" href="<?= site_url('games') ?>">Supported games</a></li>
                </ul>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide opacity-50 mb-3">Contact</p>
                <ul class="flex flex-col gap-2 text-sm opacity-80">
                    <li><a class="link link-hover" href="https://t.me/tis_nquyen" target="_blank">Telegram user</a></li>
                    <li><a class="link link-hover" href="https://t.me/zygames" target="_blank">Telegram channel</a></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-base-300 pt-6">
            <p class="text-xs opacity-50">&copy; <?= date('Y') ?> ZyGames. All rights reserved.</p>
            <div class="flex items-center gap-1">
                <a href="#" target="_blank" class="btn btn-ghost btn-circle btn-sm" aria-label="Facebook"><svg class="icon"><use href="#i-facebook" /></svg></a>
                <a href="#" target="_blank" class="btn btn-ghost btn-circle btn-sm" aria-label="YouTube"><svg class="icon"><use href="#i-youtube" /></svg></a>
                <a href="https://t.me/zygames" target="_blank" class="btn btn-ghost btn-circle btn-sm" aria-label="Telegram"><svg class="icon"><use href="#i-telegram" /></svg></a>
            </div>
        </div>
    </div>
</footer>
