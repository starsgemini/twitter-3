<?php include('common/main_menu.php'); ?>

<div class="timeline">
    <?php
    foreach ($tweets as $tweet) {
        $entified_tweet = tmhUtilities::entify($tweet);
        ?>
        <div class="tweet">
            <?php echo $entified_tweet ?>
        </div>
        <?php
    } ?>
</div>