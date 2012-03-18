<?php include('common/main_menu.php'); ?>

<div class="timeline">
    <?php
    foreach ($tweets as $tweet) { ?>
        <div class="tweet">
            <?php include('common/tweet-body.php'); ?>
        </div>
        <?php
    } ?>
</div>