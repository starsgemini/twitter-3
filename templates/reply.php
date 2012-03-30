<?php

print_r($tweet);
$mentioned_users = '@'.$tweet['user']['screen_name'].' ';
foreach($entities['user_mentions'] as $user) {
    if ($user['screen_name'] == $this->user->handle) continue;
    $mentioned_users .= '@'.$user['screen_name'].' ';
}
?>

<div class="reply-form">
    <form action="<?php echo config('base_path'); ?>t/create" method="post">
        <textarea name="tweet" id="tweet-content"><?php echo $mentioned_users; ?></textarea>
        <input type="hidden" name="in-reply-to" value="<?php echo $tweet['id_str']; ?>">
        <input type="submit" value="Reply" />
    </form>
</div>