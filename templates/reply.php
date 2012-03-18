<?php

//TODO: entities doesn't include single @replies for some reason.

print_r($tweet);
$mentioned_users = '@'.$tweet['user']['screen_name'].' ';
foreach($entities['user_mentions'] as $user) {
    $mentioned_users .= '@'.$user['screen_name'].' ';
}
?>

<div class="reply-form">
    <form action="<?php echo config('base_path'); ?>t/tweet">
        <textarea name="tweet" id="tweet-content"><?php echo $mentioned_users; ?></textarea>
    </form>
</div>