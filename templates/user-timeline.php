<?php include('common/main_menu.php'); print_r($relationship); ?>

<div class="user-utils">
    <ul>
        <li>Follow</li>
    </ul>
</div>

<div class="reply-form compose">
    <form action="<?php echo config('base_path'); ?>t/create" method="post">
        <textarea name="tweet" id="tweet-content">@<?php echo $user;  ?> </textarea>
        <input type="hidden" name="in-reply-to" value="">
        <input type="submit" value="Tweet" />
    </form>
</div>

<div class="timeline">
    <?php
    foreach ($tweets as $tweet) { ?>
        <div class="tweet">
            <?php include('common/tweet-body.php'); ?>
        </div>
        <?php
    } ?>
</div>