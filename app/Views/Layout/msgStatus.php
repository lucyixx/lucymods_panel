<?php if (session()->getFlashdata('msgDanger')) : ?>
    <div class="alert alert-error mb-3" role="alert">
        <?= session()->getFlashdata('msgDanger') ?>
    </div>
<?php elseif (session()->getFlashdata('msgSuccess')) : ?>
    <div class="alert alert-success mb-3" role="alert">
        <?= session()->getFlashdata('msgSuccess') ?>
    </div>
<?php elseif (session()->getFlashdata('msgWarning')) : ?>
    <div class="alert alert-warning mb-3" role="alert">
        <?= session()->getFlashdata('msgWarning') ?>
    </div>
<?php else : ?>
    <?php if (session()->has('userid')) : ?>
        <?php if (isset($messages)) : ?>
            <div class="alert alert-<?= $messages[1] === 'danger' ? 'error' : $messages[1] ?> mb-3" role="alert">
                <?= $messages[0] ?>
            </div>
        <?php else : ?>
            <div class="alert alert-info mb-3" role="alert">
                Welcome <?= !isset($user) ? "Friend" : getName($user) ?>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-info mb-3" role="alert" id="welcomeAlert">
            <span>Welcome <?= !isset($user) ? "Friend" : getName($user) ?></span>
            <button type="button" class="btn btn-ghost btn-xs btn-circle ml-auto" aria-label="Close" onclick="this.closest('#welcomeAlert').remove();">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    <?php endif; ?>
<?php endif; ?>
