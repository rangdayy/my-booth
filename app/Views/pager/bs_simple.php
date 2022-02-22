<?php

/**
 * bs_full.php - Bootstrap 4 full Pager
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<div class="row">
    <div class="col-12 text-right">
        <div class="btn-group text-right" role="group" id="transaction_paginate" aria-label="Basic example">
            <?php foreach ($pager->links() as $link) : ?>
                <a href="<?= $link['uri'] ?>" <?= $link['active']  ? 'class="btn btn-sm btn-primary"' : 'class="btn btn-sm btn-outline-secondary"' ?>>
                    <?= $link['title'] ?>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>