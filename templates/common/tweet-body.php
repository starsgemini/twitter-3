<div class="profile-pic"><img src="<?php echo $tweet['user']['profile_image_url'] ?>"
                              alt="<?php echo $tweet['user']['name']; ?>"></div>
<div class="text">
    <span class="tweet-content">
        <a href="<?php echo '/u/view/' . $tweet['user']['screen_name']; ?>" class="username"><?php echo $tweet['user']['screen_name']; ?></a>
        <?php
        $user_url = App\config('base_path') . 'u/view/';
        $tweet['text'] = preg_replace('/\B@([a-z0-9_]+)/i', '<a href="' . $user_url . '$1">@$1</a>', $tweet['text']);
        echo $tweet['text'];
        ?></span>
    <span class="timestamp"><a
        href="<?php echo App\config('base_path') . 't/view/' . $tweet['id_str']; ?>"><?php echo $tweet['created_at']; ?></a>
    </span>

    <?php if (isset($tweet['in_reply_to_status_id_str'])) { ?>
    <span class="in-reply-to">
        <a href="<?php echo App\config('base_path') . 't/view/' . $tweet['in_reply_to_status_id_str']; ?>">in reply to <?php echo $tweet['in_reply_to_screen_name']; ?></a>
    </span>
    <?php } ?>

    <div class="meta">
        <span class="source">via <?php echo $tweet['source']; ?></span>
    </div>

</div>
<div class="controls">
    <ul>
        <li><a href="<?php echo App\config('base_path').'t/reply/'.$tweet['id_str']; ?>">Reply</a></li>
        <li><a href="#">RT</a></li>
        <li><a href="#">Fav</a></li>
    </ul>
</div>