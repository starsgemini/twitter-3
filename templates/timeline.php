<?php include('common/main_menu.php'); ?>

<div class="timeline">
    <?php
    foreach ($tweets as $tweet) {
        $entified_tweet = tmhUtilities::entify($tweet);
        ?>
        <div class="tweet">
            <div class="profile-pic"><img src="<?php echo $tweet['user']['profile_image_url']; ?>" alt=""></div>
            <div class="text">
                <a href="#" class="username"><?php echo $tweet['user']['name']; ?></a>
                <?php echo $entified_tweet ?>
                <span class="timestamp"><a href="<?php echo config('base_path').'t/view/'.$tweet['id_str']; ?>"><?php echo $tweet['created_at']; ?></a></span>
            </div>
            <div class="controls">
                <ul>
                    <li><a href="#">Reply</a></li>
                    <li><a href="#">Reply All</a></li>
                    <li><a href="#">RT</a></li>
                    <li><a href="#">Fav</a></li>
                </ul>
            </div>
        </div>
        <?php
    } ?>
</div>